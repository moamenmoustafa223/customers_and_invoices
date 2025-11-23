@extends('backend.layouts.master_invoice')

@section('page_title') {{$studentsContract->contract_number}} | {{$studentsContract->Student->first_name}} {{$studentsContract->Student->father_name}} {{$studentsContract->Student->grandfather_name}} @endsection
@section('title') {{$studentsContract->contract_number}}@endsection

@section('content')

    <!-- Start Content-->
    <div class="container">

        <div class="row" dir="rtl">
            <div class="col-md-12">
                <div class="card-box">
                    <div class="panel-body">
                        <div class="clearfix">
                            <div class="">
                                <img src="{{asset(App\Models\Setting::first()->header_contract_image)}}" alt="" width="100%"  >
                            </div>
                        </div>

                        <div class="row ">
                            <div class="col-md-12 ">
                                <div class="text-center font-weight-bold mb-3">
                                    <h4>
                                        عقد تسجيل طالب
                                    </h4>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 ">
                                @php
                                $date = $studentsContract->contract_date;
                                $gregorian = \Carbon\Carbon::parse($date)->format('d / m / Y');
                            @endphp
                            
                            <p class="text-start">
                                <strong>التاريخ:</strong> {{ $gregorian }}م
                            </p>

                                <p><strong>الطرف الأول:</strong></p>
                                <table class="table table-sm">
                                    <tr>
                                        <td><strong>اسم الجهة:</strong> {{ App\Models\Setting::first()->company_name_ar }}</td>
                                        <td><strong>الموقع:</strong> {{ App\Models\Setting::first()->address_ar }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><strong>يمثلها:</strong> إدارة المدرسة</td>
                                    </tr>
                                </table>

                                <p><strong>الطرف الثاني:</strong></p>
                                <table class="table table-sm">
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
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h5>المادة (1): الهدف من العقد</h5>
                                <p>يوثق هذا العقد العلاقة التربوية والإدارية والمالية بين الطرفين، بما يضمن وضوح الحقوق والواجبات للطرفين خلال فترة دراسة الطالب/ـة في المدرسة.</p>
                            </div>

                            <div class="col-md-12">
                                <h5>المادة (2): الرسوم الدراسية و الأقساط</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center table-sm">
                                        <thead class="thead-light">
                                        <tr style="background-color: #b5d7ea">
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
                                    <h5 style="margin-top: 10px; font-weight: bold;">جدول الأقساط</h5>
                                    <table class="table table-bordered text-center table-sm">
                                        <thead style="background-color: #d7e9f5">
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
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            {!! app()->getLocale() == 'en' ? $studentsContract->contract_terms_en : $studentsContract->contract_terms_ar !!}

                        </div>

                        <div class="col-md-12 text-center mt-3">
                            <table class="table table-bordered">
                                <tr>
                                    <td width="50%">
                                        <strong>الطرف الأول</strong><br>
                                        <div style="margin-bottom: 8px;">مدارس زهرة الحكمة الأهلية</div>
                                        <div style="margin-bottom: 8px;">يمثلها: __________________________</div>
                                        <div style="margin-bottom: 8px;">الوظيفة: __________________________</div>
                                        <div style="margin-bottom: 8px;">التوقيع: __________________________</div>
                                        <div style="margin-bottom: 8px;">
                                            الختم الرسمي:
                                            <img src="{{ asset(App\Models\Setting::first()->stamp) }}" alt="Stamp" width="100" style="vertical-align: middle; margin-inline-start: 10px;">
                                        </div>
                                    </td>
                                    
                                    <td width="50%">
                                        <strong>الطرف الثاني (ولي الأمر)</strong><br>
                                    
                                        <div style="margin-bottom: 8px;">
                                            الاسم الكامل: {{ $studentsContract->Student->Guardian->guardian_name ?? '_______________________' }}
                                        </div>
                                    
                                        <div style="margin-bottom: 8px;">
                                            رقم الهوية / الإقامة: {{ $studentsContract->Student->Guardian->id_number ?? '__________________' }}
                                        </div>
                                    
                                        <div style="margin-bottom: 12px;">
                                            رقم الجوال: {{ $studentsContract->Student->Guardian->phone ?? '______________________' }}
                                        </div>
                                    
                                        <div style="margin-bottom: 6px;">التوقيع:</div>
                                    
                                        @if($studentsContract->signature)
                                            <img src="{{ asset($studentsContract->signature) }}" alt="Guardian Signature" style="max-width: 250px; height: auto; padding: 4px;">
                                        @else
                                            <div style="height: 40px;">__________________________</div>
                                        @endif
                                    </td>
                                    
                                    
                                </tr>
                            </table>
                        </div>


                        <div class="d-print-none mt-3">
                            <div class="float-right">
                                <a href="{{ route('print_studentsContract', $studentsContract->id) }}" target="_blank" class="btn btn-dark waves-effect waves-light"><i class="fa fa-print"></i></a>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                    </div>
                </div>

                
            </div>
        </div>

    </div>
@endsection
