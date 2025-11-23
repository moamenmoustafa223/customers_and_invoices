@extends('backend.layouts.master')

@section('page_title')
    {{trans('salaries.salaries')}}
@endsection

@section('content')

    <div class="row">
        @can('Salaries_add')
            <div class="col-md-9 mb-1">
                <a class="btn btn-primary btn-sm" href="{{route('Salaries.create')}}">
                    <i class="mdi mdi-plus"></i>
                    {{trans('salaries.add_new_salary')}}
                </a>
                <a class="btn btn-info btn-sm" href="{{ route('Salaries.create_multiple') }}">
                    <i class="fas fa-users me-1"></i>
                    {{ trans('salaries.add_salary_multiple') }}
                </a>
                
            </div>
        @endcan

        <div class="col-md-3 mb-1">
            <form action="{{ route('Salaries.index') }}" method="GET" role="search">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="query"
                           value="{{old('query', request()->input('query'))}}" placeholder="search..." id="query">
                    <button class="btn btn-primary btn-sm ml-1" type="submit" title="Search">
                        <span class="fas fa-search"></span>
                    </button>
                    <a href="{{ route('Salaries.index') }}" class="btn btn-success btn-sm ml-1 " type="button"
                       title="Reload">
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
                    <table class="table text-center  table-bordered table-sm ">
                        <thead>
                        <tr style="background-color: rgb(232,245,252)">
                            <th>#</th>
                            <th> {{trans('salaries.salary_name')}}</th>
                            <th> {{trans('salaries.Employee_name')}}</th>
                            <th> {{trans('salaries.amount')}}</th>
                            <th> {{trans('back.payment_methods')}}</th>
                            <th> {{trans('salaries.date')}}</th>
                            <th> {{trans('salaries.Created_at')}}</th>
                            <th> {{trans('salaries.Action')}}</th>
                        </tr>
                        </thead>


                        <tbody>
                        @foreach($salaries as $key=> $salary)
                            <tr>
                                <td>{{$key+ $salaries->firstItem()}}</td>
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
                                <td> @if(app()->getLocale() == 'ar' ) {{ $salary->Payment_method->name_ar }} @else {{ $salary->Payment_method->name_en }} @endif</td>
                                <td>{{ $salary->date }}</td>
                                <td>{{ $salary->created_at }}</td>
                                <td class="text-center">

                                    {{-- Edit --}}
                                    @can('Salaries_edit')
                                        <a href="{{ route('Salaries.edit', $salary->id) }}" 
                                           class="text-success mx-1" title="{{ trans('back.edit') }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan
                                
                                    {{-- Delete --}}
                                    @can('Salaries_delete')
                                        <a href="#" class="text-danger mx-1" title="{{ trans('back.delete') }}"
                                           data-bs-toggle="modal" data-bs-target="#delete_salary{{ $salary->id }}">
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

                {!! $salaries->appends(Request::all())->links() !!}

            </div>
        </div>
    </div>

@endsection



@section('js')

    <script>

    </script>

@endsection


