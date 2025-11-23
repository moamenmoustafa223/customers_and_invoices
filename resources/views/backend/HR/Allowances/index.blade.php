@extends('backend.layouts.master')

@section('page_title')
    {{trans('allowances.allowances')}}
@endsection


@section('content')

    <div class="row">
        @can('Allowances_add')
            <div class="col-md-9 mb-1">
                <a class="btn btn-primary btn-sm" href="{{route('Allowances.create')}}">
                    <i class="mdi mdi-plus"></i>
                    {{trans('allowances.add_new_allowance')}}
                </a>
            </div>
        @endcan

        <div class="col-md-3 mb-1">
            <form action="{{ route('Allowances.index') }}" method="GET" role="search">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="query"
                           value="{{old('query', request()->input('query'))}}" placeholder="search..." id="query">
                    <button class="btn btn-primary btn-sm ml-1" type="submit" title="Search">
                        <span class="fas fa-search"></span>
                    </button>
                    <a href="{{ route('Allowances.index') }}" class="btn btn-success btn-sm ml-1 " type="button"
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
                            <th> {{trans('allowances.allowance_name')}}</th>
                            <th> {{trans('allowances.Employee_name')}}</th>
                            <th> {{trans('allowances.category_name')}}</th>
                            <th> {{trans('allowances.amount')}}</th>
                            <th> {{trans('back.payment_methods')}}</th>
                            <th> {{trans('allowances.date')}}</th>
                            <th> {{trans('allowances.Created_at')}}</th>
                            <th> {{trans('allowances.Action')}}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($allowances as $key=> $allowance)
                            <tr>
                                <td>{{$key+ $allowances->firstItem()}}</td>
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
                                <td> @if(app()->getLocale() == 'ar' ) {{ $allowance->Payment_method->name_ar }} @else {{ $allowance->Payment_method->name_en }} @endif</td>
                                <td>{{ $allowance->date }}</td>
                                <td class="text-center">

                                    {{-- Edit --}}
                                    @can('Allowances_edit')
                                        <a href="{{ route('Allowances.edit', $allowance->id) }}" class="text-success mx-1" title="{{ trans('back.edit') }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan
                                
                                    {{-- Delete --}}
                                    @can('Allowances_delete')
                                        <a href="#" class="text-danger mx-1" title="{{ trans('back.delete') }}"
                                           data-bs-toggle="modal" data-bs-target="#delete_Allowance{{ $allowance->id }}">
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
                {!! $allowances->appends(Request::all())->links() !!}

            </div>
        </div>
    </div>

@endsection



@section('js')

    <script>

    </script>

@endsection


