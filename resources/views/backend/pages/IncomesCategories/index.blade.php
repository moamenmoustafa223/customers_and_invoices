@extends('backend.layouts.master')

@section('page_title')
{{trans('Incomes.Income_Categories')}}
@endsection


@section('content')

    <div class="row">
        @can('IncomesCategory_add')
        <div class="col-md-9 mb-1">
            <a class="btn btn-primary btn-sm" href="" data-bs-toggle="modal" data-bs-target="#add_incomesCategory">
                <i class="mdi mdi-plus"></i>
                {{trans('Incomes.Add_New_Income_Category')}}
            </a>
            @include('backend.pages.IncomesCategories.add')
        </div>
        @endcan
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">


                <div class="table-responsive">
                    <table  class="table text-center  table-striped  table-bordered table-sm ">
                        <thead>
                        <tr style="background-color: rgb(232,245,252)">
                            <th> {{trans('Incomes.Name_Category')}}</th>
                            <th> {{trans('Incomes.Created_at')}}</th>
                            <th> {{trans('Incomes.Action')}}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($incomesCategories as $incomesCategory)
                            <tr>
                                <td>
                                    @if (app()->getLocale() == 'ar')
                                        {{ $incomesCategory->name_ar }}
                                    @else
                                        {{ $incomesCategory->name_en }}
                                    @endif
                                </td>
                                <td>{{ $incomesCategory->created_at }}</td>
                                <td class="text-center">

                                    {{-- Edit --}}
                                    @can('ExpenseCategory_edit')
                                        <a href="#" class="text-primary mx-1" title="{{ trans('back.edit') }}" data-bs-toggle="modal" data-bs-target="#edit_incomesCategory{{ $incomesCategory->id }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @include('backend.pages.IncomesCategories.edit')
                                    @endcan
                                
                                    {{-- Delete --}}
                                    @can('ExpenseCategory_delete')
                                        <a href="#" class="text-danger mx-1" title="{{ trans('back.delete') }}" data-bs-toggle="modal" data-bs-target="#delete_incomesCategory{{ $incomesCategory->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        @include('backend.pages.IncomesCategories.delete')
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


