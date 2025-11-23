@extends('backend.layouts.master')

@section('page_title')
    {{ trans('back.quotation') }} : {{ $quotation->quotation_number }}
@endsection


@section('content')

    <div class="row">
        <div class="col-sm-12">
            <a href="{{ route('quotations.index') }}" class="btn btn-info btn-sm mb-2">
                <i class="fas fa-arrow-left me-1"></i>
                {{ trans('back.quotations') }}
            </a>

            @can('edit_quotation')
                <a href="{{ route('quotations.edit', $quotation->id) }}" class="btn btn-primary btn-sm mb-2">
                    <i class="fas fa-edit me-1"></i>
                    {{ trans('back.edit') }}
                </a>
            @endcan

            @if (
                ($quotation->status == 'pending' || $quotation->status == 'accepted') &&
                    auth()->user()->can('convert_quotation_to_invoice'))
                <form action="{{ route('quotations.convertToInvoice', $quotation->id) }}" method="POST"
                    style="display: inline-block;"
                    onsubmit="return confirm('{{ trans('back.are_you_sure_convert_to_invoice') }}')">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm mb-2">
                        <i class="fas fa-exchange-alt me-1"></i> {{ trans('back.convert_to_invoice') }}
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">

                {{-- Customer Information --}}
                <div class="row mb-3">
                    <div class="col-md-12">
                        <h4 class="header-title mb-3">{{ trans('back.customer_information') }}</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <tr>
                                    <th width="200">{{ trans('back.customer_name') }}</th>
                                    <td>{{ $quotation->customer->name }}</td>
                                    <th width="200">{{ trans('back.phone') }}</th>
                                    <td>{{ $quotation->customer->phone }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('back.email') }}</th>
                                    <td>{{ $quotation->customer->email ?? '-' }}</td>
                                    <th>{{ trans('back.address') }}</th>
                                    <td>{{ app()->getLocale() == 'ar' ? $quotation->customer->address_ar ?? '-' : $quotation->customer->address_en ?? '-' }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Quotation Details --}}
                <div class="row mb-3">
                    <div class="col-md-12">
                        <h4 class="header-title mb-3">{{ trans('back.quotation_details') }}</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <tr>
                                    <th width="200">{{ trans('back.quotation_number') }}</th>
                                    <td>{{ $quotation->quotation_number }}</td>
                                    <th width="200">{{ trans('back.quotation_date') }}</th>
                                    <td>{{ $quotation->quotation_date->format('Y-m-d') }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('back.valid_until') }}</th>
                                    <td>{{ $quotation->valid_until->format('Y-m-d') }}</td>
                                    <th>{{ trans('back.status') }}</th>
                                    <td>
                                        @if ($quotation->status == 'pending')
                                            <span class="badge bg-warning">{{ trans('back.pending') }}</span>
                                        @elseif($quotation->status == 'accepted')
                                            <span class="badge bg-success">{{ trans('back.accepted') }}</span>
                                        @elseif($quotation->status == 'rejected')
                                            <span class="badge bg-danger">{{ trans('back.rejected') }}</span>
                                        @elseif($quotation->status == 'converted')
                                            <span class="badge bg-info">{{ trans('back.converted') }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trans('back.created_by') }}</th>
                                    <td>{{ $quotation->user->name ?? '-' }}</td>
                                    <th>{{ trans('back.created_at') }}</th>
                                    <td>{{ $quotation->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Converted Invoice Link --}}
                @if ($quotation->status == 'converted' && $quotation->invoice_id)
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <strong>{{ trans('back.converted_to_invoice') }}:</strong>
                                <a href="{{ route('invoices.show', $quotation->invoice_id) }}" target="_blank">
                                    {{ $quotation->invoice->invoice_number ?? 'INV-' . $quotation->invoice_id }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Quotation Items --}}
                <div class="row mb-3">
                    <div class="col-md-12">
                        <h4 class="header-title mb-3">{{ trans('back.quotation_items') }}</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered text-center table-sm">
                                <thead style="background-color: #f1f1f1">
                                    <tr>
                                        <th width="50">#</th>
                                        <th>{{ trans('back.service') }}</th>
                                        <th width="100">{{ trans('back.quantity') }}</th>
                                        <th width="120">{{ trans('back.unit_price') }}</th>
                                        <th width="120">{{ trans('back.total') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($quotation->items as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td class="text-start">
                                                {{ $item->service_name ?? (app()->getLocale() == 'ar' ? $item->service->name_ar : $item->service->name_en) }}
                                            </td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ number_format($item->unit_price, 3) }}</td>
                                            <td>{{ number_format($item->total_price, 3) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Totals --}}
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" style="max-width: 400px; margin-left: auto;">
                                <tr style="background-color: #f9f9f9">
                                    <th width="200">{{ trans('back.subtotal') }}</th>
                                    <td class="text-end">{{ number_format($quotation->subtotal, 3) }}</td>
                                </tr>
                                <tr style="background-color: #f9f9f9">
                                    <th>{{ trans('back.tax') }}</th>
                                    <td class="text-end">{{ number_format($quotation->tax, 3) }}</td>
                                </tr>
                                <tr style="background-color: #e9e9e9; font-weight: bold;">
                                    <th>{{ trans('back.total') }}</th>
                                    <td class="text-end">{{ number_format($quotation->total, 3) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Notes --}}
                @if ($quotation->notes_ar || $quotation->notes_en)
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h4 class="header-title mb-3">{{ trans('back.notes') }}</h4>
                            @if (app()->getLocale() == 'ar' && $quotation->notes_ar)
                                <div class="alert alert-info">
                                    {!! nl2br(e($quotation->notes_ar)) !!}
                                </div>
                            @elseif(app()->getLocale() == 'en' && $quotation->notes_en)
                                <div class="alert alert-info">
                                    {!! nl2br(e($quotation->notes_en)) !!}
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

@endsection
