@extends('backend.layouts.master_invoice')

@section('page_title')
    {{trans('contracts.print_contract')}} :
    {{$contract->name}}
@endsection

@section('css')
    <style>
        .table td, .table th {
            padding: 0.35rem;
            vertical-align: initial;
        }
    </style>
@endsection

@section('content')


    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="clearfix">
                                    <img src="{{asset(App\Models\Setting::first()->header)}}" width="100%" alt="">
                                    <hr>
                                    <div class="d-flex justify-content-between mb-3">
                                        <div>
                                            <strong>Contract No:</strong> CON00{{ $contract->id }}
                                        </div>
                                        <div>
                                            <strong>{{ trans('contracts.date') }}:</strong> {{ $contract->date }}
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">


                                <div class="table-responsive">
                                    <table class="table" style="font-size: 16px">
                                        <tbody>
                                        {{--   إنه في يوم --}}
                                        <tr>
                                            <td width="50%" style="border: none">
                                                <strong>This contract was executed on :</strong>
                                                <br>
                                                DATE : {{$contract->date}}
                                                <br>
                                                <strong>
                                                    This contract is maintained between :
                                                </strong>
                                            </td>

                                            <td width="50%" dir="rtl" style="text-align: right; border: none">
                                                <strong>إنه في يوم </strong>
                                                <br>
                                                التاريخ : {{$contract->date}}
                                                <br>
                                                <strong>حرر هذا العقد بين كل من :</strong> 
                                            </td>
                                            
                                        </tr>
                                        
                                        {{--   الطرف الأول--}}
                                        <tr>
                                            <td style="border: none">
                                                <h5 class="fw-bold">
                                                    FIRST PARTY (Employer)
                                                </h5>
                                                <p>
                                                    <strong>Name :</strong>
                                                    {{App\Models\Setting::first()->company_name_en}}<br>
                                                
                                                    <strong>CR NO :</strong>
                                                    {{App\Models\Setting::first()->cr_no}}<br>
                                                
                                                    <strong>Address :</strong>
                                                    {{App\Models\Setting::first()->address_en}}<br>
                                                
                                                    <strong>Governorate :</strong>
                                                    {{App\Models\Setting::first()->governorate_en}}<br>
                                                
                                                    <strong>Wilayat :</strong>
                                                    {{App\Models\Setting::first()->wilayat_en}}<br>
                                                
                                                    <strong>Building No :</strong>
                                                    {{App\Models\Setting::first()->building_no}}<br>
                                                
                                                    <strong>P.O. Box :</strong>
                                                    {{App\Models\Setting::first()->PO_box}}<br>
                                                
                                                    <strong>PC :</strong>
                                                    {{App\Models\Setting::first()->pc}}<br>
                                                
                                                    <strong>Email :</strong>
                                                    {{App\Models\Setting::first()->email}}
                                                </p>
                                                
                                            </td>

                                            <td dir="rtl" style="text-align: right; border: none">
                                               <h5>
                                                   الطرف الأول ( صاحب العمل)
                                               </h5>
                                               <p>
                                                <strong>الاسم :</strong>
                                                {{App\Models\Setting::first()->company_name_ar}}<br>
                                            
                                                <strong>رقم السجل التجاري:</strong>
                                                {{App\Models\Setting::first()->cr_no}}<br>
                                            
                                                <strong>العنوان :</strong>
                                                {{App\Models\Setting::first()->address_ar}}<br>
                                            
                                                <strong>المحافظة :</strong>
                                                {{App\Models\Setting::first()->governorate_ar}}<br>
                                            
                                                <strong>الولاية :</strong>
                                                {{App\Models\Setting::first()->wilayat_ar}}<br>
                                            
                                                <strong>رقم المبنى :</strong>
                                                {{App\Models\Setting::first()->building_no}}<br>
                                            
                                                <strong>ص ب :</strong>
                                                {{App\Models\Setting::first()->PO_box}}<br>
                                            
                                                <strong>الرمز البريدي :</strong>
                                                {{App\Models\Setting::first()->pc}}<br>
                                            
                                                <strong>البريد الإلكتروني :</strong>
                                                {{App\Models\Setting::first()->email}}
                                            </p>
                                            
                                            </td>
                                        </tr>

                                        {{--   الطرف الثاني--}}
                                        <tr>
                                            <td style="border: none">
                                                <h5 class="fw-bold">
                                                    Second Party (Employee)
                                                </h5>
                                                <p>
                                                    <strong>Civil No:</strong>
                                                    {{ App\Models\Setting::first()->name_website }}
                                                    <br>
                                                    <strong>Name:</strong>
                                                    {{ $contract->Employee->name_en }}
                                                    <br>
                                                    <strong>Nationality:</strong>
                                                    {{ $contract->Employee->Nationality }}
                                                    <br>
                                                    <strong>Birth Date:</strong>
                                                    {{ $contract->Employee->birth_date }}
                                                    <br>
                                                    <strong>Qualification:</strong>
                                                    {{ $contract->Employee->academic }}
                                                    <br>
                                                    <strong>Passport Number:</strong>
                                                    {{ $contract->Employee->passport_number }}
                                                    <br>
                                                    <strong>Date of Issue:</strong>
                                                    {{ $contract->Employee->start_date_passport }}
                                                    <br>
                                                    <strong>Issued By:</strong>
                                                    {{ $contract->Employee->Place }}
                                                    <br>
                                                    <strong>Phone No:</strong>
                                                    {{ $contract->Employee->phone }}
                                                    <br>
                                                    <strong>Clearance Number:</strong>
                                                    _______________
                                                    <br>
                                                    <strong>WP Number:</strong>
                                                    _______________
                                                </p>
                                                
                                            </td>

                                            <td dir="rtl" style="text-align: right; border: none">
                                                <h5 class="fw-bold">
                                                    الطرف الثاني (العامل)
                                                </h5>
                                                <p >
                                                    <strong>الرقم المدني:</strong>
                                                    {{ $contract->Employee->id_number }}
                                                    <br>
                                                    <strong>الاسم:</strong>
                                                    {{ $contract->Employee->name_ar }}
                                                    <br>
                                                    <strong>الجنسية:</strong>
                                                    {{ $contract->Employee->Nationality }}
                                                    <br>
                                                    <strong>تاريخ الميلاد:</strong>
                                                    {{ $contract->Employee->birth_date }}
                                                    <br>
                                                    <strong>المؤهل العلمي:</strong>
                                                    {{ $contract->Employee->academic }}
                                                    <br>
                                                    <strong>رقم جواز السفر:</strong>
                                                    {{ $contract->Employee->passport_number }}
                                                    <br>
                                                    <strong>الصادر بتاريخ:</strong>
                                                    {{ $contract->Employee->start_date_passport }}
                                                    <br>
                                                    <strong>الصادر من:</strong>
                                                    {{ $contract->Employee->Place }}
                                                    <br>
                                                    <strong>رقم الهاتف:</strong>
                                                    {{ $contract->Employee->phone }}
                                                    <br>
                                                    <strong>رقم الترخيص:</strong>
                                                    _______________
                                                    <br>
                                                    <strong>رقم تصريح العمل:</strong>
                                                    _______________
                                                </p>
                                                
                                            </td>
                                        </tr>

                                        {{-- مكان الإقامة --}}
                                        <tr>
                                            <td style="border: none">
                                                <h5 class="fw-bold">
                                                    Place of residence
                                                </h5>
                                                <p>
                                                    <strong>Governorate:</strong>
                                                    {{ App\Models\Setting::first()->governorate_en }}
                                                    <br>
                                                    <strong>Wilayat:</strong>
                                                    {{ App\Models\Setting::first()->wilayat_en }}
                                                    <br>
                                                    <strong>Village:</strong>
                                                    _______________
                                                </p>
                                                
                                            </td>

                                            <td dir="rtl" style="text-align: right; border: none">
                                                <h5 class="fw-bold">
                                                   مكان الإقامة :
                                                </h5>
                                                <p>
                                                    <strong>المحافظة:</strong>
                                                    {{ App\Models\Setting::first()->governorate_ar }}
                                                    <br>
                                                    <strong>الولاية:</strong>
                                                    {{ App\Models\Setting::first()->wilayat_ar }}
                                                    <br>
                                                    <strong>القرية:</strong>
                                                    _______________
                                                </p>
                                                
                                            </td>
                                        </tr>


                                        {{-- مقر العمل --}}
                                        <tr>
                                            <td style="border: none">
                                                <h5 class="fw-bold">
                                                    Work  Location Address
                                                </h5>
                                                <p>
                                                    <strong>Governorate:</strong> {{ App\Models\Setting::first()->governorate_en }}<br>
                                                    <strong>Wilayat:</strong> {{ App\Models\Setting::first()->wilayat_en }}<br>
                                                    <strong>Village:</strong> _______________<br>
                                                    <strong>Address:</strong> {{ App\Models\Setting::first()->address }}
                                                </p>
                                            </td>

                                            <td dir="rtl" style="text-align: right; border: none">
                                                <h5 class="fw-bold">
                                                    مقر العمل :
                                                </h5>
                                                <p >
                                                    <strong>المحافظة:</strong> {{ App\Models\Setting::first()->governorate_ar }}<br>
                                                    <strong>الولاية:</strong> {{ App\Models\Setting::first()->wilayat_ar }}<br>
                                                    <strong>القرية:</strong> _______________<br>
                                                    <strong>العنوان:</strong> {{ App\Models\Setting::first()->address }}
                                                </p>
                                            </td>
                                        </tr>

                                        {{-- بعد أن أقر --}}
                                        <tr>
                                            <td style="border: none">
                                                <h5 class="fw-bold">
                                                    After declaring their illegibility to sign this contract the two parties have agreed on the following
                                                </h5>
                                                <p>
                                                    <strong>1:</strong> The second party has agreed to work with the first party as:<br>
                                                    <strong>Occupation:</strong> {{ $contract->job_name_en }}
                                                </p>
                                                
                                                <p>
                                                    <strong>2:</strong> Duration of the contract: {{ $contract->contract_duration }}
                                                </p>
                                                
                                                <p>
                                                    <strong>From:</strong> {{ $contract->start_date }}<br>
                                                    <strong>To:</strong> {{ $contract->end_date }}<br>
                                                    <strong>Basic salary:</strong> {{ $contract->basic_salary }}<br>
                                                    <strong>Gross salary:</strong> {{ $contract->total_salary }}<br>
                                                    <strong>Pay Frequency:</strong> Monthly
                                                </p>
                                            </td>

                                            <td dir="rtl" style="text-align: right; border: none">
                                                <h5 class="fw-bold">
                                                   بعد ان أقرّ الطرفان بأهليتهما للتعاقد اتفقا على ما يلي :
                                                </h5>
                                                <p>
                                                    <strong>1:</strong> وافق الطرف الثاني أن يعمل لدى الطرف الأول بمهنة:<br>
                                                    <strong>{{ $contract->job_name_ar }}</strong>
                                                </p>
                                                
                                                <p>
                                                    <strong>2:</strong> مدة التعاقد: {{ $contract->contract_duration }}<br>
                                                    <strong>بداية العقد:</strong> {{ $contract->start_date }}<br>
                                                    <strong>نهاية العقد:</strong> {{ $contract->end_date }}<br>
                                                    <strong>الراتب الأساسي:</strong> {{ $contract->basic_salary }}<br>
                                                    <strong>الراتب الشامل:</strong> {{ $contract->total_salary }}<br>
                                                    <strong>ويدفع الأجر لكل:</strong> شهر
                                                </p>
                                            </td>
                                        </tr>

                                        {{-- الشروط والأحكام --}}
                                        <tr>
                                            <td style="border: none">
                                                <h5 class="fw-bold">
                                                    Terms and Conditions :
                                                </h5>
                                                <p>
                                                    {!! $contract->contract_terms_en !!}
                                                </p>
                                            </td>

                                            <td dir="rtl" style="text-align: right; border: none">
                                                <h5 class="fw-bold">
                                                    الشروط والاحكام :
                                                </h5>
                                                <p>
                                                    {!! $contract->contract_terms_ar !!}
                                                </p>
                                            </td>
                                        </tr>


                                        </tbody>
                                    </table>
                                </div>


                                <div class="table-responsive">
                                    <table class="table" style="font-size: 16px">
                                        {{-- التوقيع --}}
                                        <tr>
                                            <td style="border: none">
                                                <h5 class="fw-bold">
                                                    Second Party Signature
                                                </h5>
                                                <p>
                                                    -------------------------------
                                                </p>
                                            </td>

                                            <td style="border: none">
                                                <h5 class="fw-bold">
                                                    توقيع الطرف الثاني
                                                </h5>
                                                <p>
                                                    -------------------------------
                                                </p>
                                            </td>


                                            <td dir="rtl" style="text-align: right; border: none">
                                                <h5 class="fw-bold">
                                                    First Party Signature
                                                </h5>
                                                <p>
                                                    -------------------------------
                                                </p>
                                            </td>


                                            <td dir="rtl" style="text-align: right; border: none">
                                                <h5 class="fw-bold">
                                                    توقيع الطرف الأول :
                                                </h5>
                                                <p>
                                                    -------------------------------
                                                </p>
                                            </td>


                                        </tr>
                                    </table>
                                </div>

                                <div class="col-md-12 text-center">
                                    {!! QrCode::size(120)->generate(route('contract_number', $contract->contract_number)) !!}
                                    {{--                                    ------------------------------------}}
                                </div>

                            </div>
                        </div>

                        <hr>
                        <div class="d-print-none">
                            <div class="float-right">
                                <a href="javascript:window.print()" class="btn btn-dark btn-sm"><i class="fa fa-print"></i></a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>





@endsection


@section('js')
    <script>




    </script>
@endsection


