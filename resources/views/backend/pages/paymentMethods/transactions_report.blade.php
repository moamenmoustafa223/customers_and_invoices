@extends('backend.layouts.master')

@section('page_title')
    {{ trans('back.payment_method_transactions_report') }}
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 mb-2">
        <form method="GET" action="{{ route('payment_method_transactions.index') }}">
            <div class="row g-1 align-items-end">

                <div class="col-md-2">
                    <label class="form-label fw-semibold">{{ trans('back.start_date') }}</label>
                    <input type="date" name="start_date" class="form-control form-control-sm"
                        value="{{ request('start_date', now()->toDateString()) }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold">{{ trans('back.end_date') }}</label>
                    <input type="date" name="end_date" class="form-control form-control-sm"
                        value="{{ request('end_date', now()->toDateString()) }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold">{{ trans('payment_methods.type') }}</label>
                    <select name="type" class="form-select form-select-sm">
                        <option value="">{{ trans('back.all') }}</option>
                        <option value="credit" {{ request('type') == 'credit' ? 'selected' : '' }}>{{ trans('back.credit') }}</option>
                        <option value="debit" {{ request('type') == 'debit' ? 'selected' : '' }}>{{ trans('back.debit') }}</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold">{{ trans('payment_methods.source_type') }}</label>
                    <input type="text" name="source_type" class="form-control form-control-sm"
                        value="{{ request('source_type') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold">{{ trans('payment_methods.payment_methods') }}</label>
                    <select name="payment_method_id" class="form-select form-select-sm">
                        <option value="">{{ trans('back.all') }}</option>
                        @foreach($paymentMethods as $method)
                            <option value="{{ $method->id }}" {{ request('payment_method_id') == $method->id ? 'selected' : '' }}>
                                {{ app()->getLocale() == 'ar' ? $method->name_ar : $method->name_en }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 d-flex gap-1">
                    <button type="submit" class="btn btn-sm btn-primary ">
                        <i class="fas fa-search me-1"></i> {{ trans('back.Search') }}
                    </button>

                    <a href="{{ route('payment_method_transactions.index') }}" class="btn btn-sm btn-warning" title="Reload">
                        <i class="fas fa-sync-alt"></i>
                    </a>

                    <button formaction="{{ route('payment_method_transactions.export_excel') }}" class="btn btn-sm btn-success" type="submit">
                        <i class="fas fa-file-excel me-1"></i> Excel
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>



<div class="row">
    <div class="col-12">
        <div class="card-box">
            <div class="table-responsive">
                <table class="table table-bordered text-center table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ trans('payment_methods.transaction_date') }}</th>
                            <th>{{ trans('payment_methods.payment_methods') }}</th>
                            <th>{{ trans('payment_methods.type') }}</th>
                            <th>{{ trans('payment_methods.amount') }}</th>
                            <th>{{ trans('payment_methods.source_type') }}</th>
                            <th>{{ trans('payment_methods.description') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $key => $txn)
                            <tr>
                                <td>{{ $key + $transactions->firstItem() }}</td>
                                <td>{{ $txn->transaction_date }}</td>
                                <td>{{ app ()->getLocale() == 'ar' ? $txn->payment_method->name_ar : $txn->payment_method->name_en ?? '-' }}</td>
                                <td class="{{ $txn->type == 'credit' ? 'text-success' : 'text-danger' }}">
                                    {{ trans('back.' . $txn->type) }}
                                </td>
                                <td>{{ number_format($txn->amount, 3) }}</td>
                                <td>{{ $txn->source_type }}</td>
                                <td>{{ $txn->description }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="background-color: #eaf8ef">
                            <th colspan="4">{{ trans('back.total_credit') }}:</th>
                            <th colspan="3" class="text-success">{{ number_format($totalCredit, 3) }}</th>
                        </tr>
                        <tr style="background-color: #f8eaea">
                            <th colspan="4">{{ trans('back.total_debit') }}:</th>
                            <th colspan="3" class="text-danger">{{ number_format($totalDebit, 3) }}</th>
                        </tr>
                    </tfoot>
                </table>
                {!! $transactions->appends(Request::all())->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection
