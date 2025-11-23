@extends('Employee.layouts.master')

@section('page_title')
{{trans('back.dashboard')}}
@endsection

@section('title_page')
{{trans('back.dashboard')}}
@endsection

@section('css')
    <style>
        .card_custom{
            padding: 5px;
        }
    </style>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0 rounded-4 p-4 mb-2 bg-white">

                {{-- Header Section --}}
                <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset($employee->image) }}" alt="profile-image"
                             class="rounded-circle img-thumbnail me-3" style="width: 80px; height: 80px;">
                        <h4 class="mb-0 text-primary fw-bold">
                            <span class="text-dark">
                                {{ trans('employees.employee_name') }}:
                                </span>
                            @if (app()->getLocale() == 'ar')
                                {{ $employee->name_ar }}
                            @else
                                {{ $employee->name_en }}
                            @endif
                        </h4>
                    </div>
                </div>
            
                <hr>
            
                {{-- Basic Info --}}
                <div class="row g-3 text-dark small fw-semibold">
                    <div class="col-md-4">
                        <i class="fas fa-hashtag me-1 text-muted"></i>
                        {{ trans('employees.employee_no') }}:
                        <span class="text-secondary">{{ $employee->employee_no }}</span>
                    </div>
            
                    <div class="col-md-4">
                        <i class="fas fa-briefcase me-1 text-muted"></i>
                        {{ trans('employees.jop') }}:
                        <span class="text-secondary">
                            @if(app()->getLocale() == 'ar')
                                {{ $employee->jop_ar }}
                            @else
                                {{ $employee->jop_en }}
                            @endif
                        </span>
                    </div>
            
                    <div class="col-md-4">
                        <i class="fas fa-calendar-alt me-1 text-muted"></i>
                        {{ trans('employees.Join_date') }}:
                        <span class="text-secondary">{{ $employee->Join_date }}</span>
                    </div>
            
                    <div class="col-md-4">
                        <i class="fas fa-flag me-1 text-muted"></i>
                        {{ trans('employees.Nationality') }}:
                        <span class="text-secondary">{{ $employee->Nationality }}</span>
                    </div>
            
                    <div class="col-md-4">
                        <i class="fas fa-transgender me-1 text-muted"></i>
                        {{ trans('employees.gender') }}:
                        <span class="text-secondary">{{ $employee->gender ? trans('back.female') : trans('back.male') }}</span>
                    </div>
            
                    <div class="col-md-4">
                        <i class="fas fa-heart me-1 text-muted"></i>
                        {{ trans('employees.social_status') }}:
                        <span class="text-secondary">{{ $employee->social_status }}</span>
                    </div>
            
                    <div class="col-md-4">
                        <i class="fas fa-id-card me-1 text-muted"></i>
                        {{ trans('back.id_number') }}:
                        <span class="text-secondary">{{ $employee->id_number }}</span>
                    </div>
            
                    <div class="col-md-4">
                        <i class="fas fa-passport me-1 text-muted"></i>
                        {{ trans('back.passport_number') }}:
                        <span class="text-secondary">{{ $employee->passport_number }}</span>
                    </div>
            
                    <div class="col-md-4">
                        <i class="fas fa-map-marker-alt me-1 text-muted"></i>
                        {{ trans('employees.address') }}:
                        <span class="text-secondary">{{ $employee->address }}</span>
                    </div>
            
                    <div class="col-md-4">
                        <i class="fas fa-phone me-1 text-muted"></i>
                        {{ trans('employees.phone') }}:
                        <span class="text-secondary">{{ $employee->phone }}</span>
                    </div>
            
                    <div class="col-md-4">
                        <i class="fas fa-envelope me-1 text-muted"></i>
                        {{ trans('employees.email') }}:
                        <span class="text-secondary">{{ $employee->email }}</span>
                    </div>
            
                    <div class="col-md-4">
                        <i class="fas fa-university me-1 text-muted"></i>
                        {{ trans('employees.academic') }}:
                        <span class="text-secondary">{{ $employee->academic }}</span>
                    </div>
                </div>
            
                <hr>
            
                {{-- Leave Balances --}}
                <div class="row g-3 text-dark small fw-semibold">
                    <div class="col-md-4">
                        <i class="fas fa-calendar-check me-1 text-muted"></i>
                        {{ trans('back.Total_Leave_Balance') }}:
                        <span class="text-danger fw-bold">({{ $employee->Balances->sum('number') }})</span>
                    </div>
            
                    <div class="col-md-4">
                        <i class="fas fa-calendar-times me-1 text-muted"></i>
                        {{ trans('back.total_holidays') }}:
                        <span class="text-danger fw-bold">({{ $employee->Holidays->sum('number') }})</span>
                    </div>
            
                    <div class="col-md-4">
                        <i class="fas fa-balance-scale me-1 text-muted"></i>
                        {{ trans('back.The_rest') }}:
                        <span class="text-danger fw-bold">
                            ({{ $employee->Balances->sum('number') - $employee->Holidays->sum('number') }})
                        </span>
                    </div>
                </div>
            </div>
            
            
            <!--/ meta -->

            {{-- Contracts --}}
<div class="card shadow-sm border-0 rounded-4 p-4 mb-2 bg-white">
    <h4 class="mb-3 text-primary"><i class="fas fa-file-contract me-2"></i> {{ trans('contracts.Contracts') }}</h4>

    @if($employee->Contracts->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-sm table-striped table-hover align-middle text-center">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>{{ trans('contracts.contract_name') }}</th>
                    <th>{{ trans('contracts.Employee_name') }}</th>
                    <th>{{ trans('contracts.start_date') }}</th>
                    <th>{{ trans('contracts.end_date') }}</th>
                    <th>{{ trans('contracts.job_name') }}</th>
                    <th>{{ trans('contracts.Created_at') }}</th>
                    <th>{{ trans('contracts.Action') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($employee->Contracts as $i => $contract)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $contract->name }}</td>
                        <td>
                            {{ app()->getLocale() == 'ar' ? $contract->Employee->name_ar : $contract->Employee->name_en }}
                            <br>
                            <span class="text-muted small">{{ $contract->Employee->phone }}</span>
                        </td>
                        <td>{{ $contract->start_date }}</td>
                        <td>{{ $contract->end_date }}</td>
                        <td>{{ app()->getLocale() == 'ar' ? $contract->job_name_ar : $contract->job_name_en }}</td>
                        <td>{{ $contract->date }}</td>
                        <td>
                            <a href="{{ route('contract_number', $contract->contract_number) }}"
                               class="btn btn-outline-primary btn-sm" target="_blank">
                                <i class="fas fa-print"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center text-danger fw-semibold">{{ trans('contracts.No_contracts') }}</div>
    @endif
</div>

{{-- Salaries --}}
<div class="card shadow-sm border-0 rounded-4 p-4 mb-2 bg-white">
    <h4 class="mb-3 text-success"><i class="fas fa-money-check-alt me-2"></i> {{ trans('salaries.salaries') }}</h4>

    @if($employee->Salaries->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-sm table-striped table-hover align-middle text-center">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>{{ trans('salaries.salary_name') }}</th>
                    <th>{{ trans('salaries.Employee_name') }}</th>
                    <th>{{ trans('salaries.amount') }}</th>
                    <th>{{ trans('salaries.date') }}</th>
                    <th>{{ trans('salaries.Created_at') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($employee->Salaries as $i => $salary)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $salary->name }}</td>
                        <td>
                            {{ app()->getLocale() == 'ar' ? $salary->Employee->name_ar : $salary->Employee->name_en }}
                            <br>
                            <span class="text-dark small">{{ $salary->Employee->phone }}</span>
                        </td>
                        <td><span class="badge fs-14 bg-success text-white">{{ $salary->amount }}</span></td>
                        <td>{{ $salary->date }}</td>
                        <td>{{ $salary->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center text-danger fw-semibold">{{ trans('salaries.No_salaries_yet') }}</div>
    @endif
</div>

{{-- Holidays --}}
<div class="card shadow-sm border-0 rounded-4 p-4 mb-2 bg-white">
    <h4 class="mb-3 text-warning"><i class="fas fa-plane-departure me-2"></i> {{ trans('holidays.holidays') }}</h4>

    @if($employee->Holidays->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-sm table-striped table-hover align-middle text-center">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>{{ trans('holidays.holiday_name') }}</th>
                    <th>{{ trans('holidays.Employee_name') }}</th>
                    <th>{{ trans('holidays.category_name') }}</th>
                    <th>{{ trans('holidays.number_of_days') }}</th>
                    <th>{{ trans('holidays.Start_date') }}</th>
                    <th>{{ trans('holidays.End_date') }}</th>
                    <th>{{ trans('holidays.Created_at') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($employee->Holidays as $i => $holiday)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $holiday->name }}</td>
                        <td>
                            {{ app()->getLocale() == 'ar' ? $holiday->Employee->name_ar : $holiday->Employee->name_en }}
                            <br>
                            <span class="text-dark small">{{ $holiday->Employee->phone }}</span>
                        </td>
                        <td>{{ app()->getLocale() == 'ar' ? $holiday->CategoryHoliday->name : $holiday->CategoryHoliday->name_en }}</td>
                        <td><span class="badge bg-secondary fs-14">{{ $holiday->number }}</span></td>
                        <td>{{ $holiday->start_date }}</td>
                        <td>{{ $holiday->end_date }}</td>
                        <td>{{ $holiday->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center text-danger fw-semibold">{{ trans('holidays.No_holidays_yet') }}</div>
    @endif
</div>


<div class="card shadow-sm border-0 rounded-4 p-4 mb-2 bg-white">
    <h4 class="mb-3 text-info"><i class="fas fa-chalkboard-teacher me-2"></i> {{ trans('courses.Employees_Courses') }}</h4>

    @if($employee->employees_courses->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-sm table-striped table-hover text-center align-middle">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>{{ trans('courses.Course_name') }}</th>
                    <th>{{ trans('courses.Employee_name') }}</th>
                    <th>{{ trans('courses.Course_Start') }}</th>
                    <th>{{ trans('courses.Course_End') }}</th>
                    <th>{{ trans('courses.Created_at') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($employee->employees_courses as $i => $course)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $course->name }}</td>
                        <td>
                            {{ app()->getLocale() == 'ar' ? $course->employee->name_ar : $course->employee->name_en }}
                            <br>
                            <span class="text-dark small">{{ $course->employee->phone }}</span>
                        </td>
                        <td>{{ $course->start }}</td>
                        <td>{{ $course->end }}</td>
                        <td>{{ $course->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center text-danger fw-semibold">{{ trans('courses.No_courses_yet') }}</div>
    @endif
</div>


<div class="card shadow-sm border-0 rounded-4 p-4 mb-2 bg-white">
    <h4 class="mb-3 text-danger"><i class="fas fa-percentage me-2"></i> {{ trans('discounts.discounts') }}</h4>

    @if($employee->Discounts->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-sm table-striped table-hover text-center align-middle">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>{{ trans('discounts.discount_name') }}</th>
                    <th>{{ trans('discounts.Employee_name') }}</th>
                    <th>{{ trans('discounts.category_name') }}</th>
                    <th>{{ trans('discounts.amount') }}</th>
                    <th>{{ trans('discounts.date') }}</th>
                    <th>{{ trans('discounts.Created_at') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($employee->Discounts as $i => $discount)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $discount->name }}</td>
                        <td>
                            {{ app()->getLocale() == 'ar' ? $discount->Employee->name_ar : $discount->Employee->name_en }}
                            <br>
                            <span class="text-dark small">{{ $discount->Employee->phone }}</span>
                        </td>
                        <td>{{ app()->getLocale() == 'ar' ? $discount->CategoryDiscount->name : $discount->CategoryDiscount->name_en }}</td>
                        <td><span class="badge bg-danger-subtle text-danger fs-14">{{ $discount->amount }}</span></td>
                        <td>{{ $discount->date }}</td>
                        <td>{{ $discount->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center text-danger fw-semibold">{{ trans('discounts.No_discounts_yet') }}</div>
    @endif
</div>


<div class="card shadow-sm border-0 rounded-4 p-4 mb-2 bg-white">
    <h4 class="mb-3 text-success"><i class="fas fa-donate me-2"></i> {{ trans('allowances.allowances') }}</h4>

    @if($employee->Allowances->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-sm table-striped table-hover text-center align-middle">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>{{ trans('allowances.allowance_name') }}</th>
                    <th>{{ trans('allowances.Employee_name') }}</th>
                    <th>{{ trans('allowances.category_name') }}</th>
                    <th>{{ trans('allowances.amount') }}</th>
                    <th>{{ trans('allowances.date') }}</th>
                    <th>{{ trans('allowances.Created_at') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($employee->Allowances as $i => $allowance)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $allowance->name }}</td>
                        <td>
                            {{ app()->getLocale() == 'ar' ? $allowance->Employee->name_ar : $allowance->Employee->name_en }}
                            <br>
                            <span class="text-dark small">{{ $allowance->Employee->phone }}</span>
                        </td>
                        <td>{{ app()->getLocale() == 'ar' ? $allowance->CategoryAllowance->name : $allowance->CategoryAllowance->name_en }}</td>
                        <td><span class="badge bg-success-subtle text-success fs-14">{{ $allowance->amount }}</span></td>
                        <td>{{ $allowance->date }}</td>
                        <td>{{ $allowance->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center text-danger fw-semibold">{{ trans('allowances.No_Allowances_yet') }}</div>
    @endif
</div>


        </div>

    </div>


@endsection
