@extends('backend.layouts.master')
@section('page_title') {{trans('back.Edit_Income')}}@endsection

@section('content')

    @can('Incomes')
        <div>
            <a class="btn btn-primary btn-sm mb-1" href="{{route('Incomes.index')}}" >
                <i class="fas fa-undo"></i>
                {{trans('back.Turn_back')}}
            </a>
        </div>
    @endcan


    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <form action=" {{ route('Incomes.update', $income->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="form-group col-md-3">
                            <label for="" class="font-weight-bold"> {{trans('back.MainCategory')}} </label>
                            <b class="text-danger">*</b>
                            <select class="form-control Category" name="incomes_category_id" required>
                                <option selected disabled value=""> {{trans('Expenses.select_Category')}}</option>
                                @foreach(App\Models\IncomesCategory::all() as $incomesCategory)
                                    <option value="{{ $incomesCategory->id }}" {{ old('incomes_category_id', $income->incomes_category_id) == $incomesCategory->id ? 'selected' : null }}>
                                        @if(app()->getLocale() == 'ar')
                                            {{ $incomesCategory->name_ar }}
                                        @else
                                            {{ $incomesCategory->name_en }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="incomes_sub_category_id" class="font-weight-bold"> {{trans('back.SubCategory')}} </label>
                            <select class="form-control SubCategory" name="incomes_sub_category_id">
                                <option value=""> {{trans('back.select')}} </option>
                                @foreach(App\Models\IncomesSubCategory::all() as $incomesSubCategory)
                                    <option value="{{ $incomesSubCategory->id }}" {{ old('incomes_sub_category_id', $income->incomes_sub_category_id) == $incomesSubCategory->id ? 'selected' : null }}>
                                        @if(app()->getLocale() == 'ar')
                                            {{ $incomesSubCategory->name_ar }}
                                        @else
                                            {{ $incomesSubCategory->name_en }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{--المورد--}}
                        <div class="form-group col-md-3">
                            <label for="supplier">{{trans('back.supplier')}}</label>
                            <b class="text-danger">*</b>
                            <input type="text" class="form-control" placeholder="{{trans('back.supplier')}}" name="supplier" value="{{$income->supplier}}">
                        </div>

                        {{--رقم فاتورة المورد--}}
                        <div class="form-group col-md-3">
                            <label for="supplier_invoice_number">{{trans('back.supplier_invoice_number')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('back.supplier_invoice_number')}}" name="supplier_invoice_number" value="{{$income->supplier_invoice_number}}">
                        </div>


                        {{--المبلغ--}}
                        <div class="form-group col-md-3">
                            <label for="amount">{{trans('Expenses.amount')}}</label>
                            <b class="text-danger">*</b>
                            <input type="number" class="form-control amount" step="any" placeholder="{{trans('Expenses.amount')}}"  name="amount" value="{{$income->amount}}">
                        </div>

                        {{--الضريبة--}}
                        <div class="form-group col-md-3">
                            <label for="tax"> {{trans('back.tax')}} %</label>
                            <input type="number" class="form-control tax" name="tax"  step="any" value="{{$income->tax}}">
                        </div>

                        {{--المبلغ شامل الضريبة--}}
                        <div class="form-group col-md-3">
                            <label for="expense_amount_with_tax"> {{trans('back.amount_with_tax')}} </label>
                            <input type="number" class="form-control amount_with_tax" name="amount_with_tax" readonly  step="any"  value="{{$income->amount_with_tax}}">
                        </div>


                        {{--تاريخ الصرف--}}
                        <div class="form-group col-md-3">
                            <label for="expense_date"> {{trans('Expenses.expense_date')}} </label>
                            <b class="text-danger">*</b>
                            <input type="date" class="form-control" placeholder=" {{trans('Expenses.expense_date')}}" name="expense_date" value="{{$income->expense_date}}">
                        </div>

                        {{--الحساب المالى--}}
                        <div class="form-group col-md-3">
                            <label for="payment_method_id" >{{trans('payment_methods.select_payment_method')}}:</label>
                            <b class="text-danger">*</b>
                            <select class="form-control " name="payment_method_id" required>
                                <option value="">{{trans('payment_methods.select_payment_method')}}</option>
                                @foreach(App\Models\Payment_method::all() as $payment_method)
                                    <option value="{{ $payment_method->id }}" {{ old('payment_method_id', $income->payment_method_id) == $payment_method->id ? 'selected' : null }}>
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
                            <input type="text" class="form-control" placeholder="{{trans('payment_methods.Check_number')}}" name="check_number" value="{{$income->check_number}}" >
                        </div>

                        {{--مرفق--}}
                        <div class="form-group col-md-3">
                            <label for="file">{{trans('Incomes.attached')}}</label>
                            <input type="file" class="form-control"  name="file" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="image">{{trans('Incomes.attached')}}</label>
                            <br>
                            @if($income->file)
                                <a href="{{$income->file}}" target="_blank" class="btn btn-primary btn-xs"> {{trans('Incomes.show')}}</a>
                            @else
                                {{trans('Incomes.none')}}
                            @endif
                        </div>

                        {{--البيان--}}
                        <div class="form-group col-md-12">
                            <label for="description">{{trans('back.description')}}</label>
                            <b class="text-danger">*</b>
                            <input type="text" class="form-control" placeholder="{{trans('back.description')}}" name="description" value="{{$income->description}}">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="notes">  {{trans('back.notes')}} </label>
                            <textarea class="form-control" name="notes" rows="4"> {{ $income->notes }}</textarea>
                        </div>

                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success">{{trans('back.Save')}}</button>
                    </div>

                </form>
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
                url: "{{url('fetchIncomesSubCategories')}}",
                type: "POST",
                data: {
                    incomes_category_id: idCategory,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function(result) {
                    $('.SubCategory').html('<option selected disabled value="">Select</option>');
                    $.each(result.IncomesSubCategories, function (key, value) {
                        $(".SubCategory").append('<option value="' + value
                            .id + '">' + value.name_ar + '</option>');
                    });
                }
            });
        });
    </script>

@endsection
