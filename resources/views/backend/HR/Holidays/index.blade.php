@extends('backend.layouts.master')

@section('page_title')
    {{trans('holidays.holidays')}}
@endsection


@section('content')

    <div class="row">
        <div class="col-md-9 mb-1">
            <a class="btn btn-primary btn-sm" href="{{route('Holidays.create')}}">
                <i class="mdi mdi-plus"></i>
                {{trans('holidays.add_new_holiday')}}
            </a>
        </div>

        <div class="col-md-3 mb-1">
            <form action="{{ route('Holidays.index') }}" method="GET" role="search">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="query"
                           value="{{old('query', request()->input('query'))}}" placeholder="search..." id="query">
                    <button class="btn btn-primary btn-sm ml-1" type="submit" title="Search">
                        <span class="fas fa-search"></span>
                    </button>
                    <a href="{{ route('Holidays.index') }}" class="btn btn-success btn-sm ml-1 " type="button"
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

                        @php $i=1 @endphp

                        <tbody>
                        @foreach($holidays as $key => $holiday)
                            <tr>
                                <td>{{$key+ $holidays->firstItem()}}</td>
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
                                <td class="text-center">

                                    {{-- Edit --}}
                                    <a href="{{ route('Holidays.edit', $holiday->id) }}" 
                                       class="text-success mx-1" title="{{ trans('back.edit') }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                
                                    {{-- Delete --}}
                                    <a href="#" class="text-danger mx-1" title="{{ trans('back.delete') }}"
                                       data-bs-toggle="modal" data-bs-target="#delete_Holidays{{ $holiday->id }}">
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

                {!! $holidays->appends(Request::all())->links() !!}

            </div>
        </div>
    </div>

@endsection



@section('js')

    <script>

    </script>

@endsection


