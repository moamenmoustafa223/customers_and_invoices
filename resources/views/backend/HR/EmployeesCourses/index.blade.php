@extends('backend.layouts.master')

@section('page_title')
{{trans('courses.Employees_Courses')}}
@endsection


@section('content')

    <div class="row">
        @can('EmployeesCourses_add')
        <div class="col-md-9 mb-1">
            <a class="btn btn-primary btn-sm" href="" data-bs-toggle="modal" data-bs-target="#add_CategoryAllowances">
                <i class="mdi mdi-plus"></i>
                {{trans('courses.add_new_Course')}}
            </a>
            @include('backend.HR.EmployeesCourses.add')
        </div>
        @endcan

        <div class="col-md-3 mb-1">
            <form action="{{ route('EmployeesCourses.index') }}" method="GET" role="search">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="query" value="{{old('query', request()->input('query'))}}" placeholder="search..." id="query">
                    <button class="btn btn-primary btn-sm ml-1" type="submit" title="Search">
                        <span class="fas fa-search"></span>
                    </button>
                    <a href="{{ route('EmployeesCourses.index') }}" class="btn btn-success btn-sm ml-1 " type="button" title="Reload">
                        <span class="fas fa-sync-alt"></span>
                    </a>
                </div>
            </form>
        </div>

    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">

                <div class="table-responsive">
                    <table  class="table text-center  table-bordered table-sm ">
                        <thead>
                        <tr style="background-color: rgb(232,245,252)">
                            <th>#</th>
                            <th> {{trans('courses.Course_name')}}</th>
                            <th> {{trans('courses.Employee_name')}}</th>
                            <th> {{trans('courses.Course_Start')}}</th>
                            <th> {{trans('courses.Course_End')}}</th>
                            <th> {{trans('courses.Created_at')}}</th>
                            <th> {{trans('courses.Action')}}</th>
                        </tr>
                        </thead>

                        @php $i=1 @endphp

                        <tbody>
                        @foreach($employeesCourses as $employeesCourse)
                            <tr>
                                <td>{{$i++}}</td>
                                <td> {{ $employeesCourse->name }}</td>
                                <td>
                                    <a href="{{route('Employees.show', $employeesCourse->employee->id )}}">
                                        @if (app()->getLocale() == 'ar')
                                            {{ $employeesCourse->employee->name_ar }} <br> {{ $employeesCourse->employee->phone }}
                                        @else
                                            {{ $employeesCourse->employee->name_en }} <br> {{ $employeesCourse->employee->phone }}
                                        @endif
                                    </a>
                                </td>
                                <td> {{ $employeesCourse->start }}</td>
                                <td> {{ $employeesCourse->end }}</td>
                                <td>{{ $employeesCourse->created_at }}</td>
                                <td class="text-center">

                                    {{-- Edit --}}
                                    @can('EmployeesCourses_edit')
                                        <a href="#" class="text-success mx-1" title="{{ trans('back.edit') }}"
                                           data-bs-toggle="modal" data-bs-target="#edit_EmployeesCourses{{ $employeesCourse->id }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @include('backend.HR.EmployeesCourses.edit')
                                    @endcan
                                
                                    {{-- Delete --}}
                                    @can('EmployeesCourses_delete')
                                        <a href="#" class="text-danger mx-1" title="{{ trans('back.delete') }}"
                                           data-bs-toggle="modal" data-bs-target="#delete_EmployeesCourses{{ $employeesCourse->id }}">
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


            </div>
        </div>
    </div>

@endsection



@section('js')

    <script>

    </script>

@endsection


