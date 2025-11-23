<!-- Modal -->
<div class="modal fade" id="add_income" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('back.Income_add')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action=" {{ route('Incomes.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                    <div class="row">

                        <div class="form-group col-md-4">
                            <label for="" class="font-weight-bold"> {{trans('back.MainCategory')}} </label>
                            <b class="text-danger">*</b>
                            <select class="form-control Category" name="incomes_category_id"  required>
                                <option selected disabled value=""> {{trans('Expenses.select_Category')}}</option>
                                @foreach(App\Models\IncomesCategory::all() as $incomesCategory)
                                    <option value="{{ $incomesCategory->id }}" {{ old('incomes_category_id') == $incomesCategory->id ? 'selected' : null }}>
                                        @if (app()->getLocale() == 'ar')
                                            {{ $incomesCategory->name_ar ?? "" }}
                                        @else
                                            {{ $incomesCategory->name_en ?? "" }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="incomes_sub_category_id" class="font-weight-bold"> {{trans('back.SubCategory')}} </label>
                            <select class="form-control SubCategory" name="incomes_sub_category_id">
                                <option value=""> {{trans('back.select')}} </option>
                            </select>
                        </div>


                        {{--المورد--}}
                        <div class="form-group col-md-4">
                            <label for="supplier">{{trans('back.supplier')}}</label>
                            <b class="text-danger">*</b>
                            <input type="text" class="form-control" placeholder="{{trans('back.supplier')}}" name="supplier" value="{{old('supplier')}}">
                        </div>

                        {{--رقم فاتورة المورد--}}
                        <div class="form-group col-md-3">
                            <label for="supplier_invoice_number">{{trans('back.supplier_invoice_number')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('back.supplier_invoice_number')}}" name="supplier_invoice_number" value="{{old('supplier_invoice_number')}}">
                        </div>

                        {{--المبلغ--}}
                        <div class="form-group col-md-3">
                            <label for="amount">{{trans('Expenses.amount')}}</label>
                            <b class="text-danger">*</b>
                            <input type="number" class="form-control amount" step="any" placeholder="{{trans('Expenses.amount')}}"  name="amount" value="0.000">
                        </div>

                        {{--الضريبة--}}
                        <div class="form-group col-md-3">
                            <label for="tax"> {{trans('back.tax')}}% </label>
                            <input type="number" class="form-control tax" name="tax"  step="any" value="{{App\Models\Setting::first()->tax ?? 0}}">
                        </div>

                        {{--المبلغ شامل الضريبة--}}
                        <div class="form-group col-md-3">
                            <label for="expense_amount_with_tax"> {{trans('back.amount_with_tax')}} </label>
                            <input type="number" class="form-control amount_with_tax" name="amount_with_tax" readonly  step="any"  value="0.000">
                        </div>


                        {{--تاريخ الصرف--}}
                        <div class="form-group col-md-3">
                            <label for="expense_date"> {{trans('Expenses.expense_date')}} </label>
                            <b class="text-danger">*</b>
                            <input type="date" class="form-control" placeholder=" {{trans('Expenses.expense_date')}}" name="expense_date" value="{{date('Y-m-d')}}">
                        </div>

                        {{--الحساب المالى--}}
                        <div class="form-group col-md-3">
                            <label for="payment_method_id" >{{trans('payment_methods.select_payment_method')}}:</label>
                            <b class="text-danger">*</b>
                            <select class="form-control " name="payment_method_id" required>
                                <option value="">{{trans('payment_methods.select_payment_method')}}</option>
                                @foreach(App\Models\Payment_method::all() as $payment_method)
                                    <option value="{{ $payment_method->id }}">
                                        @if(app()->getLocale() == 'ar')
                                            {{ $payment_method->name_ar }}
                                        @else
                                            {{ $payment_method->name_en }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{--رقم الشيك إن وجد--}}
                        <div class="form-group col-md-3" >
                            <label for="check_number">{{trans('payment_methods.Check_number_if_any')}}:</label>
                            <input type="text" class="form-control" placeholder="{{trans('payment_methods.Check_number')}}" name="check_number" value="{{old('check_number')}}" >
                        </div>

                        {{--مرفق--}}
                        <div class="form-group col-md-3">
                            <label for="file">{{trans('Incomes.attached')}}</label>
                            <input type="file" class="form-control"  name="file" >
                        </div>

                        {{--البيان--}}
                        <div class="form-group col-md-12">
                            <label for="description">{{trans('back.description')}}</label>
                            <b class="text-danger">*</b>
                            <input type="text" class="form-control" placeholder="{{trans('back.description')}}" name="description" value="{{old('description')}}">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="notes">  {{trans('Incomes.notes')}} </label>
                            <textarea class="form-control" name="notes" rows="4"> {{ old('notes') }}</textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{trans('back.Close')}}</button>
                        <button type="submit" class="btn btn-success">{{trans('back.Add')}}</button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
