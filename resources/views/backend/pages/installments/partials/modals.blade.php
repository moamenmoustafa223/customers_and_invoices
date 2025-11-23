{{-- Payment Modal --}}
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('payments.store') }}" method="POST" class="text-left" id="paymentForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="paymentModalLabel">{{ trans('back.add_payment') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('back.close') }}"></button>
                </div>

                <div class="modal-body row">
                    {{-- Hidden fields --}}
                    <input type="hidden" name="student_id" id="modal_student_id">
                    <input type="hidden" name="academic_year_id" id="modal_academic_year_id">
                    <input type="hidden" name="classroom_id" id="modal_classroom_id">
                    <input type="hidden" name="students_contract_id" id="modal_contract_id">
                    <input type="hidden" id="total_amount_with_tax">
                    <input type="hidden" name="installment_id" id="installment_id">
                    
                    

                    {{-- Payment fields --}}
                    <div class="form-group col-md-2">
                        <label>{{ trans('back.payment_amount') }} <b class="text-danger">*</b></label>
                        <input type="number" step="any" class="form-control" name="payment_amount" id="payment_amount" required>
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
                            @foreach(App\Models\Payment_method::all() as $method)
                                <option value="{{ $method->id }}">
                                    {{ app()->getLocale() == 'ar' ? $method->name_ar : $method->name_en }}
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
                        <input type="text" class="form-control" name="payment_about" id="payment_about">
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> {{ trans('back.Add') }}
                        </button>
                    </div>

                    <div class="col-md-12">
                        <hr>
                        <h5 class="text-primary">{{ trans('back.previous_payments') }}</h5>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered text-center mb-0">
                                <thead style="background:#f3f9fc;">
                                    <tr>
                                        <th>{{ trans('back.amount') }}</th>
                                        <th>{{ trans('back.payment_method') }}</th>
                                        <th>{{ trans('back.about') }}</th>
                                        <th>{{ trans('back.date') }}</th>
                                        <th>{{ trans('back.status') }}</th>
                                        <th>{{ trans('back.delete') }}</th>
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

{{-- Include Edit and Delete Modals if needed --}}

<script>
$('body').on('click', '.pay-installment-btn', function () {
    const $btn = $(this);

    const installmentAmount = parseFloat($btn.data('total-amount')) || 0;

    $('#payment_amount').val(installmentAmount.toFixed(3));
    $('#rest_amount').val(0); // مباشرة نحسب الباقي عند إدخال المستخدم للمبلغ

    // تعبئة الحقول الأخرى كما كنت تفعل سابقًا
    $('#payment_date').val($btn.data('date'));
    $('#installment_id').val($btn.data('id'));
    $('#total_amount_with_tax').val(installmentAmount);

    $('#modal_student_id').val($btn.data('student-id'));
    $('#modal_academic_year_id').val($btn.data('academic-year-id'));
    $('#modal_classroom_id').val($btn.data('classroom-id'));
    $('#modal_contract_id').val($btn.data('contract-id'));
    $('#payment_about').val($btn.data('payment-about'));

    // تعبئة جدول الدفعات السابقة
    const payments = $btn.data('payments') || [];
    const tbody = $('#installment-payments-table-body');
    tbody.empty();

    if (payments.length > 0) {
        payments.forEach(payment => {
            tbody.append(`
                <tr>
                    <td>${parseFloat(payment.payment_amount).toFixed(3)}</td>
                    <td>${payment.payment_method}</td>
                    <td>${payment.payment_about}</td>
                    <td>${payment.payment_date}</td>
                    <td><span class="badge bg-info">تم الدفع</span></td>
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

// الحساب الحي للباقي
$('form').on('keyup change', '#payment_amount', function () {
    const total = parseFloat($('#total_amount_with_tax').val()) || 0;
    const paid = parseFloat($(this).val()) || 0;
    const remaining = total - paid;

    $('#rest_amount').val(remaining.toFixed(3));
});

</script>
