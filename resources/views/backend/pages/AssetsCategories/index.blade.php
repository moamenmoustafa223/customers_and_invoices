@extends('backend.layouts.master')

@section('page_title')
{{trans('back.AssetsCategories')}}
@endsection


@section('content')

    <div class="row">
        @can('add_new_AssetsCategory')
        <div class="col-md-9 mb-1">
            <a class="btn btn-primary btn-sm" href="" data-bs-toggle="modal" data-bs-target="#add_expenseCategory">
                <i class="mdi mdi-plus"></i>
                {{trans('back.add_new_AssetsCategory')}}
            </a>
            @include('backend.pages.AssetsCategories.add')
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
                            <th> {{trans('Expenses.Name_Category')}}</th>
                            <th> {{trans('Expenses.Created_at')}}</th>
                            <th> {{trans('Expenses.Action')}}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($assetsCategories as $assetsCategory)
                            <tr>
                                <td>
                                    @if (app()->getLocale() == 'ar')
                                        {{ $assetsCategory->name_ar }}
                                    @else
                                        {{ $assetsCategory->name_en }}
                                    @endif
                                </td>
                                <td>{{ $assetsCategory->created_at }}</td>
                                <td class="text-center">

                                    {{-- Edit --}}
                                    @can('edit_AssetsCategory')
                                        <a href="#" class="text-primary mx-1" title="{{ trans('back.edit') }}" data-bs-toggle="modal" data-bs-target="#edit_AssetsCategory{{ $assetsCategory->id }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @include('backend.pages.AssetsCategories.edit')
                                    @endcan
                                
                                    {{-- Delete --}}
                                    @can('delete_AssetsCategory')
                                        <a href="#" class="text-danger mx-1" title="{{ trans('back.delete') }}" data-bs-toggle="modal" data-bs-target="#delete_AssetsCategory{{ $assetsCategory->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        @include('backend.pages.AssetsCategories.delete')
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


