@extends('backend.layouts.master')

@section('page_title')
    {{ trans('back.quotations') }}
@endsection


@section('content')


    <div class="row g-1 align-items-end mb-2">
        <div class="col-md-3">
            @can('add_quotation')
                <a href="{{ route('quotations.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i> {{ trans('back.add_quotation') }}
                </a>
            @endcan
        </div>
        <div class="col-md-12">
            <form action="{{ route('quotations.index') }}" method="GET">
                <div class="row g-1">

                    {{-- Search --}}
                    <div class="col-md-2">
                        <label class="form-label fw-semibold small mb-1">{{ trans('back.Search') }}</label>
                        <input type="text" name="query" class="form-control form-control-sm"
                            placeholder="{{ trans('back.quotation_number') }}, {{ trans('back.customer') }}"
                            value="{{ request('query') }}">
                    </div>

                    {{-- Customer Filter --}}
                    <div class="col-md-2">
                        <label class="form-label fw-semibold small mb-1">{{ trans('back.select_customer') }}</label>
                        <select name="customer_id" class="form-select form-select-sm">
                            <option value="">{{ trans('back.All') }}</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Status Filter --}}
                    <div class="col-md-2">
                        <label class="form-label fw-semibold small mb-1">{{ trans('back.status') }}</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="">{{ trans('back.All') }}</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                {{ trans('back.pending') }}</option>
                            <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>
                                {{ trans('back.accepted') }}</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                                {{ trans('back.rejected') }}</option>
                            <option value="converted" {{ request('status') == 'converted' ? 'selected' : '' }}>
                                {{ trans('back.converted') }}</option>
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

                    {{-- Action Buttons --}}
                    <div class="col-md-2 d-flex gap-1 align-items-end">
                        <button class="btn btn-primary" type="submit" title="{{ trans('back.Search') }}">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('quotations.index') }}" class="btn btn-success"
                            title="{{ trans('back.refresh') }}">
                            <i class="fas fa-sync-alt"></i>
                        </a>

                    </div>

                </div>
            </form>
        </div>
    </div>

    <div class="row">
        @if ($quotations->count() > 0)
            <div class="col-12">
                <div class="card-box">
                    <div class="table-responsive">
                        <table id="" class="table table-bordered text-center table-sm">
                            <thead>
                                <tr>
                                    <th width="30">#</th>
                                    <th width="100">{{ trans('back.quotation_number') }}</th>
                                    <th width="150">{{ trans('back.customer') }}</th>
                                    <th width="100">{{ trans('back.quotation_date') }}</th>
                                    <th width="100">{{ trans('back.valid_until') }}</th>
                                    <th width="100">{{ trans('back.status') }}</th>
                                    <th width="80" style="background-color: #fff4e6">{{ trans('back.subtotal') }}</th>
                                    <th width="80" style="background-color: #ffe6e6">{{ trans('back.discount') }}</th>
                                    <th width="80" style="background-color: #e6f3ff">{{ trans('back.tax') }}</th>
                                    <th width="100" style="background-color: #d4edda">{{ trans('back.total') }}</th>
                                    <th width="200">{{ trans('back.actions') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($quotations as $key => $quotation)
                                    <tr>
                                        <td>{{ $key + $quotations->firstItem() }}</td>
                                        <td>{{ $quotation->quotation_number }}</td>
                                        <td>
                                            {{ $quotation->customer->name }}
                                            <br>
                                            <small class="text-muted">{{ $quotation->customer->phone }}</small>
                                        </td>
                                        <td>{{ $quotation->quotation_date->format('Y-m-d') }}</td>
                                        <td>{{ $quotation->valid_until->format('Y-m-d') }}</td>
                                        <td>
                                            @php
                                                $statusBadge = [
                                                    'pending' => 'warning',
                                                    'accepted' => 'success',
                                                    'rejected' => 'danger',
                                                    'converted' => 'info',
                                                ];
                                            @endphp
                                            @can('edit_quotation')
                                                @if ($quotation->status != 'converted')
                                                    <form action="{{ route('quotations.updateStatus', $quotation->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <select name="status"
                                                            class="form-select form-select-sm bg-{{ $statusBadge[$quotation->status] ?? 'secondary' }} text-white border-0"
                                                            style="width: auto; display: inline-block;"
                                                            onchange="this.form.submit()">
                                                            <option value="pending"
                                                                {{ $quotation->status == 'pending' ? 'selected' : '' }}>
                                                                {{ trans('back.pending') }}</option>
                                                            <option value="accepted"
                                                                {{ $quotation->status == 'accepted' ? 'selected' : '' }}>
                                                                {{ trans('back.accepted') }}</option>
                                                            <option value="rejected"
                                                                {{ $quotation->status == 'rejected' ? 'selected' : '' }}>
                                                                {{ trans('back.rejected') }}</option>
                                                        </select>
                                                    </form>
                                                @else
                                                    <span
                                                        class="badge bg-{{ $statusBadge[$quotation->status] ?? 'secondary' }}">
                                                        {{ trans('back.' . $quotation->status) }}
                                                    </span>
                                                @endif
                                            @else
                                                <span class="badge bg-{{ $statusBadge[$quotation->status] ?? 'secondary' }}">
                                                    {{ trans('back.' . $quotation->status) }}
                                                </span>
                                            @endcan
                                        </td>
                                        <td style="background-color: #fff4e6">{{ number_format($quotation->subtotal, 3) }}
                                        </td>
                                        <td style="background-color: #ffe6e6">
                                            @if ($quotation->discount > 0)
                                                <span
                                                    class="text-danger">-{{ number_format($quotation->discount, 3) }}</span>
                                            @else
                                                {{ number_format($quotation->discount, 3) }}
                                            @endif
                                        </td>
                                        <td style="background-color: #e6f3ff">{{ number_format($quotation->tax, 3) }}</td>
                                        <td style="background-color: #d4edda">
                                            <strong class="text-success">{{ number_format($quotation->total, 3) }}</strong>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                @can('show_quotation')
                                                    <a href="{{ route('quotations.show', $quotation->id) }}"
                                                        class="btn btn-sm btn-info" title="{{ trans('back.show') }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endcan

                                                @can('edit_quotation')
                                                    @if ($quotation->status != 'converted')
                                                        <a href="{{ route('quotations.edit', $quotation->id) }}"
                                                            class="btn btn-sm btn-primary" title="{{ trans('back.edit') }}">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endif
                                                @endcan

                                                @if (
                                                    ($quotation->status == 'pending' || $quotation->status == 'accepted') &&
                                                        auth()->user()->can('convert_quotation_to_invoice'))
                                                    <a href="#" class="btn btn-sm btn-success"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#convert_quotation{{ $quotation->id }}"
                                                        title="{{ trans('back.convert_to_invoice') }}">
                                                        <i class="fas fa-exchange-alt"></i>
                                                    </a>
                                                @endif

                                                @can('delete_quotation')
                                                    @if ($quotation->status != 'converted')
                                                        <a href="#" class="btn btn-sm btn-danger"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#delete_quotation{{ $quotation->id }}"
                                                            title="{{ trans('back.delete') }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    @endif
                                                @endcan
                                            </div>

                                            {{-- Include delete modal --}}
                                            @include('backend.pages.quotations.delete')

                                            {{-- Include convert to invoice modal --}}
                                            @if (
                                                ($quotation->status == 'pending' || $quotation->status == 'accepted') &&
                                                    auth()->user()->can('convert_quotation_to_invoice'))
                                                @include('backend.pages.quotations.convert')
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!! $quotations->appends(Request::all())->links() !!}
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-12">
                <div class="alert alert-danger text-center">
                    <h4>{{ trans('back.none') }}</h4>
                </div>
            </div>
        @endif

    </div>

@endsection
