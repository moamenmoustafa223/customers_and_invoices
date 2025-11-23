@extends('backend.layouts.master')

@section('page_title')
{{trans('Expenses.Expense_Categories')}}
@endsection


@section('content')

    <div class="row">
        @can('ExpenseCategory_add')
        <div class="col-md-9 mb-1">
            <a class="btn btn-primary btn-sm" href="" data-bs-toggle="modal" data-bs-target="#add_expenseCategory">
                <i class="mdi mdi-plus"></i>
                {{trans('Expenses.Add_New_Expense_Category')}}
            </a>
            @include('backend.pages.ExpenseCategories.add')
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
                        @foreach($expenseCategories as $expenseCategory)
                            <tr>
                                <td>
                                    @if (app()->getLocale() == 'ar')
                                        {{ $expenseCategory->name_ar }}
                                    @else
                                        {{ $expenseCategory->name_en }}
                                    @endif
                                </td>
                                <td>{{ $expenseCategory->created_at }}</td>
                                <td class="text-center">

                                    {{-- Edit --}}
                                    @can('ExpenseCategory_edit')
                                        <a href="#" class="text-primary mx-1" title="{{ trans('back.edit') }}" data-bs-toggle="modal" data-bs-target="#edit_expenseCategory{{ $expenseCategory->id }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @include('backend.pages.ExpenseCategories.edit')
                                    @endcan
                                
                                    {{-- Delete --}}
                                    @can('ExpenseCategory_delete')
                                        <a href="#" class="text-danger mx-1" title="{{ trans('back.delete') }}" data-bs-toggle="modal" data-bs-target="#delete_expenseCategory{{ $expenseCategory->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        @include('backend.pages.ExpenseCategories.delete')
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


