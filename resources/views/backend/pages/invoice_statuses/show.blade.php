@extends('backend.layouts.master')
@section('page_title')
    {{ trans('back.show_invoice_status') }}
@endsection

@section('content')
    <div>
        <a class="btn btn-primary btn-sm mb-1" href="{{ route('invoice_statuses.index') }}">
            <i class="fas fa-undo"></i>
            {{ trans('back.Turn_back') }}
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center font-weight-bold mb-3">
                            <h4>{{ trans('back.invoice_status') }}</h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <td width="200"><strong>{{ trans('back.name_ar') }}:</strong></td>
                                <td>{{ $invoiceStatus->name_ar }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ trans('back.name_en') }}:</strong></td>
                                <td>{{ $invoiceStatus->name_en }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ trans('back.color') }}:</strong></td>
                                <td>
                                    <span class="badge" style="background-color: {{ $invoiceStatus->color }}">
                                        {{ $invoiceStatus->color }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>{{ trans('back.description_ar') }}:</strong></td>
                                <td>{{ $invoiceStatus->description_ar }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ trans('back.description_en') }}:</strong></td>
                                <td>{{ $invoiceStatus->description_en }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ trans('back.invoices') }}:</strong></td>
                                <td>{{ $invoiceStatus->invoices->count() }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if ($invoiceStatus->invoices->count() > 0)
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="mb-3">{{ trans('back.invoices') }}</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered text-center table-sm">
                                    <thead class="thead-light">
                                        <tr style="background-color: #b5d7ea">
                                            <th>#</th>
                                            <th>{{ trans('back.invoice_number') }}</th>
                                            <th>{{ trans('back.customer_name') }}</th>
                                            <th>{{ trans('back.invoice_date') }}</th>
                                            <th>{{ trans('back.total') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoiceStatus->invoices as $key => $invoice)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $invoice->invoice_number }}</td>
                                                <td>{{ $invoice->customer->name }}</td>
                                                <td>{{ $invoice->invoice_date }}</td>
                                                <td>{{ number_format($invoice->total, 3) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
