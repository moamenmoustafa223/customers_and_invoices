@extends('backend.layouts.master')

@section('page_title')
    {{ trans('back.invoice_installments') }}
@endsection

@section('content')
    <style>
        .table-responsive {
            overflow: visible !important;
            position: relative;
        }
    </style>

    <div class="row g-1 align-items-end mb-2">
        <div class="col-md-12">
            <form action="{{ route('invoice_installments.index') }}" method="GET">
                <div class="row g-1">

                    {{-- Search --}}
                    <div class="col-md-2">
                        <label class="form-label fw-semibold small mb-1">{{ trans('back.Search') }}</label>
                        <input type="text" name="query" class="form-control form-control-sm"
                            placeholder="{{ trans('back.invoice_number') }}, {{ trans('back.customer') }}"
                            value="{{ request('query') }}">
                    </div>

                    {{-- Status Filter --}}
                    <div class="col-md-2">
                        <label class="form-label fw-semibold small mb-1">{{ trans('back.status') }}</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="">{{ trans('back.All') }}</option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>
                                {{ trans('back.paid') }}</option>
                            <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>
                                {{ trans('back.unpaid') }}</option>
                            <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>
                                {{ trans('back.partial') }}</option>
                        </select>
                    </div>

                    {{-- From Date --}}
                    <div class="col-md-2">
                        <label class="form-label fw-semibold small mb-1">{{ trans('back.from_date') }}</label>
                        <input type="date" name="from_date" class="form-control form-control-sm"
                            value="{{ request('from_date') }}">
                    </div>

                    {{-- To Date --}}
                    <div class="col-md-2">
                        <label class="form-label fw-semibold small mb-1">{{ trans('back.to_date') }}</label>
                        <input type="date" name="to_date" class="form-control form-control-sm"
                            value="{{ request('to_date') }}">
                    </div>

                    {{-- Invoice Filter --}}
                    <div class="col-md-2">
                        <label class="form-label fw-semibold small mb-1">{{ trans('back.invoice') }}</label>
                        <select name="invoice_id" class="form-select form-select-sm">
                            <option value="">{{ trans('back.All') }}</option>
                            @foreach ($invoices as $invoice)
                                <option value="{{ $invoice->id }}"
                                    {{ request('invoice_id') == $invoice->id ? 'selected' : '' }}>
                                    {{ $invoice->invoice_number }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="col-md-2 d-flex gap-1 align-items-end">
                        <button class="btn btn-primary btn-sm" type="submit" title="{{ trans('back.Search') }}">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('invoice_installments.index') }}" class="btn btn-success btn-sm"
                            title="{{ trans('back.refresh') }}">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                        <a href="{{ route('invoice_installments.overdue') }}" class="btn btn-warning btn-sm"
                            title="{{ trans('back.overdue_installments') }}">
                            <i class="fas fa-exclamation-triangle"></i> {{ trans('back.overdue') }}
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <div class="row">
        @if ($installments->count() > 0)
            <div class="col-12">
                <div class="card-box">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center table-sm">
                            <thead style="background-color:rgb(232,245,252)">
                                <tr>
                                    <th width="30">#</th>
                                    <th width="120">{{ trans('back.invoice_number') }}</th>
                                    <th width="150">{{ trans('back.customer') }}</th>
                                    <th width="100">{{ trans('back.due_date') }}</th>
                                    <th width="100">{{ trans('back.amount') }}</th>
                                    <th width="100">{{ trans('back.status') }}</th>
                                    <th width="150">{{ trans('back.Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($installments as $index => $installment)
                                    <tr>
                                        <td>{{ $installments->firstItem() + $index }}</td>
                                        <td>
                                            <a href="{{ route('invoices.show', $installment->invoice_id) }}"
                                                class="text-primary">
                                                {{ $installment->invoice->invoice_number ?? '' }}
                                            </a>
                                        </td>
                                        <td>
                                            {{ $installment->invoice->customer->name ?? '' }}
                                            <br>
                                            <small
                                                class="text-muted">{{ $installment->invoice->customer->phone ?? '' }}</small>
                                        </td>
                                        <td>{{ $installment->due_date->format('Y-m-d') }}</td>
                                        <td>{{ number_format($installment->amount, 3) }}</td>
                                        <td>
                                            @if ($installment->status == 'paid')
                                                <span class="badge bg-success">{{ trans('back.paid') }}</span>
                                            @elseif($installment->status == 'unpaid')
                                                <span class="badge bg-danger">{{ trans('back.unpaid') }}</span>
                                            @else
                                                <span class="badge bg-warning">{{ trans('back.partial') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1 justify-content-center">
                                                {{-- View Payments --}}
                                                <a href="{{ route('invoices.show_installments_payments', $installment->invoice_id) }}"
                                                    class="btn btn-sm btn-info" title="{{ trans('back.payments') }}">
                                                    <i class="fas fa-money-bill-wave"></i>
                                                </a>

                                                {{-- Delete --}}
            

                                          
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center mt-3">
                        {{ $installments->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        @else
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle"></i> {{ trans('back.no_installments_found') }}
                </div>
            </div>
        @endif
    </div>

@endsection
