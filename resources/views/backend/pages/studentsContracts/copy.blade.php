@extends('backend.layouts.master')

@section('page_title')
    {{trans('back.copy_studentsContract')}} :
    {{$studentsContract->contract_number}}
@endsection


@section('content')

    <div class="row ">
        <div class="col-sm-4">
            <a href="{{route('studentsContracts.index')}}" class="btn btn-info btn-xs mb-1">
                {{trans('back.studentsContracts')}}
            </a>

            @can('student_add')
                <a class="btn btn-success btn-xs mb-1" href="{{route('students.create')}}">
                    <i class="mdi mdi-plus"></i>
                    {{trans('back.student_add')}}
                </a>
            @endcan

            @can('add_tuition_fee')
                <a class="btn btn-primary btn-xs mb-1" href="" data-bs-toggle="modal" data-bs-target="#add_tuition_fee">
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

                    <input type="hidden" name="contract_number" value="{{$studentsContract->contract_number}}">

                    <div class="row">
                        {{--الطالب--}}
                        <div class="form-group col-md-3">
                            <label for="student_id" class="font-weight-bold" > {{trans('back.select_student')}} </label>
                            <b class="text-danger">*</b>
                            <select class="form-control select2" name="student_id" required>
                                <option selected disabled value=""> {{trans('back.Select')}} </option>
                                @foreach(App\Models\Student::all() as $student)
                                    <option value="{{ $student->id}}" @if($student->id == $studentsContract->student_id) selected @endif>
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
                                    <option value="{{ $academicYear->id }}" @if($academicYear->id == $studentsContract->academic_year_id) selected @endif>
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
                                @foreach(App\Models\Classroom::all() as $classroom)
                                    <option value="{{ $classroom->id}}" @if($classroom->id == $studentsContract->classroom_id) selected @endif>
                                        {{ app()->getLocale() == 'ar' ? $classroom->name_ar : $classroom->name_en }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{--الشعبة--}}
                        <div class="form-group col-md-3">
                            <label for="section_id" class="font-weight-bold"> {{trans('back.section')}} </label>
                            <select class="form-control select2 Section" name="section_id" required>
                                <option value=""> {{trans('back.select')}} </option>
                                @foreach(App\Models\Section::all() as $section)
                                    <option value="{{ $section->id}}" @if($section->id == $studentsContract->section_id) selected @endif>
                                        {{ app()->getLocale() == 'ar' ? $section->name_ar : $section->name_en }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{--الحافلة--}}
                        <div class="form-group col-md-4">
                            <label for="bus_id" class="font-weight-bold" > {{trans('back.bus')}} </label>
                            <select class="form-control select2" name="bus_id" >
                                <option selected disabled value=""> {{trans('back.Select')}} </option>
                                @foreach(App\Models\Bus::all() as $bus)
                                    <option value="{{ $bus->id}}" @if($bus->id == $studentsContract->bus_id) selected @endif>
                                        {{ $bus->bus_number }} / {{ $bus->bus_driver }} / / {{ $bus->bus_driver_phone }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        {{--تاريخ العقد--}}
                        <div class="form-group col-md-4">
                            <label for="contract_date">{{trans('back.contract_date')}}</label>
                            <b class="text-danger">*</b>
                            <input type="date" class="form-control" placeholder="{{trans('back.contract_date')}}" name="contract_date" value="{{$studentsContract->contract_date}}" required>
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
                                            <th width="150">{{ trans('back.tuition_fee') }}</th>
                                            <th width="50">{{ trans('back.price') }}</th>
                                            <th width="50">{{ trans('back.quantity') }}</th>
                                            <th width="50">{{ trans('back.tax_rate') }} (%)</th>
                                            <th width="50">{{ trans('back.total') }}</th>
                                            <th width="50">{{ trans('back.Add') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody id="fee">
                                        @foreach(App\Models\TuitionFee::all() as $tuition_fee)
                                            @php
                                                $isAdded = in_array($tuition_fee->id, $studentsContract->TuitionFees->pluck('id')->toArray());
                                                $price = $tuition_fee->price;
                                                $quantity = $tuition_fee->quantity ?? 1;
                                                $tax_rate = $tuition_fee->tax_rate ?? 0;
                                                $total = $price * $quantity + ($price * $quantity * $tax_rate / 100);
                                            @endphp
                                            <tr>
                                                <td>{{ app()->getLocale() == 'ar' ? $tuition_fee->name_ar : $tuition_fee->name_en }}</td>
                                                <td>{{ number_format($price, 2) }}</td>
                                                <td>{{ $quantity }}</td>
                                                <td>{{ $tax_rate }}%</td>
                                                <td>{{ number_format($total, 2) }}</td>
                                                <td>
                                                    <a href="#"
                                                       id="fee-{{ $tuition_fee->id }}"
                                                       data-name="{{ app()->getLocale() == 'ar' ? $tuition_fee->name_ar : $tuition_fee->name_en }}"
                                                       data-id="{{ $tuition_fee->id }}"
                                                       data-price="{{ $price }}"
                                                       data-quantity="{{ $quantity }}"
                                                       data-taxrate="{{ $tax_rate }}"
                                                       data-total="{{ $total }}"
                                                       type="submit"
                                                       class="btn {{ $isAdded ? 'btn-secondary disabled' : 'btn-success' }} btn-xs add-fee-btn">
                                                        <i class="fas fa-plus"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
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
                                    <input type="number" class="form-control form-control-sm sub_total font-weight-bold text-center text-danger"
                                           placeholder="{{trans('back.sub_total')}}" name="sub_total" step="any" value="{{$studentsContract->sub_total}}" readonly>
                                </div>

                                {{--الخصم--}}
                                <div class="form-group col-md-3 text-center pb-0 mb-1">
                                    <label for="discount " class="font-weight-bold"> {{trans('invoices.discount')}}</label>
                                    <input type="number" name="discount" class="form-control form-control-sm discount font-weight-bold text-center text-danger"
                                           step="any" value="{{$studentsContract->discount}}" >
                                </div>

                                {{--المبلغ بعد الخصم--}}
                                <div class="form-group col-md-3 text-center pb-0 mb-1">
                                    <label for="amount_after_discount" class="font-weight-bold">{{trans('invoices.amount_after_discount')}}</label>
                                    <input type="number" name="amount_after_discount" class="form-control form-control-sm amount_after_discount font-weight-bold text-center text-danger"
                                           step="any" value="{{$studentsContract->amount_after_discount}}"  readonly>
                                </div>

                                {{--قيمة الضريبة--}}
                                <div class="form-group col-md-3">
                                    <label for="tax_value">{{ trans('back.tax_value') }}</label>
                                    <input type="number" class="form-control tax_value" name="tax_value" readonly value="{{ $studentsContract->tax_value }}">
<input type="hidden" class="original-tax" value="{{ $studentsContract->tax_value }}">
                                </div>
                                

                                {{--المبلغ شامل الضريبة--}}
                                <div class="form-group col-md-5" >
                                    <label for="total_amount_with_tax">{{trans('back.total_amount_with_tax')}}</label>
                                    <b class="text-danger">*</b>
                                    <input type="number" class="form-control form-control-sm total_amount_with_tax font-weight-bold text-center text-danger"
                                           name="total_amount_with_tax" step="any" value="{{$studentsContract->total_amount_with_tax}}" readonly>
                                </div>

                                <div class="form-group col-md-5">
                                    <button type="submit" class="btn btn-success w-100 btn-sm btn-block" style="margin-top:23px">  {{trans('back.create_contract')}}</button>
                                </div>
                            </div>

                            {{--  تفاصيل الطلب للخدمات --}}
                            <div class="card-box pt-1 pb-0 mb-2" style="background-color: #d9fce9">
                                <h5 class="mt-2">{{ trans('back.tuition_fees_details') }} </h5>
                                <div class="table-responsive">
                                    <table id="cart" class="table table-bordered table-sm text-center">
                                        <thead>
                                        <tr>
                                            <th width="100">{{trans('back.tuition_fee')}}</th>
                                            <th width="50">{{trans('back.unit_price')}}</th>
                                            <th width="50">{{trans('back.Delete')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody class="fee-list">
                                        @foreach($studentsContract->TuitionFees as $tuitionFee)
                                        <tr>
                                            <td>{{ $tuitionFee->pivot->name }}</td>
                                            <td class="fee_price">{{ $tuitionFee->pivot->price }}</td>
                                        
                                            <input type="hidden" name="fees[{{ $tuitionFee->id }}][name]" value="{{ $tuitionFee->pivot->name }}">
                                            <input type="hidden" name="fees[{{ $tuitionFee->id }}][price]" value="{{ $tuitionFee->pivot->price }}">
                                            <input type="hidden" name="fees[{{ $tuitionFee->id }}][quantity]" value="{{ $tuitionFee->pivot->quantity }}">
                                            <input type="hidden" name="fees[{{ $tuitionFee->id }}][tax_rate]" value="{{ $tuitionFee->pivot->tax_rate }}">
                                            <input type="hidden" class="original-fee" value="1">
                                        
                                            <td>
                                                <button type="button" class="btn btn-danger btn-xs remove-fee-btn" data-id="{{ $tuitionFee->id }}">
                                                    <i class="fa fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                            <h5 class="mt-2">{{trans('back.installments')}}:</h5>
                            <div id="installments-container">
                                @foreach($studentsContract->installments as $index => $installment)
                                    <div class="installment-row row mb-2">
                                        <div class="col-md-3">
                                            <label>{{ trans('back.installment_amount') }} </label>
                                            <input type="number" name="installments[{{ $index }}][installment_amount]" class="form-control installment_amount" step="any" value="{{ $installment->installment_amount }}" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label>{{ trans('back.rest_amount') }} </label>
                                            <input type="number" name="installments[{{ $index }}][rest_amount]" class="form-control rest_amount" step="any" value="{{ $installment->rest_amount }}" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label> {{ trans('back.due_date') }} </label>
                                            <input type="date" name="installments[{{ $index }}][due_date]" class="form-control" value="{{ $installment->due_date }}" required>
                                        </div>
                                        <div class="col-md-3 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-sm remove-installment-btn">
                                                <i class="fa fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-sm btn-primary" id="add-installment-btn">  {{trans('back.add_installment')}} </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                            <div class="row">

                                {{--شروط العقد--}}
                                <div class="col-md-6">
                                    <label for="notes">{{trans('back.contract_terms_ar')}}</label>
                                    <textarea name="contract_terms_ar" class="form-control editor" cols="30" rows="4">{{$studentsContract->contract_terms_ar}}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="notes">{{trans('back.contract_terms_en')}}</label>
                                    <textarea name="contract_terms_en" class="form-control editor" cols="30" rows="4">{{$studentsContract->contract_terms_en}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    </@endsection

    @section('js')
    <script>
        $(document).ready(function () {
            let installmentIndex = $('.installment-row').length;
    
            // ---------- Search Filter ----------
            $("#search_fee").on("keyup", function () {
                let value = $(this).val().toLowerCase();
                $("#fee tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
    
            // ---------- Dynamic Classroom & Section ----------
            $('.Academic_year').change(function () {
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
                            $(".Classroom").append('<option value="' + value.id + '">' + value.name_ar + '</option>');
                        });
                    }
                });
            });
    
            $('.Classroom').change(function () {
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
                            $(".Section").append('<option value="' + value.id + '">' + value.name_ar + '</option>');
                        });
                    }
                });
            });
    
            // ---------- Add Fee ----------
            $('.add-fee-btn').on('click', function (e) {
                e.preventDefault();
    
                let name = $(this).data('name');
                let id = $(this).data('id');
                let price = parseFloat($(this).data('price')) || 0;
                let quantity = parseFloat($(this).data('quantity')) || 1;
                let taxRate = parseFloat($(this).data('taxrate')) || 0;
    
                let html = `<tr>
                    <td>${name}</td>
                    <td class="fee_price">${price.toFixed(2)}</td>
                    <input type="hidden" name="fees[${id}][name]" value="${name}">
                    <input type="hidden" name="fees[${id}][price]" value="${price}">
                    <input type="hidden" name="fees[${id}][quantity]" value="${quantity}">
                    <input type="hidden" name="fees[${id}][tax_rate]" value="${taxRate}">
                    <td>
                        <button type="button" class="btn btn-danger btn-xs remove-fee-btn" data-id="${id}">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>`;
    
                $('.fee-list').append(html);
                $(this).removeClass('btn-success').addClass('btn-secondary disabled');
                recalculateAll();
            });
    
            // ---------- Remove Fee ----------
            $('body').on('click', '.remove-fee-btn', function (e) {
                e.preventDefault();
                let id = $(this).data('id');
                $(this).closest('tr').remove();
                $('#fee-' + id).removeClass('btn-secondary disabled').addClass('btn-success');
                recalculateAll();
            });
    
            // ---------- Add Installment ----------
            $('#add-installment-btn').on('click', function () {
                let html = `
                    <div class="installment-row row mb-2">
                        <div class="col-md-3">
                            <label>مبلغ القسط</label>
                            <input type="number" name="installments[${installmentIndex}][installment_amount]" class="form-control installment_amount" step="any" required>
                        </div>
                        <div class="col-md-3">
                            <label>المبلغ المتبقي</label>
                            <input type="number" name="installments[${installmentIndex}][rest_amount]" class="form-control rest_amount" step="any" value="0.000" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>تاريخ الاستحقاق</label>
                            <input type="date" name="installments[${installmentIndex}][due_date]" class="form-control" required>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="button" class="btn btn-danger btn-sm remove-installment-btn">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>`;
                $('#installments-container').append(html);
                installmentIndex++;
                updateInstallmentsRest();
            });
    
            // ---------- Remove Installment ----------
            $('body').on('click', '.remove-installment-btn', function () {
                $(this).closest('.installment-row').remove();
                updateInstallmentsRest();
            });
    
            // ---------- Recalculate on discount or tax change ----------
            $('body').on('keyup blur change', '.discount, .tax', function () {
                recalculateAll();
            });
    
            // ---------- Recalculate Installment Logic ----------
            $('body').on('input', 'input[name^="installments"][name$="[installment_amount]"]', function () {
                updateInstallmentsRest();
            });
    
            // ---------- Helpers ----------
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
                let totalTax = 0;
                $('.fee-list tr').each(function () {
                    let price = parseFloat($(this).find('input[name*="[price]"]').val()) || 0;
                    let quantity = parseFloat($(this).find('input[name*="[quantity]"]').val()) || 1;
                    let taxRate = parseFloat($(this).find('input[name*="[tax_rate]"]').val()) || 0;
                    totalTax += (price * quantity * taxRate / 100);
                });
                return totalTax.toFixed(3);
            }
    
            function sum_total_amount_with_tax() {
                let afterDiscount = parseFloat($('.amount_after_discount').val()) || 0;
                let tax = parseFloat($('.tax_value').val()) || 0;
                return (afterDiscount + tax).toFixed(3);
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
                    if (rest < 0) {
                        amountInput.addClass('is-invalid');
                        restInput.val('0.000');
                    } else {
                        amountInput.removeClass('is-invalid');
                        restInput.val(rest.toFixed(3));
                    }
                });
            }
        });
    </script>
    @endsection
    
