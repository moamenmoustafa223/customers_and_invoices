@extends('backend.layouts.master')
@section('page_title')
    {{ trans('back.show_customer') }}
@endsection

@section('content')
    <div>
        <a class="btn btn-primary btn-sm mb-1" href="{{ route('customers.index') }}">
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
                            <h4>{{ trans('back.customer') }}</h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <td width="200"><strong>{{ trans('back.customer_name') }}:</strong></td>
                                <td>{{ $customer->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ trans('back.customer_category') }}:</strong></td>
                                <td>{{ app()->getLocale() == 'ar' ? $customer->category->name_ar : $customer->category->name_en }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ trans('back.phone') }}:</strong></td>
                                <td>{{ $customer->phone }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ trans('back.email') }}:</strong></td>
                                <td>{{ $customer->email }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ trans('back.status') }}:</strong></td>
                                <td>
                                    @if ($customer->status == 'active')
                                        <span class="badge bg-success">{{ trans('back.active') }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ trans('back.inactive') }}</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <td width="200"><strong>{{ trans('back.address_ar') }}:</strong></td>
                                <td>{{ $customer->address_ar }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ trans('back.address_en') }}:</strong></td>
                                <td>{{ $customer->address_en }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ trans('back.notes_ar') }}:</strong></td>
                                <td>{{ $customer->notes_ar }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ trans('back.notes_en') }}:</strong></td>
                                <td>{{ $customer->notes_en }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if ($customer->invoices->count() > 0)
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="mb-3">{{ trans('back.invoices') }}</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered text-center table-sm">
                                    <thead class="thead-light">
                                        <tr style="background-color: #b5d7ea">
                                            <th>#</th>
                                            <th>{{ trans('back.invoice_number') }}</th>
                                            <th>{{ trans('back.invoice_date') }}</th>
                                            <th>{{ trans('back.total') }}</th>
                                            <th>{{ trans('back.status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customer->invoices as $key => $invoice)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $invoice->invoice_number }}</td>
                                                <td>{{ $invoice->invoice_date }}</td>
                                                <td>{{ number_format($invoice->total, 3) }}</td>
                                                <td>
                                                    <span class="badge"
                                                        style="background-color: {{ $invoice->status->color }}">
                                                        {{ app()->getLocale() == 'ar' ? $invoice->status->name_ar : $invoice->status->name_en }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($customer->quotations->count() > 0)
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="mb-3">{{ trans('back.quotations') }}</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered text-center table-sm">
                                    <thead class="thead-light">
                                        <tr style="background-color: #b5d7ea">
                                            <th>#</th>
                                            <th>{{ trans('back.quotation_number') }}</th>
                                            <th>{{ trans('back.quotation_date') }}</th>
                                            <th>{{ trans('back.total') }}</th>
                                            <th>{{ trans('back.status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customer->quotations as $key => $quotation)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $quotation->quotation_number }}</td>
                                                <td>{{ $quotation->quotation_date }}</td>
                                                <td>{{ number_format($quotation->total, 3) }}</td>
                                                <td>
                                                    @if ($quotation->status == 'pending')
                                                        <span class="badge bg-warning">{{ trans('back.pending') }}</span>
                                                    @elseif($quotation->status == 'accepted')
                                                        <span class="badge bg-success">{{ trans('back.accepted') }}</span>
                                                    @elseif($quotation->status == 'rejected')
                                                        <span class="badge bg-danger">{{ trans('back.rejected') }}</span>
                                                    @else
                                                        <span class="badge bg-info">{{ trans('back.converted') }}</span>
                                                    @endif
                                                </td>
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
