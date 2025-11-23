@extends('backend.layouts.master')
@section('page_title')
    {{ trans('back.customers') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-3">
            <form action="{{ route('customers.index') }}" method="GET">
                <div class="row g-2 align-items-end">
                    <div class="col-md-4 d-flex justify-content-start align-items-end">
                        @can('add_customer')
                            <a href="{{ route('customers.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> {{ trans('back.add_customer') }}
                            </a>
                        @endcan
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small mb-1">{{ trans('back.search') }}</label>
                        <input type="text" name="query" value="{{ request('query') }}" class="form-control form-control-sm"
                            placeholder="{{ trans('back.search') }}...">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold small mb-1">{{ trans('back.customer_category') }}</label>
                        <select name="customer_category_id" class="form-select form-select-sm">
                            <option value="">{{ trans('back.all') }}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('customer_category_id') == $category->id ? 'selected' : '' }}>
                                    {{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold small mb-1">{{ trans('back.status') }}</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="">{{ trans('back.all') }}</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ trans('back.active') }}</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>{{ trans('back.inactive') }}</option>
                        </select>
                    </div>
                    <div class="col-md-1 d-flex align-items-end gap-1">
                        <button class="btn btn-primary btn-sm" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('customers.index') }}" class="btn btn-success btn-sm">
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
                                <th>{{ trans('back.customer_name') }}</th>
                                <th>{{ trans('back.phone') }}</th>
                                <th>{{ trans('back.email') }}</th>
                                <th>{{ trans('back.customer_category') }}</th>
                                <th>{{ trans('back.status') }}</th>
                                <th width="150">{{ trans('back.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $key => $customer)
                                <tr>
                                    <td>{{ $key + $customers->firstItem() }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>
                                        {{ app()->getLocale() == 'ar' ? $customer->category->name_ar : $customer->category->name_en }}
                                    </td>
                                    <td>
                                        @if ($customer->status == 'active')
                                            <span class="badge bg-success">{{ trans('back.active') }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ trans('back.inactive') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @can('show_customer')
                                            <a href="{{ route('customers.show', $customer->id) }}" class="text-info"
                                                title="{{ trans('back.show') }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endcan
                                        @can('edit_customer')
                                            <a href="{{ route('customers.edit', $customer->id) }}" class="text-primary"
                                                title="{{ trans('back.edit') }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan
                                        @can('delete_customer')
                                            <a href="#" class="text-danger" data-bs-toggle="modal"
                                                data-bs-target="#delete_customer{{ $customer->id }}"
                                                title="{{ trans('back.delete') }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                                @include('backend.pages.customers.delete')
                            @empty
                                <tr>
                                    <td colspan="7">{{ trans('back.no_data_available') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {!! $customers->appends(Request::all())->links() !!}
            </div>
        </div>
    </div>
@endsection
