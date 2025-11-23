@extends('backend.layouts.master')

@section('page_title')
{{trans('back.IncomesSubCategories')}}
@endsection


@section('content')

    <div class="row">
        @can('IncomesSubCategory_add')
        <div class="col-md-9 mb-1">
            <a class="btn btn-primary btn-sm" href="" data-bs-toggle="modal" data-bs-target="#add_IncomesSubCategory">
                <i class="mdi mdi-plus"></i>
                {{trans('back.IncomesSubCategory_add')}}
            </a>
            @include('backend.pages.IncomesSubCategories.add')
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
                        @foreach($incomesSubCategories as $incomesSubCategory)
                            <tr>
                                <td>
                                    @if (app()->getLocale() == 'ar')
                                        {{ $incomesSubCategory->name_ar }}
                                    @else
                                        {{ $incomesSubCategory->name_en }}
                                    @endif
                                </td>
                                <td>
                                    @if (app()->getLocale() == 'ar')
                                        {{ $incomesSubCategory->IncomesCategory->name_ar ?? ''}}
                                    @else
                                        {{ $incomesSubCategory->IncomesCategory->name_en ?? ''}}
                                    @endif
                                </td>
                                <td>{{ $incomesSubCategory->created_at }}</td>
                                <td class="text-center">

                                    {{-- Edit --}}
                                    @can('IncomesSubCategory_edit')
                                        <a href="#" class="text-primary mx-1" title="{{ trans('back.edit') }}" data-bs-toggle="modal" data-bs-target="#edit_IncomesSubCategory{{ $incomesSubCategory->id }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @include('backend.pages.IncomesSubCategories.edit')
                                    @endcan
                                
                                    {{-- Delete --}}
                                    @can('IncomesSubCategory_delete')
                                        <a href="#" class="text-danger mx-1" title="{{ trans('back.delete') }}" data-bs-toggle="modal" data-bs-target="#delete_IncomesSubCategory{{ $incomesSubCategory->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        @include('backend.pages.IncomesSubCategories.delete')
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


