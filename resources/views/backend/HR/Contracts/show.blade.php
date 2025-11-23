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
                                    <div class="float-left ml-2">
                                        <h5>
                                            Contract No. : CON00{{$contract->id}}
                                        </h5>
                                    </div>
                                    <div class="float-right mr-2">
                                        <h5>
                                            Date : {{$contract->date}}
                                        </h5>
                                    </div>
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
                                                This  contract was executed on Tuesday
                                                <br>
                                                DATE : {{$contract->date}}
                                                <br>
                                                This contract is maintained between :
                                            </td>

                                            <td width="50%" dir="rtl" style="text-align: right; border: none">
                                                إنه في يوم
                                                <br>
                                                التاريخ : {{$contract->date}}
                                                <br>
                                                حرر هذا العقد بين كل من :
                                            </td>
                                        </tr>

                                        {{--   الطرف الأول--}}
                                        <tr>
                                            <td style="border: none">
                                                <h5>
                                                    FIRST PARTY (Employer)
                                                </h5>
                                                <p>
                                                Name :
                                                {{App\Models\Setting::first()->company_name_en}}
                                                <br>
                                                CR NO :
                                                {{App\Models\Setting::first()->cr_no}}
                                                <br>
                                                Address :
                                                {{App\Models\Setting::first()->address_en}}
                                                <br>
                                                Governorate :
                                                {{App\Models\Setting::first()->governorate_en}}
                                                <br>
                                                Wilayat :
                                                {{App\Models\Setting::first()->wilayat_en}}
                                                <br>
                                                Building No :
                                                {{App\Models\Setting::first()->building_no}}
                                                <br>
                                                P.O.  Box :
                                                {{App\Models\Setting::first()->PO_box}}
                                                <br>
                                                PC :
                                                {{App\Models\Setting::first()->pc}}
                                                <br>
                                                Email :
                                                {{App\Models\Setting::first()->email}}
                                                </p>
                                            </td>

                                            <td dir="rtl" style="text-align: right; border: none">
                                               <h5>
                                                   الطرف الأول ( صاحب العمل)
                                               </h5>
                                                <p>
                                                الاسم :
                                                {{App\Models\Setting::first()->company_name_ar}}
                                                <br>
                                                رقم السجل التجاري:
                                                {{App\Models\Setting::first()->cr_no}}
                                                <br>
                                                العنوان :
                                                {{App\Models\Setting::first()->address_ar}}
                                                <br>
                                                المحافظة :
                                                {{App\Models\Setting::first()->governorate_ar}}
                                                <br>
                                                الولاية :
                                                {{App\Models\Setting::first()->wilayat_ar}}
                                                <br>
                                                رقم المبنى :
                                                {{App\Models\Setting::first()->building_no}}
                                                <br>
                                                ص ب :
                                                {{App\Models\Setting::first()->PO_box}}
                                                <br>
                                                الرمز البريدي :
                                                {{App\Models\Setting::first()->pc}}
                                                <br>
                                                البريد الإلكتروني :
                                                {{App\Models\Setting::first()->email}}
                                                </p>
                                            </td>
                                        </tr>

                                        {{--   الطرف الثاني--}}
                                        <tr>
                                            <td style="border: none">
                                                <h5>
                                                    Second Party (Employee)
                                                </h5>
                                                <p>
                                                    Civil No :
                                                    {{App\Models\Setting::first()->name_website}}
                                                    <br>
                                                    Name  :
                                                    {{$contract->Employee->name_en}}
                                                    <br>
                                                    Nationality :
                                                    {{$contract->Employee->Nationality}}
                                                    <br>
                                                    Birth Date :
                                                    {{$contract->Employee->birth_date}}
                                                    <br>
                                                    Qualification :
                                                    {{$contract->Employee->academic}}
                                                    <br>
                                                    Passport Number :
                                                    {{$contract->Employee->passport_number}}
                                                    <br>
                                                    Date of Issue :
                                                    {{$contract->Employee->start_date_passport}}
                                                    <br>
                                                    Issued By :
                                                    {{$contract->Employee->Place}}
                                                    <br>
                                                    Phone No :
                                                    {{$contract->Employee->phone}}
                                                    <br>
                                                    Clearance Number :
                                                    ??
                                                    <br>
                                                    WP Number :
                                                    ??
                                                </p>
                                            </td>

                                            <td dir="rtl" style="text-align: right; border: none">
                                                <h5>
                                                    الطرف الثاني (العامل)
                                                </h5>
                                                <p>
                                                    الرقم المدني :
                                                    {{$contract->Employee->id_number}}
                                                    <br>
                                                    الاسم:
                                                    {{$contract->Employee->name_ar}}
                                                    <br>
                                                    الجنسية :
                                                    {{$contract->Employee->Nationality}}
                                                    <br>
                                                    تاريخ الميلاد :
                                                    {{$contract->Employee->birth_date}}
                                                    <br>
                                                    المؤهل العلمي :
                                                    {{$contract->Employee->academic}}
                                                    <br>
                                                    رقم جواز السفر :
                                                    {{$contract->Employee->passport_number}}
                                                    <br>
                                                    الصادر بتاريخ :
                                                    {{$contract->Employee->start_date_passport}}
                                                    <br>
                                                    الصادر من :
                                                    {{$contract->Employee->Place}}
                                                    <br>
                                                    رقم الهاتف :
                                                    {{$contract->Employee->phone}}
                                                    <br>
                                                    رقم الترخيص :
                                                    ??
                                                    <br>
                                                    رقم تصريح العمل :
                                                    ??
                                                </p>
                                            </td>
                                        </tr>

                                        {{-- مكان الإقامة --}}
                                        <tr>
                                            <td style="border: none">
                                                <h5>
                                                    Place of residence
                                                </h5>
                                                <p>
                                                    Governorate :
                                                    {{App\Models\Setting::first()->governorate_en}}
                                                    <br>
                                                    Wilayat :
                                                    {{App\Models\Setting::first()->wilayat_en}}
                                                    <br>
                                                    Village :
                                                    ??
                                                </p>
                                            </td>

                                            <td dir="rtl" style="text-align: right; border: none">
                                                <h5>
                                                   مكان الإقامة :
                                                </h5>
                                                <p>
                                                    المحافظة :
                                                    {{App\Models\Setting::first()->governorate_ar}}
                                                    <br>
                                                    الولاية:
                                                    {{App\Models\Setting::first()->wilayat_ar}}
                                                    <br>
                                                    القرية :
                                                    ??
                                                </p>
                                            </td>
                                        </tr>


                                        {{-- مقر العمل --}}
                                        <tr>
                                            <td style="border: none">
                                                <h5>
                                                    Work  Location Address
                                                </h5>
                                                <p>
                                                    Governorate :
                                                    {{App\Models\Setting::first()->governorate_en}}
                                                    <br>
                                                    Wilayat :
                                                    {{App\Models\Setting::first()->wilayat_en}}
                                                    <br>
                                                    Village :
                                                    ??
                                                    <br>
                                                    Address  :
                                                    {{App\Models\Setting::first()->address}}
                                                </p>
                                            </td>

                                            <td dir="rtl" style="text-align: right; border: none">
                                                <h5>
                                                    مقر العمل :
                                                </h5>
                                                <p>
                                                    المحافظة:
                                                    {{App\Models\Setting::first()->governorate_en}}
                                                    <br>
                                                    الولاية:
                                                    {{App\Models\Setting::first()->wilayat_en}}
                                                    <br>
                                                    القرية :
                                                    ??
                                                    <br>
                                                    العنوان :
                                                    {{App\Models\Setting::first()->address}}
                                                </p>
                                            </td>
                                        </tr>

                                        {{-- بعد أن أقر --}}
                                        <tr>
                                            <td style="border: none">
                                                <h5>
                                                    After declaring their illegibility to sign this contract the two parties have agreed on the following
                                                </h5>
                                                <p>
                                                    1 :
                                                    The second party has agreed to work with the first party as :
                                                    Occupation :
                                                    {{$contract->job_name_en}}
                                                </p>

                                                <p>
                                                    2 :
                                                    Duration of the contract :
                                                    {{$contract->contract_duration}}
                                                </p>

                                                <p>
                                                    From :
                                                    {{$contract->start_date}}
                                                    <br>
                                                    To  :
                                                    {{$contract->end_date}}
                                                    <br>
                                                    Basic salary   :
                                                    {{$contract->basic_salary}}
                                                    <br>
                                                    Gross salary :
                                                    {{$contract->total_salary}}
                                                    <br>
                                                    Pay Frequency :  Monthly
                                                </p>
                                            </td>

                                            <td dir="rtl" style="text-align: right; border: none">
                                                <h5>
                                                   بعد ان أقرّ الطرفان بأهليتهما للتعاقد اتفقا على ما يلي :
                                                </h5>
                                                <p>
                                                    1 :
                                                    وافق الطرف الثاني أن يعمل لدى الطرف الأول بمهنة:
                                                    {{$contract->job_name_ar}}
                                                </p>

                                                <p>
                                                    2 :
                                                    مدة التعاقد:
                                                    {{$contract->contract_duration}}
                                                    <br>
                                                    بداية العقد :
                                                    {{$contract->start_date}}
                                                    <br>
                                                    نهاية العقد :
                                                    {{$contract->end_date}}
                                                    <br>
                                                    الراتب الأساسي :
                                                    {{$contract->basic_salary}}
                                                    <br>
                                                    الراتب الشامل :
                                                    {{$contract->total_salary}}
                                                    <br>
                                                    ويدفع الأجر لكل : شهر
                                                </p>
                                            </td>
                                        </tr>

                                        {{-- الشروط والأحكام --}}
                                        <tr>
                                            <td style="border: none">
                                                <h5>
                                                    Terms and Conditions :
                                                </h5>
                                                <p>
                                                    {!! $contract->contract_terms_en !!}
                                                </p>
                                            </td>

                                            <td dir="rtl" style="text-align: right; border: none">
                                                <h5>
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
                                                <h5>
                                                    Second Party Signature
                                                </h5>
                                                <p>
                                                    -------------------------------
                                                </p>
                                            </td>

                                            <td style="border: none">
                                                <h5>
                                                    توقيع الطرف الثاني
                                                </h5>
                                                <p>
                                                    -------------------------------
                                                </p>
                                            </td>


                                            <td dir="rtl" style="text-align: right; border: none">
                                                <h5>
                                                    First Party Signature
                                                </h5>
                                                <p>
                                                    -------------------------------
                                                </p>
                                            </td>


                                            <td dir="rtl" style="text-align: right; border: none">
                                                <h5>
                                                    توقيع الطرف الأول :
                                                </h5>
                                                <p>
                                                    -------------------------------
                                                </p>
                                            </td>


                                        </tr>
                                    </table>
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


