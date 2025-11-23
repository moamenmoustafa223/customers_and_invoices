@extends('backend.layouts.master')

@section('page_title')
    {{trans('back.balances')}}
@endsection

@section('content')

    <div class="row">
        @can('balances_add')
            <div class="col-md-9 mb-1">
                <a class="btn btn-primary btn-sm" href="" data-bs-toggle="modal" data-bs-target="#add_balance">
                    <i class="mdi mdi-plus"></i>
                    {{trans('back.add_new_balance')}}
                </a>
                @include('backend.HR.Balances.add')
            </div>
        @endcan

        <div class="col-md-3 mb-1">
            <form action="{{ route('Balances.index') }}" method="GET" role="search">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="query" value="{{old('query', request()->input('query'))}}" placeholder="search..." id="query">
                    <button class="btn btn-primary btn-sm ml-1" type="submit" title="Search">
                        <span class="fas fa-search"></span>
                    </button>
                    <a href="{{ route('Balances.index') }}" class="btn btn-success btn-sm ml-1 " type="button" title="Reload">
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
                            <th> {{trans('back.Employee_name')}}</th>
                            <th> {{trans('back.balance_name')}}</th>
                            <th> {{trans('back.number_of_days')}}</th>
                            <th> {{trans('back.Created_at')}}</th>
                            <th> {{trans('back.Action')}}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($balances as $balance)
                            <tr>
                                <td>
                                    <a class="font-weight-bold" href="{{ route('Employees.show',$balance->Employee->id) }}">
                                        @if (app()->getLocale() == 'ar')
                                            {{ $balance->Employee->name_ar }}
                                        @else
                                            {{ $balance->Employee->name_en }}
                                        @endif
                                    </a>
                                </td>
                                <td>{{ $balance->name }}</td>
                                <td>{{ $balance->number }}</td>
                                <td>{{ $balance->created_at }}</td>
                                <td>

                                    @can('balances_edit')
                                        <a class="btn btn-success btn-xs" href="" data-bs-toggle="modal" data-bs-target="#edit_balance{{$balance->id}}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @include('backend.HR.Balances.edit')
                                    @endcan

                                    @can('balances_delete')
                                        <a href="" class="btn btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#delete_balance{{$balance->id}}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        @include('backend.HR.Balances.delete')
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

