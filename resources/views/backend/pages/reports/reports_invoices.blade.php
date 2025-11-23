@extends('backend.layouts.master')

@section('page_title')
    {{trans('back.reports_invoices')}}
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

                {{-- Status Filter --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">{{ trans('back.status') }}</label>
                    <select name="invoice_status_id" class="form-control form-control-sm">
                        <option value="">{{ trans('back.all') }}</option>
                        @foreach($invoice_statuses as $status)
                            <option value="{{ $status->id }}" {{ old('invoice_status_id', request('invoice_status_id')) == $status->id ? 'selected' : '' }}>
                                {{ app()->getLocale() == 'ar' ? $status->name_ar : $status->name_en }}
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
                    <button type="submit" formaction="{{ route('reports_invoices') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-search me-1"></i> {{ trans('back.Search') }}
                    </button>

                    <button type="submit" formaction="{{ route('export_reports_invoices_excel') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-file-excel me-1"></i> Excel
                    </button>

                    <a href="{{ route('reports_invoices') }}" class="btn btn-sm btn-warning" title="{{ trans('global.reset') }}">
                        <i class="fas fa-sync-alt"></i>
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>

{{-- Summary Cards --}}
<div class="row mb-3">
    <div class="col-md-3">
        <div class="card-box text-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="text-white">
                <h4 class="mb-0">{{ $total_invoices }}</h4>
                <p class="mb-0">{{ trans('back.total_invoices') }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-box text-center" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div class="text-white">
                <h4 class="mb-0">{{ number_format($total_amount, 3) }}</h4>
                <p class="mb-0">{{ trans('back.total_amount') }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-box text-center" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="text-white">
                <h4 class="mb-0">{{ number_format($total_paid, 3) }}</h4>
                <p class="mb-0">{{ trans('back.paid_amount') }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-box text-center" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
            <div class="text-white">
                <h4 class="mb-0">{{ number_format($total_remaining, 3) }}</h4>
                <p class="mb-0">{{ trans('back.remaining_amount') }}</p>
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
                        <th width="100">{{trans('back.invoice_number')}}</th>
                        <th width="150">{{trans('back.customer')}}</th>
                        <th width="100">{{trans('back.invoice_date')}}</th>
                        <th width="100">{{trans('back.due_date')}}</th>
                        <th width="100">{{trans('back.status')}}</th>
                        <th width="100">{{trans('back.total')}}</th>
                        <th width="100">{{trans('back.paid_amount')}}</th>
                        <th width="100">{{trans('back.remaining_amount')}}</th>
                        <th width="100">{{trans('back.Action')}}</th>
                        <th width="100">{{trans('back.User')}}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($invoices as $key => $invoice)
                        <tr>
                            <td>{{ $key + $invoices->firstItem() }}</td>
                            <td>{{ $invoice->invoice_number }}</td>
                            <td>{{ $invoice->customer->name }}</td>
                            <td>{{ $invoice->invoice_date->format('Y-m-d') }}</td>
                            <td>{{ $invoice->due_date->format('Y-m-d') }}</td>
                            <td>
                                <span class="badge" style="background-color: {{ $invoice->status->color ?? '#6c757d' }}">
                                    {{ app()->getLocale() == 'ar' ? $invoice->status->name_ar : $invoice->status->name_en }}
                                </span>
                            </td>
                            <td>{{ number_format($invoice->total, 3) }}</td>
                            <td>{{ number_format($invoice->paid_amount, 3) }}</td>
                            <td>{{ number_format($invoice->remaining_amount, 3) }}</td>
                            <td>
                                <a href="{{ route('invoices.show', $invoice->id) }}" class="text-primary" title="{{ trans('back.Show') }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('invoices.print', $invoice->id) }}" class="text-success ml-1" target="_blank" title="{{ trans('back.Print') }}">
                                    <i class="fas fa-print"></i>
                                </a>
                            </td>
                            <td>{{ $invoice->user->name ?? '-' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="background-color: rgb(232,245,252); font-weight: bold;">
                            <th colspan="6">{{ trans('back.Total') }}</th>
                            <th>{{ number_format($total_amount, 3) }}</th>
                            <th>{{ number_format($total_paid, 3) }}</th>
                            <th>{{ number_format($total_remaining, 3) }}</th>
                            <th colspan="2"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {!! $invoices->appends(Request::all())->links() !!}

        </div>
    </div>
</div>

@endsection
