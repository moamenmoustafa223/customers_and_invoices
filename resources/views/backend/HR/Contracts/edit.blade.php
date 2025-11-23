@extends('backend.layouts.master')

@section('page_title')
    {{trans('contracts.edit_contract')}}
    {{$contract->id}}
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

                <form action="{{route('Contracts.update', $contract->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">

                        <div class="form-group col-md-3">
                            <label for="" class="font-weight-bold">
                               {{trans('contracts.select_Employee')}}
                            </label>
                            <select class="form-control select2" name="employee_id" required>
                                <option selected disabled value=""> {{trans('contracts.select_Employee')}}</option>
                                @foreach(App\Models\HR\Employee::all() as $employee)
                                    <option value="{{$employee->id}}" @if($employee->id == $contract->employee_id) selected @endif>
                                        @if(app()->getLocale() == 'ar')
                                            {{$employee->name_ar}} / {{ $employee->phone }}
                                        @else
                                            {{$employee->name_en}} / {{ $employee->phone }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="name">{{trans('contracts.contract_name')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('contracts.contract_name')}}" name="name" value="{{$contract->name}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="job_name_ar">{{trans('contracts.job_name_ar')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('contracts.job_name_ar')}}" name="job_name_ar" value="{{$contract->job_name_ar}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="job_name_en">{{trans('contracts.job_name_en')}} </label>
                            <input type="text" class="form-control" placeholder="{{trans('contracts.job_name_en')}}" name="job_name_en" value="{{$contract->job_name_en}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="contract_duration">{{trans('contracts.contract_duration')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('contracts.contract_duration')}}" name="contract_duration" value="{{$contract->contract_duration}}" required>
                        </div>


                        <div class="form-group col-md-3">
                            <label for="start_date">{{trans('contracts.start_date')}}</label>
                            <input type="date" class="form-control" placeholder="{{trans('contracts.start_date')}}" name="start_date" value="{{$contract->start_date}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="end_date">{{trans('contracts.end_date')}} </label>
                            <input type="date" class="form-control" placeholder="{{trans('contracts.end_date')}}" name="end_date" value="{{$contract->end_date}}" required>
                        </div>

                        <hr class="col-md-12">

                        <div class="form-group col-md-3">
                            <label for="basic_salary">{{trans('contracts.basic_salary')}} </label>
                            <input type="number" class="form-control" id="basic_salary"   name="basic_salary" step="any" value="{{$contract->basic_salary}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="Acost_of_living_allowance">{{trans('contracts.Acost_of_living_allowance')}}</label>
                            <input type="number" class="form-control" id="Acost_of_living_allowance"   name="Acost_of_living_allowance" step="any" value="{{$contract->Acost_of_living_allowance}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="food_allowance">{{trans('contracts.food_allowance')}} </label>
                            <input type="number" class="form-control" id="food_allowance"   name="food_allowance" step="any" value="{{$contract->food_allowance}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="transfer_allowance">{{trans('contracts.transfer_allowance')}}</label>
                            <input type="number" class="form-control" id="transfer_allowance"   name="transfer_allowance" step="any" value="{{$contract->transfer_allowance}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="overtime">{{trans('contracts.overtime')}}</label>
                            <input type="number" class="form-control" id="overtime"   name="overtime" step="any" value="{{$contract->overtime}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="housing_allowance">{{trans('contracts.housing_allowance')}} </label>
                            <input type="number" class="form-control"  name="housing_allowance" id="housing_allowance" step="any" value="{{$contract->housing_allowance}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="phone_allowance">{{trans('contracts.phone_allowance')}} </label>
                            <input type="number" class="form-control" id="phone_allowance"   name="phone_allowance" step="any" value="{{$contract->phone_allowance}}" >
                        </div>


                        <div class="form-group col-md-3">
                            <label for="other_allowance">{{trans('contracts.other_allowance')}} </label>
                            <input type="number" class="form-control" id="other_allowance"   name="other_allowance" step="any" value="{{$contract->other_allowance}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="medical">{{trans('contracts.medical')}}</label>
                            <input type="number" class="form-control" id="medical"   name="medical" step="any" value="{{$contract->medical}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="Social_insurance_discount">{{trans('contracts.Social_insurance_discount')}} </label>
                            <input type="number" class="form-control" id="Social_insurance_discount"   step="any" name="Social_insurance_discount" value="{{$contract->Social_insurance_discount}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="total_salary">{{trans('contracts.total_salary')}}</label>
                            <input type="number" class="form-control" id="total_salary"   step="any" name="total_salary" value="{{$contract->total_salary}}" >
                        </div>


                        <hr class="col-md-12">

                        <div class="form-group col-md-3">
                            <label for="date">{{trans('contracts.date_contract')}}د </label>
                            <input type="date" class="form-control" placeholder="{{trans('contracts.date_contract')}}" name="date" value="{{$contract->date}}" required>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="contract_terms_ar">{{trans('contracts.contract_terms_ar')}}</label>
                            <textarea class="form-control" id="editor_ar" name="contract_terms_ar"  rows="6">{{$contract->contract_terms_ar}}</textarea>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="contract_terms_en">{{trans('contracts.contract_terms_en')}}</label>
                            <textarea class="form-control" id="editor_en" name="contract_terms_en"  rows="6">{{$contract->contract_terms_en}}</textarea>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="notes">{{trans('contracts.notes')}}</label>
                            <textarea class="form-control" name="notes"  rows="4">{{$contract->notes}}</textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"> {{trans('contracts.Save')}} </button>
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




