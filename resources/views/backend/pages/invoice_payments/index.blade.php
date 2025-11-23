@extends('backend.layouts.master')

@section('page_title')
    {{trans('back.invoice_payments')}}
@endsection


@section('content')


<div class="row g-1 align-items-end mb-2">
    <div class="col-md-12">
        <form action="{{ route('invoice_payments.index') }}" method="GET">
            <div class="row g-1">

                {{-- Search --}}
                <div class="col-md-2">
                    <label class="form-label fw-semibold small mb-1">{{ trans('back.Search') }}</label>
                    <input type="text" name="query" class="form-control form-control-sm"
                        placeholder="{{ trans('back.payment_number') }}, {{ trans('back.invoice_number') }}, {{ trans('back.customer') }}"
                        value="{{ request('query') }}">
                </div>

                {{-- Customer Filter --}}
                <div class="col-md-2">
                    <label class="form-label fw-semibold small mb-1">{{ trans('back.select_customer') }}</label>
                    <select name="customer_id" class="form-select form-select-sm">
                        <option value="">{{ trans('back.All') }}</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Payment Method Filter --}}
                <div class="col-md-2">
                    <label class="form-label fw-semibold small mb-1">{{ trans('back.payment_method') }}</label>
                    <select name="payment_method_id" class="form-select form-select-sm">
                        <option value="">{{ trans('back.All') }}</option>
                        @foreach($paymentMethods as $method)
                            <option value="{{ $method->id }}" {{ request('payment_method_id') == $method->id ? 'selected' : '' }}>
                                {{ app()->getLocale() == 'ar' ? $method->name_ar : $method->name_en }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- From Date --}}
                <div class="col-md-2">
                    <label class="form-label fw-semibold small mb-1">{{ trans('back.from_date') }}</label>
                    <input type="date" name="from_date" class="form-control form-control-sm" value="{{ request('from_date') }}">
                </div>

                {{-- To Date --}}
                <div class="col-md-2">
                    <label class="form-label fw-semibold small mb-1">{{ trans('back.to_date') }}</label>
                    <input type="date" name="to_date" class="form-control form-control-sm" value="{{ request('to_date') }}">
                </div>

                {{-- Action Buttons --}}
                <div class="col-md-2 d-flex gap-1 align-items-end">
                    <button class="btn btn-primary" type="submit" title="{{ trans('back.Search') }}">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="{{ route('invoice_payments.index') }}" class="btn btn-success" title="{{ trans('back.refresh') }}">
                        <i class="fas fa-sync-alt"></i>
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>

    <div class="row">
        @if($invoicePayments->count() > 0)
            <div class="col-12">
                <div class="card-box">
                    <div class="table-responsive">
                        <table id="" class="table table-bordered text-center table-sm">
                            <thead>
                            <tr>
                                <th width="30">#</th>
                                <th width="120">{{trans('back.payment_number')}}</th>
                                <th width="120">{{trans('back.invoice_number')}}</th>
                                <th width="150">{{trans('back.customer')}}</th>
                                <th width="100">{{trans('back.payment_date')}}</th>
                                <th width="100" style="background-color: #cce5ec">{{trans('back.amount')}}</th>
                                <th width="120">{{trans('back.payment_method')}}</th>
                                <th width="200">{{trans('back.actions')}}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($invoicePayments as $key => $payment)
                                <tr>
                                    <td>{{$key + $invoicePayments->firstItem()}}</td>
                                    <td>{{$payment->payment_number}}</td>
                                    <td>{{$payment->invoice->invoice_number ?? 'N/A'}}</td>
                                    <td>
                                        {{ $payment->invoice->customer->name ?? 'N/A' }}
                                        <br>
                                        <small class="text-muted">{{ $payment->invoice->customer->phone ?? 'N/A' }}</small>
                                    </td>
                                    <td>{{$payment->payment_date->format('Y-m-d')}}</td>
                                    <td style="background-color: #cce5ec">{{number_format($payment->amount, 3)}}</td>
                                    <td>
                                        {{ app()->getLocale() == 'ar' ? $payment->paymentMethod->name_ar : $payment->paymentMethod->name_en }}
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            @can('show_invoice_payment')
                                                <a href="{{ route('invoice_payments.show', $payment->id) }}" class="btn btn-sm btn-info" title="{{ trans('back.show') }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endcan

                                            @can('edit_invoice_payment')
                                                <a href="{{ route('invoice_payments.edit', $payment->id) }}" class="btn btn-sm btn-primary" title="{{ trans('back.edit') }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endcan

                                            @can('print_invoice_payment')
                                                <a href="{{ route('invoice_payments.print', $payment->id) }}" target="_blank" class="btn btn-sm btn-secondary" title="{{ trans('back.print') }}">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                            @endcan

                                            @can('delete_invoice_payment')
                                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_payment{{ $payment->id }}" title="{{ trans('back.delete') }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            @endcan
                                        </div>

                                        {{-- Include delete modal --}}
                                        @include('backend.pages.invoice_payments.delete')
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $invoicePayments->appends(Request::all())->links() !!}
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-12">
                <div class="alert alert-danger text-center">
                    <h4>{{trans('back.none')}}</h4>
                </div>
            </div>
        @endif

    </div>

@endsection
