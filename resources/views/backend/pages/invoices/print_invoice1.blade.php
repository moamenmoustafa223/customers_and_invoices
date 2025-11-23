<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>{{ $invoice->invoice_number }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: #fdf8f2;
        }

        .web-preview-container {
            margin: 20px auto;
            padding: 25px;
            background-color: #fff;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            max-width: 850px;
        }

        .content {
            width: 100%;
        }

        .page-header,
        .page-footer {
            text-align: center;
            width: 100%;
            margin: 0 auto;
            max-width: 850px;
        }

        .page-header img,
        .page-footer img {
            width: 100%;
            height: auto;
            display: block;
        }

        .page-header {
            position: relative;
            margin-bottom: 10px;
        }

        .page-footer {
            position: relative;
            margin-top: 20px;
        }

        .page-header-space {
            height: 90px;
        }

        .page-footer-space {
            height: 100px;
        }

        .invoice-title {
            text-align: center;
            font-weight: bold;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .info-section {
            font-size: 16px;
            margin-bottom: 5px;
            padding-inline: 20px;
        }

        .table-sm th,
        .table-sm td {
            padding: 0.2rem !important;
            font-size: 12px !important;
        }

        .items-table,
        .items-table th,
        .items-table td {
            border: 1px solid #000;
            border-collapse: collapse;
            text-align: center;
            padding: 6px;
            font-size: 12px;
        }

        .signature-section {
            margin-top: 50px;
            font-size: 16px;
            text-align: center;
            padding-inline: 20px;
            page-break-inside: avoid;
            break-inside: avoid;
        }

        @media screen {
            .items-table-wrapper {
                overflow-x: auto;
            }

            .items-table {
                min-width: 600px;
            }
        }

        @media print {
            thead { display: table-header-group; }
            tfoot { display: table-footer-group; }

            body, html {
                margin: 0;
                padding: 0;
                background-color: #fff;
            }

            .web-preview-container {
                margin: 0;
                padding: 0;
                box-shadow: none;
                border-radius: 0;
                max-width: 100%;
            }

            .page-header,
            .page-footer {
                position: fixed;
                left: 0;
                right: 0;
                z-index: 999;
            }

            .page-header {
                top: 0;
                height: 90px;
            }

            .page-footer {
                bottom: 0;
                height: 100px;
            }

            .page-header img,
            .page-footer img {
                width: 100%;
                height: auto;
            }

            .d-print-none {
                display: none !important;
            }
        }

        @page {
            size: A4;
            margin: 2mm;
        }
    </style>
</head>
<body>

<div class="web-preview-container">

    <!-- Fixed Header -->
    <div class="page-header">
        <img src="{{ asset(App\Models\Setting::first()->header_contract_image) }}" alt="header">
    </div>

    <table>
        <thead>
            <tr><td><div class="page-header-space"></div></td></tr>
        </thead>

        <tbody>
            <tr>
                <td>
                    <!-- Main Content Starts -->
                    <div class="invoice-title">فاتورة / Invoice</div>

                    <!-- Invoice Info Section -->
                    <div class="info-section">
                        @php
                            $date = $invoice->invoice_date;
                            $gregorian = \Carbon\Carbon::parse($date)->format('d / m / Y');
                        @endphp

                        <table style="width: 100%; font-size: 14px; margin-bottom: 10px;">
                            <tr>
                                <td style="width: 50%;"><strong>رقم الفاتورة / Invoice Number:</strong> {{ $invoice->invoice_number }}</td>
                                <td style="width: 50%;"><strong>التاريخ / Date:</strong> {{ $gregorian }}م</td>
                            </tr>
                            <tr>
                                <td><strong>تاريخ الاستحقاق / Due Date:</strong> {{ $invoice->due_date->format('d / m / Y') }}م</td>
                                <td><strong>الحالة / Status:</strong> {{ app()->getLocale() == 'ar' ? $invoice->status->name_ar : $invoice->status->name_en }}</td>
                            </tr>
                        </table>

                        <hr style="margin: 10px 0;">

                        <p><strong>العميل / Customer:</strong></p>
                        <table style="width: 100%; font-size: 14px; margin-bottom: 10px;">
                            <tr>
                                <td><strong>الاسم / Name:</strong> {{ $invoice->customer->name }}</td>
                                <td><strong>الهاتف / Phone:</strong> {{ $invoice->customer->phone }}</td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong>العنوان / Address:</strong> {{ app()->getLocale() == 'ar' ? ($invoice->customer->address_ar ?? '-') : ($invoice->customer->address_en ?? '-') }}</td>
                            </tr>
                        </table>
                    </div>

                    <hr style="margin: 15px 20px;">

                    <!-- Invoice Items -->
                    <div class="info-section">
                        <strong style="font-size: 16px;">بنود الفاتورة / Invoice Items</strong>
                        <div class="items-table-wrapper">
                            <table class="items-table table-sm" width="100%" style="margin-top: 10px;">
                                <thead style="background-color: #b5d7ea;">
                                    <tr>
                                        <th width="50">#</th>
                                        <th>الخدمة / Service</th>
                                        <th width="80">الكمية / Qty</th>
                                        <th width="100">سعر الوحدة / Unit Price</th>
                                        <th width="100">الإجمالي / Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($invoice->items as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td style="text-align: start;">{{ app()->getLocale() == 'ar' ? $item->service->name_ar : $item->service->name_en }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ number_format($item->unit_price, 3) }}</td>
                                            <td>{{ number_format($item->total_price, 3) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr style="background-color: #f1f1f1; font-weight: bold;">
                                        <td colspan="4" style="text-align: end;">الإجمالي الفرعي / Subtotal</td>
                                        <td>{{ number_format($invoice->subtotal, 3) }}</td>
                                    </tr>
                                    <tr style="background-color: #f9f9f9; font-weight: bold;">
                                        <td colspan="4" style="text-align: end;">الضريبة / Tax</td>
                                        <td>{{ number_format($invoice->tax, 3) }}</td>
                                    </tr>
                                    <tr style="background-color: #e9e9e9; font-weight: bold;">
                                        <td colspan="4" style="text-align: end;">الإجمالي الكلي / Grand Total</td>
                                        <td>{{ number_format($invoice->total, 3) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        {{-- Installments if any --}}
                        @if($invoice->installments->count())
                            <h4 style="margin-top: 20px; font-weight: bold; font-size: 14px;">جدول الأقساط / Installments Schedule</h4>
                            <div class="items-table-wrapper">
                                <table class="items-table table-sm" width="100%" style="margin-top: 5px;">
                                    <thead style="background-color: #d7e9f5;">
                                        <tr>
                                            <th width="50">#</th>
                                            <th width="150">تاريخ الاستحقاق / Due Date</th>
                                            <th width="120">المبلغ / Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($invoice->installments->sortBy('due_date')->values() as $i => $installment)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>{{ $installment->due_date->format('Y/m/d') }}</td>
                                                <td>{{ number_format($installment->amount, 3) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    {{-- Notes --}}
                    @if($invoice->notes_ar || $invoice->notes_en)
                        <div class="info-section" style="margin-top: 20px; font-size: 12px;">
                            <strong>ملاحظات / Notes:</strong>
                            <p style="margin-top: 5px;">
                                {{ app()->getLocale() == 'ar' ? $invoice->notes_ar : $invoice->notes_en }}
                            </p>
                        </div>
                    @endif

                    {{-- Signature Section --}}
                    <div class="signature-section">
                        <table width="100%" style="text-align: center; border: 1px solid #000;">
                            <tr>
                                <td width="50%" style="border-left: 1px solid #000; padding: 20px;">
                                    <strong>الختم والتوقيع / Stamp & Signature</strong><br><br>
                                    <div style="min-height: 60px;">
                                        @if(App\Models\Setting::first()->stamp)
                                            <img src="{{ asset(App\Models\Setting::first()->stamp) }}" alt="Stamp" width="100" style="margin-top: 10px;">
                                        @endif
                                    </div>
                                    <div style="margin-top: 10px;">
                                        __________________________
                                    </div>
                                </td>

                                <td width="50%" style="padding: 20px;">
                                    <strong>توقيع العميل / Customer Signature</strong><br><br>
                                    <div style="min-height: 60px;">
                                    </div>
                                    <div style="margin-top: 10px;">
                                        __________________________
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                    {{-- Print Button --}}
                    <div class="d-print-none text-center" style="margin-top: 20px;">
                        <button onclick="window.print()" class="btn btn-primary" style="padding: 10px 30px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">
                            <i class="fa fa-print"></i> طباعة / Print
                        </button>
                    </div>
                </td>
            </tr>
        </tbody>

        <tfoot>
            <tr><td><div class="page-footer-space"></div></td></tr>
        </tfoot>
    </table>

    <!-- Fixed Footer (for print only) -->
    <div class="page-footer">
        <img src="{{ asset(App\Models\Setting::first()->footer_contract_image) }}" alt="footer">
    </div>
</div>

<script>
    // Auto-print when page loads (optional - can be removed if not needed)
    // window.onload = () => {
    //     window.print();
    // };
</script>

</body>
</html>
