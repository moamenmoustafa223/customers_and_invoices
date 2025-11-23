@extends('backend.layouts.master')

@section('page_title')
    {{trans('trainees.Page_of_trainee')}} :
    {{$trainee->name_ar}}
@endsection


@section('content')

    <div class="row">
        <div class="col-md-9 mb-1">
            <a class="btn btn-primary btn-sm" href="{{route('Trainees.index')}}">
                <i class="fas fa-arrow-right me-1"></i>
                {{trans('trainees.Back')}}
            </a>
        </div>
    </div>


    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm rounded border-0">
                <div class="card-body d-flex flex-column flex-md-row align-items-center gap-4 p-4">
                    {{-- Profile Image --}}
                    <div class="text-center">
                        <img src="{{ asset($trainee->image) }}"
                             alt="Trainee Image"
                             class="rounded-circle border shadow-sm"
                             style="width: 120px; height: 120px; object-fit: cover;">
                    </div>
    
                    {{-- Profile Info --}}
                    <div class="flex-fill">
                        {{-- Name --}}
                        <div class="mb-3">
                            <h5 class="fw-bold mb-2">
                                <span class="text-primary">{{ trans('trainees.trainee_name_ar') }}:</span>
                                <span class="text-dark">{{ $trainee->name_ar }}</span>
                            </h5>
                            <h6 class="fw-bold">
                                <span class="text-primary">{{ trans('trainees.trainee_name_en') }}:</span>
                                <span class="text-dark">{{ $trainee->name_en }}</span>
                            </h6>
                        </div>
                    
                        {{-- Job Titles --}}
                        <div class="mb-3">
                            <p class="mb-1">
                                <span class="fw-semibold text-primary">{{ trans('trainees.jop_ar') }}:</span>
                                <span class="text-muted">{{ $trainee->jop_ar }}</span>
                            </p>
                            <p>
                                <span class="fw-semibold text-primary">{{ trans('trainees.jop_en') }}:</span>
                                <span class="text-muted">{{ $trainee->jop_en }}</span>
                            </p>
                        </div>
                    
                        {{-- Contact & Nationality Info --}}
                        <div class="row text-muted small g-2">
                            <div class="col-md-6">
                                <span class="fw-semibold">{{ trans('trainees.Nationality') }}:</span> {{ $trainee->Nationality }}
                            </div>
                            <div class="col-md-6">
                                <span class="fw-semibold">{{ trans('trainees.phone') }}:</span> {{ $trainee->phone }}
                            </div>
                            <div class="col-md-6">
                                <span class="fw-semibold">{{ trans('trainees.email') }}:</span> {{ $trainee->email }}
                            </div>
                            <div class="col-md-6">
                                <span class="fw-semibold">{{ trans('trainees.id_number') }}:</span> {{ $trainee->id_number }}
                            </div>
                            <div class="col-12">
                                <span class="fw-semibold">{{ trans('trainees.address') }}:</span> {{ $trainee->address }}
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    

@endsection


@section('js')
    <script>

    </script>
@endsection


