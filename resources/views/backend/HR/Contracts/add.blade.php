@extends('backend.layouts.master')

@section('page_title')
    {{trans('contracts.add_new_contract')}}
@endsection


@section('content')

    <div class="row">
        <div class="col-md-9 mb-1">
            <a class="btn btn-primary btn-sm" href="{{route('Contracts.index')}}">
                <i class="fas fa-arrow-right me-1"></i>
                {{trans('contracts.Back')}}
            </a>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card-box">

                <form action="{{route('Contracts.store')}}" method="post">
                    @csrf
                    <div class="row">

                        <div class="form-group col-md-3">
                            <label for="" class="font-weight-bold">
                                {{trans('contracts.select_Employee')}}
                            </label>
                            <select class="form-control select2" name="employee_id" required>
                                <option selected disabled value=""> {{trans('contracts.select_Employee')}}</option>
                                @foreach(App\Models\HR\Employee::all() as $employee)
                                    <option {{ old('employee_id') == $employee->id ? 'selected' : null }} value="{{ $employee->id }}">
                                        @if (app()->getLocale() == 'ar')
                                            {{ $employee->name_ar }} / {{ $employee->phone }}
                                        @else
                                            {{ $employee->name_en }} / {{ $employee->phone }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="name">{{trans('contracts.contract_name')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('contracts.contract_name')}}" name="name" value="{{old('name')}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="job_name_ar">{{trans('contracts.job_name_ar')}} </label>
                            <input type="text" class="form-control" placeholder="{{trans('contracts.job_name_ar')}}" name="job_name_ar" value="{{old('job_name_ar')}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="job_name_en">{{trans('contracts.job_name_en')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('contracts.job_name_en')}}" name="job_name_en" value="{{old('job_name_en')}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="contract_duration">{{trans('contracts.contract_duration')}} </label>
                            <input type="text" class="form-control" placeholder="{{trans('contracts.contract_duration')}}" name="contract_duration" value="{{old('contract_duration')}}" >
                        </div>


                        <div class="form-group col-md-3">
                            <label for="start_date">{{trans('contracts.start_date')}}</label>
                            <input type="date" class="form-control" placeholder="{{trans('contracts.start_date')}}" name="start_date" value="{{old('start_date')}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="end_date">{{trans('contracts.end_date')}} </label>
                            <input type="date" class="form-control" placeholder="{{trans('contracts.end_date')}}" name="end_date" value="{{old('end_date')}}" >
                        </div>


                        <div class="form-group col-md-3">
                            <label for="date">{{trans('contracts.date_contract')}} </label>
                            <input type="date" class="form-control" placeholder="{{trans('contracts.date_contract')}}" name="date" value="{{old('date')}}" >
                        </div>

                        <hr class="col-md-12">

                        <div class="form-group col-md-3">
                            <label for="basic_salary">{{trans('contracts.basic_salary')}} </label>
                            <input type="number" class="form-control" id="basic_salary"  placeholder="{{trans('contracts.basic_salary')}}" name="basic_salary" step="any" value="0.00" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="Acost_of_living_allowance">{{trans('contracts.Acost_of_living_allowance')}}</label>
                            <input type="number" class="form-control" id="Acost_of_living_allowance"  placeholder="{{trans('contracts.Acost_of_living_allowance')}}" name="Acost_of_living_allowance" step="any" value="0.00" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="food_allowance">{{trans('contracts.food_allowance')}} </label>
                            <input type="number" class="form-control" id="food_allowance"  placeholder="{{trans('contracts.food_allowance')}}" name="food_allowance" step="any" value="0.00" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="transfer_allowance">{{trans('contracts.transfer_allowance')}}</label>
                            <input type="number" class="form-control" id="transfer_allowance"  placeholder="{{trans('contracts.transfer_allowance')}}" name="transfer_allowance" step="any" value="0.00" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="overtime">{{trans('contracts.overtime')}}</label>
                            <input type="number" class="form-control" id="overtime"  placeholder="{{trans('contracts.overtime')}}" name="overtime" step="any" value="0.00" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="housing_allowance">{{trans('contracts.housing_allowance')}} </label>
                            <input type="number" class="form-control" placeholder="{{trans('contracts.housing_allowance')}}" name="housing_allowance" id="housing_allowance" step="any" value="0.00" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="phone_allowance">{{trans('contracts.phone_allowance')}} </label>
                            <input type="number" class="form-control" id="phone_allowance"  placeholder="{{trans('contracts.phone_allowance')}}" name="phone_allowance" step="any" value="0.00" >
                        </div>


                        <div class="form-group col-md-3">
                            <label for="other_allowance">{{trans('contracts.other_allowance')}} </label>
                            <input type="number" class="form-control" id="other_allowance"  placeholder="{{trans('contracts.other_allowance')}}" name="other_allowance" step="any" value="0.00" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="medical">{{trans('contracts.medical')}}</label>
                            <input type="number" class="form-control" id="medical"  placeholder="{{trans('contracts.medical')}}" name="medical" step="any" value="0.00" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="Social_insurance_discount">{{trans('contracts.Social_insurance_discount')}} </label>
                            <input type="number" class="form-control" id="Social_insurance_discount"  placeholder="{{trans('contracts.Social_insurance_discount')}}" step="any" name="Social_insurance_discount" value="0.00" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="total_salary">{{trans('contracts.total_salary')}}</label>
                            <input type="number" class="form-control" id="total_salary"  placeholder="{{trans('contracts.total_salary')}}" step="any" name="total_salary" value="0.00" >
                        </div>

                        <hr class="col-md-12">

                        <div class="form-group col-md-12">
                            <label for="contract_terms_ar">{{trans('contracts.contract_terms_ar')}}</label>
                            <textarea class="form-control editor "  name="contract_terms_ar"  rows="6">{{old('contract_terms_ar' , App\Models\Setting::first()->contract_terms_ar)}}</textarea>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="contract_terms_en">{{trans('contracts.contract_terms_en')}}</label>
                            <textarea class="form-control editor "  name="contract_terms_en"  rows="6">{{old('contract_terms_en' , App\Models\Setting::first()->contract_terms_en)}}</textarea>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="notes">{{trans('contracts.notes')}}</label>
                            <textarea class="form-control" name="notes"  rows="4">{{old('notes')}}</textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"> {{trans('contracts.Add')}} </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection


@section('js')
    <script>

        $(function() {
            $("#basic_salary, #Acost_of_living_allowance, #food_allowance, #transfer_allowance, #overtime, #housing_allowance, #phone_allowance, #other_allowance, #medical, #Social_insurance_discount").on("keydown keyup", sum);
            function sum() {
                $('#total_salary').val(calculate_total_salary());
            }


            // حساب الاجمالي
            let calculate_total_salary = function (){
                let sum = 0;

                let basic_salary = parseFloat($('#basic_salary').val()) || 0;
                let Acost_of_living_allowance = parseFloat($('#Acost_of_living_allowance').val()) || 0;
                let food_allowance = parseFloat($('#food_allowance').val()) || 0;
                let transfer_allowance = parseFloat($('#transfer_allowance').val()) || 0;
                let overtime = parseFloat($('#overtime').val()) || 0;
                let housing_allowance = parseFloat($('#housing_allowance').val()) || 0;
                let phone_allowance = parseFloat($('#phone_allowance').val()) || 0;
                let other_allowance = parseFloat($('#other_allowance').val()) || 0;
                let medical = parseFloat($('#medical').val()) || 0;
                let Social_insurance_discount = parseFloat($('#Social_insurance_discount').val()) || 0;

                sum += basic_salary;
                sum += Acost_of_living_allowance;
                sum += food_allowance;
                sum += transfer_allowance;
                sum += overtime;
                sum += phone_allowance;
                sum += other_allowance;
                sum += medical;

                sum -= Social_insurance_discount;

                return sum.toFixed(2);
            }

        });

    </script>
@endsection


