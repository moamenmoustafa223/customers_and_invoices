
@extends('backend.layouts.master')

@section('page_title')
    {{trans('back.edit_asset')}}
@endsection


@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card-box">
                <form action=" {{ route('Assets.update', $asset->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="form-group col-md-3">
                            <label for="" class="font-weight-bold"> {{trans('back.MainCategory')}} </label>
                            <b class="text-danger">*</b>
                            <select class="form-control Category" name="assets_category_id" required>
                                <option selected disabled value=""> {{trans('Expenses.select_Category')}}</option>
                                @foreach(App\Models\AssetsCategory::all() as $assetsCategory)
                                    <option value="{{ $assetsCategory->id }}" {{ old('assets_category_id', $asset->assets_category_id) == $assetsCategory->id ? 'selected' : null }}>
                                        @if(app()->getLocale() == 'ar')
                                            {{ $assetsCategory->name_ar }}
                                        @else
                                            {{ $assetsCategory->name_en }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="assets_sub_category_id" class="font-weight-bold"> {{trans('back.SubCategory')}} </label>
                            <select class="form-control SubCategory" name="assets_sub_category_id">
                                <option value=""> {{trans('back.select')}} </option>
                                @foreach(App\Models\AssetsSubCategory::all() as $assetsSubCategory)
                                    <option value="{{ $assetsSubCategory->id }}" {{ old('assets_sub_category_id', $asset->assets_sub_category_id) == $assetsSubCategory->id ? 'selected' : null }}>
                                        @if(app()->getLocale() == 'ar')
                                            {{ $assetsSubCategory->name_ar }}
                                        @else
                                            {{ $assetsSubCategory->name_en }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{--المورد--}}
                        <div class="form-group col-md-3">
                            <label for="supplier">{{trans('back.supplier')}}</label>
                            <b class="text-danger">*</b>
                            <input type="text" class="form-control" placeholder="{{trans('back.supplier')}}" name="supplier" value="{{$asset->supplier}}">
                        </div>

                        {{--رقم فاتورة المورد--}}
                        <div class="form-group col-md-3">
                            <label for="supplier_invoice_number">{{trans('back.supplier_invoice_number')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('back.supplier_invoice_number')}}" name="supplier_invoice_number" value="{{$asset->supplier_invoice_number}}">
                        </div>

                        {{--المبلغ--}}
                        <div class="form-group col-md-3">
                            <label for="amount">{{trans('Expenses.amount')}}</label>
                            <b class="text-danger">*</b>
                            <input type="number" class="form-control amount" step="any" placeholder="{{trans('Expenses.amount')}}"  name="amount" value="{{$asset->amount}}">
                        </div>

                        {{--الضريبة--}}
                        <div class="form-group col-md-3">
                            <label for="tax"> {{trans('back.tax')}} %</label>
                            <input type="number" class="form-control tax" name="tax"  step="any" value="{{$asset->tax}}">
                        </div>

                        {{--المبلغ شامل الضريبة--}}
                        <div class="form-group col-md-3">
                            <label for="expense_amount_with_tax"> {{trans('back.amount_with_tax')}} </label>
                            <input type="number" class="form-control amount_with_tax" name="amount_with_tax" readonly  step="any"  value="{{$asset->amount_with_tax}}">
                        </div>

                        {{--معدل الاهلاك--}}
                        <div class="form-group col-md-3">
                            <label for="depreciation_rate"> {{trans('back.depreciation_rate')}} </label>
                            <input type="text" class="form-control" name="depreciation_rate" step="any" placeholder="{{trans('back.depreciation_rate')}}"  value="{{$asset->depreciation_rate}}">
                        </div>

                        {{--تاريخ الصرف--}}
                        <div class="form-group col-md-3">
                            <label for="expense_date"> {{trans('Expenses.expense_date')}} </label>
                            <b class="text-danger">*</b>
                            <input type="date" class="form-control" placeholder=" {{trans('Expenses.expense_date')}}" name="expense_date" value="{{$asset->expense_date}}">
                        </div>

                        {{--الحساب المالى--}}
                        <div class="form-group col-md-3">
                            <label for="payment_method_id" >{{trans('back.select_payment_method')}}:</label>
                            <b class="text-danger">*</b>
                            <select class="form-control " name="payment_method_id" required>
                                <option value="">{{trans('back.select_payment_method')}}</option>
                                @foreach(App\Models\Payment_method::all() as $payment_method)
                                    <option value="{{ $payment_method->id }}" {{ old('payment_method_id', $asset->payment_method_id) == $payment_method->id ? 'selected' : null }}>
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
                            <input type="text" class="form-control" placeholder="{{trans('payment_methods.Check_number')}}" name="check_number" value="{{$asset->check_number}}" >
                        </div>


                        {{--مرفق--}}
                        <div class="form-group col-md-3">
                            <label for="file">{{trans('Incomes.attached')}}</label>
                            <input type="file" class="form-control"  name="file" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="image">{{trans('Incomes.attached')}}</label>
                            <br>
                            @if($asset->file)
                                <a href="{{$asset->file}}" target="_blank" class="btn btn-primary btn-xs"> {{trans('Incomes.show')}}</a>
                            @else
                                {{trans('Incomes.none')}}
                            @endif
                        </div>

                        {{--البيان--}}
                        <div class="form-group col-md-12">
                            <label for="description">{{trans('back.description')}}</label>
                            <b class="text-danger">*</b>
                            <input type="text" class="form-control" placeholder="{{trans('back.description')}}" name="description" value="{{$asset->description}}">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="file">{{trans('back.notes')}}</label>
                            <textarea class="form-control" name="notes" id="notes" cols="30" rows="4">{{$asset->notes}}</textarea>
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
                url: "{{url('fetchAssetsSubCategories')}}",
                type: "POST",
                data: {
                    assets_category_id: idCategory,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function(result) {
                    $('.SubCategory').html('<option selected disabled value="">Select</option>');
                    $.each(result.AssetsSubCategories, function (key, value) {
                        $(".SubCategory").append('<option value="' + value
                            .id + '">' + value.name_ar + '</option>');
                    });
                }
            });
        });
    </script>

@endsection


