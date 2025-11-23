@extends('backend.layouts.master')

@section('page_title')
    {{trans('salaries.edit_salary')}}
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

                <form action="{{route('Salaries.update', $salary->id )}}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="form-group col-md-3">
                            <label for="" class="font-weight-bold">
                                {{trans('salaries.select_Employee ')}}
                            </label>
                            <select class="form-control select2" name="employee_id" required>
                                <option selected disabled value=""> {{trans('salaries.select_Employee ')}}</option>
                                @foreach(App\Models\HR\Employee::all() as $employee)
                                    <option value="{{$employee->id}}" @if($employee->id == $salary->employee_id) selected @endif>
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
                            <label for="name">{{trans('salaries.salary_name')}} </label>
                            <input type="text" class="form-control" placeholder="{{trans('salaries.salary_name')}} " name="name" value="{{$salary->name}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="amount">{{trans('salaries.amount')}}</label>
                            <input type="number" class="form-control" placeholder="{{trans('salaries.amount')}} " name="amount" step="any" value="{{$salary->amount}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="payment_method_id" >{{trans('back.select_payment_method')}}:</label>
                            <b class="text-danger">*</b>
                            <select class="form-control " name="payment_method_id" required>
                                <option value="">{{trans('back.select_payment_method')}}</option>
                                @foreach(App\Models\Payment_method::all() as $payment_method)
                                    <option value="{{ $payment_method->id }}" {{ old('payment_method_id', $salary->payment_method_id) == $payment_method->id ? 'selected' : null }}>
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
                            <input type="date" class="form-control" placeholder="{{trans('salaries.date')}} " name="date" value="{{$salary->date}}" required>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="notes">{{trans('salaries.notes')}}</label>
                            <textarea class="form-control" name="notes"  rows="6">{{$salary->notes}}</textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"> {{trans('salaries.Save')}} </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection


@section('js')
    <script>

    </script>
@endsection


