@extends('backend.layouts.master')

@section('page_title')
{{trans('back.guardian')}} : {{ $guardian->guardian_name }}
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0 rounded-4 p-4 mb-4 bg-white">
            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between">
                
                {{-- Title --}}
                <div>
                    <h4 class="mb-2 text-primary fw-bold">
                        {{ trans('back.guardian_name') }}: {{ $guardian->guardian_name }}
                    </h4>
                </div>

                {{-- Student Count Badge --}}
                <div class="mt-2 mt-md-0">
                    <span class="badge bg-primary p-2">
                        {{ trans('back.number_of_students') }}:
                        <strong>{{ $guardian->Students->count() }}</strong>
                    </span>
                </div>
            </div>

            <hr>

            {{-- Details Grid --}}
            <div class="row g-3 text-dark small fw-semibold">
                <div class="col-md-4">
                    <i class="fas fa-user me-1 text-muted"></i>
                    {{ trans('back.username') }}:
                    <span class="text-secondary">{{ $guardian->username }}</span>
                </div>

                <div class="col-md-4">
                    <i class="fas fa-id-card me-1 text-muted"></i>
                    {{ trans('back.id_number') }}:
                    <span class="text-secondary">{{ $guardian->id_number }}</span>
                </div>

                <div class="col-md-4">
                    <i class="fas fa-flag me-1 text-muted"></i>
                    {{ trans('back.nationality') }}:
                    <span class="text-secondary">{{ $guardian->nationality }}</span>
                </div>

                <div class="col-md-4">
                    <i class="fas fa-phone me-1 text-muted"></i>
                    {{ trans('back.phone') }}:
                    <span class="text-secondary">{{ $guardian->phone }}</span>
                </div>

                <div class="col-md-4">
                    <i class="fas fa-envelope me-1 text-muted"></i>
                    {{ trans('back.email') }}:
                    <span class="text-secondary">{{ $guardian->email }}</span>
                </div>

                <div class="col-md-4">
                    <i class="fas fa-map-marker-alt me-1 text-muted"></i>
                    {{ trans('back.address') }}:
                    <span class="text-secondary">{{ $guardian->address }}</span>
                </div>
            </div>
        </div>
    </div>
</div>



    <div class="row">

        <h5>{{trans('back.students')}} </h5>
        <div class="col-12">
            <div class="card-box">

                <div class="table-responsive">
                    <table  class="table text-center  table-bordered table-sm ">
                        <thead>
                        <tr style="background-color: rgb(232,245,252)">
                            <th width="25">#</th>
                            <th width="100"> {{trans('back.image')}}</th>
                            <th width="150"> {{trans('back.first_name')}}</th>
                            <th width="150"> {{trans('back.guardian_name')}}</th>
                            <th width="100"> {{trans('back.phone')}}</th>
                            <th width="100"> {{trans('back.username')}}</th>
                            <th width="100"> {{trans('back.id_number')}}</th>
                            <th width="100"> {{trans('back.birth_date')}}</th>
                            <th width="100"> {{trans('back.email')}}</th>
                            <th width="100"> {{trans('back.address')}}</th>
                            <th width="100"> {{trans('back.nationality')}}</th>
                            <th width="100"> {{trans('back.number_of_contracts')}}</th>
                            <th width="100"> {{trans('back.total_amount')}}</th>
                            <th width="150">  {{trans('back.Action')}}</th>
                            <th width="100"> {{trans('back.Created_at')}}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($students as $key => $student)
                            <tr>
                                <td>{{++$key}}</td>
                                <td> <img src="{{$student->image}}" width="40" alt=""></td>
                                <td>{{ $student->first_name }} {{ $student->father_name }} {{ $student->grandfather_name }}</td>
                                <td>{{ $student->Guardian->guardian_name }}</td>
                                <td><a href="https://wa.me/{{ $student->Guardian->phone }}">{{ $student->Guardian->phone }}</a></td>
                                <td>{{ $student->username }}</td>
                                <td>{{ $student->civil_id }}</td>
                                <td>{{ $student->birth_date }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->address }}</td>
                                <td>{{ $student->nationality }}</td>
                                <td>{{ $student->StudentsContracts->count() }}</td>
                                <td>{{ $student->StudentsContracts->sum('total_amount_with_tax') }}</td>
                                <td>
                                    @can('attachments')
                                        <a href="" class="text-secondary font-16 mr-1 " data-bs-toggle="modal" data-bs-target="#attachments{{$student->id}}">
                                            <i class="fas fa-paperclip"></i>
                                        </a>
                                        @include('backend.pages.attachments.add')
                                    @endcan

                                    @can('student_edit')
                                        <a class="text-secondary font-16 mr-1" href="{{route('students.show', $student->id)}}" >
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @endcan

                                    @can('student_edit')
                                    <a href="{{ route('students.edit', $student->id) }}" class="text-warning mx-1" title="{{ trans('back.edit') }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                      
                                    @endcan

                                    @can('student_delete')
                                        <a href="" class="text-secondary font-16 mr-1  " data-bs-toggle="modal" data-bs-target="#student_delete{{$student->id}}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        @include('backend.pages.students.delete')
                                    @endcan
                                </td>
                                <td>{{ $student->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>


@endsection

