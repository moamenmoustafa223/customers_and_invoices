@extends('backend.layouts.master')

@section('page_title')
    {{trans('back.reports_invoice_payments')}}
@endsection

@section('content')

<div class="row">
    <div class="col-md-12 mb-2">
        {{-- Filter Form --}}
        <form method="POST">
            @csrf
            <div class="row g-3 align-items-end">

                {{-- Customer Filter --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">{{ trans('back.customer') }}</label>
                    <select name="customer_id" class="form-control form-control-sm">
                        <option value="">{{ trans('back.all') }}</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id', request('customer_id')) == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Payment Method Filter --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">{{ trans('back.payment_method') }}</label>
                    <select name="payment_method_id" class="form-control form-control-sm">
                        <option value="">{{ trans('back.all') }}</option>
                        @foreach($payment_methods as $method)
                            <option value="{{ $method->id }}" {{ old('payment_method_id', request('payment_method_id')) == $method->id ? 'selected' : '' }}>
                                {{ app()->getLocale() == 'ar' ? $method->name_ar : $method->name_en }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Start Date --}}
                <div class="col-md-2">
                    <label class="form-label fw-semibold">{{ trans('back.start_date') }}</label>
                    <input name="start_date" type="date" class="form-control form-control-sm"
                        value="{{ old('start_date', request('start_date', date('Y-m-d'))) }}">
                </div>

                {{-- End Date --}}
                <div class="col-md-2">
                    <label class="form-label fw-semibold">{{ trans('back.end_date') }}</label>
                    <input name="end_date" type="date" class="form-control form-control-sm"
                        value="{{ old('end_date', request('end_date', date('Y-m-d'))) }}">
                </div>

                {{-- Action Buttons --}}
                <div class="col-md-2 d-flex gap-2 mt-2">
                    <button type="submit" formaction="{{ route('reports_invoice_payments') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-search me-1"></i> {{ trans('back.Search') }}
                    </button>

                    <button type="submit" formaction="{{ route('export_reports_invoice_payments_excel') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-file-excel me-1"></i> Excel
                    </button>

                    <a href="{{ route('reports_invoice_payments') }}" class="btn btn-sm btn-warning" title="{{ trans('global.reset') }}">
                        <i class="fas fa-sync-alt"></i>
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>

{{-- Summary Cards --}}
<div class="row mb-3">
    <div class="col-md-6">
        <div class="card-box text-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="text-white">
                <h4 class="mb-0">{{ $total_payments }}</h4>
                <p class="mb-0">{{ trans('back.total_payments') }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card-box text-center" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="text-white">
                <h4 class="mb-0">{{ number_format($total_amount, 3) }}</h4>
                <p class="mb-0">{{ trans('back.total_amount') }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card-box">

            <div class="table-responsive">
                <table class="table table-bordered text-center table-sm">
                    <thead>
                    <tr style="background-color: rgb(232,245,252)">
                        <th width="25">#</th>
                        <th width="100">{{trans('back.payment_number')}}</th>
                        <th width="100">{{trans('back.invoice_number')}}</th>
                        <th width="150">{{trans('back.customer')}}</th>
                        <th width="100">{{trans('back.payment_date')}}</th>
                        <th width="100">{{trans('back.payment_method')}}</th>
                        <th width="100">{{trans('back.amount')}}</th>
                        <th width="100">{{trans('back.Action')}}</th>
                        <th width="100">{{trans('back.User')}}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($invoice_payments as $key => $payment)
                        <tr>
                            <td>{{ $key + $invoice_payments->firstItem() }}</td>
                            <td>{{ $payment->payment_number }}</td>
                            <td>
                                <a href="{{ route('invoices.show', $payment->invoice->id) }}">
                                    {{ $payment->invoice->invoice_number }}
                                </a>
                            </td>
                            <td>{{ $payment->invoice->customer->name }}</td>
                            <td>{{ $payment->payment_date->format('Y-m-d') }}</td>
                            <td>
                                @if($payment->paymentMethod)
                                    {{ app()->getLocale() == 'ar' ? $payment->paymentMethod->name_ar : $payment->paymentMethod->name_en }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ number_format($payment->amount, 3) }}</td>
                            <td>
                                <a href="{{ route('invoice_payments.show', $payment->id) }}" class="text-primary" title="{{ trans('back.Show') }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('invoice_payment_number', $payment->payment_number) }}" class="text-success ml-1" target="_blank" title="{{ trans('back.Print') }}">
                                    <i class="fas fa-print"></i>
                                </a>
                            </td>
                            <td>{{ $payment->user->name ?? '-' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="background-color: rgb(232,245,252); font-weight: bold;">
                            <th colspan="6">{{ trans('back.Total') }}</th>
                            <th>{{ number_format($total_amount, 3) }}</th>
                            <th colspan="2"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {!! $invoice_payments->appends(Request::all())->links() !!}

        </div>
    </div>
</div>

@endsection
