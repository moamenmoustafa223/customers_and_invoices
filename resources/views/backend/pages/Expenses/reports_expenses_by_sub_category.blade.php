@extends('backend.layouts.master')

@section('page_title')
    {{trans('back.reports_expenses_by_sub_categories')}}
@endsection


@section('content')

    <div class="row">
        <div class="col-md-12 mb-0">
            {{-- فورم البحث بين تاريخين --}}
            <form action="{{ route('reports_expenses_by_sub_category') }}" method="post">
                @csrf
                <div class="row">

                    <div class="form-group col-md-3">
                        <label for="" class="font-weight-bold">
                            {{trans('back.select_category')}}
                        </label>
                        <select class="form-control select2" name="expense_sub_category_id" required>
                            <option value="0">{{trans('back.All')}}</option>
                            @foreach(App\Models\ExpenseCategory::all() as $expenseCategory)
                                <optgroup label="{{$expenseCategory->name_ar}}">
                                    @foreach($expenseCategory->ExpenseSubCategories as $expense_sub_category)
                                        <option value="{{ $expense_sub_category->id }}" {{ old('expense_sub_category_id', request()->input('expense_sub_category_id')) == $expense_sub_category->id ? 'selected' : null }}>
                                            @if (app()->getLocale() == 'ar')
                                                {{ $expense_sub_category->name_ar ?? "" }}
                                            @else
                                                {{ $expense_sub_category->name_en ?? "" }}
                                            @endif
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label >{{trans('back.start_date')}}</label>
                        <input name="start_date" class="form-control " type="date" value="{{ $start_date??"" }}">
                    </div>
                    <div class="col-md-2">
                        <label > {{trans('back.end_date')}}</label>
                        <input name="end_date" class="form-control " type="date" value="{{ $end_date??"" }}">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary btn-sm" style="margin-top: 25px" type="submit" formaction="{{ route('reports_expenses_by_sub_category') }}"> {{trans('back.Search')}}  </button>
                        <button class="btn btn-success btn-sm" style="margin-top: 25px" type="submit" formaction="{{route('reports_expenses_by_sub_category_excel')}}"> Excel </button>
                        <a href="{{ route('reports_expenses_by_sub_category') }}" style="margin-top: 25px" class="btn btn-warning" type="button" title="Reload">
                            <span class="fas fa-sync-alt"></span>
                        </a>
                    </div>
                </div>
            </form>
            {{--نهاية فورم البحث بين تاريخين --}}
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
                            <th width="100">{{trans('back.amount_with_tax')}}</th>
                            <th width="100">{{trans('back.description')}}</th>
                            <th width="100">{{trans('back.SubCategory')}}</th>
                            <th width="100">{{trans('back.MainCategory')}}</th>
                            <th width="100">{{trans('back.supplier')}}</th>
                            <th width="100">{{trans('back.supplier_invoice_number')}}</th>
                            <th width="100">{{trans('back.amount')}}</th>
                            <th width="100">{{trans('back.tax_amount')}}</th>
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
                                <td> {{ $expense->amount_with_tax }}</td>
                                <td>{{ $expense->description }}</td>
                                <td> @if (app()->getLocale() == 'ar') {{ $expense->ExpenseSubCategory->name_ar ?? "" }} @else  {{ $expense->ExpenseSubCategory->name_en ?? "" }} @endif </td>
                                <td> @if (app()->getLocale() == 'ar') {{ $expense->ExpenseCategory->name_ar ?? "" }} @else  {{ $expense->ExpenseCategory->name_en ?? "" }} @endif </td>
                                <td>{{ $expense->supplier }}</td>
                                <td>{{ $expense->supplier_invoice_number }}</td>
                                <td>{{ $expense->amount }}</td>
                                <td> {{ $expense->tax_amount }}</td>
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
                            <td>{{$amount_with_tax}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{$total_Expenses}}</td>
                            <td>{{$tax_amount}}</td>
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

