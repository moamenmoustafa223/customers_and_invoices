@extends('backend.layouts.master')

@section('page_title')
    {{trans('back.reports_expenses_by_main_categories')}}
@endsection


@section('content')

<form method="POST" action="{{ route('reports_expenses') }}">
    @csrf
    <div class="row g-1 align-items-end">

        {{-- Main Category --}}
        <div class="col-md-2">
            <label class="form-label fw-semibold">{{ trans('back.select_main_category') }}</label>
            <select name="expense_category_id" id="expense-main-category" class="form-select form-select-sm">
                <option value="0">{{ trans('back.All') }}</option>
                @foreach($mainCategories as $cat)
                    <option value="{{ $cat->id }}" {{ old('expense_category_id', $expenseCategoryId) == $cat->id ? 'selected' : '' }}>
                        {{ app()->getLocale() == 'ar' ? $cat->name_ar : $cat->name_en }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Sub Category --}}
        <div class="col-md-2">
            <label class="form-label fw-semibold">{{ trans('back.select_sub_category') }}</label>
            <select name="expense_sub_category_id" id="expense-sub-category" class="form-select form-select-sm">
                <option value="0">{{ trans('back.All') }}</option>
                @foreach($subCategories as $sub)
                    <option value="{{ $sub->id }}" {{ old('expense_sub_category_id', $expenseSubCategoryId) == $sub->id ? 'selected' : '' }}>
                        {{ app()->getLocale() == 'ar' ? $sub->name_ar : $sub->name_en }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Start Date --}}
        <div class="col-md-2">
            <label class="form-label fw-semibold">{{ trans('back.start_date') }}</label>
            <input type="date" name="start_date" class="form-control form-control-sm" value="{{ $start_date }}">
        </div>

        {{-- End Date --}}
        <div class="col-md-2">
            <label class="form-label fw-semibold">{{ trans('back.end_date') }}</label>
            <input type="date" name="end_date" class="form-control form-control-sm" value="{{ $end_date }}">
        </div>

        {{-- Buttons --}}
        <div class="col-md-2 d-flex gap-1">
            <button type="submit" class="btn btn-sm btn-primary">
                <i class="fas fa-search me-1"></i> {{ trans('back.Search') }}
            </button>
            <a href="{{ route('reports_expenses') }}" class="btn btn-sm btn-warning">
                <i class="fas fa-sync-alt"></i>
            </a>
            <button type="submit" formaction="{{ route('reports_expenses_excel') }}" class="btn btn-sm btn-success">
                <i class="fas fa-file-excel me-1"></i> Excel
            </button>
        </div>
    </div>
</form>


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
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($reports_Expenses as $key => $expense)
                            <tr>
                                <td>{{$key+ $reports_Expenses->firstItem()}}</td>
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
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr style="background-color: #daf1e6">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{$total_Expenses}}</td>
                            <td>{{$tax_amount}}</td>
                            <td>{{$amount_with_tax}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tfoot>
                    </table>
                    {!! $reports_Expenses->appends(Request::all())->links() !!}
                </div>

            </div>
        </div>
    </div>

@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const expenseMain = document.getElementById('expense-main-category');
        const expenseSub = document.getElementById('expense-sub-category');

        expenseMain.addEventListener('change', function () {
            const selectedId = this.value;

            // Reset subcategory list
            expenseSub.innerHTML = '<option value="0">{{ trans('back.All') }}</option>';

            if (selectedId == 0) return;

            fetch("{{ route('fetchExpenseSubCategories') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ expense_category_id: selectedId })
            })
            .then(response => response.json())
            .then(data => {
                data.ExpenseSubCategories.forEach(sub => {
                    const option = document.createElement("option");
                    option.value = sub.id;
                    option.text = '{{ app()->getLocale() == "ar" ? "__ar__" : "__en__" }}'
                        .replace("__ar__", sub.name_ar)
                        .replace("__en__", sub.name_en);
                    expenseSub.appendChild(option);
                });
            })
            .catch(error => console.error("Error loading subcategories:", error));
        });
    });
</script>

@endsection
