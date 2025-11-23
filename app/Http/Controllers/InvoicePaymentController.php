<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\InvoicePayment;
use App\Models\Invoice;
use App\Models\Payment_method;
use App\Models\PaymentMethodBalance;
use App\Models\PaymentMethodTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InvoicePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('query');
        $customers = Customer::where('status', 'active')->get();
        $paymentMethods = Payment_method::all();
        $invoicePayments = InvoicePayment::with(['invoice.customer', 'user', 'paymentMethod'])
            ->when($search, function ($query) use ($search) {
                $query->where('payment_number', 'LIKE', "%{$search}%")
                    ->orWhereHas('invoice', function ($q) use ($search) {
                        $q->where('invoice_number', 'like', "%{$search}%");
                    })
                    ->orWhereHas('invoice.customer', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->when($request->from_date, fn($q) => $q->whereDate('payment_date', '>=', $request->from_date))
            ->when($request->to_date, fn($q) => $q->whereDate('payment_date', '<=', $request->to_date))
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('backend.pages.invoice_payments.index', compact('invoicePayments' , 'customers' , 'paymentMethods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $invoices = Invoice::with('customer')->get();
        $paymentMethods = Payment_method::all();

        return view('backend.pages.invoice_payments.add', compact('invoices', 'paymentMethods'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'invoice_installment_id' => 'nullable|exists:invoice_installments,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'notes_ar' => 'nullable|string',
            'notes_en' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Generate payment number
            $payment_number = 'INV-PAY-' . date('Y') . '-' . str_pad((InvoicePayment::count() + 1), 6, '0', STR_PAD_LEFT);

            $invoicePayment = InvoicePayment::create([
                'invoice_id' => $request->invoice_id,
                'invoice_installment_id' => $request->invoice_installment_id,
                'user_id' => Auth::id(),
                'payment_method_id' => $request->payment_method_id,
                'payment_date' => $request->payment_date,
                'payment_number' => $payment_number,
                'slug' => Str::slug($payment_number . '-' . time()),
                'amount' => $request->amount,
                'notes_ar' => $request->notes_ar,
                'notes_en' => $request->notes_en,
            ]);

            // Update payment method balance
            $balance = PaymentMethodBalance::where('payment_method_id', $request->payment_method_id)->first();
            if ($balance) {
                $balance->current_balance += $request->amount;
                $balance->save();
            }

            // Create transaction record
            $invoice = Invoice::find($request->invoice_id);
            PaymentMethodTransaction::create([
                'payment_method_id' => $request->payment_method_id,
                'transaction_date' => now(),
                'amount' => $request->amount,
                'type' => 'credit',
                'source_type' => 'إيرادات الفواتير',
                'source_id' => $invoicePayment->id,
                'description' => 'دفعة للفاتورة: ' . $invoice->invoice_number,
            ]);

            // Update installment paid_amount and status if installment is specified
            if ($request->invoice_installment_id) {
                $installment = \App\Models\InvoiceInstallment::find($request->invoice_installment_id);
                if ($installment) {
                    $installment->paid_amount += $request->amount;

                    // Update installment status
                    if ($installment->paid_amount >= $installment->amount) {
                        $installment->status = 'paid';
                    }
                    $installment->save();
                }
            }

            // Update invoice paid_amount and remaining_amount
            $invoice->paid_amount += $request->amount;
            $invoice->remaining_amount = $invoice->total - $invoice->paid_amount;
            $invoice->save();

            DB::commit();

            toast(__('back.added_successfully'), 'success');

            // Redirect back to installments payments page if coming from there
            if ($request->invoice_installment_id) {
                return redirect()->route('invoices.show_installments_payments', $request->invoice_id);
            }

            return redirect()->route('invoice_payments.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toast(__('back.error_occurred') . ': ' . $e->getMessage(), 'error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoicePayment $invoicePayment)
    {
        $invoicePayment->load(['invoice.customer', 'paymentMethod']);
        return view('backend.pages.invoice_payments.show', compact('invoicePayment'));
    }

    /**
     * Print payment receipt
     */
    public function print($id)
    {
        $invoicePayment = InvoicePayment::with(['invoice.customer', 'paymentMethod'])->findOrFail($id);
        return view('backend.pages.invoice_payments.print_payment', compact('invoicePayment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InvoicePayment $invoicePayment)
    {
        $invoices = Invoice::with('customer')->get();
        $paymentMethods = Payment_method::all();

        return view('backend.pages.invoice_payments.edit', compact('invoicePayment', 'invoices', 'paymentMethods'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InvoicePayment $invoicePayment)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'notes_ar' => 'nullable|string',
            'notes_en' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $oldAmount = $invoicePayment->amount;
            $oldInvoiceId = $invoicePayment->invoice_id;

            $invoicePayment->update([
                'invoice_id' => $request->invoice_id,
                'payment_method_id' => $request->payment_method_id,
                'payment_date' => $request->payment_date,
                'amount' => $request->amount,
                'notes_ar' => $request->notes_ar,
                'notes_en' => $request->notes_en,
            ]);

            // Update old invoice amounts (revert old payment)
            if ($oldInvoiceId) {
                $oldInvoice = Invoice::find($oldInvoiceId);
                if ($oldInvoice) {
                    $oldInvoice->paid_amount -= $oldAmount;
                    $oldInvoice->remaining_amount = $oldInvoice->total - $oldInvoice->paid_amount;
                    $oldInvoice->save();
                }
            }

            // Update new invoice amounts (add new payment)
            $newInvoice = Invoice::find($request->invoice_id);
            if ($newInvoice) {
                $newInvoice->paid_amount += $request->amount;
                $newInvoice->remaining_amount = $newInvoice->total - $newInvoice->paid_amount;
                $newInvoice->save();
            }

            DB::commit();

            toast(__('back.updated_successfully'), 'success');
            return redirect()->route('invoice_payments.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toast(__('back.error_occurred') . ': ' . $e->getMessage(), 'error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InvoicePayment $invoicePayment)
    {
        DB::beginTransaction();
        try {
            // Revert installment amounts if payment was linked to installment
            if ($invoicePayment->invoice_installment_id) {
                $installment = \App\Models\InvoiceInstallment::find($invoicePayment->invoice_installment_id);
                if ($installment) {
                    $installment->paid_amount -= $invoicePayment->amount;

                    // Update installment status
                    if ($installment->paid_amount < $installment->amount) {
                        $installment->status = 'unpaid';
                    }
                    $installment->save();
                }
            }

            // Revert invoice amounts
            $invoice = Invoice::find($invoicePayment->invoice_id);
            if ($invoice) {
                $invoice->paid_amount -= $invoicePayment->amount;
                $invoice->remaining_amount = $invoice->total - $invoice->paid_amount;
                $invoice->save();
            }

            // Revert payment method balance
            $balance = PaymentMethodBalance::where('payment_method_id', $invoicePayment->payment_method_id)->first();
            if ($balance) {
                $balance->current_balance -= $invoicePayment->amount;
                $balance->save();
            }

            // Delete related transaction
            PaymentMethodTransaction::where([
                'source_type' => 'إيرادات الفواتير',
                'source_id' => $invoicePayment->id,
            ])->delete();

            // Delete the payment
            $invoicePayment->delete();

            DB::commit();

            toast(__('back.deleted_successfully'), 'success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            toast(__('back.error_occurred') . ': ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    /**
     * Get payment by payment number
     */
    public function payment_number($payment_number)
    {
        $invoicePayment = InvoicePayment::with(['invoice.customer', 'paymentMethod'])
            ->where('payment_number', $payment_number)
            ->firstOrFail();

        return view('backend.pages.invoice_payments.print_payment', compact('invoicePayment'));
    }
}
