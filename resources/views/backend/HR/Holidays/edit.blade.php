@extends('backend.layouts.master')

@section('page_title')
   {{trans('holidays.edit_holiday')}}
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

                <form action="{{route('Holidays.update', $holiday->id )}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">

                        <div class="form-group col-md-3">
                            <label for="" class="font-weight-bold">
                               {{trans('holidays.select_category')}}
                            </label>
                            <select class="form-control select2" name="category_holiday_id" required>
                                <option selected disabled value=""> {{trans('holidays.select_category')}}</option>
                                @foreach(App\Models\HR\CategoryHoliday::all() as $categoryHoliday)
                                    <option value="{{$categoryHoliday->id}}" @if($categoryHoliday->id == $holiday->category_holiday_id) selected @endif>
                                        @if (app()->getLocale() == 'ar')
                                            {{$categoryHoliday->name}}
                                        @else
                                            {{$categoryHoliday->name_en}}
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
                                <option selected disabled value="">{{trans('holidays.select_Employee ')}}</option>
                                @foreach(App\Models\HR\Employee::all() as $employee)
                                    <option value="{{$employee->id}}" @if($employee->id == $holiday->employee_id) selected @endif>
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
                            <input type="text" class="form-control" placeholder="{{trans('holidays.holiday_name')}} " name="name" value="{{$holiday->name}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="number">{{trans('holidays.number_of_days')}} </label>
                            <input type="text" class="form-control" placeholder="{{trans('holidays.number_of_days')}} " name="number" value="{{$holiday->number}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="start_date">{{trans('holidays.Start_date')}} </label>
                            <input type="date" class="form-control" placeholder="{{trans('holidays.Start_date')}} " name="start_date" value="{{$holiday->start_date}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="end_date">{{trans('holidays.End_date')}} </label>
                            <input type="date" class="form-control" placeholder={{trans('holidays.End_date')}}" name="end_date" value="{{$holiday->end_date}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="date_request">{{trans('holidays.date_request')}}</label>
                            <input type="date" class="form-control" placeholder="{{trans('holidays.date_request')}}" name="date_request" value="{{$holiday->date_request}}" required>
                        </div>


                        <div class="form-group col-md-3">
                            <label for="date_work">{{trans('holidays.date_work')}}</label>
                            <input type="date" class="form-control" placeholder="{{trans('holidays.date_work')}}" name="date_work" value="{{$holiday->date_work}}" required>
                        </div>


                        <div class="form-group col-md-3">
                            <label for="substitute_employee">{{trans('holidays.substitute_employee')}} </label>
                            <input type="text" class="form-control" placeholder="{{trans('holidays.substitute_employee')}} " name="substitute_employee" value="{{$holiday->substitute_employee}}" required>
                        </div>


                        <div class="form-group col-md-12">
                            <label for="notes">{{trans('holidays.notes')}}</label>
                            <textarea class="form-control" name="notes"  rows="6">{{$holiday->notes}}</textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">{{trans('holidays.Save')}} </button>
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


