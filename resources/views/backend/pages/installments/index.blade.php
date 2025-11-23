@extends('backend.layouts.master')

@section('page_title')
{{ trans('back.installments') }}
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 mb-3">
        <form action="{{ route('installments.index') }}" method="GET" role="search">
            <div class="row g-2 align-items-end">

                {{-- 🔍 Search --}}
                <div class="col-md-2">
                    <label class="form-label fw-semibold small mb-1">{{ trans('back.Search') }}</label>
                    <input type="text" name="query" class="form-control form-control-sm"
                           placeholder="{{ trans('back.student') }}, {{ trans('back.phone') }}, {{ trans('back.contract_num') }}"
                           value="{{ request('query') }}">
                </div>

                {{-- ✅ Status --}}
                <div class="col-md-2">
                    <label class="form-label fw-semibold small mb-1">{{ trans('back.select_status') }}</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">{{ trans('back.select_status') }}</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>{{ trans('back.paid') }}</option>
                        <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>{{ trans('back.unpaid') }}</option>
                    </select>
                </div>

                {{-- 📅 Month --}}
                <div class="col-md-2">
                    <label class="form-label fw-semibold small mb-1">{{ trans('back.select_month') }}</label>
                    <input type="month" name="due_year_month" class="form-control form-control-sm"
                           value="{{ request('due_year_month') }}">
                </div>

                {{-- 📚 Academic Year --}}
                <div class="col-md-2">
                    <label class="form-label fw-semibold small mb-1">{{ trans('back.select_academic_year') }}</label>
                    <select name="academic_year_id" class="form-select form-select-sm">
                        <option value="">{{ trans('back.All') }}</option>
                        @foreach($academicYears as $year)
                            <option value="{{ $year->id }}" {{ request('academic_year_id') == $year->id ? 'selected' : '' }}>
                                {{ $year->academic_year }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- 🏫 Classroom --}}
                <div class="col-md-2">
                    <label class="form-label fw-semibold small mb-1">{{ trans('back.select_classroom') }}</label>
                    <select name="classroom_id" class="form-select form-select-sm">
                        <option value="">{{ trans('back.All') }}</option>
                        @foreach($classrooms as $class)
                            <option value="{{ $class->id }}" {{ request('classroom_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name_ar }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- 👥 Section --}}
                <div class="col-md-2">
                    <label class="form-label fw-semibold small mb-1">{{ trans('back.select_section') }}</label>
                    <select name="section_id" class="form-select form-select-sm">
                        <option value="">{{ trans('back.All') }}</option>
                        @foreach($sectionsList as $sec)
                            <option value="{{ $sec->id }}" {{ request('section_id') == $sec->id ? 'selected' : '' }}>
                                {{ $sec->name_ar }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- 🔎 Buttons --}}
                <div class="col-md-2 d-flex align-items-end gap-1">
                    <button class="btn btn-primary btn-sm " type="submit" title="بحث">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="{{ route('installments.index') }}" class="btn btn-success btn-sm " title="تحديث">
                        <i class="fas fa-sync-alt"></i>
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>



<div class="row">
    <div class="col-12">
        <div class="card-box">
            <div class="table-responsive">
                <table class="table table-bordered text-center table-sm">
                    <thead style="background-color:rgb(232,245,252)">
                        <tr>
                            <th>#</th>
                            <th>{{ trans('back.first_name') }}</th>
                            <th>{{ trans('back.guardian_name') }}</th>
                            <th>{{ trans('back.contract_number') }}</th>
                            <th>{{ trans('back.installment_amount') }}</th>
                            <th>{{ trans('back.paid_amount') }}</th>
                            <th>{{ trans('back.rest_amount') }}</th>
                            <th>{{ trans('back.due_date') }}</th>
                            <th>{{ trans('back.status') }}</th>
                            <th>{{ trans('back.Action') }}</th>
                            <th>{{ trans('back.created_at') }}</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach($installments as $index => $installment)
                            @php
                                $payments = $installment->payments ?? collect();
                                $paidAmount = $payments->sum('payment_amount');
                                $remaining = $installment->installment_amount - $paidAmount;
                                $isPaid = $remaining <= 0;
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
                            @php
                            $contract = $installment->studentsContract;
                            $student = $contract?->student;
                            $guardian = $student?->guardian;
                        @endphp
                        
                            <tr>
                                <td>{{ $installments->firstItem() + $index }}</td>
                                <td>{{ $student?->first_name ?? '-' }}
                                    <br>
                                    {{ $student?->phone ?? '-' }}
                                </td>
                                <td>{{ $guardian?->guardian_name ?? '-' }}
                                    <br>
                                    {{ $guardian?->phone ?? '-' }}
                                </td>
                                <td>{{ $contract?->contract_number ?? '-' }}</td>

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
                                    <div class="btn-group" role="group">
                                        @foreach($payments as $payment)
                                        <button type="button"
                                                class="btn btn-sm btn-dark d-flex align-items-center justify-content-between gap-1"
                                                title="تاريخ الدفع: {{ $payment->payment_date }}"
                                                onclick="window.open('{{ route('payment_number', $payment->payment_number) }}', '_blank')">
                                            {{ number_format($payment->payment_amount, 3) }}
                                            <i class="fas fa-print ms-1"></i>
                                        </button>
                                    @endforeach
                                    
                                    @can('add_installment')
                                        <button type="button"
                                            class="btn btn-sm btn-success pay-installment-btn"
                                            data-amount="{{ $remaining }}"
                                            data-rest="{{ $remaining }}"
                                            data-total-amount="{{ $installment->installment_amount }}"
                                            data-date="{{ $installment->due_date }}"
                                            data-id="{{ $installment->id }}"
                                            data-student-id="{{ optional($installment->studentsContract)->student_id }}"
                                            data-academic-year-id="{{ optional($installment->studentsContract)->academic_year_id }}"
                                            data-classroom-id="{{ optional($installment->studentsContract)->classroom_id }}"
                                            data-contract-id="{{ optional($installment->studentsContract)->id }}"
                                            data-payment-about="{{ trans('back.contract_number') }}: {{ optional($installment->studentsContract)->contract_number }}"
                                            data-payments='@json($paymentData)'
                                            data-bs-toggle="modal"
                                            data-bs-target="#paymentModal">
                                            {{ $isPaid ? trans('back.paid') : trans('back.pay') }}
                                        </button>
                                    @endcan

                                        @can('edit_installment')
                                        <button type="button" class="btn btn-sm btn-info edit-installment-btn {{ $isPaid ? 'd-none' : '' }}" data-id="{{ $installment->id }}" data-amount="{{ $installment->installment_amount }}" data-date="{{ $installment->due_date }}" data-bs-toggle="modal" data-bs-target="#editInstallmentModal">
                                            {{ trans('back.edit') }}
                                        </button>
                                        @endcan
                                        @can('delete_installment')
                                        <button type="button" class="btn btn-sm btn-danger delete-installment-btn {{ $isPaid ? 'd-none' : '' }}" data-id="{{ $installment->id }}" data-bs-toggle="modal" data-bs-target="#deleteInstallmentModal">
                                            {{ trans('back.Delete') }}
                                        </button>
                                        @endcan
                                    </div>
                                </td>
                                <td>{{ $installment->created_at->format('Y-m-d') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $installments->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@include('backend.pages.installments.add')
@include('backend.pages.installments.edit')
@include('backend.pages.installments.delete')
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const academicYearSelect = document.querySelector('select[name="academic_year_id"]');
        const classroomSelect = document.querySelector('select[name="classroom_id"]');
        const sectionSelect = document.querySelector('select[name="section_id"]');

        const loadingText = "{{ trans('back.Loading') }}";
        const allText = "{{ trans('back.All') }}";

        academicYearSelect.addEventListener('change', function () {
            const yearId = this.value;

            classroomSelect.innerHTML = `<option value="">${loadingText}</option>`;
            sectionSelect.innerHTML = `<option value="">${allText}</option>`;

            if (!yearId) {
                classroomSelect.innerHTML = `<option value="">${allText}</option>`;
                return;
            }

            fetch(`/get-classrooms-by-year/${yearId}`)
                .then(res => res.json())
                .then(data => {
                    classroomSelect.innerHTML = `<option value="">${allText}</option>`;
                    data.forEach(item => {
                        classroomSelect.innerHTML += `<option value="${item.id}">${item.name_ar}</option>`;
                    });
                });
        });

        classroomSelect.addEventListener('change', function () {
            const classId = this.value;
            sectionSelect.innerHTML = `<option value="">${loadingText}</option>`;

            if (!classId) {
                sectionSelect.innerHTML = `<option value="">${allText}</option>`;
                return;
            }

            fetch(`/get-sections-by-classroom/${classId}`)
                .then(res => res.json())
                .then(data => {
                    sectionSelect.innerHTML = `<option value="">${allText}</option>`;
                    data.forEach(item => {
                        sectionSelect.innerHTML += `<option value="${item.id}">${item.name_ar}</option>`;
                    });
                });
        });
    });
</script>

<script>
let currentRemaining = 0; // المتبقي الحقيقي من قاعدة البيانات

$('body').on('click', '.pay-installment-btn', function () {
    const $btn = $(this);

    const remaining = parseFloat($btn.data('rest')) || 0;
    currentRemaining = remaining;

    // ✅ تعبئة قيمة الدفع بالقيمة المتبقية
    $('#payment_amount').val(remaining.toFixed(3));

    // ✅ الباقي يجب أن يكون صفر عند ملء كل المتبقي
    $('#rest_amount').val((currentRemaining - remaining).toFixed(3));

    // تعبئة باقي الحقول كما هو:
    $('#payment_date').val($btn.data('date'));
    $('#installment_id').val($btn.data('id'));
    $('#total_amount_with_tax').val(parseFloat($btn.data('total-amount')) || 0);

    $('#modal_student_id').val($btn.data('student-id'));
    $('#modal_academic_year_id').val($btn.data('academic-year-id'));
    $('#modal_classroom_id').val($btn.data('classroom-id'));
    $('#modal_contract_id').val($btn.data('contract-id'));
    $('#payment_about').val($btn.data('payment-about'));

    // تعبئة جدول الدفعات
    const payments = $btn.data('payments') || [];
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

// ✅ حساب حي للباقي عند تعديل المستخدم قيمة الدفع
$('form').on('keyup change', '#payment_amount', function () {
    const entered = parseFloat($(this).val()) || 0;
    const rest = currentRemaining - entered;

    $('#rest_amount').val(rest.toFixed(3));
});


    
    $('body').on('click', '.edit-installment-btn', function () {
    const id = $(this).data('id');
    const amount = $(this).data('amount');
    const date = $(this).data('date');

    $('#edit_installment_id').val(id);
    $('#edit_installment_amount').val(parseFloat(amount).toFixed(3));
    $('#edit_due_date').val(date);

    const actionUrl = "{{ route('installments.update', ':id') }}".replace(':id', id);
    $('#editInstallmentForm').attr('action', actionUrl);
    $('#editInstallmentModal').modal('show');
});

// زر الحذف
$('body').on('click', '.delete-installment-btn', function () {
    const id = $(this).data('id');
    $('#delete_installment_id').val(id);

    const actionUrl = "{{ route('installments.destroy', ':id') }}".replace(':id', id);
    $('#deleteInstallmentForm').attr('action', actionUrl);
    $('#deleteInstallmentModal').modal('show');
});
    </script>
    @endsection