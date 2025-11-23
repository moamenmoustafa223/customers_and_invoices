@extends('backend.layouts.master')

@section('page_title')
    {{trans('back.invoice')}} : {{$invoice->invoice_number}}
@endsection


@section('content')

    <div class="row">
        <div class="col-sm-12">
            <a href="{{route('invoices.index')}}" class="btn btn-info btn-sm mb-2">
                <i class="fas fa-arrow-left me-1"></i>
                {{trans('back.invoices')}}
            </a> 

            <a href="{{ route('invoices.print', $invoice->id) }}" target="_blank" class="btn btn-secondary btn-sm mb-2">
                <i class="fas fa-print me-1"></i>
                {{trans('back.print')}}
            </a>

            @can('edit_invoice')
                <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-primary btn-sm mb-2">
                    <i class="fas fa-edit me-1"></i>
                    {{trans('back.edit')}}
                </a>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">

                {{-- Customer Information --}}
                <div class="row mb-3">
                    <div class="col-md-12">
                        <h4 class="header-title mb-3">{{trans('back.customer_information')}}</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <tr>
                                    <th width="200">{{trans('back.customer_name')}}</th>
                                    <td>{{ $invoice->customer->name }}</td>
                                    <th width="200">{{trans('back.phone')}}</th>
                                    <td>{{ $invoice->customer->phone }}</td>
                                </tr>
                                <tr>
                                    <th>{{trans('back.email')}}</th>
                                    <td>{{ $invoice->customer->email ?? '-' }}</td>
                                    <th>{{trans('back.address')}}</th>
                                    <td>{{ app()->getLocale() == 'ar' ? ($invoice->customer->address_ar ?? '-') : ($invoice->customer->address_en ?? '-') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Invoice Details --}}
                <div class="row mb-3">
                    <div class="col-md-12">
                        <h4 class="header-title mb-3">{{trans('back.invoice_details')}}</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <tr>
                                    <th width="200">{{trans('back.invoice_number')}}</th>
                                    <td>{{ $invoice->invoice_number }}</td>
                                    <th width="200">{{trans('back.invoice_date')}}</th>
                                    <td>{{ $invoice->invoice_date->format('Y-m-d') }}</td>
                                </tr>
                                <tr>
                                    <th>{{trans('back.due_date')}}</th>
                                    <td>{{ $invoice->due_date->format('Y-m-d') }}</td>
                                    <th>{{trans('back.status')}}</th>
                                    <td>
                                        <span class="badge" style="background-color: {{ $invoice->status->color ?? '#6c757d' }}">
                                            {{ app()->getLocale() == 'ar' ? $invoice->status->name_ar : $invoice->status->name_en }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{trans('back.created_by')}}</th>
                                    <td>{{ $invoice->user->name ?? '-' }}</td>
                                    <th>{{trans('back.created_at')}}</th>
                                    <td>{{ $invoice->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Invoice Items --}}
                <div class="row mb-3">
                    <div class="col-md-12">
                        <h4 class="header-title mb-3">{{trans('back.invoice_items')}}</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered text-center table-sm">
                                <thead style="background-color: #f1f1f1">
                                    <tr>
                                        <th width="50">#</th>
                                        <th>{{trans('back.service')}}</th>
                                        <th width="100">{{trans('back.quantity')}}</th>
                                        <th width="120">{{trans('back.unit_price')}}</th>
                                        <th width="120">{{trans('back.total')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($invoice->items as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td class="text-start">{{ $item->service_name ?? (app()->getLocale() == 'ar' ? $item->service->name_ar : $item->service->name_en) }}</td>
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
                                    <th width="200">{{trans('back.subtotal')}}</th>
                                    <td class="text-end">{{ number_format($invoice->subtotal, 3) }}</td>
                                </tr>
                                <tr style="background-color: #f9f9f9">
                                    <th>{{trans('back.tax')}}</th>
                                    <td class="text-end">{{ number_format($invoice->tax, 3) }}</td>
                                </tr>
                                <tr style="background-color: #e9e9e9; font-weight: bold;">
                                    <th>{{trans('back.total')}}</th>
                                    <td class="text-end">{{ number_format($invoice->total, 3) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Installments --}}
                @if($invoice->installments->count() > 0)
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h4 class="header-title mb-3">{{trans('back.installments')}}</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered text-center table-sm">
                                    <thead style="background-color: #f1f1f1">
                                        <tr>
                                            <th width="50">#</th>
                                            <th width="150">{{trans('back.due_date')}}</th>
                                            <th width="120">{{trans('back.amount')}}</th>
                                            <th width="120">{{trans('back.paid_amount')}}</th>
                                            <th width="120">{{trans('back.remaining_amount')}}</th>
                                            <th width="100">{{trans('back.status')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($invoice->installments->sortBy('due_date') as $index => $installment)
                                            @php
                                                $paidAmount = $installment->payments->sum('amount') ?? 0;
                                                $remainingAmount = $installment->amount - $paidAmount;
                                                $isPaid = $remainingAmount <= 0;
                                            @endphp
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $installment->due_date->format('Y-m-d') }}</td>
                                                <td>{{ number_format($installment->amount, 3) }}</td>
                                                <td>{{ number_format($paidAmount, 3) }}</td>
                                                <td>{{ number_format($remainingAmount, 3) }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $isPaid ? 'success' : 'warning' }}">
                                                        {{ $isPaid ? trans('back.paid') : trans('back.pending') }}
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

                {{-- Payments --}}
                @if($invoice->payments->count() > 0)
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h4 class="header-title mb-3">{{trans('back.payments')}}</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered text-center table-sm">
                                    <thead style="background-color: #f1f1f1">
                                        <tr>
                                            <th width="50">#</th>
                                            <th width="150">{{trans('back.payment_date')}}</th>
                                            <th width="120">{{trans('back.amount')}}</th>
                                            <th width="150">{{trans('back.payment_method')}}</th>
                                            <th>{{trans('back.notes')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($invoice->payments->sortBy('payment_date') as $index => $payment)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $payment->payment_date->format('Y-m-d') }}</td>
                                                <td>{{ number_format($payment->amount, 3) }}</td>
                                                <td>{{ app()->getLocale() == 'ar' ? ($payment->paymentMethod->name_ar ?? '-') : ($payment->paymentMethod->name_en ?? '-') }}</td>
                                                <td class="text-start">{{ $payment->notes ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                        <tr style="background-color: #d0eccc; font-weight: bold;">
                                            <td colspan="2" class="text-end">{{trans('back.total_paid')}}</td>
                                            <td>{{ number_format($invoice->payments->sum('amount'), 3) }}</td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr style="background-color: #eccccc; font-weight: bold;">
                                            <td colspan="2" class="text-end">{{trans('back.remaining_amount')}}</td>
                                            <td>{{ number_format($invoice->total - $invoice->payments->sum('amount'), 3) }}</td>
                                            <td colspan="2"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Notes --}}
                @if($invoice->notes_ar || $invoice->notes_en)
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h4 class="header-title mb-3">{{trans('back.notes')}}</h4>
                            @if(app()->getLocale() == 'ar' && $invoice->notes_ar)
                                <div class="alert alert-info">
                                    {!! nl2br(e($invoice->notes_ar)) !!}
                                </div>
                            @elseif(app()->getLocale() == 'en' && $invoice->notes_en)
                                <div class="alert alert-info">
                                    {!! nl2br(e($invoice->notes_en)) !!}
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

@endsection
