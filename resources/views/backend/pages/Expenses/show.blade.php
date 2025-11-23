@extends('backend.layouts.master')

@section('page_title')
موظفين فرع
    {{$branch->name_ar}}
@endsection


@section('content')

    <div class="row">
        <div class="col-md-3 mb-1">
            <form action="{{ route('Employees.index') }}" method="GET" role="search">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="query" value="{{old('query', request()->input('query'))}}" placeholder="search..." id="query">
                    <button class="btn btn-secondary btn-sm ml-1" type="submit" title="Search">
                        <span class="fas fa-search"></span>
                    </button>
                    <a href="{{ route('Employees.index') }}" class="btn btn-secondary btn-sm ml-1 " type="button" title="Reload">
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
                        <tr>
                            <th>صورة</th>
                            <th> اسم الموظف عربي</th>
                            <th> اسم الموظف انجلزي</th>
                            <th>المسمى الوظيفي </th>
                            <th>الفرع </th>
                            <th>القسم </th>
                            <th>هاتف الموظف </th>
                            <th>الإيميل </th>
                            <th>تاريخ الإنشاء</th>
                            <th> إجراء</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($branch->employees as $employee)
                            <tr>
                                <td>
                                    @if(isset($employee->image))
                                        <img src="{{asset($employee->image)}}" alt="{{$employee->name}}" width="40">
                                    @else
                                        <img src="{{asset('images/no_image.png')}}" alt="{{$employee->name}}" width="40">
                                    @endif
                                </td>
                                <td> {{ $employee->name }}</td>
                                <td> {{ $employee->name_en }}</td>
                                <td> {{ $employee->jop }}</td>
                                <td> {{ $employee->Branch->name_ar }}</td>
                                <td> {{ $employee->CategoryEmployees->name }}</td>
                                <td> <a href="https://wa.me/{{ $employee->phone }}" target="_blank">{{ $employee->phone }}</a> </td>
                                <td> {{ $employee->email }}</td>
                                <td>{{ $employee->created_at }}</td>
                                <td>
                                    <a class="btn btn-secondary btn-xs ml-1" href="{{ route('Employees.show',$employee->id) }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a class="btn btn-secondary btn-xs ml-1" href="{{ route('Employees.edit',$employee->id) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="" class="btn btn-secondary btn-xs ml-1" data-bs-toggle="modal" data-bs-target="#delete_Employees{{$employee->id}}">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                    @include('backend.pages.Employees.delete')
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


