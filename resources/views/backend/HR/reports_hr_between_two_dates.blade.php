@extends('backend.layouts.master')

@section('page_title')
    {{trans('back.reports_hr_between_two_dates')}}
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class=" justify-content-between">
                <form action="{{ route('reports_hr_between_two_dates') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="payment_method_id" >{{trans('back.Employees')}}:</label>
                            <select class="form-control select2 " name="employee_id" >
                                <option value="0">{{trans('back.All')}}</option>
                                @foreach(App\Models\HR\Employee::all() as $employee)
                                    <option value="{{ $employee->id }}" {{ old('employee_id', request()->input('employee_id')) == $employee->id ? 'selected' : null }}>
                                        {{ $employee->name_ar}} / {{ $employee->name_en}} / {{ $employee->phone }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label >{{trans('back.start_date')}}</label>
                            <input name="start_date" class="form-control form-control-sm " type="date" value="{{ $start_date??"" }}">
                        </div>
                        <div class="col-md-2">
                            <label > {{trans('back.end_date')}}</label>
                            <input name="end_date" class="form-control form-control-sm " type="date" value="{{ $end_date??"" }}">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary btn-sm " style="margin-top: 25px" type="submit">  {{trans('back.Search')}}  </button>
                            <a href="{{ route('reports_hr_between_two_dates') }}" style="margin-top: 25px" class="btn btn-success ml-1 " type="button" title="Reload">
                                <span class="fas fa-sync-alt"></span>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12 text-center">
            <h5>
                {{trans('back.total_salary')}} + {{trans('back.total_allowances')}} - {{trans('back.total_discounts')}}
                =
                <span class="text-danger">
                    {{trans('back.total')}} = {{ number_format(($salaries->sum('amount') + $allowances->sum('amount') ) - $discounts->sum('amount'), 3) }} OMR
                </span>
            </h5>
        </div>
        {{--الرواتب--}}
        <div class="col-md-6">
            <h5> {{trans('back.salaries')}} : </h5>
            <div class="card-box">
                <div class="table-responsive">
                    <table class="table text-center  table-bordered table-sm pb-0 mb-0 pt-0 ">
                        <thead>
                        <tr style="background-color: rgb(232,245,252)">
                            <th> {{trans('salaries.salary_name')}}</th>
                            <th> {{trans('salaries.Employee_name')}}</th>
                            <th> {{trans('salaries.amount')}}</th>
                            <th> {{trans('salaries.date')}}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($salaries as $salary)
                            <tr>
                                <td>{{ $salary->name }}</td>
                                <td>
                                    @if (app()->getLocale() == 'ar')
                                        {{ $salary->Employee->name_ar }} / {{ $salary->Employee->phone }}
                                    @else
                                        {{ $salary->Employee->name_en }} / {{ $salary->Employee->phone }}
                                    @endif
                                </td>
                                <td>{{ $salary->amount }}</td>
                                <td>{{ $salary->date }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>{{number_format($salaries->sum('amount', 3))}}</td>
                            <td></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{--الحوافز--}}
        <div class="col-md-6">
            <h5> {{trans('back.allowances')}} : </h5>
            <div class="card-box">

                <div class="table-responsive">
                    <table class="table text-center  table-bordered table-sm mb-0 pt-0 pb-0 ">
                        <thead>
                        <tr style="background-color: rgb(232,245,252)">
                            <th> {{trans('allowances.allowance_name')}}</th>
                            <th> {{trans('allowances.Employee_name')}}</th>
                            <th> {{trans('allowances.category_name')}}</th>
                            <th> {{trans('allowances.amount')}}</th>
                            <th> {{trans('allowances.date')}}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($allowances as $allowance)
                            <tr>
                                <td> {{ $allowance->name }}</td>
                                <td>
                                    @if (app()->getLocale() == 'ar')
                                        {{ $allowance->Employee->name_ar }} / {{ $allowance->Employee->phone }}
                                    @else
                                        {{ $allowance->Employee->name_en }} / {{ $allowance->Employee->phone }}
                                    @endif
                                </td>
                                <td>
                                    @if (app()->getLocale() == 'ar')
                                        {{ $allowance->CategoryAllowance->name }}
                                    @else
                                        {{ $allowance->CategoryAllowance->name_en }}
                                    @endif
                                </td>
                                <td>{{ $allowance->amount }}</td>
                                <td>{{ $allowance->date }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{number_format($allowances->sum('amount', 3))}}</td>
                            <td></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>

        {{--الخصومات--}}
        <div class="col-md-6">
            <h5> {{trans('back.discounts')}} : </h5>
            <div class="card-box">

                <div class="table-responsive">
                    <table class="table text-center  table-bordered table-sm pt-0 pb-0 mb-0 ">
                        <thead>
                        <tr style="background-color: rgb(232,245,252)">
                            <th> {{trans('discounts.discount_name')}}</th>
                            <th> {{trans('discounts.Employee_name')}}</th>
                            <th> {{trans('discounts.category_name')}}</th>
                            <th> {{trans('discounts.amount')}}</th>
                            <th> {{trans('discounts.date')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($discounts as $discount)
                            <tr>
                                <td> {{ $discount->name }}</td>
                                <td>
                                    @if (app()->getLocale() == 'ar')
                                        {{ $discount->Employee->name_ar }}/{{ $discount->Employee->phone }}
                                    @else
                                        {{ $discount->Employee->name_en }}/{{ $discount->Employee->phone }}
                                    @endif
                                </td>
                                <td>
                                    @if (app()->getLocale() == 'ar')
                                        {{ $discount->CategoryDiscount->name }}
                                    @else
                                        {{ $discount->CategoryDiscount->name_en }}
                                    @endif
                                </td>
                                <td>{{ $discount->amount }}</td>
                                <td>{{ $discount->date }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{number_format($discounts->sum('amount', 3))}}</td>
                            <td></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{--الاجازات--}}
        <div class="col-md-6">
            <h5> {{trans('back.holidays')}} : </h5>
            <div class="card-box">

                <div class="table-responsive">
                    <table class="table text-center  table-bordered table-sm pt-0 pb-0 mb-0 ">
                        <thead>
                        <tr style="background-color: rgb(232,245,252)">
                            <th>#</th>
                            <th> {{trans('holidays.holiday_name')}}</th>
                            <th> {{trans('holidays.Employee_name')}}</th>
                            <th> {{trans('holidays.category_name')}}</th>
                            <th> {{trans('holidays.number_of_days')}}</th>
                            <th> {{trans('holidays.Start_date')}}</th>
                            <th> {{trans('holidays.End_date')}}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($holidays as $holiday)
                            <tr>
                                <td> {{ $holiday->name }}</td>
                                <td>
                                    @if (app()->getLocale() == 'ar')
                                        {{ $holiday->Employee->name_ar }}/ {{ $holiday->Employee->phone }}
                                    @else
                                        {{ $holiday->Employee->name_en }}/{{ $holiday->Employee->phone }}
                                    @endif
                                </td>
                                <td>
                                    @if (app()->getLocale() == 'ar')
                                        {{ $holiday->CategoryHoliday->name }}
                                    @else
                                        {{ $holiday->CategoryHoliday->name_en }}
                                    @endif
                                </td>
                                <td>{{ $holiday->number }}</td>
                                <td>{{ $holiday->start_date }}</td>
                                <td>{{ $holiday->end_date }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{number_format($holidays->sum('number', 3))}}</td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>

    </div>

@endsection
