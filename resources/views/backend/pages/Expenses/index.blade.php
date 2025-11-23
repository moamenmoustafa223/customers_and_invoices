@extends('backend.layouts.master')

@section('page_title')
    {{trans('Expenses.Expenses')}}
@endsection

@section('content')

    <div class="row">

        @can('Expense_search')
            <div class="col-md-3 mb-1">
                <form action="{{ route('Expenses.index') }}" method="GET" role="search">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" name="query" value="{{old('query', request()->input('query'))}}" placeholder="{{trans('services.search')}}" id="query" >
                        <button class="btn btn-primary btn-sm ml-1" type="submit" title="Search">
                            <span class="fas fa-search"></span>
                        </button>
                        <a href="{{ route('Expenses.index') }}" class="btn btn-success btn-sm ml-1 " type="button" title="Reload">
                            <span class="fas fa-sync-alt"></span>
                        </a>
                    </div>
                </form>
            </div>
        @endcan

        <div class="col-md-9 mb-1">
            @can('ExpenseCategory_add')
                <a class="btn btn-primary btn-sm" href="" data-bs-toggle="modal" data-bs-target="#add_expenseCategory">
                    <i class="mdi mdi-plus"></i>
                    {{trans('Expenses.Add_New_Expense_Category')}}
                </a>
                @include('backend.pages.ExpenseCategories.add')
            @endcan

            @can('ExpenseSubCategory_add')
                <a class="btn btn-success btn-sm" href="" data-bs-toggle="modal" data-bs-target="#add_ExpenseSubCategory">
                    <i class="mdi mdi-plus"></i>
                    {{trans('back.ExpenseSubCategory_add')}}
                </a>
                @include('backend.pages.ExpenseSubCategories.add')
            @endcan

            @can('Expense_add')
                <a class="btn btn-info btn-sm" href="" data-bs-toggle="modal" data-bs-target="#add_expense">
                    <i class="mdi mdi-plus"></i>
                    {{trans('Expenses.Add_new_Expense')}}
                </a>
                @include('backend.pages.Expenses.add')
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">

                <div class="table-responsive">
                    <table  class="table text-center  table-bordered table-sm ">
                        <thead>
                        <tr style="background-color: rgb(232,245,252)">
                            <th width="30">#</th>
                            <th width="100">{{trans('back.expense_date')}}</th>
                            <th width="100">{{trans('back.description')}}</th>
                            <th width="100">{{trans('back.SubCategory')}}</th>
                            <th width="100">{{trans('back.MainCategory')}}</th>
                            <th width="100">{{trans('back.supplier')}}</th>
                            <th width="100">{{trans('back.supplier_invoice_number')}}</th>
                            <th width="100">{{trans('back.amount')}}</th>
                            <th width="100">{{trans('back.tax_amount')}}</th>
                            <th width="100">{{trans('back.amount_with_tax')}}</th>
                            <th width="100">{{trans('back.payment_methods')}}</th>
                            <th width="100">{{trans('back.Check_number')}}</th>
                            <th width="100">{{trans('back.notes')}}</th>
                            <th width="100">{{trans('back.Created_at')}}</th>
                            <th width="100">{{trans('back.User')}}</th>
                            <th width="100">{{trans('back.attached')}}</th>
                            <th width="100">{{trans('back.actions')}}</th>

                        </tr>
                        </thead>

                        <tbody>
                        @foreach($expenses as $key => $expense)
                            <tr>
                                <td>{{$key+ $expenses->firstItem()}}</td>
                                <td>{{ $expense->expense_date }}</td>
                                <td>{{ $expense->description }}</td>
                                <td> @if (app()->getLocale() == 'ar') {{ $expense->ExpenseSubCategory->name_ar ?? "" }} @else  {{ $expense->ExpenseSubCategory->name_en ?? "" }} @endif </td>
                                <td> @if (app()->getLocale() == 'ar') {{ $expense->ExpenseCategory->name_ar ?? "" }} @else  {{ $expense->ExpenseCategory->name_en ?? "" }} @endif </td>
                                <td>{{ $expense->supplier }}</td>
                                <td>{{ $expense->supplier_invoice_number }}</td>
                                <td>{{ $expense->amount }}</td>
                                <td> {{ $expense->tax_amount }}</td>
                                <td> {{ $expense->amount_with_tax }}</td>
                                <td> @if(app()->getLocale() == 'ar' ) {{ $expense->Payment_method->name_ar }} @else {{ $expense->Payment_method->name_en }} @endif</td>
                                <td>{{ $expense->check_number }}</td>
                                <td>{{ $expense->notes }}</td>
                                <td>{{ $expense->created_at }}</td>
                                <td>{{ $expense->User->name ?? "" }}</td>
                                <td class="text-center">
                                    {{-- Show Attachment --}}
                                    @if($expense->file)
                                        <a href="{{$expense->file}}" target="_blank" class="text-primary mx-1" title="{{ trans('Incomes.show') }}">
                                            <i class="fas fa-paperclip"></i>
                                        </a>
                                    @else
                                        <span class="text-muted">{{ trans('Incomes.none') }}</span>
                                    @endif
                                </td>
                                
                                <td class="text-center">
                                    {{-- Edit --}}
                                    @can('Expense_edit')
                                        <a href="{{ route('Expenses.edit', $expense->id) }}" class="text-primary mx-1" title="{{ trans('verbs.edit') }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan
                                
                                    {{-- Delete --}}
                                    @can('Expense_delete')
                                        <a href="#" class="text-danger mx-1" title="{{ trans('verbs.delete') }}"
                                           data-bs-toggle="modal" data-bs-target="#delete_expense{{ $expense->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        @include('backend.pages.Expenses.delete')
                                    @endcan
                                </td>
                                
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $expenses->appends(Request::all())->links() !!}
                </div>

            </div>
        </div>
    </div>

@endsection



@section('js')

    <script>
        // حساب الضريبة في الاضافة
        $(function() {
            $(".amount, .tax").on("keydown keyup", sum);

            function sum() {
                let amount = Number($('.amount').val()) ||0;
                let tax = Number($(".tax").val()) ||0;
                let tax_amount = amount * (tax/100);
                $('.amount_with_tax').val(amount + tax_amount).toFixed(3);
            }
        });
    </script>


    <script>
        $('.Category').change(function (){

            var idCategory = this.value;

            $(".SubCategory").html('');
            $.ajax({
                url: "{{url('fetchExpenseSubCategories')}}",
                type: "POST",
                data: {
                    expense_category_id: idCategory,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function(result) {
                    $('.SubCategory').html('<option selected disabled value="">Select</option>');
                    $.each(result.ExpenseSubCategories, function (key, value) {
                        $(".SubCategory").append('<option value="' + value
                            .id + '">' + value.name_ar + '</option>');
                    });
                }
            });
        });
    </script>


@endsection


