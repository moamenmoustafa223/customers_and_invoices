@extends('backend.layouts.master')

@section('page_title')
    {{trans('back.reports_quotations')}}
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
                    <select name="status" class="form-control form-control-sm">
                        <option value="">{{ trans('back.all') }}</option>
                        <option value="pending" {{ old('status', request('status')) == 'pending' ? 'selected' : '' }}>{{ trans('back.pending') }}</option>
                        <option value="accepted" {{ old('status', request('status')) == 'accepted' ? 'selected' : '' }}>{{ trans('back.accepted') }}</option>
                        <option value="rejected" {{ old('status', request('status')) == 'rejected' ? 'selected' : '' }}>{{ trans('back.rejected') }}</option>
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
                    <button type="submit" formaction="{{ route('reports_quotations') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-search me-1"></i> {{ trans('back.Search') }}
                    </button>

                    <button type="submit" formaction="{{ route('export_reports_quotations_excel') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-file-excel me-1"></i> Excel
                    </button>

                    <a href="{{ route('reports_quotations') }}" class="btn btn-sm btn-warning" title="{{ trans('global.reset') }}">
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
                <h4 class="mb-0">{{ $total_quotations }}</h4>
                <p class="mb-0 small">{{ trans('back.total_quotations') }}</p>
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
                <h4 class="mb-0">{{ $accepted_count }}</h4>
                <p class="mb-0 small">{{ trans('back.accepted') }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card-box text-center" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
            <div class="text-white">
                <h4 class="mb-0">{{ $rejected_count }}</h4>
                <p class="mb-0 small">{{ trans('back.rejected') }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card-box text-center" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
            <div class="text-white">
                <h4 class="mb-0">{{ $converted_count }}</h4>
                <p class="mb-0 small">{{ trans('back.converted') }}</p>
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
                        <th width="100">{{trans('back.quotation_number')}}</th>
                        <th width="150">{{trans('back.customer')}}</th>
                        <th width="100">{{trans('back.quotation_date')}}</th>
                        <th width="100">{{trans('back.valid_until')}}</th>
                        <th width="100">{{trans('back.status')}}</th>
                        <th width="100">{{trans('back.total')}}</th>
                        <th width="100">{{trans('back.converted')}}</th>
                        <th width="100">{{trans('back.Action')}}</th>
                        <th width="100">{{trans('back.User')}}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($quotations as $key => $quotation)
                        <tr>
                            <td>{{ $key + $quotations->firstItem() }}</td>
                            <td>{{ $quotation->quotation_number }}</td>
                            <td>{{ $quotation->customer->name }}</td>
                            <td>{{ $quotation->quotation_date->format('Y-m-d') }}</td>
                            <td>{{ $quotation->valid_until->format('Y-m-d') }}</td>
                            <td>
                                @if($quotation->status == 'pending')
                                    <span class="badge bg-warning">{{ trans('back.pending') }}</span>
                                @elseif($quotation->status == 'accepted')
                                    <span class="badge bg-success">{{ trans('back.accepted') }}</span>
                                @elseif($quotation->status == 'rejected')
                                    <span class="badge bg-danger">{{ trans('back.rejected') }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $quotation->status }}</span>
                                @endif
                            </td>
                            <td>{{ number_format($quotation->total, 3) }}</td>
                            <td>
                                @if($quotation->converted_invoice_id)
                                    <a href="{{ route('invoices.show', $quotation->converted_invoice_id) }}" class="text-success">
                                        <i class="fas fa-check-circle"></i>
                                    </a>
                                @else
                                    <i class="fas fa-times-circle text-muted"></i>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('quotations.show', $quotation->id) }}" class="text-primary" title="{{ trans('back.Show') }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                            <td>{{ $quotation->user->name ?? '-' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="background-color: rgb(232,245,252); font-weight: bold;">
                            <th colspan="6">{{ trans('back.Total') }}</th>
                            <th>{{ number_format($total_amount, 3) }}</th>
                            <th colspan="3"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {!! $quotations->appends(Request::all())->links() !!}

        </div>
    </div>
</div>

@endsection
