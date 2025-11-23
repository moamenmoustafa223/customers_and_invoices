@extends('backend.layouts.master')

@section('page_title')
    {{trans('salaries.add_new_salary')}}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-9 mb-1">
            <a class="btn btn-primary btn-sm" href="{{route('Salaries.index')}}">
                <i class="fas fa-arrow-right me-1"></i>
                {{trans('salaries.Back')}}
            </a>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card-box">

                <form action="{{route('Salaries.store')}}" method="post">
                    @csrf
                    <div class="row">

                        <div class="form-group col-md-3">
                            <label for="" class="font-weight-bold">
                                {{trans('salaries.select_Employee')}}
                            </label>
                            <select class="form-control select2" name="employee_id" id="employee_id" required>
                                <option selected disabled value=""> {{trans('salaries.select_Employee')}}</option>
                                @foreach(App\Models\HR\Employee::all() as $employee)
                                    @php
                                        $latestContract = $employee->Contracts()->latest()->first();
                                        $totalSalary = $latestContract ? $latestContract->total_salary : 0;
                                    @endphp
                                    <option value="{{ $employee->id }}" data-salary="{{ $totalSalary }}">
                                        @if (app()->getLocale() == 'ar')
                                            {{ $employee->name_ar }}
                                        @else
                                            {{ $employee->name_en }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="name">{{trans('salaries.salary_name')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('salaries.salary_name')}} " name="name" value="{{old('name')}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="amount">{{trans('salaries.amount')}}</label>
                            <input type="number" class="form-control" id="salary_amount" placeholder="{{trans('salaries.amount')}}" name="amount" step="any" value="{{old('amount')}}" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="payment_method_id" >{{trans('payment_methods.select_payment_method')}}:</label>
                            <b class="text-danger">*</b>
                            <select class="form-control " name="payment_method_id" required>
                                <option value="">{{trans('payment_methods.select_payment_method')}}</option>
                                @foreach(App\Models\Payment_method::all() as $payment_method)
                                    <option value="{{ $payment_method->id }}">
                                        @if(app()->getLocale() == 'ar')
                                            {{ $payment_method->name_ar }}
                                        @else
                                            {{ $payment_method->name_en }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="date">{{trans('salaries.date')}} </label>
                            <input type="date" class="form-control" placeholder="{{trans('salaries.date')}} " name="date" value="{{date('Y-m-d')}}" required>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="notes">{{trans('salaries.notes')}}</label>
                            <textarea class="form-control" name="notes"  rows="6">{{old('notes')}}</textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">{{trans('salaries.Add')}} </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection


@section('js')
    <script>
        $(document).ready(function() {
            // Initialize Select2 if not already initialized
            if ($('#employee_id').hasClass('select2')) {
                $('#employee_id').select2();
            }

            // When employee is selected, auto-fill the salary amount
            // Use select2:select event for Select2 dropdowns
            $('#employee_id').on('select2:select change', function(e) {
                var selectedOption = $(this).find('option:selected');
                var salary = selectedOption.data('salary');

                console.log('Selected employee salary:', salary); // Debug log

                if (salary && salary > 0) {
                    $('#salary_amount').val(salary);
                } else {
                    $('#salary_amount').val('');
                }
            });
        });
    </script>
@endsection


