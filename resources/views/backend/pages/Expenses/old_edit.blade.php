<!-- Modal -->
<div class="modal fade" id="edit_expense{{$expense->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('Expenses.Edit_Expense')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-left">

                <form action=" {{ route('Expenses.update', $expense->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')


                    <div class="row">

                        <div class="form-group col-md-4">
                            <label for="" class="font-weight-bold"> {{trans('back.MainCategory')}} </label>
                            <b class="text-danger">*</b>
                            <select class="form-control Category" name="expense_category_id" required>
                                <option selected disabled value=""> {{trans('Expenses.select_Category')}}</option>
                                @foreach(App\Models\ExpenseCategory::all() as $expenseCategory)
                                    <option value="{{ $expenseCategory->id }}" {{ old('expense_category_id', $expense->expense_category_id) == $expenseCategory->id ? 'selected' : null }}>
                                        @if (app()->getLocale() == 'ar')
                                            {{ $expenseCategory->name_ar ?? "" }}
                                        @else
                                            {{ $expenseCategory->name_en ?? "" }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="expense_sub_category_id" class="font-weight-bold"> {{trans('back.SubCategory')}} </label>
                            <select class="form-control SubCategory" name="expense_sub_category_id">
                                <option value=""> {{trans('back.select')}} </option>
                                @foreach(App\Models\ExpenseSubCategory::all() as $expenseSubCategory)
                                    <option value="{{ $expenseSubCategory->id }}" {{ old('expense_sub_category_id', $expense->expense_sub_category_id) == $expenseSubCategory->id ? 'selected' : null }}>
                                        @if (app()->getLocale() == 'ar')
                                            {{ $expenseSubCategory->name_ar ?? "" }}
                                        @else
                                            {{ $expenseSubCategory->name_en ?? "" }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="name">{{trans('Expenses.the_expense_for_him')}} </label>
                            <b class="text-danger">*</b>
                            <input type="text" class="form-control" name="name" value="{{$expense->name}}">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="amount">{{trans('Expenses.amount')}} </label>
                            <b class="text-danger">*</b>
                            <input type="number" class="form-control expense_amount_edit" step="any" placeholder="{{trans('Expenses.amount')}}" name="amount" value="{{$expense->amount}}">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="tax">{{trans('back.Tax_Amount')}} </label>
                            <input type="number" class="form-control tax_edit" name="tax" id="tax"  step="any" value="{{$expense->tax}}">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="expense_amount_with_tax">{{trans('back.expense_amount_with_tax')}}</label>
                            <input type="number" class="form-control expense_amount_with_tax_edit" name="expense_amount_with_tax" readonly  step="any"  value="{{$expense->expense_amount_with_tax}}">
                        </div>


                        <div class="form-group col-md-3">
                            <label for="expense_date"> {{trans('Expenses.expense_date')}} </label>
                            <b class="text-danger">*</b>
                            <input type="date" class="form-control" placeholder=" {{trans('Expenses.expense_date')}}" name="expense_date" value="{{$expense->expense_date}}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="payment_method_id" >{{trans('payment_methods.select_payment_method')}}:</label>
                            <b class="text-danger">*</b>
                            <select class="form-control " name="payment_method_id" required>
                                <option value="">{{trans('payment_methods.select_payment_method')}}</option>
                                @foreach(App\Models\Payment_method::all() as $payment_method)
                                    <option value="{{ $payment_method->id }}" {{ old('payment_method_id', $expense->payment_method_id) == $payment_method->id ? 'selected' : null }}>
                                        @if(app()->getLocale() == 'ar')
                                            {{ $payment_method->name_ar }}
                                        @else
                                            {{ $payment_method->name_en }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3" >
                            <label for="check_number">{{trans('payment_methods.Check_number_if_any')}}:</label>
                            <input type="text" class="form-control" placeholder="{{trans('payment_methods.Check_number')}}" name="check_number" value="{{$expense->check_number}}" >
                        </div>

                        <div class="form-group col-md-4">
                            <label for="image">{{trans('Expenses.attached')}}</label>
                            <input type="file" class="form-control"  name="image" >
                        </div>

                        <div class="form-group col-md-4">
                            <label for="image">{{trans('Expenses.attached')}}</label>
                            <br>
                            @if($expense->image)
                                <a href="{{asset($expense->image)}}" target="_blank" class="btn btn-secondary btn-xs"> {{trans('Expenses.show')}}</a>
                            @else
                                {{trans('Expenses.none')}}
                            @endif
                        </div>

                        <div class="form-group col-md-12">
                            <label for="about">{{trans('Expenses.about')}}</label>
                            <b class="text-danger">*</b>
                            <input type="text" class="form-control" placeholder="{{trans('Expenses.about')}}" name="about" value="{{$expense->about}}">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="notes">  {{trans('Expenses.notes')}} </label>
                            <textarea class="form-control" name="notes" rows="4"> {{ $expense->notes }}</textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{trans('back.Close')}}</button>
                        <button type="submit" class="btn btn-secondary">{{trans('back.Save')}}</button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
