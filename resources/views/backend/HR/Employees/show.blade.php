@extends('backend.layouts.master')

@section('page_title')
    {{trans('employees.Page_of_employee')}} :
    {{$employee->name}}
@endsection


@section('content')

    <div class="row">
        <div class="col-md-9 mb-1">
            <a class="btn btn-primary btn-sm" href="{{route('Employees.index')}}">
                <i class="fas fa-arrow-right me-1"></i>
                {{trans('back.Back')}}
            </a>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="bg-picture card-box">
                <div class="profile-info-name">
                    <img src="{{asset($employee->image)}}"
                         class="rounded-circle avatar-xl img-thumbnail float-left mr-3" alt="profile-image">

                    <div class="profile-info-detail overflow-hidden">
                        <h4 class="mb-2">
                            <span class="text-primary">{{trans('back.employee_name')}} :</span>
                            @if (app()->getLocale() == 'ar')
                                {{ $employee->name_ar }}
                            @else
                                {{ $employee->name_en }}
                            @endif
                        </h4>
                        <p class="font-16">
                            <span class="text-primary">{{trans('back.employee_no')}} :</span>
                            {{$employee->employee_no}}
                        </p>

                        <p class="font-16">
                            <span class="text-primary">{{trans('back.Join_date')}} :</span>
                            {{$employee->Join_date}}
                        </p>

                        <p class="font-16">
                            <b>{{trans('back.Nationality')}} :</b>
                            {{$employee->Nationality}}
                            -
                            <b> {{trans('back.phone')}} :</b>
                            {{$employee->phone}}
                            -
                            <b>{{trans('back.email')}} :</b>
                            {{$employee->email}}
                            -
                            <b> {{trans('back.id_number')}} :</b>
                            {{$employee->id_number}}
                            -
                            <b> {{trans('back.passport_number')}} :</b>
                            {{$employee->passport_number}}
                            -
                            <b> {{trans('back.address')}} :</b>
                            {{$employee->address}}
                        </p>

                        <p class="font-16">
                            <b>{{trans('back.Total_Leave_Balance')}}</b>
                            <span class="text-primary">( {{$employee->Balances->sum('number')}} ) </span>
                            <br>

                            <b>{{trans('back.total_holidays')}}</b>
                            <span class="text-primary"> ( {{$employee->Holidays->sum('number')}} ) </span>
                            <br>

                            <b>{{trans('back.The_rest')}}</b>
                            <span class="text-primary">( {{$employee->Balances->sum('number') - $employee->Holidays->sum('number')}} ) </span>

                        </p>

                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>
            <!--/ meta -->

            <div class="card-box">
                <h4 class="mb-2 font-14"> {{trans('contracts.Contracts')}} : </h4>
                @if(!$employee->Contracts->count() == 0)
                    <div class="col-md-12">

                        <div class="table-responsive">
                            <table class="table text-center  table-bordered table-sm ">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th> {{trans('contracts.contract_name')}}</th>
                                    <th> {{trans('contracts.Employee_name')}}</th>
                                    <th> {{trans('contracts.start_date')}}</th>
                                    <th> {{trans('contracts.end_date')}}</th>
                                    <th> {{trans('contracts.job_name')}}</th>
                                    <th> {{trans('contracts.Created_at')}}</th>
                                    <th> {{trans('contracts.Action')}}</th>
                                </tr>
                                </thead>

                                @php $i=1 @endphp
                                <tbody>
                                @foreach($employee->Contracts as $contract)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td> {{ $contract->name }}</td>
                                        <td>
                                            <a href="{{route('Employees.show', $contract->Employee->id )}}"
                                               class="font-weight-bold">
                                                @if (app()->getLocale() == 'ar')
                                                    {{ $contract->Employee->name_ar }}
                                                    <br>
                                                    {{ $contract->Employee->phone }}
                                                @else
                                                    {{ $contract->Employee->name_en }}
                                                    <br>
                                                    {{ $contract->Employee->phone }}
                                                @endif
                                            </a>
                                        </td>
                                        <td> {{ $contract->start_date }}</td>
                                        <td> {{ $contract->end_date }}</td>
                                        <td>
                                            @if (app()->getLocale() == 'ar')
                                                {{ $contract->job_name_ar }}
                                            @else
                                                {{ $contract->job_name_en }}
                                            @endif
                                        </td>
                                        <td>{{ $contract->date }}</td>
                                        <td>
                                            <a class="btn btn-primary btn-xs ml-1"
                                               href="{{ route('Contracts.show',$contract->id) }}" target="_blank">
                                                <i class="fas fa-print"></i>
                                            </a>
                                            <a class="btn btn-success btn-xs ml-1"
                                               href="{{ route('Contracts.edit',$contract->id) }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="" class="btn btn-primary btn-xs ml-1" data-toggle="modal"
                                               data-target="#delete_contract{{$contract->id}}">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                            @include('backend.HR.Contracts.delete')
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="text-center">
                        <h5 class="text-primary"> {{trans('contracts.No_contracts')}}</h5>
                    </div>
                @endif
            </div>

            <div class="card-box">
                <h4 class="mb-2 font-14"> {{trans('salaries.salaries')}} :</h4>
                @if(!$employee->Salaries->count() == 0)
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table text-center  table-bordered table-sm ">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th> {{trans('salaries.salary_name')}}</th>
                                    <th> {{trans('salaries.Employee_name')}}</th>
                                    <th> {{trans('salaries.amount')}}</th>
                                    <th> {{trans('salaries.date')}}</th>
                                    <th> {{trans('salaries.Created_at')}}</th>
                                    <th> {{trans('salaries.Action')}}</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($employee->Salaries as $salary)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{ $salary->name }}</td>
                                        <td>
                                            <a href="{{route('Employees.show', $salary->Employee->id )}}"
                                               class="font-weight-bold">
                                                @if (app()->getLocale() == 'ar')
                                                    {{ $salary->Employee->name_ar }}
                                                    <br>
                                                    {{ $salary->Employee->phone }}
                                                @else
                                                    {{ $salary->Employee->name_en }}
                                                    <br>
                                                    {{ $salary->Employee->phone }}
                                                @endif
                                            </a>
                                        </td>
                                        <td>{{ $salary->amount }}</td>
                                        <td>{{ $salary->date }}</td>
                                        <td>{{ $salary->created_at }}</td>
                                        <td>
                                            {{--                                            @can('Salaries_show')--}}
                                            {{--                                                <a class="btn btn-secondary btn-xs " href="{{ route('Salaries.show',$salary->id) }}">--}}
                                            {{--                                                    <i class="fas fa-eye"></i>--}}
                                            {{--                                                </a>--}}
                                            {{--                                            @endcan--}}

                                            @can('Salaries_edit')
                                                <a class="btn btn-success btn-xs "
                                                   href="{{route('Salaries.edit', $salary->id)}}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endcan

                                            @can('Salaries_delete')
                                                <a href="" class="btn btn-primary btn-xs " data-toggle="modal"
                                                   data-target="#delete_salary{{$salary->id}}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                                @include('backend.HR.Salaries.delete')
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="text-center">
                        <h5 class="text-primary"> {{trans('salaries.No_salaries_yet')}}</h5>
                    </div>
                @endif
            </div>

            <div class="card-box">
                <h4 class="mb-2 font-14"> {{trans('holidays.holidays')}} :</h4>
                @if(!$employee->Holidays->count() == 0)
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table text-center  table-bordered table-sm ">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th> {{trans('holidays.holiday_name')}}</th>
                                    <th> {{trans('holidays.Employee_name')}}</th>
                                    <th> {{trans('holidays.category_name')}}</th>
                                    <th> {{trans('holidays.number_of_days')}}</th>
                                    <th> {{trans('holidays.Start_date')}}</th>
                                    <th> {{trans('holidays.End_date')}}</th>
                                    <th> {{trans('holidays.Action')}}</th>
                                    <th> {{trans('holidays.Created_at')}}</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($employee->Holidays as $key => $holiday)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td> {{ $holiday->name }}</td>
                                        <td>
                                            <a href="{{route('Employees.show', $holiday->Employee->id )}}"
                                               class="font-weight-bold">
                                                @if (app()->getLocale() == 'ar')
                                                    {{ $holiday->Employee->name_ar }}
                                                    <br>
                                                    {{ $holiday->Employee->phone }}
                                                @else
                                                    {{ $holiday->Employee->name_en }}
                                                    <br>
                                                    {{ $holiday->Employee->phone }}
                                                @endif
                                            </a>
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
                                        <td>
                                            {{--                                    <a class="btn btn-secondary btn-xs " href="{{ route('CategoryHolidays.show',$holiday->id) }}">--}}
                                            {{--                                        <i class="fas fa-eye"></i>--}}
                                            {{--                                    </a>--}}
                                            <a class="btn btn-success btn-xs "
                                               href="{{route('Holidays.edit', $holiday->id)}}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="" class="btn btn-primary btn-xs " data-toggle="modal"
                                               data-target="#delete_Holidays{{$holiday->id}}">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                            @include('backend.HR.Holidays.delete')
                                        </td>
                                        <td>{{ $holiday->created_at }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="text-center">
                        <h5 class="text-primary">  {{trans('holidays.No_holidays_yet')}}</h5>
                    </div>
                @endif
            </div>

            <div class="card-box">
                <h4 class="mb-2 font-14"> {{trans('courses.Employees_Courses')}} :</h4>
                <div class="col-md-12">
                    @if(!$employee->Allowances->count() == 0)
                        <div class="table-responsive">
                            <table class="table text-center  table-bordered table-sm ">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th> {{trans('courses.Course_name')}}</th>
                                    <th> {{trans('courses.Employee_name')}}</th>
                                    <th> {{trans('courses.Course_Start')}}</th>
                                    <th> {{trans('courses.Course_End')}}</th>
                                    <th> {{trans('courses.Created_at')}}</th>
                                    <th> {{trans('courses.Action')}}</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($employee->employees_courses as $employeesCourse)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td> {{ $employeesCourse->name }}</td>
                                        <td>
                                            <a href="{{route('Employees.show', $employeesCourse->employee->id )}}">
                                                @if (app()->getLocale() == 'ar')
                                                    {{ $employeesCourse->employee->name_ar }}
                                                    <br> {{ $employeesCourse->employee->phone }}
                                                @else
                                                    {{ $employeesCourse->employee->name_en }}
                                                    <br> {{ $employeesCourse->employee->phone }}
                                                @endif
                                            </a>
                                        </td>
                                        <td> {{ $employeesCourse->start }}</td>
                                        <td> {{ $employeesCourse->end }}</td>
                                        <td>{{ $employeesCourse->created_at }}</td>
                                        <td>
                                            @can('EmployeesCourses_edit')
                                                <a class="btn btn-success btn-xs" href="" data-toggle="modal"
                                                   data-target="#edit_EmployeesCourses{{$employeesCourse->id}}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @include('backend.HR.EmployeesCourses.edit')
                                            @endcan

                                            @can('EmployeesCourses_delete')
                                                <a href="" class="btn btn-primary btn-xs" data-toggle="modal"
                                                   data-target="#delete_EmployeesCourses{{$employeesCourse->id}}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                                @include('backend.HR.EmployeesCourses.delete')
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center">
                            <h5 class="text-primary"> {{trans('courses.No_courses_yet')}}</h5>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card-box">
                <h4 class="mb-2 font-14"> {{trans('discounts.discounts')}} :</h4>
                <div class="col-md-12">
                    @if(!$employee->Discounts->count() == 0)
                        <div class="table-responsive">
                            <table class="table text-center  table-bordered table-sm ">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th> {{trans('discounts.discount_name')}}</th>
                                    <th> {{trans('discounts.Employee_name')}}</th>
                                    <th> {{trans('discounts.category_name')}}</th>
                                    <th> {{trans('discounts.amount')}}</th>
                                    <th> {{trans('discounts.date')}}</th>
                                    <th> {{trans('discounts.Created_at')}}</th>
                                    <th> {{trans('discounts.Action')}}</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($employee->Discounts as $discount)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td> {{ $discount->name }}</td>
                                        <td>
                                            <a href="{{route('Employees.show', $discount->Employee->id )}}"
                                               class="font-weight-bold">
                                                @if (app()->getLocale() == 'ar')
                                                    {{ $discount->Employee->name_ar }}
                                                    <br>
                                                    {{ $discount->Employee->phone }}
                                                @else
                                                    {{ $discount->Employee->name_en }}
                                                    <br>
                                                    {{ $discount->Employee->phone }}
                                                @endif
                                            </a>
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
                                        <td>{{ $discount->created_at }}</td>

                                        <td>
                                            {{--                                    @can('Discounts_show')--}}
                                            {{--                                    <a class="btn btn-secondary btn-xs " href="{{ route('Discounts.show',$discount->id) }}">--}}
                                            {{--                                        <i class="fas fa-eye"></i>--}}
                                            {{--                                    </a>--}}
                                            {{--                                    @endcan--}}

                                            @can('Discounts_edit')
                                                <a class="btn btn-success btn-xs "
                                                   href="{{route('Discounts.edit', $discount->id)}}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endcan

                                            @can('Discounts_delete')
                                                <a href="" class="btn btn-primary btn-xs " data-toggle="modal"
                                                   data-target="#delete_Discounts{{$discount->id}}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                                @include('backend.HR.Discounts.delete')
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center">
                            <h5 class="text-primary"> {{trans('discounts.No_discounts_yet')}}</h5>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card-box">
                <h4 class="mb-2 font-14"> {{trans('allowances.allowances')}} :</h4>
                <div class="col-md-12">
                    @if(!$employee->Discounts->count() == 0)
                        <div class="table-responsive">
                            <table class="table text-center  table-bordered table-sm ">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th> {{trans('allowances.allowance_name')}}</th>
                                    <th> {{trans('allowances.Employee_name')}}</th>
                                    <th> {{trans('allowances.category_name')}}</th>
                                    <th> {{trans('allowances.amount')}}</th>
                                    <th> {{trans('allowances.date')}}</th>
                                    <th> {{trans('allowances.Created_at')}}</th>
                                    <th> {{trans('allowances.Action')}}</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($employee->Allowances as $allowance)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td> {{ $allowance->name }}</td>
                                        <td>
                                            <a href="{{route('Employees.show', $allowance->Employee->id )}}"
                                               class="font-weight-bold">
                                                @if (app()->getLocale() == 'ar')
                                                    {{ $allowance->Employee->name_ar }}
                                                    <br>
                                                    {{ $allowance->Employee->phone }}
                                                @else
                                                    {{ $allowance->Employee->name_en }}
                                                    <br>
                                                    {{ $allowance->Employee->phone }}
                                                @endif
                                            </a>
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
                                        <td>
                                            {{--                                            @can('Allowances_show')--}}
                                            {{--                                                <a class="btn btn-secondary btn-xs " href="{{ route('Allowances.show',$allowance->id) }}">--}}
                                            {{--                                                    <i class="fas fa-eye"></i>--}}
                                            {{--                                                </a>--}}
                                            {{--                                            @endcan--}}

                                            @can('Allowances_edit')
                                                <a class="btn btn-success btn-xs "
                                                   href="{{route('Allowances.edit', $allowance->id)}}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endcan

                                            @can('Allowances_delete')
                                                <a href="" class="btn btn-primary btn-xs " data-toggle="modal"
                                                   data-target="#delete_Allowance{{$allowance->id}}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                                @include('backend.HR.Allowances.delete')
                                            @endcan
                                        </td>
                                        <td>{{ $allowance->created_at }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center">
                            <h5 class="text-primary"> {{trans('allowances.No_Allowances_yet')}}</h5>
                        </div>
                    @endif
                </div>
            </div>

        </div>

    </div>

@endsection

