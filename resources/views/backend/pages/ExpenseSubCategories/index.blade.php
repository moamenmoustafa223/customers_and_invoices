@extends('backend.layouts.master')

@section('page_title')
{{trans('back.ExpenseSubCategories')}}
@endsection


@section('content')

    <div class="row">
        @can('ExpenseSubCategory_add')
        <div class="col-md-9 mb-1">
            <a class="btn btn-primary btn-sm" href="" data-bs-toggle="modal" data-bs-target="#add_ExpenseSubCategory">
                <i class="mdi mdi-plus"></i>
                {{trans('back.ExpenseSubCategory_add')}}
            </a>
            @include('backend.pages.ExpenseSubCategories.add')
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
                        @foreach($expenseSubCategories as $expenseSubCategory)
                            <tr>
                                <td>
                                    @if (app()->getLocale() == 'ar')
                                        {{ $expenseSubCategory->name_ar }}
                                    @else
                                        {{ $expenseSubCategory->name_en }}
                                    @endif
                                </td>
                                <td>
                                    @if (app()->getLocale() == 'ar')
                                        {{ $expenseSubCategory->ExpenseCategory->name_ar ?? ''}}
                                    @else
                                        {{ $expenseSubCategory->ExpenseCategory->name_en ?? ''}}
                                    @endif
                                </td>
                                <td>{{ $expenseSubCategory->created_at }}</td>
                                <td class="text-center">

                                    {{-- Edit --}}
                                    @can('ExpenseCategory_edit')
                                        <a href="#" class="text-primary mx-1" title="{{ trans('back.edit') }}" data-bs-toggle="modal" data-bs-target="#edit_ExpenseSubCategory{{ $expenseSubCategory->id }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @include('backend.pages.ExpenseSubCategories.edit')
                                    @endcan
                                
                                    {{-- Delete --}}
                                    @can('ExpenseCategory_delete')
                                        <a href="#" class="text-danger mx-1" title="{{ trans('back.delete') }}" data-bs-toggle="modal" data-bs-target="#delete_ExpenseSubCategory{{ $expenseSubCategory->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        @include('backend.pages.ExpenseSubCategories.delete')
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


