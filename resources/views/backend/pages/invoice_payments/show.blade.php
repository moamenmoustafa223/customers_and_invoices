@extends('backend.layouts.master')
@section('page_title')
    {{ trans('back.show_invoice_payment') }}
@endsection

@section('content')
    <div class="mb-2">
        <a class="btn btn-primary btn-sm" href="{{ route('invoice_payments.index') }}">
            <i class="fas fa-undo"></i> {{ trans('back.Turn_back') }}
        </a>
        @can('print_invoice_payment')
            <a class="btn btn-secondary btn-sm" href="{{ route('invoice_payments.print', $invoicePayment->id) }}" target="_blank">
                <i class="fas fa-print"></i> {{ trans('back.print') }}
            </a>
        @endcan
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center font-weight-bold mb-3">
                            <h4>{{ trans('back.invoice_payment') }}</h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-3">{{ trans('back.payment_information') }}</h5>
                        <table class="table table-sm table-bordered">
                            <tr>
                                <td width="200"><strong>{{ trans('back.payment_number') }}:</strong></td>
                                <td>{{ $invoicePayment->payment_number }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ trans('back.payment_date') }}:</strong></td>
                                <td>{{ $invoicePayment->payment_date->format('Y-m-d') }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ trans('back.amount') }}:</strong></td>
                                <td><strong class="text-success">{{ number_format($invoicePayment->amount, 3) }}</strong></td>
                            </tr>
                            <tr>
                                <td><strong>{{ trans('back.payment_method') }}:</strong></td>
                                <td>{{ app()->getLocale() == 'ar' ? $invoicePayment->paymentMethod->name_ar : $invoicePayment->paymentMethod->name_en }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <h5 class="mb-3">{{ trans('back.invoice_information') }}</h5>
                        <table class="table table-sm table-bordered">
                            <tr>
                                <td width="200"><strong>{{ trans('back.invoice_number') }}:</strong></td>
                                <td>
                                    <a href="{{ route('invoices.show', $invoicePayment->invoice->id) }}">
                                        {{ $invoicePayment->invoice->invoice_number }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>{{ trans('back.customer_name') }}:</strong></td>
                                <td>{{ $invoicePayment->invoice->customer->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ trans('back.customer_phone') }}:</strong></td>
                                <td>{{ $invoicePayment->invoice->customer->phone }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ trans('back.invoice_total') }}:</strong></td>
                                <td>{{ number_format($invoicePayment->invoice->total, 3) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($invoicePayment->notes_ar || $invoicePayment->notes_en)
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h5 class="mb-3">{{ trans('back.notes') }}</h5>
                            <table class="table table-sm table-bordered">
                                @if($invoicePayment->notes_ar)
                                    <tr>
                                        <td width="200"><strong>{{ trans('back.notes_ar') }}:</strong></td>
                                        <td>{{ $invoicePayment->notes_ar }}</td>
                                    </tr>
                                @endif
                                @if($invoicePayment->notes_en)
                                    <tr>
                                        <td width="200"><strong>{{ trans('back.notes_en') }}:</strong></td>
                                        <td>{{ $invoicePayment->notes_en }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
