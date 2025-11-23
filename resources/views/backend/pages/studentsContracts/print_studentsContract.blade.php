<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>{{ $studentsContract->contract_number }}</title>

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

        .contract-title {
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

        .fees-table,
        .fees-table th,
        .fees-table td {
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
            .fees-table-wrapper {
                overflow-x: auto;
            }

            .fees-table {
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
                    <div class="contract-title">عقد تسجيل طالب</div>

                    <!-- Info Section -->
                    <div class="info-section">
                        @php
                            $date = $studentsContract->contract_date;
                            $gregorian = \Carbon\Carbon::parse($date)->format('d / m / Y');
                        @endphp
                        <p class="text-center"><strong>التاريخ:</strong> {{ $gregorian }}م</p>

                        <p><strong>الطرف الأول:</strong></p>
                        <table style="width: 100%; font-size: 16px; margin-bottom: 5px;">
                            <tr>
                                <td><strong>اسم الجهة:</strong> {{ App\Models\Setting::first()->company_name_ar }}</td>
                                <td><strong>الموقع:</strong> {{ App\Models\Setting::first()->address_ar }}</td>
                            </tr>
                            <tr><td colspan="2"><strong>يمثلها:</strong> إدارة المدرسة</td></tr>
                        </table>

                        <p><strong>الطرف الثاني:</strong></p>
                        <table style="width: 100%; font-size: 16px; margin-bottom: 5px;">
                            <tr>
                                <td><strong>ولي أمر الطالب/ـة:</strong> {{ $studentsContract->Student->Guardian->guardian_name ?? '________________' }}</td>
                                <td><strong>الجنسية:</strong> {{ $studentsContract->Student->nationality ?? '________________' }}</td>
                            </tr>
                            <tr>
                                <td><strong>رقم الهوية/الإقامة:</strong> {{ $studentsContract->Student->id_number }}</td>
                                <td><strong>رقم الجوال:</strong> {{ $studentsContract->Student->phone }}</td>
                            </tr>
                            <tr>
                                <td><strong>البريد الإلكتروني:</strong> {{ $studentsContract->Student->email ?? '________________' }}</td>
                                <td><strong>اسم الطالب/ـة:</strong> {{ $studentsContract->Student->first_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>الصف:</strong> {{ $studentsContract->Classroom->name_ar }} / {{ $studentsContract->Section->name_ar }}</td>
                                <td><strong>العام الدراسي:</strong> {{ $studentsContract->AcademicYear->academic_year }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Contract Clauses -->
                    <div class="info-section">
                        <strong>المادة (1): الهدف من العقد</strong><br>
                        يوثق هذا العقد العلاقة التربوية والإدارية والمالية بين الطرفين، بما يضمن وضوح الحقوق والواجبات للطرفين خلال فترة دراسة الطالب/ـة في المدرسة.
                    </div>

                    <div class="info-section">
                        <strong>المادة (2): الرسوم الدراسية و الأقساط</strong>
                        <div class="fees-table-wrapper">
                            <table class="fees-table table-sm" width="100%" style="margin-top: 5px;">
                                <thead style="background-color: #b5d7ea;">
                                    <tr>
                                        <th>#</th>
                                        <th>الرسوم</th>
                                        <th>الإجمالي</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($studentsContract->TuitionFees as $index => $fee)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $fee->pivot->name }}</td>
                                            <td>{{ number_format($fee->pivot->total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr style="background-color: #f1f1f1; font-weight: bold;">
                                        <td colspan="2">الإجمالي الفرعي</td>
                                        <td>{{ number_format($studentsContract->sub_total, 2) }}</td>
                                    </tr>
                                    <tr style="background-color: #f1f1f1; font-weight: bold;">
                                        <td colspan="2">الإجمالي الضريبة</td>
                                        <td>{{ number_format($studentsContract->tax_value, 2) }}</td>
                                    </tr>
                                    <tr style="background-color: #f9f9f9; font-weight: bold;">
                                        <td colspan="2">الخصم</td>
                                        <td>{{ number_format($studentsContract->discount, 2) }}</td>
                                    </tr>
                                    <tr style="background-color: #e9e9e9; font-weight: bold;">
                                        <td colspan="2">المبلغ بعد الخصم + الضريبة</td>
                                        <td>{{ number_format($studentsContract->total_amount_with_tax, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        @if($studentsContract->Installments->count())
                            <h4 style="margin-top: 10px; font-weight: bold;">جدول الأقساط</h4>
                            <div class="fees-table-wrapper">
                                <table class="fees-table table-sm" width="100%">
                                    <thead style="background-color: #d7e9f5;">
                                        <tr>
                                            <th>#</th>
                                            <th>المبلغ</th>
                                            <th>تاريخ الاستحقاق</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($studentsContract->Installments->sortBy('due_date')->values() as $i => $installment)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>{{ number_format($installment->installment_amount, 2) }}</td>
                                                <td>{{ \Carbon\Carbon::parse($installment->due_date)->format('Y/m/d') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    <div class="info-section" style="margin-top: 20px; font-size: 11.8px;">
                        {!! app()->getLocale() == 'en' ? $studentsContract->contract_terms_en : $studentsContract->contract_terms_ar !!}
                    </div>

                    <div class="signature-section">
                        <table width="100%" style="text-align: center;">
                            <tr>
                                <td width="50%">
                                    <strong>الطرف الأول</strong><br>
                                    <div>مدارس زهرة الحكمة الأهلية</div>
                                    <div>يمثلها: __________________________</div>
                                    <div>الوظيفة: __________________________</div>
                                    <div>التوقيع: __________________________</div>
                                    <div>
                                        الختم الرسمي:
                                        <img src="{{ asset(App\Models\Setting::first()->stamp) }}" alt="Stamp" width="100" style="vertical-align: middle; margin-inline-start: 10px;">
                                    </div>
                                </td>

                                <td width="50%">
                                    <strong>الطرف الثاني (ولي الأمر)</strong><br>
                                    <div>الاسم الكامل: {{ $studentsContract->Student->Guardian->guardian_name ?? '_______________________' }}</div>
                                    <div>رقم الهوية / الإقامة: {{ $studentsContract->Student->Guardian->id_number ?? '__________________' }}</div>
                                    <div>رقم الجوال: {{ $studentsContract->Student->Guardian->phone ?? '______________________' }}</div>
                                    <div>التوقيع:</div>
                                    @if($studentsContract->signature)
                                        <img src="{{ asset($studentsContract->signature) }}" alt="Guardian Signature" style="max-width: 250px; height: auto; padding: 4px;">
                                    @else
                                        <div style="height: 40px;">__________________________</div>
                                    @endif
                                </td>
                            </tr>
                        </table>
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
    window.onload = () => {
        window.print();
    };
</script>

</body>
</html>
