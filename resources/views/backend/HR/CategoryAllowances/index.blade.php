@extends('backend.layouts.master')

@section('page_title')
    {{ trans('cat_allowances.Category_Allowances') }}
@endsection

@section('content')

<div class="row">
    @can('CategoryAllowances_add')
        <div class="col-md-9 mb-1">
            <a class="btn btn-primary btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#add_CategoryAllowances">
                <i class="mdi mdi-plus"></i> {{ trans('cat_allowances.add_new_category') }}
            </a>
            @include('backend.HR.CategoryAllowances.add')
        </div>
    @endcan

    <div class="col-md-3 mb-1">
        <form action="{{ route('CategoryAllowances.index') }}" method="GET" role="search">
            <div class="input-group">
                <input type="text" class="form-control form-control-sm" name="query"
                       value="{{ old('query', request()->input('query')) }}" placeholder="{{ trans('back.search') }}" id="query">
                <button class="btn btn-primary btn-sm ml-1" type="submit" title="Search">
                    <span class="fas fa-search"></span>
                </button>
                <a href="{{ route('CategoryAllowances.index') }}" class="btn btn-success btn-sm ml-1" title="Reload">
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
                <table class="table text-center table-bordered table-sm">
                    <thead>
                        <tr style="background-color: rgb(232,245,252)">
                            <th>{{ trans('cat_allowances.category_name') }}</th>
                            <th>{{ trans('cat_allowances.Created_at') }}</th>
                            <th>{{ trans('cat_allowances.Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categoriesAllowances as $categoryAllowance)
                            <tr>
                                <td>
                                    {{ app()->getLocale() == 'ar' ? $categoryAllowance->name : $categoryAllowance->name_en }}
                                </td>
                                <td>{{ $categoryAllowance->created_at }}</td>
                                <td class="text-center">
                                    @can('CategoryAllowances_edit')
                                        <a href="#" class="text-success mx-1" title="{{ trans('back.edit') }}"
                                           data-bs-toggle="modal" data-bs-target="#edit_CategoryAllowances{{ $categoryAllowance->id }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @include('backend.HR.CategoryAllowances.edit', ['categoryAllowance' => $categoryAllowance])
                                    @endcan

                                    @can('CategoryAllowances_delete')
                                        <a href="#" class="text-danger mx-1" title="{{ trans('back.delete') }}"
                                           data-bs-toggle="modal" data-bs-target="#delete_CategoryAllowances{{ $categoryAllowance->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        @include('backend.HR.CategoryAllowances.delete', ['categoryAllowance' => $categoryAllowance])
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
