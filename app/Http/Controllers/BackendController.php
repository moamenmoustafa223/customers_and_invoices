<?php

namespace App\Http\Controllers;

use App\Models\HR\Allowance;
use App\Models\HR\Discount;
use App\Models\HR\Holiday;
use App\Models\HR\Message;
use App\Models\HR\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BackendController extends Controller
{

    public function index(Request $request)
    {
        return view('backend.dashboard');
    }


    public function show_notification_all()
    {
        return view('backend.show_notification_all');
    }
    public function reply_message(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required|string',
        ], [
            'reply.required' => 'الرد مطلوب',
        ]);

        $message = Message::find($id);
        $message->update([
            'reply' => $request->reply,
            // إذا تم الرد نعتبر الحالة "مكتمل"
            'status' => $request->status ?? 1,
        ]);

        toast('تم إرسال الرد بنجاح', 'success');
        return redirect()->back();
    }


    public function all_messages(Request $request)
    {
        $search = $request->input('query');
        $all_messages = Message::query()
            ->where('title', 'LIKE', "%{$search}%")
            ->orWhereHas('employee', function ($query) use ($search) {
                $query->where('name_ar', 'like', '%' . $search . '%')
                    ->orWhere('name_en', 'like', '%' . $search . '%');
            })
            ->orderBy('id', 'desc')->paginate(10);

        return view('backend.all_messages', compact('all_messages'));
    }



    // مسح جميع الإشعارات
    public function markAsRead_all(Request $request)
    {
        auth()->user()->unreadNotifications->markAsRead();
        toast('تم مسح جميع الإشعارات بنجاح بنجاح', 'success');
        return redirect()->back();
    }


    // مسح إشعار واحد فقط
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();
        $notification->markAsRead();
        toast('تم مسح الاشعار بنجاح بنجاح', 'success');
        return redirect()->back();
    }

    public function edit_messages_status(Request $request, $id)
    {
        $message = Message::find($id);
        $message->update([
            'employee_id' => $request->employee_id,
            'title' => $request->title,
            'notes' => $request->notes,
            'status' => $request->status,
        ]);
        toast('تم التعديل بنجاح', 'success');
        return redirect()->route('all_messages');
    }



    // عرض التقارير الاجمالية
    public function show_reports_all()
    {
        // Customer and Service Data
        $customers_count = DB::table('customers')->count();
        $services_count = DB::table('services')->count();
        $customer_categories_count = DB::table('customer_categories')->count();

        // Invoice Data
        $invoices_count = DB::table('invoices')->count();
        $invoices_subtotal = DB::table('invoices')->sum('subtotal');
        $invoices_discount = DB::table('invoices')->sum('discount');
        $invoices_tax = DB::table('invoices')->sum('tax');
        $invoices_total = DB::table('invoices')->sum('total');

        // Invoice Items
        $invoice_items_count = DB::table('invoice_items')->count();
        $invoice_items_total = DB::table('invoice_items')->sum('total_price');

        // Quotations
        $quotations_count = DB::table('quotations')->count();
        $quotations_total = DB::table('quotations')->sum('total');

        // Invoice Installments
        $installments_count = DB::table('invoice_installments')->count();
        $installments_total = DB::table('invoice_installments')->sum('amount');
        $installments_paid_count = DB::table('invoice_installments')->where('status', 'paid')->count();
        $installments_unpaid_count = DB::table('invoice_installments')->where('status', 'unpaid')->count();

        // اجمالي المدفوعات
        $payment_amount = DB::table('invoice_payments')->sum('amount');

        // اجمالي المصروفات
        $total_Expenses = DB::table('expenses')->sum('amount');

        // اجمالي ضريبة المصروفات
        $total_expense_tax_amount = DB::table('expenses')->sum('tax_amount');

        // اجمالي المصروفات شامل الضريبة
        $total_expense_amount_with_tax = DB::table('expenses')->sum('amount_with_tax');

        // اجمالي الايرادات
        $total_Incomes = DB::table('incomes')->sum('amount');

        // اجمالي ضريبة الإيرادات
        $total_Incomes_tax_amount = DB::table('incomes')->sum('tax_amount');

        // اجمالي الإيرادات شامل الضريبة
        $total_Incomes_amount_with_tax = DB::table('incomes')->sum('amount_with_tax');


        // اجمالي الأصول
        $total_assets = DB::table('assets')->sum('amount');

        // اجمالي ضريبة الأصول
        $total_assets_tax_amount = DB::table('assets')->sum('tax_amount');

        // اجمالي الأصول شامل الضريبة
        $total_assets_amount_with_tax = DB::table('assets')->sum('amount_with_tax');


        // الموارد البشرية
        // Employee Count
        $employee_count = DB::table('employees')->count();

        // trainees Count
        $trainees_count = DB::table('trainees')->count();

        // studentsContracts Count
        $contracts_count = DB::table('contracts')->count();

        // total_Salary_amount
        $total_Salary_amount = DB::table('salaries')->sum('amount');

        // total_allowance_amount
        $total_allowance_amount = DB::table('allowances')->sum('amount');

        // total_discount_amount
        $total_discount_amount = DB::table('discounts')->sum('amount');

        $payment_method_balances = DB::table('payment_method_balances')
            ->join('payment_methods', 'payment_method_balances.payment_method_id', '=', 'payment_methods.id')
            ->select('payment_methods.name_ar', 'payment_methods.name_en', 'payment_method_balances.current_balance')
            ->get();

        $total_current_balances = DB::table('payment_method_balances')->sum('current_balance');



        return view(
            'backend.show_reports_all',
            compact(
                'customers_count',
                'services_count',
                'customer_categories_count',
                'invoices_count',
                'invoices_subtotal',
                'invoices_discount',
                'invoices_tax',
                'invoices_total',
                'invoice_items_count',
                'invoice_items_total',
                'quotations_count',
                'quotations_total',
                'installments_count',
                'installments_total',
                'installments_paid_count',
                'installments_unpaid_count',
                'payment_amount',
                'total_Expenses',
                'total_expense_tax_amount',
                'total_expense_amount_with_tax',
                'total_Incomes',
                'total_Incomes_tax_amount',
                'total_Incomes_amount_with_tax',
                'total_assets',
                'total_assets_tax_amount',
                'total_assets_amount_with_tax',
                'employee_count',
                'trainees_count',
                'contracts_count',
                'total_Salary_amount',
                'total_allowance_amount',
                'total_discount_amount',
                'payment_method_balances',
                'total_current_balances'
            )
        );
    }


    // تقرير الكل بين تاريخين
    public function reports_all_between_two_dates(Request $request)
    {
        $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $end_date = Carbon::parse($request->end_date)->format('Y-m-d');

        // Customer and Service Data
        $customers_count = DB::table('customers')
            ->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)
            ->count();
        $services_count = DB::table('services')
            ->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)
            ->count();
        $customer_categories_count = DB::table('customer_categories')
            ->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)
            ->count();

        // Invoice Data
        $invoices_count = DB::table('invoices')
            ->whereDate('invoice_date', '>=', $start_date)->whereDate('invoice_date', '<=', $end_date)
            ->count();
        $invoices_subtotal = DB::table('invoices')
            ->whereDate('invoice_date', '>=', $start_date)->whereDate('invoice_date', '<=', $end_date)
            ->sum('subtotal');
        $invoices_discount = DB::table('invoices')
            ->whereDate('invoice_date', '>=', $start_date)->whereDate('invoice_date', '<=', $end_date)
            ->sum('discount');
        $invoices_tax = DB::table('invoices')
            ->whereDate('invoice_date', '>=', $start_date)->whereDate('invoice_date', '<=', $end_date)
            ->sum('tax');
        $invoices_total = DB::table('invoices')
            ->whereDate('invoice_date', '>=', $start_date)->whereDate('invoice_date', '<=', $end_date)
            ->sum('total');

        // Invoice Items
        $invoice_items_count = DB::table('invoice_items')
            ->join('invoices', 'invoice_items.invoice_id', '=', 'invoices.id')
            ->whereDate('invoices.invoice_date', '>=', $start_date)->whereDate('invoices.invoice_date', '<=', $end_date)
            ->count();
        $invoice_items_total = DB::table('invoice_items')
            ->join('invoices', 'invoice_items.invoice_id', '=', 'invoices.id')
            ->whereDate('invoices.invoice_date', '>=', $start_date)->whereDate('invoices.invoice_date', '<=', $end_date)
            ->sum('invoice_items.total_price');

        // Quotations
        $quotations_count = DB::table('quotations')
            ->whereDate('quotation_date', '>=', $start_date)->whereDate('quotation_date', '<=', $end_date)
            ->count();
        $quotations_total = DB::table('quotations')
            ->whereDate('quotation_date', '>=', $start_date)->whereDate('quotation_date', '<=', $end_date)
            ->sum('total');

        // Invoice Installments
        $installments_count = DB::table('invoice_installments')
            ->whereDate('due_date', '>=', $start_date)->whereDate('due_date', '<=', $end_date)
            ->count();
        $installments_total = DB::table('invoice_installments')
            ->whereDate('due_date', '>=', $start_date)->whereDate('due_date', '<=', $end_date)
            ->sum('amount');
        $installments_paid_count = DB::table('invoice_installments')
            ->whereDate('due_date', '>=', $start_date)->whereDate('due_date', '<=', $end_date)
            ->where('status', 'paid')->count();
        $installments_unpaid_count = DB::table('invoice_installments')
            ->whereDate('due_date', '>=', $start_date)->whereDate('due_date', '<=', $end_date)
            ->where('status', 'unpaid')->count();

        $payment_amount = DB::table('invoice_payments')
            ->whereDate('payment_date', '>=', $start_date)
            ->whereDate('payment_date', '<=', $end_date)
            ->sum('amount');


        // اجمالي المصروفات
        $total_Expenses = DB::table('expenses')
            ->whereDate('expense_date', '>=', $start_date)->whereDate('expense_date', '<=', $end_date)
            ->sum('amount');

        // اجمالي ضريبة المصروفات
        $total_expense_tax_amount = DB::table('expenses')
            ->whereDate('expense_date', '>=', $start_date)->whereDate('expense_date', '<=', $end_date)
            ->sum('tax_amount');

        // اجمالي المصروفات شامل الضريبة
        $total_expense_amount_with_tax = DB::table('expenses')
            ->whereDate('expense_date', '>=', $start_date)->whereDate('expense_date', '<=', $end_date)
            ->sum('amount_with_tax');

        // اجمالي الايرادات
        $total_Incomes = DB::table('incomes')
            ->whereDate('expense_date', '>=', $start_date)->whereDate('expense_date', '<=', $end_date)
            ->sum('amount');

        // اجمالي ضريبة الإيرادات
        $total_Incomes_tax_amount = DB::table('incomes')
            ->whereDate('expense_date', '>=', $start_date)->whereDate('expense_date', '<=', $end_date)
            ->sum('tax_amount');

        // اجمالي الإيرادات شامل الضريبة
        $total_Incomes_amount_with_tax = DB::table('incomes')
            ->whereDate('expense_date', '>=', $start_date)->whereDate('expense_date', '<=', $end_date)
            ->sum('amount_with_tax');


        // اجمالي الأصول
        $total_assets = DB::table('assets')
            ->whereDate('expense_date', '>=', $start_date)->whereDate('expense_date', '<=', $end_date)
            ->sum('amount');

        // اجمالي ضريبة الأصول
        $total_assets_tax_amount = DB::table('assets')
            ->whereDate('expense_date', '>=', $start_date)->whereDate('expense_date', '<=', $end_date)
            ->sum('tax_amount');

        // اجمالي الأصول شامل الضريبة
        $total_assets_amount_with_tax = DB::table('assets')
            ->whereDate('expense_date', '>=', $start_date)->whereDate('expense_date', '<=', $end_date)
            ->sum('amount_with_tax');



        // الموارد البشرية
        // Employee Count
        $employee_count = DB::table('employees')
            ->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)
            ->count();

        // trainees Count
        $trainees_count = DB::table('trainees')
            ->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)
            ->count();

        // studentsContracts Count
        $contracts_count = DB::table('contracts')
            ->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)
            ->count();

        // total_Salary_amount
        $total_Salary_amount = DB::table('salaries')
            ->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)
            ->sum('amount');

        // total_allowance_amount
        $total_allowance_amount = DB::table('allowances')
            ->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)
            ->sum('amount');

        // total_discount_amount
        $total_discount_amount = DB::table('discounts')
            ->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)
            ->sum('amount');

        $payment_method_balances = DB::table('payment_method_balances')
            ->join('payment_methods', 'payment_method_balances.payment_method_id', '=', 'payment_methods.id')
            ->select('payment_methods.name_ar', 'payment_methods.name_en', 'payment_method_balances.current_balance')
            ->whereDate('payment_method_balances.created_at', '>=', $start_date)->whereDate('payment_method_balances.created_at', '<=', $end_date)
            ->get();
        $total_current_balances = DB::table('payment_method_balances')
            ->whereDate('payment_method_balances.created_at', '>=', $start_date)->whereDate('payment_method_balances.created_at', '<=', $end_date)
            ->sum('current_balance');

        return view(
            'backend.reports_all_between_two_dates',
            compact(
                'start_date',
                'end_date',
                'customers_count',
                'services_count',
                'customer_categories_count',
                'invoices_count',
                'invoices_subtotal',
                'invoices_discount',
                'invoices_tax',
                'invoices_total',
                'invoice_items_count',
                'invoice_items_total',
                'quotations_count',
                'quotations_total',
                'installments_count',
                'installments_total',
                'installments_paid_count',
                'installments_unpaid_count',
                'payment_amount',
                'total_Expenses',
                'total_expense_tax_amount',
                'total_expense_amount_with_tax',
                'total_Incomes',
                'total_Incomes_tax_amount',
                'total_Incomes_amount_with_tax',
                'total_assets',
                'total_assets_tax_amount',
                'total_assets_amount_with_tax',
                'employee_count',
                'trainees_count',
                'contracts_count',
                'total_Salary_amount',
                'total_allowance_amount',
                'total_discount_amount',
                'payment_method_balances',
                'total_current_balances'
            )
        );
    }



    // تقارير الموارد البشرية بين تاريخين
    public function reports_hr_between_two_dates(Request $request)
    {
        if ($request->employee_id == 0) {
            $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
            $end_date = Carbon::parse($request->end_date)->format('Y-m-d');

            $salaries = Salary::whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)->get();
            $discounts = Discount::whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)->get();
            $allowances = Allowance::whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)->get();
            $holidays = Holiday::whereDate('date_request', '>=', $start_date)->whereDate('date_request', '<=', $end_date)->get();

            return view(
                'backend.HR.reports_hr_between_two_dates',
                compact(
                    'start_date',
                    'end_date',
                    'salaries',
                    'discounts',
                    'allowances',
                    'holidays',
                )
            );
        } else {
            $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
            $end_date = Carbon::parse($request->end_date)->format('Y-m-d');

            $salaries = Salary::whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)->where('employee_id', $request->employee_id)->get();
            $discounts = Discount::whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)->where('employee_id', $request->employee_id)->get();
            $allowances = Allowance::whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)->where('employee_id', $request->employee_id)->get();
            $holidays = Holiday::whereDate('date_request', '>=', $start_date)->whereDate('date_request', '<=', $end_date)->where('employee_id', $request->employee_id)->get();

            return view(
                'backend.HR.reports_hr_between_two_dates',
                compact(
                    'start_date',
                    'end_date',
                    'salaries',
                    'discounts',
                    'allowances',
                    'holidays',
                )
            );
        }
    }

    // تقارير الفواتير - Invoice Reports
    public function reports_invoices(Request $request)
    {
        // Set default dates to today
        $start_date = $request->start_date ?? date('Y-m-d');
        $end_date = $request->end_date ?? date('Y-m-d');

        // Get customers and statuses for filters
        $customers = \App\Models\Customer::orderBy('name')->get();
        $invoice_statuses = \App\Models\InvoiceStatus::all();

        // Only run query if filters are applied
        if ($request->has('start_date') || $request->has('customer_id') || $request->has('invoice_status_id')) {
            $query = \App\Models\Invoice::with(['customer', 'status', 'user']);

            // Apply filters
            if ($request->customer_id) {
                $query->where('customer_id', $request->customer_id);
            }

            if ($request->invoice_status_id) {
                $query->where('invoice_status_id', $request->invoice_status_id);
            }

            // Apply date filter
            $query->whereBetween('invoice_date', [
                Carbon::parse($start_date)->format('Y-m-d'),
                Carbon::parse($end_date)->format('Y-m-d')
            ]);

            // Calculate summary
            $total_invoices = $query->count();
            $total_amount = $query->sum('total');
            $total_paid = $query->sum('paid_amount');
            $total_remaining = $query->sum('remaining_amount');

            // Get paginated results
            $invoices = $query->orderBy('invoice_date', 'desc')->paginate(50);
        } else {
            // No filters applied, return empty results
            $invoices = \App\Models\Invoice::whereRaw('1 = 0')->paginate(50);
            $total_invoices = 0;
            $total_amount = 0;
            $total_paid = 0;
            $total_remaining = 0;
        }

        return view('backend.pages.reports.reports_invoices', compact(
            'invoices',
            'customers',
            'invoice_statuses',
            'total_invoices',
            'total_amount',
            'total_paid',
            'total_remaining',
            'start_date',
            'end_date'
        ));
    }

    // Export invoices to Excel
    public function export_reports_invoices_excel(Request $request)
    {
        $fileName = 'invoices_report_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\InvoicesReportExport($request->customer_id, $request->invoice_status_id, $request->start_date, $request->end_date),
            $fileName
        );
    }

    // تقارير مدفوعات الفواتير - Invoice Payments Reports
    public function reports_invoice_payments(Request $request)
    {
        // Set default dates to today
        $start_date = $request->start_date ?? date('Y-m-d');
        $end_date = $request->end_date ?? date('Y-m-d');

        // Get customers and payment methods for filters
        $customers = \App\Models\Customer::orderBy('name')->get();
        $payment_methods = \App\Models\Payment_method::all();

        // Only run query if filters are applied
        if ($request->has('start_date') || $request->has('customer_id') || $request->has('payment_method_id')) {
            $query = \App\Models\InvoicePayment::with(['invoice.customer', 'paymentMethod', 'user']);

            // Apply filters
            if ($request->customer_id) {
                $query->whereHas('invoice', function ($q) use ($request) {
                    $q->where('customer_id', $request->customer_id);
                });
            }

            if ($request->payment_method_id) {
                $query->where('payment_method_id', $request->payment_method_id);
            }

            // Apply date filter
            $query->whereBetween('payment_date', [
                Carbon::parse($start_date)->format('Y-m-d'),
                Carbon::parse($end_date)->format('Y-m-d')
            ]);

            // Calculate summary
            $total_payments = $query->count();
            $total_amount = $query->sum('amount');

            // Get paginated results
            $invoice_payments = $query->orderBy('payment_date', 'desc')->paginate(50);
        } else {
            // No filters applied, return empty results
            $invoice_payments = \App\Models\InvoicePayment::whereRaw('1 = 0')->paginate(50);
            $total_payments = 0;
            $total_amount = 0;
        }

        return view('backend.pages.reports.reports_invoice_payments', compact(
            'invoice_payments',
            'customers',
            'payment_methods',
            'total_payments',
            'total_amount',
            'start_date',
            'end_date'
        ));
    }

    // Export invoice payments to Excel
    public function export_reports_invoice_payments_excel(Request $request)
    {
        $fileName = 'invoice_payments_report_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\InvoicePaymentsReportExport($request->customer_id, $request->payment_method_id, $request->start_date, $request->end_date),
            $fileName
        );
    }

    // تقارير عروض الأسعار - Quotations Reports
    public function reports_quotations(Request $request)
    {
        // Set default dates to today
        $start_date = $request->start_date ?? date('Y-m-d');
        $end_date = $request->end_date ?? date('Y-m-d');

        // Get customers for filters
        $customers = \App\Models\Customer::orderBy('name')->get();

        // Only run query if filters are applied
        if ($request->has('start_date') || $request->has('customer_id') || $request->has('status')) {
            $query = \App\Models\Quotation::with(['customer', 'user', 'convertedInvoice']);

            // Apply filters
            if ($request->customer_id) {
                $query->where('customer_id', $request->customer_id);
            }

            if ($request->status) {
                $query->where('status', $request->status);
            }

            // Apply date filter
            $query->whereBetween('quotation_date', [
                Carbon::parse($start_date)->format('Y-m-d'),
                Carbon::parse($end_date)->format('Y-m-d')
            ]);

            // Calculate summary
            $total_quotations = $query->count();
            $total_amount = $query->sum('total');
            $accepted_count = (clone $query)->where('status', 'accepted')->count();
            $rejected_count = (clone $query)->where('status', 'rejected')->count();
            $converted_count = (clone $query)->whereNotNull('converted_invoice_id')->count();

            // Get paginated results
            $quotations = $query->orderBy('quotation_date', 'desc')->paginate(50);
        } else {
            // No filters applied, return empty results
            $quotations = \App\Models\Quotation::whereRaw('1 = 0')->paginate(50);
            $total_quotations = 0;
            $total_amount = 0;
            $accepted_count = 0;
            $rejected_count = 0;
            $converted_count = 0;
        }

        return view('backend.pages.reports.reports_quotations', compact(
            'quotations',
            'customers',
            'total_quotations',
            'total_amount',
            'accepted_count',
            'rejected_count',
            'converted_count',
            'start_date',
            'end_date'
        ));
    }

    // Export quotations to Excel
    public function export_reports_quotations_excel(Request $request)
    {
        $fileName = 'quotations_report_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\QuotationsReportExport($request->customer_id, $request->status, $request->start_date, $request->end_date),
            $fileName
        );
    }

    // تقارير الأقساط - Installments Reports
    public function reports_installments(Request $request)
    {
        // Set default dates to today
        $start_date = $request->start_date ?? date('Y-m-d');
        $end_date = $request->end_date ?? date('Y-m-d');

        $query = \App\Models\InvoiceInstallment::with(['invoice.customer']);

        // Apply filters
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Apply date filter
        $query->whereBetween('due_date', [
            Carbon::parse($start_date)->format('Y-m-d'),
            Carbon::parse($end_date)->format('Y-m-d')
        ]);

        if ($request->show_overdue_only) {
            $query->where('status', 'unpaid')
                ->where('due_date', '<', now()->toDateString());
        }

        // Calculate summary
        $total_installments = $query->count();
        $total_amount = $query->sum('amount');
        $paid_count = (clone $query)->where('status', 'paid')->count();
        $paid_amount = (clone $query)->where('status', 'paid')->sum('amount');
        $unpaid_count = (clone $query)->where('status', 'unpaid')->count();
        $unpaid_amount = (clone $query)->where('status', 'unpaid')->sum('amount');
        $overdue_count = \App\Models\InvoiceInstallment::where('status', 'unpaid')
            ->where('due_date', '<', now()->toDateString())->count();
        $overdue_amount = \App\Models\InvoiceInstallment::where('status', 'unpaid')
            ->where('due_date', '<', now()->toDateString())->sum('amount');

        // Get paginated results
        $installments = $query->orderBy('due_date', 'asc')->paginate(50);

        return view('backend.pages.reports.reports_installments', compact(
            'installments',
            'total_installments',
            'total_amount',
            'paid_count',
            'paid_amount',
            'unpaid_count',
            'unpaid_amount',
            'overdue_count',
            'overdue_amount',
            'start_date',
            'end_date'
        ));
    }

    // Export installments to Excel
    public function export_reports_installments_excel(Request $request)
    {
        $fileName = 'installments_report_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\InstallmentsReportExport($request->status, $request->start_date, $request->end_date, $request->show_overdue_only),
            $fileName
        );
    }
}
