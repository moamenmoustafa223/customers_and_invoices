@extends('backend.layouts.master')

@section('page_title')
    {{trans('back.add_studentsContract')}}
@endsection


@section('content')

    <div class="row ">
        <div class="col-sm-4">
            <a href="{{route('studentsContracts.index')}}" class="btn btn-info btn-sm mb-1">
                {{trans('back.studentsContracts')}}
            </a>

            @can('student_add')
                <a class="btn btn-success btn-sm mb-1" href="{{route('students.create')}}" >
                    <i class="mdi mdi-plus"></i>
                    {{trans('back.student_add')}}
                </a>
              
            @endcan

            @can('add_tuition_fee')
                <a class="btn btn-primary btn-sm mb-1" href="" data-bs-toggle="modal" data-bs-target="#add_tuition_fee">
                    <i class="mdi mdi-plus"></i>
                    {{trans('back.add_tuition_fee')}}
                </a>
                @include('backend.pages.tuition_fees.add')
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <form action="{{route('studentsContracts.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        {{--الطالب--}}
                        <div class="form-group col-md-3">
                            <label for="student_id" class="font-weight-bold" > {{trans('back.select_student')}} </label>
                            <b class="text-danger">*</b>
                            <select class="form-control select2" name="student_id" required>
                                <option selected disabled value=""> {{trans('back.Select')}} </option>
                                @foreach(App\Models\Student::all() as $student)
                                    <option value="{{ $student->id}}">
                                        {{ $student->first_name }} {{ $student->father_name }} {{ $student->grandfather_name }} / {{ $student->Guardian->phone }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{--السنة الدراسية--}}
                        <div class="form-group col-md-3">
                            <label for="academic_year_id" class="font-weight-bold"> {{trans('back.academic_year')}} </label>
                            <b class="text-danger">*</b>
                            <select class="form-control select2 Academic_year" name="academic_year_id" required>
                                <option selected disabled value=""> {{trans('back.Select')}} </option>
                                @foreach(App\Models\AcademicYear::all() as $academicYear)
                                    <option value="{{ $academicYear->id}}">
                                        {{ $academicYear->academic_year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{--الصف الدراسي--}}
                        <div class="form-group col-md-3">
                            <label for="classroom_id" class="font-weight-bold"> {{trans('back.classroom')}} </label>
                            <select class="form-control select2 Classroom" name="classroom_id" required>
                                <option value=""> {{trans('back.select')}} </option>
                            </select>
                        </div>

                        {{--الشعبة--}}
                        <div class="form-group col-md-3">
                            <label for="section_id" class="font-weight-bold"> {{trans('back.section')}} </label>
                            <select class="form-control select2 Section" name="section_id" required>
                                <option value=""> {{trans('back.select')}} </option>
                            </select>
                        </div>

                        {{--الحافلة--}}
                        <div class="form-group col-md-4">
                            <label for="bus_id" class="font-weight-bold" > {{trans('back.bus')}} </label>
                            <select class="form-control select2" name="bus_id" >
                                <option selected disabled value=""> {{trans('back.Select')}} </option>
                                @foreach(App\Models\Bus::all() as $bus)
                                    <option value="{{ $bus->id}}">
                                        {{ $bus->bus_number }} / {{ $bus->bus_driver }} / / {{ $bus->bus_driver_phone }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{--تاريخ العقد--}}
                        <div class="form-group col-md-4">
                            <label for="contract_date">{{trans('back.contract_date')}}</label>
                            <b class="text-danger">*</b>
                            <input type="date" class="form-control" placeholder="{{trans('back.contract_date')}}" name="contract_date" value="{{date('Y-m-d')}}" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="file">{{trans('back.file')}}</label>
                            <input type="file" class="form-control form-control-file" name="file" >
                        </div>

                        <div class="col-md-12 mt-0">
                            <hr class="mt-0 pt-0">
                        </div>
                    </div>

                    {{--بنود الرسوم الدراسية --}}
                    <div class="row pt-2 pb-2" style="background-color: #ececec">

                        <div class="col-md-5" style="height: 450px; overflow-y: scroll;">
                            <div class="pt-2">
                                <h5 class="mt-0"> {{trans('back.tuition_fees')}}</h5>
                                <input type="search" id="search_fee" class="form-control form-control-sm mb-2"  placeholder="{{trans('back.Search')}}">

                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm text-center">
                                        <thead>
                                        <tr style="background-color: rgb(232,245,252)">
                                            <th width="150">{{trans('back.tuition_fee')}}</th>
                                            <th width="50">{{trans('back.price')}}</th>
                                            <th width="50">{{trans('back.quantity')}}</th>
                                            <th width="50">{{trans('back.tax_rate')}}(%)</th>
                                            <th width="50">{{trans('back.total')}}</th>
                                            <th width="50">{{trans('back.Add')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody id="fee">
                                        @foreach(App\Models\TuitionFee::all() as $tuition_fee)
                                            <tr>
                                                <td>{{app()->getLocale() == 'ar' ? $tuition_fee->name_ar : $tuition_fee->name_en}}</td>
                                                <td>{{$tuition_fee->price}}</td>
                                                <td>{{$tuition_fee->quantity}}</td>
                                                <td>{{$tuition_fee->tax_rate}} %</td>
                                                <td>{{$tuition_fee->total}} </td>
                                                <td>
                                                    <a href=""
                                                       id="fee-{{$tuition_fee->id}}"
                                                       data-name="{{app()->getLocale() == 'ar' ? $tuition_fee->name_ar : $tuition_fee->name_en}}"
                                                       data-id="{{$tuition_fee->id}}"
                                                       data-price="{{$tuition_fee->price}}"
                                                       data-quantity="{{$tuition_fee->quantity}}"
                                                       data-taxrate="{{$tuition_fee->tax_rate}}"
                                                       data-total="{{$tuition_fee->total}}"
                                                       type="submit"
                                                       class="btn btn-success btn-sm add-fee-btn">
                                                        <i class="fas fa-plus"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{--تفاصيل العقد --}}
                        <div class="col-md-7 pt-2">
                            <h5 class="mt-0">
                                {{trans('back.contract_details')}}
                            </h5>
                            {{--  تفاصيل المبلغ --}}
                            <div class="row">
                                {{--المبلغ--}}
                                <div class="form-group col-md-3">
                                    <label for="sub_total">{{trans('back.sub_total')}}</label>
                                    <b class="text-danger">*</b>
                                    <input type="number" class="form-control form-control-sm sub_total font-weight-bold text-center text-danger" placeholder="{{trans('back.sub_total')}}" name="sub_total" step="any" value="0.000" readonly>
                                </div>

                                {{--الخصم--}}
                                <div class="form-group col-md-3 text-center pb-0 mb-1">
                                    <label for="discount " class="font-weight-bold"> {{trans('invoices.discount')}}</label>
                                    <input type="number" name="discount" class="form-control form-control-sm discount font-weight-bold text-center text-danger" step="any" value="0.000" >
                                </div>

                                {{--المبلغ بعد الخصم--}}
                                <div class="form-group col-md-3 text-center pb-0 mb-1">
                                    <label for="amount_after_discount" class="font-weight-bold">{{trans('invoices.amount_after_discount')}}</label>
                                    <input type="number" name="amount_after_discount" class="form-control form-control-sm amount_after_discount font-weight-bold text-center text-danger" step="any" value="0.000"  readonly>
                                </div>

                                {{--قيمة الضريبة--}}
                                <div class="form-group col-md-3">
                                    <label for="tax_value">{{trans('back.tax_value')}}</label>
                                    <input type="number" class="form-control form-control-sm tax_value font-weight-bold text-center text-danger" name="tax_value" step="any" value="0.000" readonly >
                                </div>

                                {{--المبلغ شامل الضريبة--}}
                                <div class="form-group col-md-5" >
                                    <label for="total_amount_with_tax">{{trans('back.total_amount_with_tax')}}</label>
                                    <b class="text-danger">*</b>
                                    <input type="number" class="form-control form-control-sm total_amount_with_tax font-weight-bold text-center text-danger" name="total_amount_with_tax" step="any" value="0.000" readonly>
                                </div>

                                <div class="form-group col-md-5">
                                    <button type="submit" class="btn btn-success w-100  btn-sm btn-block" style="margin-top:23px"> {{trans('back.create_contract')}}</button>
                                </div>
                            </div>

                            {{--  تفاصيل الطلب للخدمات --}}
                            <div class="card-box pt-1 pb-0 mb-2" style="background-color: #d9fce9">
                                <h5 class="mt-2">{{trans('back.tuition_fees_details')}}</h5>
                                <div class="table-responsive">
                                    <table id="cart" class="table table-bordered table-sm text-center">
                                        <thead>
                                        <tr>
                                            <th width="100">{{trans('back.tuition_fee')}}</th>
                                            <th width="50">{{trans('back.unit_price')}}</th>
                                            <th width="50">{{trans('back.quantity')}}</th>
                                            <th width="50">{{trans('back.tax_rate')}}(%)</th>
                                            <th width="50">{{trans('back.total')}}</th>
                                            <th width="10">{{trans('back.Delete')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody class="fee-list">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- الأقساط --}}
                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                            <h5 class="mt-2">{{trans('back.installments')}}:</h5>
                            <div id="installments-container">
                                <div class="installment-row row mb-2">
                                    <div class="col-md-4">
                                        <label> {{trans('back.installment_amount')}}</label>
                                        <input type="number" name="installments[0][installment_amount]" class="form-control installment_amount" step="any">
                                    </div>
                                    <div class="col-md-4">
                                        <label>{{trans('back.rest_amount')}}</label>
                                        <input type="number" name="installments[0][rest_amount]" class="form-control rest_amount" step="any" value="0.000" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label> {{trans('back.due_date')}}</label>
                                        <input type="date" name="installments[0][due_date]" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="alert alert-danger d-none" id="installment-warning">
                                {{trans('back.installment_warning')}}
                                يجب أن يكون مجموع الأقساط مساويًا لإجمالي المبلغ (لا يمكن ترك مبلغ متبقي).
                            </div>

                            <button type="button" class="btn btn-sm btn-primary" id="add-installment-btn">  {{trans('back.add_installment')}}</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                            <div class="row">

                                {{--شروط العقد--}}
                                <div class="col-md-6">
                                    <label for="notes">{{trans('back.contract_terms_ar')}}</label>
                                    <textarea name="contract_terms_ar" class="form-control editor" cols="30" rows="4">{{App\Models\Setting::first()->contract_terms_ar}}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="notes">{{trans('back.contract_terms_en')}}</label>
                                    <textarea name="contract_terms_en" class="form-control editor" cols="30" rows="4">{{App\Models\Setting::first()->contract_terms_en}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
<script>
    $('.Academic_year').change(function (){

        var idAcademic_year = this.value;

        $(".Classroom").html('');
        $.ajax({
            url: "{{url('fetchClassrooms')}}",
            type: "POST",
            data: {
                academic_year_id: idAcademic_year,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function(result) {
                $('.Classroom').html('<option selected disabled value="">Select</option>');
                $.each(result.Classrooms, function (key, value) {
                    $(".Classroom").append('<option value="' + value
                        .id + '">' + value.name_ar + '</option>');
                });
            }
        });
    });



    $('.Classroom').change(function (){

        var idClassroom = this.value;

        $(".Section").html('');
        $.ajax({
            url: "{{url('fetchSections')}}",
            type: "POST",
            data: {
                classroom_id: idClassroom,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function(result) {
                $('.Section').html('<option selected disabled value="">Select</option>');
                $.each(result.Sections, function (key, value) {
                    $(".Section").append('<option value="' + value
                        .id + '">' + value.name_ar + '</option>');
                });
            }
        });
    });

</script>
<script>
    $(document).ready(function () {
        let installmentIndex = 1;

        // ------------------------------
        // INSTALLMENTS LOGIC
        // ------------------------------

        function sum_total_amount_with_tax() {
            let amount_after_discount = parseFloat($('.amount_after_discount').val()) || 0;
            let tax_value = parseFloat($('.tax_value').val()) || 0;
            return (amount_after_discount + tax_value).toFixed(3);
        }

        function updateInstallmentsRest() {
    let total = parseFloat(sum_total_amount_with_tax()) || 0;
    let used = 0;

    $('.installment-row').each(function () {
        let amountInput = $(this).find('input[name^="installments"][name$="[installment_amount]"]');
        let restInput = $(this).find('input[name^="installments"][name$="[rest_amount]"]');

        let currentAmount = parseFloat(amountInput.val()) || 0;
        used += currentAmount;

        let rest = total - used;
        restInput.val(rest.toFixed(3));

        if (rest < 0) {
            amountInput.addClass('is-invalid');
        } else {
            amountInput.removeClass('is-invalid');
        }
    });

    let finalRest = total - used;
    if (finalRest !== 0) {
        $('#installment-warning').removeClass('d-none');
    } else {
        $('#installment-warning').addClass('d-none');
    }
}


        function updateFirstInstallment() {
            const total = parseFloat(sum_total_amount_with_tax()) || 0;
            const firstInstallment = $('input[name="installments[0][installment_amount]"]');
            const restAmount = $('input[name="installments[0][rest_amount]"]');

            let currentInstallment = parseFloat(firstInstallment.val()) || 0;

            if (currentInstallment === 0) {
                firstInstallment.val(total.toFixed(3));
                restAmount.val('0.000');
            } else {
                restAmount.val((total - currentInstallment).toFixed(3));
            }
        }

        updateFirstInstallment();

        $('body').on('input', 'input[name^="installments"][name$="[installment_amount]"]', function () {
            updateInstallmentsRest();
        });

        $('#add-installment-btn').on('click', function () {
    let html = `
    <div class="installment-row row mb-2">
        <div class="col-md-4">
            <label>مبلغ القسط</label>
            <input type="number" name="installments[${installmentIndex}][installment_amount]" class="form-control installment_amount" step="any" required>
        </div>
        <div class="col-md-4">
            <label>المبلغ المتبقي</label>
            <input type="number" name="installments[${installmentIndex}][rest_amount]" class="form-control rest_amount" step="any" value="0.000" readonly>
        </div>
        <div class="col-md-3">
            <label>تاريخ الاستحقاق</label>
            <input type="date" name="installments[${installmentIndex}][due_date]" class="form-control" required>
        </div>
        <div class="col-md-1 d-flex align-items-end">
            <button type="button" class="btn btn-danger btn-sm remove-installment">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>`;
    $('#installments-container').append(html);
    installmentIndex++;
});
$('body').on('click', '.remove-installment', function () {
    $(this).closest('.installment-row').remove();
    updateInstallmentsRest(); // recalculate totals after deletion
});


        // ------------------------------
        // FEES LOGIC
        // ------------------------------

        $('.add-fee-btn').on('click', function (e) {
    e.preventDefault();
    let name = $(this).data('name');
    let id = $(this).data('id');
    let price = $(this).data('price');
    let quantity = $(this).data('quantity');
    let taxRate = $(this).data('taxrate');
    let total = $(this).data('total');

    let html = `<tr>
        <td><input type="text" name="fees[${id}][name]" class="form-control" value="${name}" readonly></td>
        <td><input type="text" name="fees[${id}][price]" class="form-control" value="${price}" readonly></td>
        <td><input type="text" name="fees[${id}][quantity]" class="form-control fee-quantity" value="${quantity}" readonly></td>
        <td><input type="text" name="fees[${id}][tax_rate]" class="form-control" value="${taxRate}" readonly></td>
        
        <input type="hidden" name="fees[${id}][tuition_fee_id]" value="${id}">
        <input type="hidden" name="fees[${id}][total]" value="${total}">
        
        <td class="fee_price">${total}</td>
        <td><button class="btn btn-danger btn-xs remove-fee-btn" data-id="${id}">
            <i class="fa fa-trash-alt"></i>
        </button></td>
    </tr>`;

    $('.fee-list').append(html);
    $(this).removeClass('btn-success').addClass('btn-secondary disabled');
    recalculateAll();
});


        $('body').on('click', '.remove-fee-btn', function (e) {
            e.preventDefault();
            let id = $(this).data('id');
            $(this).closest('tr').remove();
            $('#fee-' + id).removeClass('btn-secondary disabled').addClass('btn-success');
            recalculateAll();
        });

        $('body').on('keyup blur change', '.discount, .tax', function () {
            recalculateAll();
        });

        function recalculateAll() {
            $('.sub_total').val(calculateSubTotal());
            $('.amount_after_discount').val(amount_after_discount());
            $('.tax_value').val(calculateTax());
            $('.total_amount_with_tax').val(sum_total_amount_with_tax());
            updateInstallmentsRest();
        }

        function calculateSubTotal() {
            let price = 0;
            $('.fee-list tr').each(function () {
                let unitPrice = parseFloat($(this).find('input[name*="[price]"]').val()) || 0;
                let quantity = parseFloat($(this).find('input[name*="[quantity]"]').val()) || 1;
                price += unitPrice * quantity;
            });
            return price.toFixed(3);
        }

        function amount_after_discount() {
            let sub_total = parseFloat($('.sub_total').val()) || 0;
            let discount = parseFloat($('.discount').val()) || 0;
            return (sub_total - discount).toFixed(3);
        }

        function calculateTax() {
            let taxTotal = 0;
            $('.fee-list tr').each(function () {
                let unitPrice = parseFloat($(this).find('input[name*="[price]"]').val()) || 0;
                let quantity = parseFloat($(this).find('input[name*="[quantity]"]').val()) || 1;
                let taxRate = parseFloat($(this).find('input[name*="[tax_rate]"]').val()) || 0;
                taxTotal += unitPrice * quantity * taxRate / 100;
            });
            return taxTotal.toFixed(3);
        }

        $("#search_fee").on("keyup", function () {
            let value = $(this).val().toLowerCase();
            $("#fee tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
    });
    $('form').on('submit', function (e) {
    let total = parseFloat(sum_total_amount_with_tax()) || 0;
    let used = 0;

    $('.installment-row input[name^="installments"][name$="[installment_amount]"]').each(function () {
        used += parseFloat($(this).val()) || 0;
    });

    if (total.toFixed(3) != used.toFixed(3)) {
        e.preventDefault();
        $('#installment-warning').removeClass('d-none');
        $('html, body').animate({
            scrollTop: $('#installment-warning').offset().top - 100
        }, 400);
    }
});

</script>



@endsection
