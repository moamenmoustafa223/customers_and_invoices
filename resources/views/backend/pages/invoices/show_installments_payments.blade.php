@extends('backend.layouts.master')

@section('page_title'){{trans('back.invoice_payments_details')}} : {{$invoice->invoice_number}}@endsection

@section('content')

    <div class="row">
 
        {{--بيانات الفاتورة--}}
        <div class="col-md-12">
            <div class="card-box ">
                <h5 class="text-danger font-weight-bold">بيانات الفاتورة :</h5>
                <table class="table table-bordered text-center table-sm pb-0 mb-1">
                    <tr style="background-color: #d5eff1">
                        <th width="100">{{trans('back.invoice_number')}}</th>
                        <th width="100">{{trans('back.customer')}}</th>
                        <th width="100">{{trans('back.phone')}}</th>
                        <th width="100">{{trans('back.invoice_date')}}</th>
                        <th width="100">{{trans('back.status')}}</th>
                    </tr>
                    <tr>
                        <th>{{$invoice->invoice_number}}</th>
                        <th>{{$invoice->customer->name}}</th>
                        <th>{{$invoice->customer->phone}}</th>
                        <th>{{$invoice->invoice_date->format('Y-m-d')}}</th>
                        <th>
                            <span class="badge" style="background-color: {{ $invoice->status->color ?? '#6c757d' }}">
                                {{ app()->getLocale() == 'ar' ? $invoice->status->name_ar : $invoice->status->name_en }}
                            </span>
                        </th>
                    </tr>
                </table>
            </div>
        </div>

        {{--اضافة الدفعات المالية--}}
        <div class="col-12">
            <div class="card-box">

               <!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <form action="{{ route('invoice_payments.store') }}" method="POST" class="text-left">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="paymentModalLabel">{{ trans('back.add_payment') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('back.close') }}"></button>
                </div>
                <div class="modal-body row">
                    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                    <input type="hidden" id="total_amount" value="{{ $invoice->total - $invoice->payments->sum('amount') }}">
                    <input type="hidden" name="invoice_installment_id" id="installment_id">

                    <div class="form-group col-md-2">
                        <label>{{ trans('back.payment_amount') }} <b class="text-danger">*</b></label>
                        <input type="number" step="any" class="form-control" name="amount" id="payment_amount" required>
                    </div>

                    <div class="form-group col-md-2">
                        <label>{{ trans('back.rest_amount') }} <b class="text-danger">*</b></label>
                        <input type="number" step="any" class="form-control" name="rest_amount" id="rest_amount" readonly>
                    </div>

                    <div class="form-group col-md-3">
                        <label>{{ trans('back.payment_date') }} <b class="text-danger">*</b></label>
                        <input type="date" class="form-control" name="payment_date" id="payment_date" value="{{ date('Y-m-d') }}" required>
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
                        <label>{{ trans('back.notes') }}</label>
                        <input type="text" class="form-control" name="notes_ar" value="{{ trans('back.invoice_number') }} : {{ $invoice->invoice_number }}">
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
                                        <th>ملاحظات</th>
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
                    <span class="text-danger"> {{trans('back.total')}}: </span>
                    {{ number_format($invoice->total, 3) }}
                    )
                    -
                    (
                    <span class="text-danger"> {{trans('back.paid')}}:</span>
                    {{ number_format($invoice->payments->sum('amount'), 3) }}
                    )
                    -
                    (
                    <span class="text-danger">{{trans('back.remaining_amount')}}</span>
                    {{ number_format($invoice->total - $invoice->payments->sum('amount'), 3) }}
                    )
                </h5>
                <hr>

                {{--  الأقساط  ------ --}}
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
            @foreach($invoice->installments as $index => $installment)
                @php
                    $payments = $installment->payments ?? collect();
                    $paidAmount = $payments->sum('amount');
                    $remaining = $installment->amount - $paidAmount;
                    $isPaid = $remaining <= 0;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ number_format($installment->amount, 3) }}</td>
                    <td>{{ number_format($paidAmount, 3) }}</td>
                    <td>{{ number_format($remaining, 3) }}</td>
                    <td>{{ $installment->due_date->format('Y-m-d') }}</td>
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
                                    'amount' => number_format($p->amount, 3),
                                    'payment_method' => app()->getLocale() == 'ar' ? $p->paymentMethod->name_ar : $p->paymentMethod->name_en,
                                    'notes' => $p->notes_ar ?? $p->notes_en,
                                    'payment_date' => $p->payment_date->format('Y-m-d'),
                                    'payment_number' => $p->payment_number,
                                ];
                            });
                        @endphp

                        <div class="btn-group" role="group">
                            {{-- Show previous payments --}}
                            @foreach($payments as $payment)
                            <button type="button"
                                    class="btn btn-sm btn-dark d-flex align-items-center justify-content-between gap-1"
                                    title="تاريخ الدفع: {{ $payment->payment_date->format('Y-m-d') }}"
                                    onclick="window.open('{{ route('invoice_payment_number', $payment->payment_number) }}', '_blank')">
                                {{ number_format($payment->amount, 3) }}
                                <i class="fas fa-print ms-1"></i>
                            </button>
                        @endforeach

                            {{-- Always show the pay button --}}
                            <button type="button"
                            class="btn btn-sm btn-success pay-installment-btn"
                            data-amount="{{ $remaining }}"
                            data-rest="{{ $remaining }}"
                            data-date="{{ $installment->due_date->format('Y-m-d') }}"
                            data-id="{{ $installment->id }}"
                            data-total-amount="{{ $installment->amount }}"
                            data-payments='@json($paymentData)'
                            data-bs-toggle="modal"
                            data-bs-target="#paymentModal">
                            {{ $isPaid ? trans('back.paid') : trans('back.pay') }}
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
            $('#rest_amount').val((0).toFixed(3));
            $('#payment_date').val(date);
            $('#installment_id').val(installmentId);
            $('#total_amount').val(totalAmount);

            currentRemaining = remaining;

            // تعبئة جدول الدفعات
            const tbody = $('#installment-payments-table-body').empty();

            if (payments.length > 0) {
                payments.forEach(payment => {
                    tbody.append(`
                        <tr>
                            <td>${parseFloat(payment.amount).toFixed(3)}</td>
                            <td>${payment.payment_method}</td>
                            <td>${payment.notes || '-'}</td>
                            <td>${payment.payment_date}</td>
                            <td>
                                <a href="/invoice_payment/${payment.payment_number}" class="text-success ml-1" target="_blank" title="طباعة الإيصال">
                                    <i class="fas fa-print"></i>
                                </a>
                            </td>
                            <td>
                                <form method="POST" action="/invoice_payments/${payment.id}" onsubmit="return confirm('هل تريد حذف هذه الدفعة؟')">
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
    });
</script>

@endsection
