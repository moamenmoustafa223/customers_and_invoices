@extends('backend.layouts.master')

@section('page_title')
    {{trans('holidays.add_new_holiday')}}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-9 mb-1">
            <a class="btn btn-primary btn-sm" href="{{route('Holidays.index')}}">
                <i class="fas fa-arrow-right me-1"></i>
                {{trans('holidays.Back')}}
            </a>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card-box">

                <form action="{{route('Holidays.store')}}" method="post">
                    @csrf
                    <div class="row">

                        <div class="form-group col-md-3">
                            <label for="" class="font-weight-bold">
                                {{trans('holidays.select_category')}}
                            </label>
                            <select class="form-control select2" name="category_holiday_id" required>
                                <option selected disabled value=""> {{trans('holidays.select_category')}}</option>
                                @foreach(App\Models\HR\CategoryHoliday::all() as $categoryHoliday)
                                    <option value="{{ $categoryHoliday->id }}">
                                        @if (app()->getLocale() == 'ar')
                                            {{ $categoryHoliday->name }}
                                        @else
                                            {{ $categoryHoliday->name_en }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="" class="font-weight-bold">
                                {{trans('holidays.select_Employee ')}}
                            </label>
                            <select class="form-control select2" name="employee_id" required>
                                <option selected disabled value=""> {{trans('holidays.select_Employee ')}}</option>
                                @foreach(App\Models\HR\Employee::all() as $employee)
                                    <option value="{{ $employee->id }}">
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
                            <label for="name">{{trans('holidays.holiday_name')}} </label>
                            <input type="text" class="form-control" placeholder="{{trans('holidays.holiday_name')}} " name="name" value="{{old('name')}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="number">{{trans('holidays.number_of_days')}} </label>
                            <input type="text" class="form-control" placeholder="{{trans('holidays.number_of_days')}} " name="number" value="{{old('number')}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="start_date">{{trans('holidays.Start_date')}} </label>
                            <input type="date" class="form-control" placeholder="{{trans('holidays.Start_date')}}" name="start_date" value="{{old('start_date')}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="end_date">{{trans('holidays.End_date')}} </label>
                            <input type="date" class="form-control" placeholder="{{trans('holidays.End_date')}} " name="end_date" value="{{old('end_date')}}" required>
                        </div>


                        <div class="form-group col-md-3">
                            <label for="date_request">{{trans('holidays.date_request')}} </label>
                            <input type="date" class="form-control" placeholder="{{trans('holidays.date_request')}}" name="date_request" value="{{old('date_request')}}" required>
                        </div>


                        <div class="form-group col-md-3">
                            <label for="date_work">{{trans('holidays.date_work')}}</label>
                            <input type="date" class="form-control" placeholder="{{trans('holidays.date_work')}}" name="date_work" value="{{old('date_work')}}" required>
                        </div>


                        <div class="form-group col-md-3">
                            <label for="substitute_employee">{{trans('holidays.substitute_employee')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('holidays.substitute_employee')}} " name="substitute_employee" value="{{old('substitute_employee')}}" required>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="notes">{{trans('holidays.notes')}}</label>
                            <textarea class="form-control" name="notes"  rows="6">{{old('notes')}}</textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">{{trans('holidays.Add')}}</button>
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


