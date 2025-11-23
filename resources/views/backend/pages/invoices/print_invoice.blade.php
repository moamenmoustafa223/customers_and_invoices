@extends('backend.layouts.master')

@section('page_title')
    {{ trans('back.invoice') }} : {{ $invoice->invoice_number }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- Invoice Logo-->
                    <div>
                        <img alt="logo" class="w-100 mb-2"
                            src="{{ asset(App\Models\Setting::first()->header_contract_image) }}" />
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-1 text-end">
                            <span style="background-color: {{ $invoice->status->color }}" class="badge p-1 fs-12 mb-1">
                                {{ app()->getLocale() == 'ar' ? $invoice->status->name_ar : $invoice->status->name_en }}
                            </span>
                            <h3 class="m-0 fw-bolder fs-18">{{ trans('back.invoice') }}: {{ $invoice->invoice_number }}</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="mb-2">
                                <h5 class="fw-bold pb-1 mb-2 fs-14"> {{ trans('back.invoice_from') }} : </h5>
                                <h6 class="fs-14 mb-2">{{ App\Models\Setting::first()->company_name_ar ?? 'شركتك' }}</h6>
                                <h6 class="fs-14 text-muted mb-2 lh-base">{{ App\Models\Setting::first()->address ?? '-' }}
                                </h6>
                                <h6 class="fs-14 text-muted mb-0">{{ trans('back.phone') }}:
                                    {{ App\Models\Setting::first()->phone ?? '-' }}</h6>
                            </div>
                            <div>
                                <h5 class="fw-bold fs-14"> {{ trans('back.invoice_date') }} : </h5>
                                <h6 class="fs-14 text-muted">{{ $invoice->invoice_date->format('d M Y') }}</h6>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-2">
                                <h5 class="fw-bold pb-1 mb-2 fs-14"> {{ trans('back.bill_to') }} : </h5>
                                <h6 class="fs-14 mb-2">{{ $invoice->customer->name }}</h6>
                                <h6 class="fs-14 text-muted mb-2 lh-base">
                                    {{ app()->getLocale() == 'ar' ? $invoice->customer->address_ar ?? '-' : $invoice->customer->address_en ?? '-' }}
                                </h6>
                                <h6 class="fs-14 text-muted mb-0">{{ trans('back.phone') }}:
                                    {{ $invoice->customer->phone }}</h6>
                            </div>
                            <div>
                                <h5 class="fw-bold fs-14"> {{ trans('back.due_date') }} : </h5>
                                <h6 class="fs-14 text-muted">{{ $invoice->due_date->format('d M Y') }}</h6>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="mt-2">
                    <div class="table-responsive">
                        <table class="table table-sm text-center table-nowrap align-middle mb-0">
                            <thead>
                                <tr class="bg-light bg-opacity-50">
                                    <th class="border-0" scope="col" style="width: 50px;">#</th>
                                    <th class="text-start border-0" scope="col">{{ trans('back.service') }}</th>
                                    <th class="border-0" scope="col">{{ trans('back.quantity') }}</th>
                                    <th class="border-0" scope="col">{{ trans('back.unit_price') }}</th>
                                    <th class="text-end" scope="col">{{ trans('back.total') }}</th>
                                </tr>
                            </thead>
                            <tbody id="products-list">
                                @foreach ($invoice->items as $index => $item)
                                    <tr>
                                        <th scope="row">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</th>
                                        <td class="text-start">
                                            <span class="fw-medium">{{ $item->service_name ?? (app()->getLocale() == 'ar' ? $item->service->name_ar : $item->service->name_en) }}</span>
                                        </td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->unit_price, 3) }}</td>
                                        <td class="text-end">{{ number_format($item->total_price, 3) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <table class="table table-sm table-nowrap align-middle mb-0 ms-auto" style="width:335px">
                            <tbody>
                                <tr>
                                    <td class="fw-medium">{{ trans('back.subtotal') }}</td>
                                    <td class="text-end">{{ number_format($invoice->subtotal, 3) }}</td>
                                </tr>
                                @if ($invoice->discount > 0)
                                    <tr>
                                        <td class="fw-medium">{{ trans('back.discount') }}</td>
                                        <td class="text-end text-danger">-{{ number_format($invoice->discount, 3) }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td class="fw-medium">{{ trans('back.tax') }}</td>
                                    <td class="text-end">{{ number_format($invoice->tax, 3) }}</td>
                                </tr>
                                <tr class="border-top border-top-dashed fs-16">
                                    <td class="fw-bold">{{ trans('back.total_amount') }}</td>
                                    <td class="fw-bold text-end">{{ number_format($invoice->total, 3) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <!--end table-->
                    </div>
                </div>
                <div class="card-body">
                    @if ($invoice->notes_ar || $invoice->notes_en)
                        <div class="bg-body p-2 rounded-2 mt-2">
                            <p class="mb-0"><span class="fs-12 fw-bold text-uppercase">{{ trans('back.notes') }} :
                                </span>
                                {{ app()->getLocale() == 'ar' ? $invoice->notes_ar : $invoice->notes_en }}
                            </p>
                        </div>
                    @endif

                    {{-- Installments Schedule --}}
                    @if ($invoice->installments->count())
                        <div class="mt-2">
                            <h5 class="fw-bold mb-1">{{ trans('back.installments_schedule') }}</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>#</th>
                                            <th>{{ trans('back.due_date') }}</th>
                                            <th>{{ trans('back.amount') }}</th>
                                            <th>{{ trans('back.status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach ($invoice->installments->sortBy('due_date')->values() as $i => $installment)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>{{ $installment->due_date->format('Y/m/d') }}</td>
                                                <td>{{ number_format($installment->amount, 3) }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $installment->status == 'paid' ? 'success' : 'warning' }}">
                                                        {{ trans('back.' . $installment->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <div class="mt-2">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="px-3">
                                    @if (App\Models\Setting::first()->stamp)
                                        <img alt="stamp" height="80"
                                            src="{{ asset(App\Models\Setting::first()->stamp) }}" />
                                    @else
                                        <div style="min-height: 80px;"></div>
                                    @endif
                                    <div class="mt-3">
                                        <h5 class="mb-0">{{ trans('back.authorized_signature') }}</h5>
                                        <div class="mt-2">__________________________</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="px-3">
                                    <div style="min-height: 80px;"></div>
                                    <div class="mt-3">
                                        <h5 class="mb-0">{{ trans('back.customer_signature') }}</h5>
                                        <div class="mt-2">__________________________</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end card-body-->
            </div>
            <div class="d-print-none mb-2">
                <div class="d-flex justify-content-center gap-2">
                    <a class="btn btn-primary" href="javascript:window.print()"><i class="ti ti-printer me-1"></i>
                        {{ trans('back.print') }}</a>
                </div>
            </div>
            <!-- end buttons -->
        </div>
    </div>
@endsection

@section('scripts')
@endsection
