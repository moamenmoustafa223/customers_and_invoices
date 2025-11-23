@extends('backend.layouts.master')

@section('page_title')
    {{trans('back.reports_installments')}}
@endsection

@section('content')

<div class="row">
    <div class="col-md-12 mb-2">
        {{-- Filter Form --}}
        <form method="POST">
            @csrf
            <div class="row g-3 align-items-end">

                {{-- Status Filter --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">{{ trans('back.status') }}</label>
                    <select name="status" class="form-control form-control-sm">
                        <option value="">{{ trans('back.all') }}</option>
                        <option value="unpaid" {{ old('status', request('status')) == 'unpaid' ? 'selected' : '' }}>{{ trans('back.unpaid') }}</option>
                        <option value="paid" {{ old('status', request('status')) == 'paid' ? 'selected' : '' }}>{{ trans('back.paid') }}</option>
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

                {{-- Show Overdue Only --}}
                <div class="col-md-2">
                    <div class="form-check mt-4">
                        <input class="form-check-input" type="checkbox" name="show_overdue_only" id="show_overdue_only"
                            value="1" {{ old('show_overdue_only', request('show_overdue_only')) ? 'checked' : '' }}>
                        <label class="form-check-label" for="show_overdue_only">
                            {{ trans('back.show_overdue_only') }}
                        </label>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="col-md-3 d-flex gap-2 mt-2">
                    <button type="submit" formaction="{{ route('reports_installments') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-search me-1"></i> {{ trans('back.Search') }}
                    </button>

                    <button type="submit" formaction="{{ route('export_reports_installments_excel') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-file-excel me-1"></i> Excel
                    </button>

                    <a href="{{ route('reports_installments') }}" class="btn btn-sm btn-warning" title="{{ trans('global.reset') }}">
                        <i class="fas fa-sync-alt"></i>
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>

{{-- Summary Cards --}}
<div class="row mb-3">
    <div class="col-md-2">
        <div class="card-box text-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="text-white">
                <h4 class="mb-0">{{ $total_installments }}</h4>
                <p class="mb-0 small">{{ trans('back.total_installments') }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card-box text-center" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div class="text-white">
                <h4 class="mb-0">{{ number_format($total_amount, 3) }}</h4>
                <p class="mb-0 small">{{ trans('back.total_amount') }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card-box text-center" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="text-white">
                <h5 class="mb-0">{{ $paid_count }}</h5>
                <p class="mb-0 small">{{ trans('back.paid') }}</p>
                <small>{{ number_format($paid_amount, 3) }}</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card-box text-center" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
            <div class="text-white">
                <h5 class="mb-0">{{ $unpaid_count }}</h5>
                <p class="mb-0 small">{{ trans('back.unpaid') }}</p>
                <small>{{ number_format($unpaid_amount, 3) }}</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card-box text-center" style="background: linear-gradient(135deg, #fa709a 0%, #dc143c 100%);">
            <div class="text-white">
                <h5 class="mb-0">{{ $overdue_count }}</h5>
                <p class="mb-0 small">{{ trans('back.overdue') }}</p>
                <small>{{ number_format($overdue_amount, 3) }}</small>
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
                        <th width="100">{{trans('back.due_date')}}</th>
                        <th width="100">{{trans('back.amount')}}</th>
                        <th width="100">{{trans('back.status')}}</th>
                        <th width="100">{{trans('back.days_overdue')}}</th>
                        <th width="100">{{trans('back.Action')}}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($installments as $key => $installment)
                        @php
                            $daysOverdue = 0;
                            if($installment->status == 'unpaid' && $installment->due_date < now()) {
                                $daysOverdue = $installment->due_date->diffInDays(now());
                            }
                        @endphp
                        <tr class="{{ $daysOverdue > 0 ? 'table-danger' : '' }}">
                            <td>{{ $key + $installments->firstItem() }}</td>
                            <td>
                                <a href="{{ route('invoices.show', $installment->invoice->id) }}">
                                    {{ $installment->invoice->invoice_number }}
                                </a>
                            </td>
                            <td>{{ $installment->invoice->customer->name }}</td>
                            <td>{{ $installment->due_date->format('Y-m-d') }}</td>
                            <td>{{ number_format($installment->amount, 3) }}</td>
                            <td>
                                @if($installment->status == 'paid')
                                    <span class="badge bg-success">{{ trans('back.paid') }}</span>
                                @else
                                    <span class="badge bg-warning">{{ trans('back.unpaid') }}</span>
                                @endif
                            </td>
                            <td>
                                @if($daysOverdue > 0)
                                    <span class="badge bg-danger">{{ $daysOverdue }} {{ trans('back.days') }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('invoices.show', $installment->invoice->id) }}" class="text-primary" title="{{ trans('back.Show') }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                {{-- @if($installment->status == 'unpaid')
                                    <form action="{{ route('invoice_installments.markAsPaid', $installment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-link text-success p-0 ml-1" title="{{ trans('back.mark_as_paid') }}"
                                            onclick="return confirm('{{ trans('back.are_you_sure') }}')">
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                    </form>
                                @endif --}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="background-color: rgb(232,245,252); font-weight: bold;">
                            <th colspan="4">{{ trans('back.Total') }}</th>
                            <th>{{ number_format($total_amount, 3) }}</th>
                            <th colspan="3"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {!! $installments->appends(Request::all())->links() !!}

        </div>
    </div>
</div>

@endsection
