@extends('backend.layouts.master')

@section('page_title')
    {{trans('contracts.Contracts')}}
@endsection


@section('content')

    <div class="row">
        <div class="col-md-9 mb-1">
            <a class="btn btn-primary btn-sm" href="{{route('Contracts.create')}}">
                <i class="mdi mdi-plus"></i>
                {{trans('contracts.add_new_contract')}}
            </a>
        </div>

        <div class="col-md-3 mb-1">
            <form action="{{ route('Contracts.index') }}" method="GET" role="search">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="query" value="{{old('query', request()->input('query'))}}" placeholder="search..." id="query">
                    <button class="btn btn-primary btn-sm ml-1" type="submit" title="Search">
                        <span class="fas fa-search"></span>
                    </button>
                    <a href="{{ route('Contracts.index') }}" class="btn btn-success btn-sm ml-1 " type="button" title="Reload">
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
                        @foreach($contracts as $key=> $contract)
                            <tr>
                                <td>{{$key+ $contracts->firstItem()}}</td>
                                <td> {{ $contract->name }}</td>
                                <td>
                                    <a href="{{route('Employees.show', $contract->Employee->id )}}" class="font-weight-bold">
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
                                <td class="text-center">

                                    {{-- Print/View --}}
                                    <a href="{{ route('contract_number', $contract->contract_number) }}" target="_blank" 
                                       class="text-primary mx-1" title="{{ trans('back.print') }}">
                                        <i class="fas fa-print"></i>
                                    </a>
                                
                                    {{-- Edit --}}
                                    <a href="{{ route('Contracts.edit', $contract->id) }}" 
                                       class="text-success mx-1" title="{{ trans('back.edit') }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                
                                    {{-- Delete --}}
                                    <a href="#" class="text-danger mx-1" title="{{ trans('back.delete') }}"
                                       data-bs-toggle="modal" data-bs-target="#delete_contract{{ $contract->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                    @include('backend.HR.Contracts.delete')
                                
                                </td>
                                
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {!! $contracts->appends(Request::all())->appends(Request::all())->links() !!}

            </div>
        </div>
    </div>

@endsection


@section('js')
    <script>
        $('#datatable').dataTable( {
            "paging": false,
            "info": false,
            // "searching": false,
        } );
    </script>
@endsection


