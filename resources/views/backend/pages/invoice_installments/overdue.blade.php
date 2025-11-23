@extends('backend.layouts.master')

@section('page_title')
    {{ trans('back.overdue_installments') }}
@endsection

@section('content')
    <style>
        .table-responsive {
            overflow: visible !important;
            position: relative;
        }

        .overdue-highlight {
            background-color: #fff3cd;
        }
    </style>

    <div class="row g-1 align-items-end mb-2">
        <div class="col-md-12">
            <form action="{{ route('invoice_installments.overdue') }}" method="GET">
                <div class="row g-1">

                    {{-- Search --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small mb-1">{{ trans('back.Search') }}</label>
                        <input type="text" name="query" class="form-control form-control-sm"
                            placeholder="{{ trans('back.invoice_number') }}, {{ trans('back.customer') }}"
                            value="{{ request('query') }}">
                    </div>

                    {{-- From Date --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small mb-1">{{ trans('back.from_date') }}</label>
                        <input type="date" name="from_date" class="form-control form-control-sm"
                            value="{{ request('from_date') }}">
                    </div>

                    {{-- To Date --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small mb-1">{{ trans('back.to_date') }}</label>
                        <input type="date" name="to_date" class="form-control form-control-sm"
                            value="{{ request('to_date') }}">
                    </div>

                    {{-- Action Buttons --}}
                    <div class="col-md-3 d-flex gap-1 align-items-end">
                        <button class="btn btn-primary btn-sm" type="submit" title="{{ trans('back.Search') }}">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('invoice_installments.overdue') }}" class="btn btn-success btn-sm"
                            title="{{ trans('back.refresh') }}">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                        <a href="{{ route('invoice_installments.index') }}" class="btn btn-secondary btn-sm"
                            title="{{ trans('back.all_installments') }}">
                            <i class="fas fa-list"></i> {{ trans('back.all_installments') }}
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title">{{ trans('back.total_overdue_installments') }}</h5>
                    <h3>{{ $installments->total() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h5 class="card-title">{{ trans('back.total_overdue_amount') }}</h5>
                    <h3>{{ number_format($installments->sum('amount'), 3) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @if ($installments->count() > 0)
            <div class="col-12">
                <div class="card-box">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center table-sm">
                            <thead style="background-color:rgb(255, 230, 230)">
                                <tr>
                                    <th width="30">#</th>
                                    <th width="120">{{ trans('back.invoice_number') }}</th>
                                    <th width="150">{{ trans('back.customer') }}</th>
                                    <th width="120">{{ trans('back.customer_contact') }}</th>
                                    <th width="100">{{ trans('back.due_date') }}</th>
                                    <th width="80">{{ trans('back.days_overdue') }}</th>
                                    <th width="100">{{ trans('back.amount') }}</th>
                                    <th width="100">{{ trans('back.status') }}</th>
                                    <th width="150">{{ trans('back.Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($installments as $index => $installment)
                                    @php
                                        $daysOverdue = abs(now()->startOfDay()->diffInDays($installment->due_date->startOfDay(), false));
                                        $overdueClass = $daysOverdue > 30 ? 'table-danger' : 'overdue-highlight';
                                    @endphp
                                    <tr class="{{ $overdueClass }}">
                                        <td>{{ $installments->firstItem() + $index }}</td>
                                        <td>
                                            <a href="{{ route('invoices.show', $installment->invoice_id) }}"
                                                class="text-primary">
                                                {{ $installment->invoice->invoice_number ?? '' }}
                                            </a>
                                        </td>
                                        <td>
                                            <strong>{{ $installment->invoice->customer->name ?? '' }}</strong>
                                        </td>
                                        <td>
                                            <div class="text-start">
                                                @if ($installment->invoice->customer->phone)
                                                    <i class="fas fa-phone text-primary"></i>
                                                    <a href="tel:{{ $installment->invoice->customer->phone ?? '' }}">
                                                        {{ $installment->invoice->customer->phone ?? '' }}
                                                    </a>
                                                    <br>
                                                @endif
                                                @if ($installment->invoice->customer->email)
                                                    <i class="fas fa-envelope text-info"></i>
                                                    <a href="mailto:{{ $installment->invoice->customer->email ?? '' }}">
                                                        {{ $installment->invoice->customer->email ?? '' }}
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            {{ $installment->due_date->format('Y-m-d') }}
                                        </td>
                                        <td>
                                            <span class="badge {{ $daysOverdue > 30 ? 'bg-danger' : 'bg-warning' }}">
                                                {{ $daysOverdue }} {{ trans('back.days') }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong>{{ number_format($installment->amount, 3) }}</strong>
                                        </td>
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
                                                {{-- View Invoice --}}
                                                <a href="{{ route('invoices.show_installments_payments', $installment->invoice_id) }}"
                                                    class="btn btn-sm btn-success" title="{{ trans('back.payments') }}">
                                                    <i class="fas fa-money-bill-wave"></i>
                                                </a>
                                                <a href="{{ route('invoices.show', $installment->invoice_id) }}"
                                                    class="btn btn-sm btn-info" title="{{ trans('back.view_invoice') }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>

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
                <div class="alert alert-success text-center">
                    <i class="fas fa-check-circle"></i> {{ trans('back.no_overdue_installments') }}
                </div>
            </div>
        @endif
    </div>

@endsection
