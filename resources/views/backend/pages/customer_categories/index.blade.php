@extends('backend.layouts.master')
@section('page_title')
    {{ trans('back.customer_categories') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-3">
            <form action="{{ route('customer_categories.index') }}" method="GET">
                <div class="row g-2 align-items-end">
                    <div class="col-md-8 d-flex justify-content-start align-items-end">
                        @can('add_customer_category')
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#add_customer_category">
                                <i class="fas fa-plus"></i> {{ trans('back.add_customer_category') }}
                            </button>
                        @endcan
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small mb-1">{{ trans('back.search') }}</label>
                        <input type="text" name="query" value="{{ request('query') }}" class="form-control form-control-sm"
                            placeholder="{{ trans('back.search') }}...">
                    </div>
                    <div class="col-md-1 d-flex align-items-end gap-1">
                        <button class="btn btn-primary btn-sm" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('customer_categories.index') }}" class="btn btn-success btn-sm">
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
                                <th>{{ trans('back.status') }}</th>
                                <th>{{ trans('back.customers') }}</th>
                                <th width="150">{{ trans('back.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customerCategories as $key => $category)
                                <tr>
                                    <td>{{ $key + $customerCategories->firstItem() }}</td>
                                    <td>{{ $category->name_ar }}</td>
                                    <td>{{ $category->name_en }}</td>
                                    <td>
                                        @if ($category->status == 'active')
                                            <span class="badge bg-success">{{ trans('back.active') }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ trans('back.inactive') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $category->customers_count }}</td>
                                    <td>
                                        @can('show_customer_category')
                                            <a href="{{ route('customer_categories.show', $category->id) }}"
                                                class="text-info" title="{{ trans('back.show') }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endcan
                                        @can('edit_customer_category')
                                            <a href="{{ route('customer_categories.edit', $category->id) }}"
                                                class="text-primary" title="{{ trans('back.edit') }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan
                                        @can('delete_customer_category')
                                            <a href="#" class="text-danger" data-bs-toggle="modal"
                                                data-bs-target="#delete_customer_category{{ $category->id }}"
                                                title="{{ trans('back.delete') }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                                @include('backend.pages.customer_categories.delete')
                            @empty
                                <tr>
                                    <td colspan="6">{{ trans('back.no_data_available') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {!! $customerCategories->appends(Request::all())->links() !!}
            </div>
        </div>
    </div>

    @include('backend.pages.customer_categories.add')
@endsection
