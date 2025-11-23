@extends('backend.layouts.master')

@section('page_title')
    {{ trans('back.All_report_between_two_dates') }}
@endsection

@section('content')
<style>
    @media print {
        .btn, .no-print {
            display: none !important;
        }
    }

    .report-label {
        font-size: 14px;
        color: #6c757d;
    }

    .report-value {
        font-size: 20px;
        font-weight: bold;
        color: #1a1a1a;
    }

    .report-table td,
    .report-table th {
        vertical-align: middle;
        border: 1px solid #343a40 !important; /* Darker border */
    }

    .report-table {
        border-color: #343a40 !important;
    }
</style>

<div class="row">
    <div class="col-md-12 mb-2">
        <form action="{{ route('reports_all_between_two_dates_post') }}" method="POST" >
            @csrf
            <div class="row g-3 align-items-end">
                {{-- Start Date --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">{{ trans('PaymentsPurchases.start_date') }}</label>
                    <input type="date" name="start_date" class="form-control form-control-sm" value="{{ $start_date ?? '' }}">
                </div>

                {{-- End Date --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">{{ trans('PaymentsPurchases.end_date') }}</label>
                    <input type="date" name="end_date" class="form-control form-control-sm" value="{{ $end_date ?? '' }}">
                </div>

                {{-- Buttons --}}
                <div class="col-md-6 d-flex gap-2 mt-2">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-search me-1"></i> {{ trans('PaymentsPurchases.Search') }}
                    </button>

                    <a href="{{ route('reports_all_between_two_dates') }}" class="btn btn-sm btn-success" title="{{ trans('global.reset') }}">
                        <i class="fas fa-sync-alt"></i>
                    </a>

                    <button type="button" id="btnPrint" onclick="printthispage();" class="btn btn-sm btn-info no-print" title="{{ trans('global.print') }}">
                        <i class="fas fa-print"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Report Data Table -->
<div class="card card-body shadow-sm">
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover report-table table-sm text-center align-middle">
            <tbody>
                {{-- صف 1 - Customer Data --}}
                <tr>
                    <td>
                        <div class="report-label">{{ trans('back.customers_count') }}</div>
                        <div class="report-value">{{ $customers_count }}</div>
                    </td>
                    <td>
                        <div class="report-label">{{ trans('back.services_count') }}</div>
                        <div class="report-value">{{ $services_count }}</div>
                    </td>
                    <td>
                        <div class="report-label">{{ trans('back.customer_categories_count') }}</div>
                        <div class="report-value">{{ $customer_categories_count }}</div>
                    </td>
                    <td>
                        <div class="report-label">{{ trans('back.invoices_count') }}</div>
                        <div class="report-value">{{ $invoices_count }}</div>
                    </td>
                </tr>

                {{-- صف 2 - Invoice Data --}}
                <tr>
                    <td>
                        <div class="report-label">{{ trans('back.invoices_subtotal') }}</div>
                        <div class="report-value">{{ number_format($invoices_subtotal, 3) }}</div>
                    </td>
                    <td>
                        <div class="report-label">{{ trans('back.invoices_discount') }}</div>
                        <div class="report-value">{{ number_format($invoices_discount, 3) }}</div>
                    </td>
                    <td>
                        <div class="report-label">{{ trans('back.invoices_tax') }}</div>
                        <div class="report-value">{{ number_format($invoices_tax, 3) }}</div>
                    </td>
                    <td>
                        <div class="report-label">{{ trans('back.invoices_total') }}</div>
                        <div class="report-value">{{ number_format($invoices_total, 3) }}</div>
                    </td>
                </tr>

                {{-- صف 3 - Invoice Items & Quotations --}}
                <tr>
                    <td>
                        <div class="report-label">{{ trans('back.invoice_items_count') }}</div>
                        <div class="report-value">{{ $invoice_items_count }}</div>
                    </td>
                    <td>
                        <div class="report-label">{{ trans('back.invoice_items_total') }}</div>
                        <div class="report-value">{{ number_format($invoice_items_total, 3) }}</div>
                    </td>
                    <td>
                        <div class="report-label">{{ trans('back.quotations_count') }}</div>
                        <div class="report-value">{{ $quotations_count }}</div>
                    </td>
                    <td>
                        <div class="report-label">{{ trans('back.quotations_total') }}</div>
                        <div class="report-value">{{ number_format($quotations_total, 3) }}</div>
                    </td>
                </tr>

                {{-- صف 4 - Installments & Payments --}}
                <tr>
                    <td>
                        <div class="report-label">{{ trans('back.installments_count') }}</div>
                        <div class="report-value">{{ $installments_count }}</div>
                    </td>
                    <td>
                        <div class="report-label">{{ trans('back.installments_total') }}</div>
                        <div class="report-value">{{ number_format($installments_total, 3) }}</div>
                    </td>
                    <td>
                        <div class="report-label">{{ trans('back.installments_paid') }}</div>
                        <div class="report-value">{{ $installments_paid_count }}</div>
                    </td>
                    <td>
                        <div class="report-label">{{ trans('back.installments_unpaid') }}</div>
                        <div class="report-value">{{ $installments_unpaid_count }}</div>
                    </td>
                </tr>

                {{-- صف 5 - Payments & Expenses --}}
                <tr>
                    <td>
                        <div class="report-label">{{ trans('back.payment_amount') }}</div>
                        <div class="report-value">{{ number_format($payment_amount, 3) }}</div>
                    </td>
                    <td>
                        <div class="report-label">{{ trans('back.total_Expenses') }}</div>
                        <div class="report-value">{{ number_format($total_Expenses, 3) }}</div>
                    </td>
                    <td>
                        <div class="report-label">{{ trans('back.total_expense_tax_amount') }}</div>
                        <div class="report-value">{{ number_format($total_expense_tax_amount, 3) }}</div>
                    </td>
                    <td>
                        <div class="report-label">{{ trans('back.total_expense_amount_with_tax') }}</div>
                        <div class="report-value">{{ number_format($total_expense_amount_with_tax, 3) }}</div>
                    </td>
                </tr>


                {{-- صف 6 - Incomes --}}
                <tr>
                    <td>
                        <div class="report-label">{{ trans('back.total_Incomes') }}</div>
                        <div class="report-value">{{ number_format($total_Incomes, 3) }}</div>
                    </td>
                    <td>
                        <div class="report-label">{{ trans('back.total_Incomes_tax_amount') }}</div>
                        <div class="report-value">{{ number_format($total_Incomes_tax_amount, 3) }}</div>
                    </td>
                    <td>
                        <div class="report-label">{{ trans('back.total_Incomes_amount_with_tax') }}</div>
                        <div class="report-value">{{ number_format($total_Incomes_amount_with_tax, 3) }}</div>
                    </td>
                    <td>
                        <div class="report-label">{{ trans('back.total_assets') }}</div>
                        <div class="report-value">{{ number_format($total_assets, 3) }}</div>
                    </td>
                </tr>

                {{-- صف 7 - Assets & HR --}}
                <tr>
                    <td>
                        <div class="report-label">{{ trans('back.total_assets_tax_amount') }}</div>
                        <div class="report-value">{{ number_format($total_assets_tax_amount, 3) }}</div>
                    </td>
                    <td>
                        <div class="report-label">{{ trans('back.total_assets_amount_with_tax') }}</div>
                        <div class="report-value">{{ number_format($total_assets_amount_with_tax, 3) }}</div>
                    </td>
                    <td>
                        <div class="report-label">{{ trans('back.employee_count') }}</div>
                        <div class="report-value">{{ $employee_count }}</div>
                    </td>
                    <td>
                        <div class="report-label">{{ trans('back.trainees_count') }}</div>
                        <div class="report-value">{{ $trainees_count }}</div>
                    </td>
                </tr>

                {{-- صف 8 - HR Contracts & Salary --}}
                <tr>
                    <td>
                        <div class="report-label">{{ trans('back.contracts_count') }}</div>
                        <div class="report-value">{{ $contracts_count }}</div>
                    </td>
                    <td>
                        <div class="report-label">{{ trans('back.total_Salary_amount') }}</div>
                        <div class="report-value">{{ number_format($total_Salary_amount, 3) }}</div>
                    </td>
                    <td>
                        <div class="report-label">{{ trans('back.total_allowance_amount') }}</div>
                        <div class="report-value">{{ number_format($total_allowance_amount, 3) }}</div>
                    </td>
                    <td>
                        <div class="report-label">{{ trans('back.total_discount_amount') }}</div>
                        <div class="report-value text-danger fw-bold">{{ number_format($total_discount_amount, 3) }}</div>
                    </td>
                </tr>

                {{-- صف 9 - Payment Methods --}}
                <tr>
                    <td colspan="4">
                        <div class="report-label mb-2">{{ trans('back.payment_methods_current_balances') }}</div>
                        <div class="report-value">
                            <div class="row g-2 px-2">
                                @foreach($payment_method_balances as $method)
                                    <div class="col-md-6 col-lg-4">
                                        <div class="d-flex justify-content-between align-items-center bg-light rounded px-3 py-2 border">
                                            <span class="text-dark small">
                                                {{ app()->getLocale() == 'ar' ? $method->name_ar : $method->name_en }}
                                            </span>
                                            <span class="badge bg-warning rounded-pill fs-6 text-dark">
                                                {{ number_format($method->current_balance, 3) }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                
                                {{-- Total --}}
                                <div class="col-12 mt-3">
                                    <div class="d-flex justify-content-between align-items-center bg-success bg-opacity-25 border border-success rounded px-3 py-2">
                                        <span class="fw-bold fs-5">{{ trans('back.total_current_balance') }}</span>
                                        <span class="fw-bold text-dark fs-4">
                                            {{ number_format($total_current_balances, 3) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                
            </tbody>
        </table>
    </div>
    <style>
        .report-value .badge {
font-size: 1rem;
padding: 0.4em 0.8em;
}

    </style>
</div>
@endsection

@section('js')
<script>
    function printthispage() {
        document.getElementById('btnPrint').style.display = 'none';
        window.print();
        document.getElementById('btnPrint').style.display = 'inline-block';
    }
</script>
@endsection
