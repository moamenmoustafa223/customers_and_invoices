@extends('backend.layouts.master_invoice')

@section('page_title')
    {{ $payment->payment_number }} | {{ $payment->Student->first_name }}
@endsection

@section('content')
    <style>
        @media print {
            body {
                display: flex;
                justify-content: center;
                align-items: flex-start;
                padding: 0;
                margin: 0;
            }

            .container {
                width: 210mm !important;
                /* A4 width */
                margin: 0 auto !important;
                padding: 0 !important;
            }

            .row,
            .card-box,
            .panel-body {
                margin: 0 !important;
                padding: 0 !important;
            }

            .table {
                width: 100% !important;
            }
        }

        @media print {

            body,
            .container,
            .row,
            .card-box,
            .panel-body {
                padding: 0 !important;
                margin: 0 !important;
            }

            .mt-2,
            .mt-3 {
                margin-top: 0 !important;
            }

            .p-2 {
                padding: 0 !important;
            }

            .d-print-none {
                display: none !important;
            }

            .signature-stamp-row {
                page-break-inside: avoid !important;
            }
        }
    </style>

    <div class="container mt-2">
        <div class="row" dir="rtl">
            <div class="col-md-12">
                <div class="card-box">
                    <div class="panel-body">
                        <div class="clearfix">
                            <div>
                                <img src="{{ asset(App\Models\Setting::first()->header) }}" alt="" width="100%">
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="text-center font-weight-bold">
                                    <h4>سند قبض - Receipt Voucher</h4>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="float-left p-2">
                                        <p style="line-height: 30px">
                                            <strong>
                                                {{ trans('back.payment_date') }}:
                                                {{ $payment->created_at->format('Y-m-d') }}<br>
                                                {{ trans('back.receipt_number') }}: {{ $payment->payment_number }}<br>
                                                {{ trans('back.contract_number') }}:
                                                {{ $payment->StudentsContract->contract_number }}
                                            </strong>
                                        </p>
                                    </div>
                                    <div class="float-right p-2">
                                        <p>{!! QrCode::size(100)->generate(route('payment_number', $payment->payment_number)) !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table text-center table-bordered table-sm">
                                        <thead>
                                            <tr>
                                                <th width="30%">استلمنا من الفاضل</th>
                                                <th width="40%">{{ $payment->Student->first_name }}</th>
                                                <th width="30%">We Received from</th>
                                            </tr>
                                            <tr>
                                                <th>رقم العقد</th>
                                                <th>{{ $payment->StudentsContract->contract_number }}</th>
                                                <th>Contract Number</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>مبلغ وقدره</th>
                                                <th>{{ number_format($payment->payment_amount, 3) }} ريال</th>
                                                <th>Amount</th>
                                            </tr>
                                            <tr>
                                                <th>الحساب المالى</th>
                                                <th>
                                                    {{ app()->getLocale() == 'ar' ? $payment->Payment_method->name_ar : $payment->Payment_method->name_en }}
                                                </th>
                                                <th>Payment Method</th>
                                            </tr>
                                            <tr>
                                                <th>{{ trans('payment_methods.Check_number') }}</th>
                                                <th>{{ $payment->check_number ?? '-' }}</th>
                                                <th>Check Number</th>
                                            </tr>
                                            <tr>
                                                <th>البيان</th>
                                                <th>{{ $payment->payment_about ?? '-' }}</th>
                                                <th>Statement</th>
                                            </tr>
                                            <tr style="font-weight: bold;">
                                                <th>المبلغ المتبقي من القسط</th>
                                                <th class="text-danger">
                                                    {{ $installmentRest !== null ? number_format($installmentRest, 3) . ' ريال' : '-' }}
                                                </th>
                                                <th>Remaining from Installment</th>
                                            </tr>
                                            <tr style="font-weight: bold;">
                                                <th>المبلغ المتبقي من العقد كاملاً</th>
                                                <th class="text-primary">{{ number_format($contractRest, 3) }} ريال</th>
                                                <th>Total Remaining from Contract</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Signature + Stamp (Keep side by side) -->
                        <div class="row justify-content-between text-center mt-3 signature-stamp-row">
                            <div class="col-6">
                                <h5 class="text-dark">{{ trans('back.recipient_signature') }}</h5>
                                ----------------------------------
                            </div>
                            <div class="col-6">
                                <h5 class="text-dark">{{ trans('back.stamp') }}</h5>
                                <img src="{{ asset(App\Models\Setting::first()->stamp) }}" alt="" width="125">
                            </div>
                        </div>

                        <!-- Print Button -->
                        <div class="d-print-none mt-3">
                            <div class="float-right">
                                <a href="javascript:window.print()" class="btn btn-dark waves-effect waves-light">
                                    <i class="fa fa-print"></i> طباعة
                                </a>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.onload = () => {
            window.print();
        };
    </script>
@endsection
