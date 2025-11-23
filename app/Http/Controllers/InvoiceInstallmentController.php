<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceInstallment;
use App\Models\Customer;
use App\Models\InvoiceStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InvoiceInstallmentController extends Controller
{
    /**
     * Display a listing of installments with filters
     */
    public function index(Request $request)
    {
        $query = InvoiceInstallment::with(['invoice.customer', 'invoice.status']);

        // Search by invoice number
        if ($request->filled('query')) {
            $search = $request->query;
            $query->whereHas('invoice', function ($q) use ($search) {
                $q->where('invoice_number', 'LIKE', "%{$search}%")
                    ->orWhereHas('customer', function ($customerQuery) use ($search) {
                        $customerQuery->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('phone', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('from_date')) {
            $query->whereDate('due_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('due_date', '<=', $request->to_date);
        }

        // Filter by invoice
        if ($request->filled('invoice_id')) {
            $query->where('invoice_id', $request->invoice_id);
        }

        $installments = $query->orderBy('due_date', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(20);

        $customers = Customer::where('status', 'active')->get();
        $invoices = Invoice::with('customer')->orderBy('id', 'desc')->get();

        return view('backend.pages.invoice_installments.index', compact('installments', 'customers', 'invoices'));
    }

    /**
     * Display overdue installments
     */
    public function overdue(Request $request)
    {
        $query = InvoiceInstallment::with(['invoice.customer', 'invoice.status'])
            ->where('status', '!=', 'paid')
            ->whereDate('due_date', '<', Carbon::today());

        // Search by invoice number or customer
        if ($request->filled('query')) {
            $search = $request->query;
            $query->whereHas('invoice', function ($q) use ($search) {
                $q->where('invoice_number', 'LIKE', "%{$search}%")
                    ->orWhereHas('customer', function ($customerQuery) use ($search) {
                        $customerQuery->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('phone', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Filter by date range
        if ($request->filled('from_date')) {
            $query->whereDate('due_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('due_date', '<=', $request->to_date);
        }

        $installments = $query->orderBy('due_date', 'asc')
            ->paginate(20);

        $customers = Customer::where('status', 'active')->get();

        return view('backend.pages.invoice_installments.overdue', compact('installments', 'customers'));
    }

    /**
     * Mark installment as paid and update invoice amounts
     */
    public function markAsPaid($id)
    {
        DB::beginTransaction();
        try {
            $installment = InvoiceInstallment::findOrFail($id);

            // Check if already paid
            if ($installment->status === 'paid') {
                toast(__('back.installment_already_paid'), 'warning');
                return redirect()->back();
            }

            // Update installment status
            $installment->update(['status' => 'paid']);

            // Update invoice paid_amount and remaining_amount
            $invoice = $installment->invoice;
            $invoice->paid_amount = $invoice->paid_amount + $installment->amount;
            $invoice->remaining_amount = $invoice->remaining_amount - $installment->amount;

            // Update invoice status if fully paid
            if ($invoice->remaining_amount <= 0) {
                $paidStatus = InvoiceStatus::where('name_en', 'Paid')
                    ->orWhere('name_ar', 'مدفوع')
                    ->first();

                if ($paidStatus) {
                    $invoice->invoice_status_id = $paidStatus->id;
                }
            } elseif ($invoice->paid_amount > 0) {
                // Partially paid
                $partialStatus = InvoiceStatus::where('name_en', 'Partially Paid')
                    ->orWhere('name_ar', 'مدفوع جزئياً')
                    ->first();

                if ($partialStatus) {
                    $invoice->invoice_status_id = $partialStatus->id;
                }
            }

            $invoice->save();

            DB::commit();

            toast(__('back.installment_marked_as_paid_successfully'), 'success');
            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollBack();
            toast(__('back.error_occurred') . ': ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    /**
     * Delete installment
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $installment = InvoiceInstallment::findOrFail($id);

            // Check if installment has payments
            $hasPayments = \App\Models\InvoicePayment::where('invoice_installment_id', $installment->id)->exists();

            if ($hasPayments) {
                toast(__('back.cannot_delete_installment_with_payments'), 'error');
                return redirect()->back();
            }

            // If installment was paid, revert the invoice amounts
            if ($installment->status === 'paid') {
                $invoice = $installment->invoice;
                $invoice->paid_amount = $invoice->paid_amount - $installment->amount;
                $invoice->remaining_amount = $invoice->remaining_amount + $installment->amount;

                // Update invoice status
                if ($invoice->paid_amount <= 0) {
                    $unpaidStatus = InvoiceStatus::where('name_en', 'Unpaid')
                        ->orWhere('name_ar', 'غير مدفوع')
                        ->first();

                    if ($unpaidStatus) {
                        $invoice->invoice_status_id = $unpaidStatus->id;
                    }
                } elseif ($invoice->remaining_amount > 0) {
                    $partialStatus = InvoiceStatus::where('name_en', 'Partially Paid')
                        ->orWhere('name_ar', 'مدفوع جزئياً')
                        ->first();

                    if ($partialStatus) {
                        $invoice->invoice_status_id = $partialStatus->id;
                    }
                }

                $invoice->save();
            }

            $installment->delete();

            DB::commit();

            toast(__('back.deleted_successfully'), 'success');
            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollBack();
            toast(__('back.error_occurred') . ': ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }
}
