@extends('backend.layouts.master')

@section('page_title')
    {{trans('back.invoices')}}
@endsection


@section('content')


<div class="row g-1 align-items-end mb-2">
    <div class="col-md-3">
        @can('add_invoice')
        <a href="{{ route('invoices.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-1"></i> {{ trans('back.add_invoice') }}
        </a>
    @endcan
    </div>
    <div class="col-md-12">
        <form action="{{ route('invoices.index') }}" method="GET">
            <div class="row g-1">

                {{-- Search --}}
                <div class="col-md-2">
                    <label class="form-label fw-semibold small mb-1">{{ trans('back.Search') }}</label>
                    <input type="text" name="query" class="form-control form-control-sm"
                        placeholder="{{ trans('back.invoice_number') }}, {{ trans('back.customer') }}"
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

                {{-- Status Filter --}}
                <div class="col-md-2">
                    <label class="form-label fw-semibold small mb-1">{{ trans('back.status') }}</label>
                    <select name="invoice_status_id" class="form-select form-select-sm">
                        <option value="">{{ trans('back.All') }}</option>
                        @foreach($invoiceStatuses as $status)
                            <option value="{{ $status->id }}" {{ request('invoice_status_id') == $status->id ? 'selected' : '' }}>
                                {{ app()->getLocale() == 'ar' ? $status->name_ar : $status->name_en }}
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
                    <a href="{{ route('invoices.index') }}" class="btn btn-success" title="{{ trans('back.refresh') }}">
                        <i class="fas fa-sync-alt"></i>
                    </a>
        
                </div>

            </div>
        </form>
    </div>
</div>

    <div class="row">
        @if($invoices->count() > 0)
            <div class="col-12">
                <div class="card-box">
                    <div class="table-responsive">
                        <table id="" class="table table-bordered text-center table-sm">
                            <thead>
                            <tr>
                                <th width="30">#</th>
                                <th width="100">{{trans('back.invoice_number')}}</th>
                                <th width="150">{{trans('back.customer')}}</th>
                                <th width="100">{{trans('back.invoice_date')}}</th>
                                <th width="100">{{trans('back.due_date')}}</th>
                                <th width="100">{{trans('back.status')}}</th>
                                <th width="80">{{trans('back.subtotal')}}</th>
                                <th width="80">{{trans('back.tax')}}</th>
                                <th width="100" style="background-color: #cce5ec">{{trans('back.total')}}</th>
                                <th width="100">{{trans('back.paid_amount')}}</th>
                                <th width="100">{{trans('back.remaining_amount')}}</th>
                                <th width="200">{{trans('back.actions')}}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($invoices as $key => $invoice)
                                <tr>
                                    <td>{{$key + $invoices->firstItem()}}</td>
                                    <td>{{$invoice->invoice_number}}</td>
                                    <td>
                                        {{ $invoice->customer->name }}
                                        <br>
                                        <small class="text-muted">{{ $invoice->customer->phone }}</small>
                                    </td>
                                    <td>{{$invoice->invoice_date->format('Y-m-d')}}</td>
                                    <td>{{$invoice->due_date->format('Y-m-d')}}</td>
                                    <td>
                                        <span class="badge" style="background-color: {{ $invoice->status->color ?? '#6c757d' }}">
                                            {{ app()->getLocale() == 'ar' ? $invoice->status->name_ar : $invoice->status->name_en }}
                                        </span>
                                    </td>
                                    <td>{{number_format($invoice->subtotal, 3)}}</td>
                                    <td>{{number_format($invoice->tax, 3)}}</td>
                                    <td style="background-color: #cce5ec">{{number_format($invoice->total, 3)}}</td>
                                    <td class="text-success">{{number_format($invoice->paid_amount, 3)}}</td>
                                    <td class="text-danger">{{number_format($invoice->remaining_amount, 3)}}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            @can('show_invoice')
                                                <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-sm btn-info" title="{{ trans('back.show') }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endcan

                                            {{-- Payments Button --}}
                                            @if($invoice->installments->count() > 0)
                                                <a href="{{ route('invoices.show_installments_payments', $invoice->id) }}" class="btn btn-sm btn-success" title="{{ trans('back.payments') }}">
                                                    <i class="fas fa-money-bill-wave"></i>
                                                </a>
                                            @endif

                                            @can('edit_invoice')
                                                <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-sm btn-primary" title="{{ trans('back.edit') }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endcan

                                            @can('print_invoice')
                                                <a href="{{ route('invoices.print', $invoice->id) }}" target="_blank" class="btn btn-sm btn-secondary" title="{{ trans('back.print') }}">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                            @endcan

                                            @can('delete_invoice')
                                                <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_invoice{{ $invoice->id }}" title="{{ trans('back.delete') }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            @endcan
                                        </div>

                                        {{-- Include delete modal --}}
                                        @include('backend.pages.invoices.delete')
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $invoices->appends(Request::all())->links() !!}
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
