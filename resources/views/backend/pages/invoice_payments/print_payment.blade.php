@extends('backend.layouts.master')

@section('page_title')
    {{ trans('back.payment_receipt') }} : {{ $invoicePayment->payment_number }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- Header -->
                    <div>
                        <img alt="logo" class="w-100 mb-2"
                            src="{{ asset(App\Models\Setting::first()->header_contract_image) }}" />
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-1 text-end">
                            <span style="background-color: #28a745" class="badge p-1 fs-12 mb-1 text-white">
                                {{ trans('back.payment_received') }}
                            </span>
                            <h3 class="m-0 fw-bolder fs-18">{{ app()->getLocale() == 'ar' ? 'سند قبض' : 'Payment Receipt' }}: {{ $invoicePayment->payment_number }}</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="mb-2">
                                <h5 class="fw-bold pb-1 mb-2 fs-14"> {{ trans('back.payment_from') }} : </h5>
                                <h6 class="fs-14 mb-2">{{ $invoicePayment->invoice->customer->name }}</h6>
                                <h6 class="fs-14 text-muted mb-2 lh-base">
                                    {{ app()->getLocale() == 'ar' ? $invoicePayment->invoice->customer->address_ar ?? '-' : $invoicePayment->invoice->customer->address_en ?? '-' }}
                                </h6>
                                <h6 class="fs-14 text-muted mb-0">{{ trans('back.phone') }}:
                                    {{ $invoicePayment->invoice->customer->phone }}</h6>
                            </div>
                            <div>
                                <h5 class="fw-bold fs-14"> {{ trans('back.payment_date') }} : </h5>
                                <h6 class="fs-14 text-muted">{{ $invoicePayment->payment_date->format('d M Y') }}</h6>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-2">
                                <h5 class="fw-bold pb-1 mb-2 fs-14"> {{ trans('back.invoice_number') }} : </h5>
                                <h6 class="fs-14 mb-2">{{ $invoicePayment->invoice->invoice_number }}</h6>
                            </div>
                            <div class="mb-2">
                                <h5 class="fw-bold fs-14"> {{ trans('back.payment_method') }} : </h5>
                                <h6 class="fs-14 text-muted">{{ app()->getLocale() == 'ar' ? $invoicePayment->paymentMethod->name_ar : $invoicePayment->paymentMethod->name_en }}</h6>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="mt-2">
                    <div class="table-responsive">
                        <table class="table table-sm text-center table-nowrap align-middle mb-0">
                            <thead>
                                <tr class="bg-light bg-opacity-50">
                                    <th class="border-0" scope="col">{{ trans('back.description') }}</th>
                                    <th class="text-end border-0" scope="col">{{ trans('back.amount') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-start">
                                        <span class="fw-medium">{{ trans('back.payment_for_invoice') }} {{ $invoicePayment->invoice->invoice_number }}</span>
                                    </td>
                                    <td class="text-end">{{ number_format($invoicePayment->amount, 3) }}</td>
                                </tr>
                            </tbody>
                        </table><!--end table-->
                    </div>
                    <div>
                        <table class="table table-sm table-nowrap align-middle mb-0 ms-auto" style="width:335px">
                            <tbody>
                                <tr class="border-top border-top-dashed fs-16">
                                    <td class="fw-bold">{{ trans('back.total_payment') }}</td>
                                    <td class="fw-bold text-end">{{ number_format($invoicePayment->amount, 3) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <!--end table-->
                    </div>
                </div>
                <div class="card-body">
                    @if ($invoicePayment->notes_ar || $invoicePayment->notes_en)
                        <div class="bg-body p-2 rounded-2 mt-2">
                            <p class="mb-0"><span class="fs-12 fw-bold text-uppercase">{{ trans('back.notes') }} :
                                </span>
                                {{ app()->getLocale() == 'ar' ? $invoicePayment->notes_ar : $invoicePayment->notes_en }}
                            </p>
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
                                        <h5 class="mb-0">{{ trans('back.company_stamp') }}</h5>
                                        <div class="mt-2">__________________________</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="px-3">
                                    <div style="min-height: 80px;"></div>
                                    <div class="mt-3">
                                        <h5 class="mb-0">{{ trans('back.receiver_signature') }}</h5>
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
    <script>
        window.onload = () => {
            window.print();
        };
    </script>
@endsection
