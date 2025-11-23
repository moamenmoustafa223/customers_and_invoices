@extends('backend.layouts.master')

@section('page_title')
    {{trans('setting.setting')}}
@endsection

@section('content')

    @can('Setting')
        <div class="row">
            <div class="col-12">
                <div class="card-box">

                    <form action=" {{ route('Setting.update', $setting->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">

                            <div class="form-group col-md-6">
                                <label for="exampleFormControlFile1">{{trans('setting.logo')}} </label>
                                <input type="file" class="form-control-file mb-2" name="logo" id="logo">
                                <img src="{{ asset($setting->logo) }}"  alt="image" width="100px">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="stamp"> {{trans('setting.stamp')}}</label>
                                <input type="file" class="form-control-file mb-2" name="stamp" id="stamp">
                                <img src="{{ asset($setting->stamp) }}"  alt="image" width="100px">
                            </div>

                            <hr class="col-md-12 mt-4 mb-4">

                            <div class="form-group col-md-4">
                                <label for="header">{{trans('setting.header')}} </label>
                                <input type="file" class="form-control-file mb-2" name="header" id="header">
                                <img src="{{ asset($setting->header) }}"  alt="image" width="100%">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="header_contract_image">{{trans('setting.header_contract_image')}} </label>
                                <input type="file" class="form-control-file mb-2" name="header_contract_image" id="header_contract_image">
                                <img src="{{ asset($setting->header_contract_image) }}"  alt="image" width="100%">
                            </div>

                            <hr class="col-md-12 mt-4 mb-4">

                            <div class="form-group col-md-3">
                                <label for="company_name_ar"> {{trans('setting.company_name_ar')}}   </label>
                                <input type="text" class="form-control"  name="company_name_ar" value="{{ $setting->company_name_ar }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="company_name_en"> {{trans('setting.company_name_en')}}   </label>
                                <input type="text" class="form-control"  name="company_name_en" value="{{ $setting->company_name_en }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="cr_no"> {{trans('setting.cr_no')}}   </label>
                                <input type="text" class="form-control"  name="cr_no" value="{{ $setting->cr_no }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="address_ar"> {{trans('setting.address_ar')}}   </label>
                                <input type="text" class="form-control"  name="address_ar" value="{{ $setting->address_ar }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="address_en"> {{trans('setting.address_en')}}   </label>
                                <input type="text" class="form-control"  name="address_en" value="{{ $setting->address_en }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="governorate_ar"> {{trans('setting.governorate_ar')}}   </label>
                                <input type="text" class="form-control"  name="governorate_ar" value="{{ $setting->governorate_ar }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="governorate_en"> {{trans('setting.governorate_en')}}   </label>
                                <input type="text" class="form-control"  name="governorate_en" value="{{ $setting->governorate_en }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="wilayat_ar"> {{trans('setting.wilayat_ar')}}   </label>
                                <input type="text" class="form-control"  name="wilayat_ar" value="{{ $setting->wilayat_ar }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="wilayat_en"> {{trans('setting.wilayat_en')}}   </label>
                                <input type="text" class="form-control"  name="wilayat_en" value="{{ $setting->wilayat_en }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="building_no"> {{trans('setting.building_no')}}   </label>
                                <input type="text" class="form-control"  name="building_no" value="{{ $setting->building_no }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="PO_box"> {{trans('setting.PO_box')}}   </label>
                                <input type="text" class="form-control"  name="PO_box" value="{{ $setting->PO_box }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="pc"> {{trans('setting.pc')}}   </label>
                                <input type="text" class="form-control"  name="pc" value="{{ $setting->pc }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="email"> {{trans('setting.email')}}  </label>
                                <input type="email" class="form-control"   name="email" value="{{ $setting->email }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="phone"> {{trans('setting.phone')}}   </label>
                                <input type="number" class="form-control" name="phone" value="{{ $setting->phone }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="phone_code"> {{trans('setting.phone_code')}}   </label>
                                <input type="number" class="form-control" name="phone_code" value="{{ $setting->phone_code }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="tax_no"> الرقم الضريبي   </label>
                                <input type="text" class="form-control" name="tax_no" value="{{ $setting->tax_no }}" placeholder="الرقم الضريبي">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="tax"> قيمة الضريبة </label>
                                <input type="number" class="form-control" name="tax" value="{{ $setting->tax }}" placeholder="قيمة الضريبة">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="tax_percentage"> نسبة الضريبة (%) / Tax Percentage (%) </label>
                                <input type="number" class="form-control" name="tax_percentage" value="{{ $setting->tax_percentage ?? 15 }}" placeholder="15" step="0.01" min="0" max="100">
                            </div>
                            <hr class="col-md-12 mt-4 mb-4">
                            <div class="form-group col-md-6">
                                <label for="contract_terms_ar"> شروط العقد (عربي) / Contract Terms (Arabic) </label>
                                <textarea class="form-control editor" name="contract_terms_ar" rows="4" placeholder="أدخل شروط العقد بالعربية">{{ $setting->contract_terms_ar }}</textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="contract_terms_en"> شروط العقد (إنجليزي) / Contract Terms (English) </label>
                                <textarea class="form-control editor" name="contract_terms_en" rows="4" placeholder="Enter contract terms in English">{{ $setting->contract_terms_en }}</textarea>
                            </div>

                            <div class="form-group col-md-12 text-center">
                                <button type="submit" class="btn btn-success"> {{trans('verbs.save')}}  </button>
                            </div>

                        </div>

                    </form>

                </div>
            </div>
        </div>
    @endcan

@endsection



