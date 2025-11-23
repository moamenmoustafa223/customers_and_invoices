@extends('backend.layouts.master')

@section('page_title'){{trans('back.contract_Payments_Details_no')}} :{{$studentsContract->contract_number}}@endsection

@section('content')

    <div class="row">

        {{--بيانات الطالب--}}
        <div class="col-md-12">
            <div class="card-box ">
                <h5 class="text-danger font-weight-bold">بيانات الطالب :</h5>
                <table class="table table-bordered text-center table-sm pb-0 mb-1">
                    <tr style="background-color: #d5eff1">
                        <th width="100">{{trans('back.student')}}</th>
                        <th width="100">{{trans('back.phone')}}</th>
                        <th width="100">{{trans('back.academic_year')}}</th>
                        <th width="100">{{trans('back.classroom')}}</th>
                        <th width="100">{{trans('back.section')}}</th>
                    </tr>
                    <tr>
                        <th>{{$studentsContract->Student->first_name}} {{$studentsContract->Student->father_name}} {{$studentsContract->Student->grandfather_name}}</th>
                        <th>{{$studentsContract->Student->Guardian->phone}}</th>
                        <th>{{$studentsContract->AcademicYear->academic_year}}</th>
                        <th>{{app()->getLocale() == 'ar' ? $studentsContract->Classroom->name_ar : $studentsContract->Classroom->name_en}}</th>
                        <th>{{app()->getLocale() == 'ar' ? $studentsContract->Section->name_ar : $studentsContract->Section->name_en}}</th>
                    </tr>
                </table>
            </div>
        </div>

        {{--اضافة الدفعات المالية--}}
        <div class="col-12">
            <div class="card-box">
                {{-- اضافة دفعة جديدة --}}
               

               <!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            
            <form action="{{ route('payments.store') }}" method="POST" class="text-left">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="paymentModalLabel">{{ trans('back.add_payment') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('back.close') }}"></button>
                </div>
                <div class="modal-body row">
                    <input type="hidden" name="student_id" value="{{ $studentsContract->Student->id }}">
                    <input type="hidden" name="academic_year_id" value="{{ $studentsContract->AcademicYear->id }}">
                    <input type="hidden" name="classroom_id" value="{{ $studentsContract->Classroom->id }}">
                    <input type="hidden" name="students_contract_id" value="{{ $studentsContract->id }}">
                    <input type="hidden" id="total_amount_with_tax" value="{{ $studentsContract->total_amount_with_tax - $studentsContract->Payments->sum('payment_amount') }}">
                    <input type="hidden" name="installment_id" id="installment_id">

                    <div class="form-group col-md-2">
                        <label>{{ trans('back.payment_amount') }} <b class="text-danger">*</b></label>
                        <input type="number" step="any" class="form-control" name="payment_amount" id="payment_amount">
                    </div>

                    <div class="form-group col-md-2">
                        <label>{{ trans('back.rest_amount') }} <b class="text-danger">*</b></label>
                        <input type="number" step="any" class="form-control" name="rest_amount" id="rest_amount" readonly>
                    </div>

                    <div class="form-group col-md-3">
                        <label>{{ trans('back.payment_date') }} <b class="text-danger">*</b></label>
                        <input type="date" class="form-control" name="payment_date" id="payment_date" value="{{ date('Y-m-d') }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label>{{ trans('back.select_payment_method') }} <b class="text-danger">*</b></label>
                        <select class="form-control" name="payment_method_id" required>
                            <option value="">{{ trans('back.select_payment_method') }}</option>
                            @foreach(App\Models\Payment_method::all() as $payment_method)
                                <option value="{{ $payment_method->id }}">
                                    {{ app()->getLocale() == 'ar' ? $payment_method->name_ar : $payment_method->name_en }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label>{{ trans('back.check_number_if_any') }}</label>
                        <input type="text" class="form-control" name="check_number" placeholder="{{ trans('back.check_number') }}">
                    </div>

                    <div class="form-group col-md-12 mt-2">
                        <label>{{ trans('back.payment_about') }}</label>
                        <input type="text" class="form-control" name="payment_about" value="{{ trans('back.contract_number') }} : {{ $studentsContract->contract_number }}">
                    </div>
                    <div class="text-end">

                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> {{ trans('back.Add') }}
                        </button>
                    </div>
                    <div class="col-md-12">
                        <hr>
                        <h5 class="text-primary">الدفعات السابقة لهذا القسط:</h5>
                    
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered text-center mb-0">
                                <thead style="background:#f3f9fc;">
                                    <tr>
                                        <th>المبلغ</th>
                                        <th>الحساب المالى</th>
                                        <th>وذلك عن</th>
                                        <th>تاريخ الدفع</th>
                                        <th>إجراء</th>
                                        <th>حــذف</th>
                                    </tr>
                                </thead>
                                <tbody id="installment-payments-table-body">
                                    <tr><td colspan="6" class="text-muted">لا توجد دفعات</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">{{ trans('back.cancel') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>


                <hr>
                {{--  الخلاصة --}}
                <h5 class="text-center">
                    (
                    <span class="text-danger"> {{trans('back.total_amount')}}: </span>
                    {{ number_format($studentsContract->total_amount_with_tax, 3) }}
                    )
                    -
                    (
                    <span class="text-danger"> {{trans('back.paid')}}:</span>
                    {{ number_format($studentsContract->Payments->sum('payment_amount'), 3) }}
                    )
                    -
                    (
                    <span class="text-danger">{{trans('back.rest_amount')}}</span>
                    {{ number_format($studentsContract->total_amount_with_tax  - $studentsContract->payments->sum('payment_amount'), 3) }}
                    )
                </h5>
                <hr>

                {{--  الدفعات  ------ --}}
{{-- الأقساط --}}
<h4 class="text-danger font-weight-bold">{{ trans('back.installments') }}:</h4>

<div class="table-responsive">
    <table class="table table-bordered text-center table-sm">
        <thead>
            <tr style="background-color:rgb(232,245,252)">
                <th>#</th>
                <th>{{ trans('back.installment_amount') }}</th>
                <th>{{ trans('back.paid_amount') }}</th>
                <th>{{ trans('back.rest_amount') }}</th>
                <th>{{ trans('back.due_date') }}</th>
                <th>{{ trans('back.status') }}</th>
                <th>{{ trans('back.action') }}</th>
                <th>{{ trans('back.created_at') }}</th>
            </tr>
        </thead>
        
        <tbody>
            @foreach($studentsContract->installments as $index => $installment)
                @php
                    $payments = $installment->payments ?? collect(); // Ensure it's a collection
                    $paidAmount = $payments->sum('payment_amount');
                    $remaining = $installment->installment_amount - $paidAmount;
                    $isPaid = $remaining <= 0;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ number_format($installment->installment_amount, 3) }}</td>
                    <td>{{ number_format($paidAmount, 3) }}</td>
                    <td>{{ number_format($remaining, 3) }}</td>
                    <td>{{ $installment->due_date }}</td>
                    <td>
                        @if($isPaid)
                            <span class="badge bg-success">{{ trans('back.paid') }}</span>
                        @else
                            <span class="badge bg-warning text-dark">{{ trans('back.unpaid') }}</span>
                        @endif
                    </td>
                    <td>
                        @php
                            $paymentData = $payments->map(function ($p) {
                                return [
                                    'id' => $p->id,
                                    'payment_amount' => number_format($p->payment_amount, 3),
                                    'payment_method' => app()->getLocale() == 'ar' ? $p->Payment_method->name_ar : $p->Payment_method->name_en,
                                    'payment_about' => $p->payment_about,
                                    'payment_date' => $p->payment_date,
                                    'payment_number' => $p->payment_number,
                                ];
                            });
                        @endphp
                    
                        <div class="btn-group" role="group">
                            {{-- Show previous payments --}}
                            @foreach($payments as $payment)
                            <button type="button"
                                    class="btn btn-sm btn-dark d-flex align-items-center justify-content-between gap-1"
                                    title="تاريخ الدفع: {{ $payment->payment_date }}"
                                    onclick="window.open('{{ route('payment_number', $payment->payment_number) }}', '_blank')">
                                {{ number_format($payment->payment_amount, 3) }}
                                <i class="fas fa-print ms-1"></i>
                            </button>
                        @endforeach
                    
                            {{-- Always show the pay button --}}
                            <button type="button"
                            class="btn btn-sm btn-success pay-installment-btn"
                            data-amount="{{ $remaining }}"
                            data-rest="{{ $remaining }}"
                            data-date="{{ $installment->due_date }}"
                            data-id="{{ $installment->id }}"
                            data-total-amount="{{ $installment->installment_amount }}"
                            data-payments='@json($paymentData)'
                            data-bs-toggle="modal"
                            data-bs-target="#paymentModal">
                            {{ $isPaid ? trans('back.paid') : trans('back.pay') }}
                        </button>
                        
                    
                            {{-- Edit Button - Hidden if paid --}}
                            <button type="button"
                                    class="btn btn-sm btn-info edit-installment-btn {{ $isPaid ? 'd-none' : '' }}"
                                    data-id="{{ $installment->id }}"
                                    data-amount="{{ $installment->installment_amount }}"
                                    data-date="{{ $installment->due_date }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editInstallmentModal">
                                {{ trans('back.edit') }}
                            </button>
                    
                            {{-- Delete Button - Hidden if paid --}}
                            <button type="button"
                                    class="btn btn-sm btn-danger delete-installment-btn {{ $isPaid ? 'd-none' : '' }}"
                                    data-id="{{ $installment->id }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteInstallmentModal">
                                {{ trans('back.Delete') }}
                            </button>
                        </div>
                    </td>
                    
                    
                    <td>{{ $installment->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
            </tbody>
            
            
            
    </table>
</div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="editInstallmentModal" tabindex="-1" aria-labelledby="editInstallmentLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('installments.update', 0) }}" id="editInstallmentForm">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title">{{ trans('back.edit_installment') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body row">
                        <input type="hidden" name="id" id="edit_installment_id">
                        
                        <div class="form-group col-md-6">
                            <label>{{ trans('back.installment_amount') }}</label>
                            <input type="number" step="0.001" name="installment_amount" id="edit_installment_amount" class="form-control" required>
                        </div>
    
                        <div class="form-group col-md-6">
                            <label>{{ trans('back.due_date') }}</label>
                            <input type="date" name="due_date" id="edit_due_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">{{ trans('back.save_changes') }}</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('back.cancel') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="deleteInstallmentModal" tabindex="-1" aria-labelledby="deleteInstallmentLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="" id="deleteInstallmentForm">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">{{ trans('back.confirm_delete') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ trans('back.confirm_delete_message') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="submit">{{ trans('back.delete') }}</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('back.cancel') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
<script>
    let currentRemaining = 0;
    
    $(document).ready(function () {
        // ✅ فتح مودال الدفع وتعبئة البيانات
        $('body').on('click', '.pay-installment-btn', function () {
            const $btn = $(this);
    
            const amount = parseFloat($btn.data('amount')) || 0;
            const remaining = parseFloat($btn.data('rest')) || 0;
            const date = $btn.data('date');
            const installmentId = $btn.data('id');
            const totalAmount = parseFloat($btn.data('total-amount')) || 0;
    
            const payments = $btn.data('payments') || [];
    
            // تعبئة الحقول
            $('#payment_amount').val(remaining.toFixed(3));
            $('#rest_amount').val((0).toFixed(3)); // لأنه سيتم دفع الكل
            $('#payment_date').val(date);
            $('#installment_id').val(installmentId);
            $('#total_amount_with_tax').val(totalAmount);
    
            $('#modal_student_id').val($btn.data('student-id'));
            $('#modal_academic_year_id').val($btn.data('academic-year-id'));
            $('#modal_classroom_id').val($btn.data('classroom-id'));
            $('#modal_contract_id').val($btn.data('contract-id'));
            $('#payment_about').val($btn.data('payment-about'));
    
            currentRemaining = remaining;
    
            // تعبئة جدول الدفعات
            const tbody = $('#installment-payments-table-body').empty();
    
            if (payments.length > 0) {
                payments.forEach(payment => {
                    tbody.append(`
                        <tr>
                            <td>${parseFloat(payment.payment_amount).toFixed(3)}</td>
                            <td>${payment.payment_method}</td>
                            <td>${payment.payment_about}</td>
                            <td>${payment.payment_date}</td>
                            <td>
                                <a href="/payment/${payment.payment_number}" class="text-success ml-1" target="_blank" title="طباعة الإيصال">
                                    <i class="fas fa-print"></i>
                                </a>
                            </td>
                            <td>
                                <form method="POST" action="/payments/${payment.id}" onsubmit="return confirm('هل تريد حذف هذه الدفعة؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                                </form>
                            </td>
                        </tr>
                    `);
                });
            } else {
                tbody.html(`<tr><td colspan="6" class="text-muted">لا توجد دفعات</td></tr>`);
            }
    
            $('#paymentModal').modal('show');
        });
    
        // ✅ حساب الباقي عند تعديل قيمة الدفع
        $('form').on('keyup change', '#payment_amount', function () {
            const entered = parseFloat($(this).val()) || 0;
            const rest = currentRemaining - entered;
            $('#rest_amount').val(rest.toFixed(3));
        });
    
        // ✅ فتح مودال تعديل القسط
        $('body').on('click', '.edit-installment-btn', function () {
            const id = $(this).data('id');
            const amount = parseFloat($(this).data('amount')) || 0;
            const date = $(this).data('date');
    
            $('#edit_installment_id').val(id);
            $('#edit_installment_amount').val(amount.toFixed(3));
            $('#edit_due_date').val(date);
    
            const actionUrl = "{{ route('installments.update', ':id') }}".replace(':id', id);
            $('#editInstallmentForm').attr('action', actionUrl);
            $('#editInstallmentModal').modal('show');
        });
    
        // ✅ فتح مودال الحذف
        $('body').on('click', '.delete-installment-btn', function () {
            const id = $(this).data('id');
    
            $('#delete_installment_id').val(id);
            const actionUrl = "{{ route('installments.destroy', ':id') }}".replace(':id', id);
            $('#deleteInstallmentForm').attr('action', actionUrl);
            $('#deleteInstallmentModal').modal('show');
        });
    });
    </script>
    
    {{-- نهاية حساب المبلغ الباقي عند دفع مبلغ--}}
@endsection
