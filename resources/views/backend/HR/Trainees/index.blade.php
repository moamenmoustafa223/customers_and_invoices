@extends('backend.layouts.master')

@section('page_title')
{{trans('trainees.trainees')}}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-9 mb-1">
            <a class="btn btn-primary btn-sm" href="{{route('Trainees.create')}}">
                <i class="mdi mdi-plus"></i>
                {{trans('trainees.add_new_trainee')}}
            </a>
        </div>

        <div class="col-md-3 mb-1">
            <form action="{{ route('Trainees.index') }}" method="GET" role="search">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="query" value="{{old('query', request()->input('query'))}}" placeholder="search..." id="query">
                    <button class="btn btn-primary btn-sm ml-1" type="submit" title="Search">
                        <span class="fas fa-search"></span>
                    </button>
                    <a href="{{ route('Trainees.index') }}" class="btn btn-success btn-sm ml-1 " type="button" title="Reload">
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
                            <th>{{trans('trainees.image')}}</th>
                            <th>{{trans('trainees.trainee_name_ar')}}</th>
                            <th>{{trans('trainees.trainee_name_en')}}</th>
                            <th>{{trans('trainees.jop_ar')}}</th>
                            <th>{{trans('trainees.jop_en')}}</th>
                            <th>{{trans('trainees.phone')}}</th>
                            <th>{{trans('trainees.email')}}</th>
                            <th>{{trans('trainees.Created_at')}}</th>
                            <th>{{trans('trainees.Action')}}</th>
                           </tr>
                        </thead>

                        <tbody>
                        @foreach($trainees as $key=> $trainee)
                            <tr>
                                <td>{{$key+ $trainees->firstItem()}}</td>
                                <td>
                                    @if(isset($trainee->image))
                                        <img src="{{asset($trainee->image)}}" alt="{{$trainee->name_ar}}" width="40">
                                    @else
                                        <img src="{{asset('images/no_image.png')}}" alt="{{$trainee->name_ar}}" width="40">
                                    @endif
                                </td>
                                <td> {{ $trainee->name_ar }}</td>
                                <td> {{ $trainee->name_en }}</td>
                                <td> {{ $trainee->jop_ar }}</td>
                                <td> {{ $trainee->jop_en }}</td>
                                <td> <a href="https://wa.me/{{ $trainee->phone }}" target="_blank">{{ $trainee->phone }}</a> </td>
                                <td> {{ $trainee->email }}</td>
                                <td>{{ $trainee->created_at }}</td>
                                <td class="text-center">

                                    {{-- View --}}
                                    <a href="{{ route('Trainees.show', $trainee->id) }}" class="text-primary mx-1" title="{{ trans('back.view') }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                
                                    {{-- Edit --}}
                                    <a href="{{ route('Trainees.edit', $trainee->id) }}" class="text-success mx-1" title="{{ trans('back.edit') }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                
                                    {{-- Delete --}}
                                    <a href="#" class="text-danger mx-1" title="{{ trans('back.delete') }}"
                                       data-bs-toggle="modal" data-bs-target="#delete_trainee{{ $trainee->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                    @include('backend.HR.Trainees.delete')
                                
                                </td>
                                
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {!! $trainees->appends(Request::all())->links() !!}

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


