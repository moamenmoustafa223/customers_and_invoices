@extends('backend.layouts.master')

@section('page_title')
{{trans('back.AssetsSubCategories')}}
@endsection


@section('content')

    <div class="row">
        @can('add_new_AssetsSubCategory')
        <div class="col-md-9 mb-1">
            <a class="btn btn-primary btn-sm" href="" data-bs-toggle="modal" data-bs-target="#add_AssetsSubCategory">
                <i class="mdi mdi-plus"></i>
                {{trans('back.add_new_AssetsSubCategory')}}
            </a>
            @include('backend.pages.AssetsSubCategories.add')
        </div>
        @endcan
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">

                <div class="table-responsive">
                    <table  class="table text-center  table-bordered table-sm ">
                        <thead>
                        <tr style="background-color: rgb(232,245,252)">
                            <th> {{trans('back.SubCategory')}}</th>
                            <th> {{trans('back.MainCategory')}}</th>
                            <th> {{trans('Expenses.Created_at')}}</th>
                            <th> {{trans('Expenses.Action')}}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($assetsSubCategories as $assetsSubCategory)
                            <tr>
                                <td>
                                    @if (app()->getLocale() == 'ar')
                                        {{ $assetsSubCategory->name_ar }}
                                    @else
                                        {{ $assetsSubCategory->name_en }}
                                    @endif
                                </td>
                                <td>
                                    @if (app()->getLocale() == 'ar')
                                        {{ $assetsSubCategory->AssetsCategory->name_ar ?? ''}}
                                    @else
                                        {{ $assetsSubCategory->AssetsCategory->name_en ?? ''}}
                                    @endif
                                </td>
                                <td>{{ $assetsSubCategory->created_at }}</td>
                                <td class="text-center">

                                    {{-- Edit --}}
                                    @can('edit_AssetsSubCategory')
                                        <a href="#" class="text-primary mx-1" title="{{ trans('back.edit') }}" data-bs-toggle="modal" data-bs-target="#edit_AssetsSubCategory{{ $assetsSubCategory->id }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @include('backend.pages.AssetsSubCategories.edit')
                                    @endcan
                                
                                    {{-- Delete --}}
                                    @can('delete_AssetsSubCategory')
                                        <a href="#" class="text-danger mx-1" title="{{ trans('back.delete') }}" data-bs-toggle="modal" data-bs-target="#delete_AssetsSubCategory{{ $assetsSubCategory->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        @include('backend.pages.AssetsSubCategories.delete')
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



@section('js')

    <script>

    </script>

@endsection


