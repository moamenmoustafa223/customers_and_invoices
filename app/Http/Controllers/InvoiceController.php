<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceInstallment;
use App\Models\Customer;
use App\Models\InvoiceStatus;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('query');

        $invoices = Invoice::with(['customer', 'status', 'user', 'installments'])
            ->when($search, function ($query) use ($search) {
                $query->where('invoice_number', 'LIKE', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    })
                    ->orWhereHas('status', function ($q) use ($search) {
                        $q->where('name_ar', 'like', "%{$search}%")
                            ->orWhere('name_en', 'like', "%{$search}%");
                    });
            })
            ->when($request->customer_id, fn($q) => $q->where('customer_id', $request->customer_id))
            ->when($request->invoice_status_id, fn($q) => $q->where('invoice_status_id', $request->invoice_status_id))
            ->when($request->from_date, fn($q) => $q->whereDate('invoice_date', '>=', $request->from_date))
            ->when($request->to_date, fn($q) => $q->whereDate('invoice_date', '<=', $request->to_date))
            ->orderBy('id', 'desc')
            ->paginate(10);

        $customers = Customer::where('status', 'active')->get();
        $statuses = InvoiceStatus::all();
        $invoiceStatuses = InvoiceStatus::all();

        return view('backend.pages.invoices.index', compact('invoices', 'customers', 'statuses', 'invoiceStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::where('status', 'active')->get();
        $statuses = InvoiceStatus::all();
        $services = Service::where('status', 'active')->get();
        $setting = \App\Models\Setting::first();

        return view('backend.pages.invoices.add', compact('customers', 'statuses', 'services', 'setting'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_status_id' => 'required|exists:invoice_statuses,id',
            'invoice_date' => 'required|date',
            'due_date' => 'nullable|date',
            'notes_ar' => 'nullable|string',
            'notes_en' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.service_name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'installments' => 'nullable|array',
            'installments.*.due_date' => 'nullable|date',
            'installments.*.amount' => 'nullable|numeric|min:0',
        ]);
 
        DB::beginTransaction();
        try {
            // Generate unique invoice number
            $year = date('Y');

            // Lock the table to prevent race conditions
            $lastInvoice = Invoice::where('invoice_number', 'LIKE', "INV-{$year}-%")
                ->orderByRaw('CAST(SUBSTRING(invoice_number, 11) AS UNSIGNED) DESC')
                ->lockForUpdate()
                ->first();

            if ($lastInvoice) {
                // Extract the number from the last invoice and increment it
                preg_match('/INV-\d{4}-(\d+)/', $lastInvoice->invoice_number, $matches);
                $nextNumber = isset($matches[1]) ? (int)$matches[1] + 1 : 1;
            } else {
                $nextNumber = 1;
            }

            // Check if this number already exists (in case of race condition)
            do {
                $invoice_number = 'INV-' . $year . '-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
                $exists = Invoice::where('invoice_number', $invoice_number)->exists();
                if ($exists) {
                    $nextNumber++;
                }
            } while ($exists);

            // Calculate totals
            $subtotal = 0;
            foreach ($request->items as $item) {
                $subtotal += $item['quantity'] * $item['unit_price'];
            }

            $discount = $request->discount ?? 0;
            $tax = $request->tax ?? 0;
            $total = ($subtotal - $discount) + $tax;

            // Create invoice
            $invoice = Invoice::create([
                'invoice_number' => $invoice_number,
                'customer_id' => $request->customer_id,
                'invoice_status_id' => $request->invoice_status_id,
                'user_id' => Auth::id(),
                'invoice_date' => $request->invoice_date,
                'due_date' => $request->due_date,
                'slug' => Str::slug($invoice_number . '-' . time()),
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'total' => $total,
                'paid_amount' => 0,
                'remaining_amount' => $total,
                'notes_ar' => $request->notes_ar,
                'notes_en' => $request->notes_en,
            ]);

            // Create invoice items
            foreach ($request->items as $item) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'service_id' => null,
                    'service_name' => $item['service_name'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $item['quantity'] * $item['unit_price'],
                ]);
            }

            // Create installments if provided
            if ($request->filled('installments')) {
                foreach ($request->installments as $installment) {
                    if (!empty($installment['due_date']) && !empty($installment['amount'])) {
                        InvoiceInstallment::create([
                            'invoice_id' => $invoice->id,
                            'due_date' => $installment['due_date'],
                            'amount' => $installment['amount'],
                            'status' => 'unpaid',
                        ]);
                    }
                }
            }

            DB::commit();

            toast(__('back.added_successfully'), 'success');
            return redirect()->route('invoices.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toast(__('back.error_occurred') . ': ' . $e->getMessage(), 'error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load(['customer', 'status', 'user', 'items.service', 'installments', 'payments']);
        return view('backend.pages.invoices.show', compact('invoice'));
    }

    /**
     * Print invoice
     */
    public function print($id)
    {
        $invoice = Invoice::with(['customer', 'status', 'items.service'])->findOrFail($id);
        return view('backend.pages.invoices.print_invoice', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $invoice->load('items');
        $customers = Customer::where('status', 'active')->get();
        $statuses = InvoiceStatus::all();
        $services = Service::where('status', 'active')->get();

        return view('backend.pages.invoices.edit', compact('invoice', 'customers', 'statuses', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_status_id' => 'required|exists:invoice_statuses,id',
            'invoice_date' => 'required|date',
            'due_date' => 'nullable|date',
            'notes_ar' => 'nullable|string',
            'notes_en' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.service_name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'installments' => 'nullable|array',
            'installments.*.due_date' => 'nullable|date',
            'installments.*.amount' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Calculate totals
            $subtotal = 0;
            foreach ($request->items as $item) {
                $subtotal += $item['quantity'] * $item['unit_price'];
            }

            $discount = $request->discount ?? 0;
            $tax = $request->tax ?? 0;
            $total = ($subtotal - $discount) + $tax;

            // Keep existing paid_amount and recalculate remaining
            $paid_amount = $invoice->paid_amount;
            $remaining_amount = $total - $paid_amount;

            // Update invoice
            $invoice->update([
                'customer_id' => $request->customer_id,
                'invoice_status_id' => $request->invoice_status_id,
                'invoice_date' => $request->invoice_date,
                'due_date' => $request->due_date,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'total' => $total,
                'remaining_amount' => $remaining_amount,
                'notes_ar' => $request->notes_ar,
                'notes_en' => $request->notes_en,
            ]);

            // Delete old items and create new ones
            $invoice->items()->delete();
            foreach ($request->items as $item) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'service_id' => null,
                    'service_name' => $item['service_name'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $item['quantity'] * $item['unit_price'],
                ]);
            }

            // Update installments if provided
            if ($request->filled('installments')) {
                // Delete existing installments that don't have payments
                $installmentsWithPayments = InvoiceInstallment::where('invoice_id', $invoice->id)
                    ->whereHas('payments')
                    ->pluck('id')
                    ->toArray();

                InvoiceInstallment::where('invoice_id', $invoice->id)
                    ->whereNotIn('id', $installmentsWithPayments)
                    ->delete();

                // Create new installments
                foreach ($request->installments as $installment) {
                    if (!empty($installment['due_date']) && !empty($installment['amount'])) {
                        InvoiceInstallment::create([
                            'invoice_id' => $invoice->id,
                            'due_date' => $installment['due_date'],
                            'amount' => $installment['amount'],
                            'status' => 'unpaid',
                        ]);
                    }
                }
            }

            DB::commit();

            toast(__('back.updated_successfully'), 'success');
            return redirect()->route('invoices.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toast(__('back.error_occurred') . ': ' . $e->getMessage(), 'error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        DB::beginTransaction();
        try {
            // Check if any installment has payments
            $hasPayments = InvoiceInstallment::where('invoice_id', $invoice->id)
                ->whereHas('payments')
                ->exists();

            if ($hasPayments) {
                toast(__('back.cannot_delete_invoice_with_payments'), 'error');
                return redirect()->back();
            }

            // Delete installments first
            InvoiceInstallment::where('invoice_id', $invoice->id)->delete();

            // Delete invoice items
            $invoice->items()->delete();

            // Delete the invoice
            $invoice->delete();

            DB::commit();

            toast(__('back.deleted_successfully'), 'success');
            return redirect()->route('invoices.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toast(__('back.error_occurred') . ': ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    /**
     * Show invoice installments and payments
     */
    public function show_invoice_installments_payments($id)
    {
        $invoice = Invoice::with([
            'customer',
            'status',
            'payments',
            'installments.payments.paymentMethod',
        ])->findOrFail($id);

        return view('backend.pages.invoices.show_installments_payments', compact('invoice'));
    }
}
