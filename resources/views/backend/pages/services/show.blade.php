@extends('backend.layouts.master')
@section('page_title')
    {{ trans('back.show_service') }}
@endsection

@section('content')
    <div>
        <a class="btn btn-primary btn-sm mb-1" href="{{ route('services.index') }}">
            <i class="fas fa-undo"></i>
            {{ trans('back.Turn_back') }}
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center font-weight-bold mb-3">
                            <h4>{{ trans('back.service') }}</h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <td width="200"><strong>{{ trans('back.name_ar') }}:</strong></td>
                                <td>{{ $service->name_ar }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ trans('back.name_en') }}:</strong></td>
                                <td>{{ $service->name_en }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ trans('back.price') }}:</strong></td>
                                <td>{{ number_format($service->price, 3) }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ trans('back.status') }}:</strong></td>
                                <td>
                                    @if ($service->status == 'active')
                                        <span class="badge bg-success">{{ trans('back.active') }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ trans('back.inactive') }}</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <td width="200"><strong>{{ trans('back.description_ar') }}:</strong></td>
                                <td>{{ $service->description_ar }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ trans('back.description_en') }}:</strong></td>
                                <td>{{ $service->description_en }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
