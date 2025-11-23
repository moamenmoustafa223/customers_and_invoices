@extends('backend.layouts.master')

@section('page_title')
{{trans('cat_discounts.Category_Discounts')}}
@endsection


@section('content')

    <div class="row">
        @can('CategoryDiscounts_add')
        <div class="col-md-9 mb-1">
            <a class="btn btn-primary btn-sm" href="" data-bs-toggle="modal" data-bs-target="#add_CategoryDiscounts">
                <i class="mdi mdi-plus"></i>
                {{trans('cat_discounts.add_new_category')}}
            </a>
            @include('backend.HR.CategoryDiscounts.add')
        </div>
        @endcan

        <div class="col-md-3 mb-1">
            <form action="{{ route('CategoryDiscounts.index') }}" method="GET" role="search">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="query" value="{{old('query', request()->input('query'))}}" placeholder="search..." id="query">
                    <button class="btn btn-primary btn-sm ml-1" type="submit" title="Search">
                        <span class="fas fa-search"></span>
                    </button>
                    <a href="{{ route('CategoryDiscounts.index') }}" class="btn btn-success btn-sm ml-1 " type="button" title="Reload">
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
                            <th> {{trans('cat_discounts.category_name')}}</th>
                            <th> {{trans('cat_discounts.Created_at')}}</th>
                            <th> {{trans('cat_discounts.Action')}}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($CategoriesDiscounts as $CategoryDiscounts)
                            <tr>
                                <td>
                                    @if (app()->getLocale() == 'ar')
                                        {{ $CategoryDiscounts->name }}
                                    @else
                                        {{ $CategoryDiscounts->name_en }}
                                    @endif
                                </td>
                                <td>{{ $CategoryDiscounts->created_at }}</td>
                                <td class="text-center">

                                    {{-- Edit --}}
                                    @can('CategoryDiscounts_edit')
                                        <a href="#" class="text-success mx-1" title="{{ trans('back.edit') }}"
                                           data-bs-toggle="modal" data-bs-target="#edit_CategoryDiscounts{{ $CategoryDiscounts->id }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @include('backend.HR.CategoryDiscounts.edit')
                                    @endcan
                                
                                    {{-- Delete --}}
                                    @can('CategoryDiscounts_delete')
                                        <a href="#" class="text-danger mx-1" title="{{ trans('back.delete') }}"
                                           data-bs-toggle="modal" data-bs-target="#delete_CategoryDiscounts{{ $CategoryDiscounts->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        @include('backend.HR.CategoryDiscounts.delete')
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


