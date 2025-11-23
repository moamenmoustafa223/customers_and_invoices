<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Customer;
use App\Models\InvoiceStatus;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('query');

        $quotations = Quotation::with(['customer', 'user'])
            ->when($search, function ($query) use ($search) {
                $query->where('quotation_number', 'LIKE', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
            })
            ->when($request->customer_id, fn($q) => $q->where('customer_id', $request->customer_id))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->from_date, fn($q) => $q->whereDate('quotation_date', '>=', $request->from_date))
            ->when($request->to_date, fn($q) => $q->whereDate('quotation_date', '<=', $request->to_date))
            ->orderBy('id', 'desc')
            ->paginate(10);

        $customers = Customer::where('status', 'active')->get();

        return view('backend.pages.quotations.index', compact('quotations', 'customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::where('status', 'active')->get();
        $services = Service::where('status', 'active')->get();
        $setting = \App\Models\Setting::first();

        return view('backend.pages.quotations.add', compact('customers', 'services', 'setting'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'quotation_date' => 'required|date',
            'valid_until' => 'nullable|date',
            'notes_ar' => 'nullable|string',
            'notes_en' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.service_name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax_percentage' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Generate unique quotation number safely
            $last = Quotation::lockForUpdate()->orderBy('id', 'desc')->first();
            $nextNumber = $last ? ((int)substr($last->quotation_number, -6) + 1) : 1;

            $quotation_number = 'QUO-' . date('Y') . '-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

            // Calculate totals
            $subtotal = 0;
            foreach ($request->items as $item) {
                $subtotal += $item['quantity'] * $item['unit_price'];
            }

            $discount = $request->discount ?? 0;
            $subtotalAfterDiscount = $subtotal - $discount;
            $tax_percentage = $request->tax_percentage ?? 0;
            $tax = ($subtotalAfterDiscount * $tax_percentage) / 100;
            $total = $subtotalAfterDiscount + $tax;

            // Create quotation
            $quotation = Quotation::create([
                'quotation_number' => $quotation_number,
                'customer_id' => $request->customer_id,
                'user_id' => Auth::id(),
                'quotation_date' => $request->quotation_date,
                'valid_until' => $request->valid_until,
                'slug' => Str::slug($quotation_number . '-' . time()),
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'total' => $total,
                'notes_ar' => $request->notes_ar,
                'notes_en' => $request->notes_en,
                'status' => 'pending',
            ]);

            // Create quotation items
            foreach ($request->items as $item) {
                QuotationItem::create([
                    'quotation_id' => $quotation->id,
                    'service_id' => null,
                    'service_name' => $item['service_name'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $item['quantity'] * $item['unit_price'],
                ]);
            }

            DB::commit();

            toast(__('back.added_successfully'), 'success');
            return redirect()->route('quotations.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toast(__('back.error_occurred') . ': ' . $e->getMessage(), 'error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Quotation $quotation)
    {
        $quotation->load(['customer', 'user', 'items.service', 'convertedInvoice']);
        return view('backend.pages.quotations.show', compact('quotation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quotation $quotation)
    {
        $quotation->load('items');
        $customers = Customer::where('status', 'active')->get();
        $services = Service::where('status', 'active')->get();

        return view('backend.pages.quotations.edit', compact('quotation', 'customers', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quotation $quotation)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'quotation_date' => 'required|date',
            'valid_until' => 'nullable|date',
            'notes_ar' => 'nullable|string',
            'notes_en' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.service_name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax_percentage' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Calculate totals
            $subtotal = 0;
            foreach ($request->items as $item) {
                $subtotal += $item['quantity'] * $item['unit_price'];
            }

            $discount = $request->discount ?? 0;
            $subtotalAfterDiscount = $subtotal - $discount;
            $tax_percentage = $request->tax_percentage ?? 0;
            $tax = ($subtotalAfterDiscount * $tax_percentage) / 100;
            $total = $subtotalAfterDiscount + $tax;

            // Update quotation
            $quotation->update([
                'customer_id' => $request->customer_id,
                'quotation_date' => $request->quotation_date,
                'valid_until' => $request->valid_until,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'total' => $total,
                'notes_ar' => $request->notes_ar,
                'notes_en' => $request->notes_en,
            ]);

            // Delete old items and create new ones
            $quotation->items()->delete();
            foreach ($request->items as $item) {
                QuotationItem::create([
                    'quotation_id' => $quotation->id,
                    'service_id' => null,
                    'service_name' => $item['service_name'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $item['quantity'] * $item['unit_price'],
                ]);
            }

            DB::commit();

            toast(__('back.updated_successfully'), 'success');
            return redirect()->route('quotations.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toast(__('back.error_occurred') . ': ' . $e->getMessage(), 'error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quotation $quotation)
    {
        $quotation->delete();

        toast(__('back.deleted_successfully'), 'success');
        return redirect()->route('quotations.index');
    }
 
    /**
     * Convert quotation to invoice
     */
    public function convertToInvoice($id)
    {
        $quotation = Quotation::with('items')->findOrFail($id);

        // Check if already converted
        if ($quotation->status === 'converted') {
            toast(__('back.quotation_already_converted'), 'error');
            return redirect()->back();
        }

        DB::beginTransaction();
        try {
            // Generate unique invoice number safely
            $last = Invoice::lockForUpdate()->orderBy('id', 'desc')->first();
            $nextNumber = $last ? ((int)substr($last->invoice_number, -6) + 1) : 1;
            $invoice_number = 'INV-' . date('Y') . '-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

            // Get default invoice status (you may want to adjust this)
            $defaultStatus = InvoiceStatus::first();

            // Create invoice
            $invoice = Invoice::create([
                'invoice_number' => $invoice_number,
                'customer_id' => $quotation->customer_id,
                'invoice_status_id' => $defaultStatus->id ?? 1,
                'user_id' => Auth::id(),
                'invoice_date' => now(),
                'due_date' => now()->addDays(30),
                'slug' => Str::slug($invoice_number . '-' . time()),
                'subtotal' => $quotation->subtotal,
                'discount' => $quotation->discount ?? 0,
                'tax' => $quotation->tax,
                'total' => $quotation->total,
                'paid_amount' => 0,
                'remaining_amount' => $quotation->total,
                'notes_ar' => $quotation->notes_ar,
                'notes_en' => $quotation->notes_en,
            ]);

            // Copy quotation items to invoice items
            foreach ($quotation->items as $item) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'service_id' => $item->service_id,
                    'service_name' => $item->service_name,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'total_price' => $item->total_price,
                ]);
            }

            // Create one installment with total amount and today's date
            \App\Models\InvoiceInstallment::create([
                'invoice_id' => $invoice->id,
                'due_date' => now(),
                'amount' => $quotation->total,
                'status' => 'unpaid',
            ]);

            // Update quotation status
            $quotation->update([
                'status' => 'converted',
                'converted_invoice_id' => $invoice->id,
            ]);

            DB::commit();

            toast(__('back.quotation_converted_successfully'), 'success');
            return redirect()->route('invoices.show', $invoice->id);
        } catch (\Exception $e) {
            DB::rollBack();
            toast(__('back.error_occurred') . ': ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    /**
     * Update quotation status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,rejected',
        ]);

        $quotation = Quotation::findOrFail($id);

        // Prevent status change if already converted
        if ($quotation->status === 'converted') {
            toast(__('back.cannot_change_converted_quotation_status'), 'error');
            return redirect()->back();
        }

        $quotation->update([
            'status' => $request->status,
        ]);

        toast(__('back.status_updated_successfully'), 'success');
        return redirect()->back();
    }
}
