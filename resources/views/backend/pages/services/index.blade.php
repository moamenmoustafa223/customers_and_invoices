@extends('backend.layouts.master')
@section('page_title')
    {{ trans('back.services') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-3">
            <form action="{{ route('services.index') }}" method="GET">
                <div class="row g-2 align-items-end">
                    <div class="col-md-6 d-flex justify-content-start">
                        @can('add_service')
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#add_service">
                                <i class="fas fa-plus"></i> {{ trans('back.add_service') }}
                            </button>
                        @endcan
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small mb-1">{{ trans('back.search') }}</label>
                        <input type="text" name="query" value="{{ request('query') }}" class="form-control form-control-sm"
                            placeholder="{{ trans('back.search') }}...">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold small mb-1">{{ trans('back.status') }}</label>
                        <select name="status" class="form-control form-control-sm">
                            <option value="">{{ trans('back.all') }}</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ trans('back.active') }}</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>{{ trans('back.inactive') }}</option>
                        </select>
                    </div>
                    <div class="col-md-1 d-flex align-items-end gap-1">
                        <button class="btn btn-primary btn-sm" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('services.index') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="table-responsive">
                    <table class="table table-bordered text-center table-sm">
                        <thead>
                            <tr style="background-color: rgb(232,245,252)">
                                <th width="25">#</th>
                                <th>{{ trans('back.name_ar') }}</th>
                                <th>{{ trans('back.name_en') }}</th>
                                <th>{{ trans('back.price') }}</th>
                                <th>{{ trans('back.status') }}</th>
                                <th width="150">{{ trans('back.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($services as $key => $service)
                                <tr>
                                    <td>{{ $key + $services->firstItem() }}</td>
                                    <td>{{ $service->name_ar }}</td>
                                    <td>{{ $service->name_en }}</td>
                                    <td>{{ number_format($service->price, 3) }}</td>
                                    <td>
                                        @if ($service->status == 'active')
                                            <span class="badge bg-success">{{ trans('back.active') }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ trans('back.inactive') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @can('show_service')
                                            <a href="{{ route('services.show', $service->id) }}"
                                                class="text-info" title="{{ trans('back.show') }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endcan
                                        @can('edit_service')
                                            <a href="{{ route('services.edit', $service->id) }}"
                                                class="text-primary" title="{{ trans('back.edit') }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan
                                        @can('delete_service')
                                            <a href="#" class="text-danger" data-bs-toggle="modal"
                                                data-bs-target="#delete_service{{ $service->id }}"
                                                title="{{ trans('back.delete') }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                                @include('backend.pages.services.delete')
                            @empty
                                <tr>
                                    <td colspan="6">{{ trans('back.no_data_available') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {!! $services->appends(Request::all())->links() !!}
            </div>
        </div>
    </div>

    @include('backend.pages.services.add')
@endsection
