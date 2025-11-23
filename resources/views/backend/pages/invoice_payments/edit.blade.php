@extends('backend.layouts.master')
@section('page_title')
    {{ trans('back.edit_invoice_payment') }}
@endsection

@section('content')
    <div>
        <a class="btn btn-primary btn-sm mb-1" href="{{ route('invoice_payments.index') }}">
            <i class="fas fa-undo"></i>
            {{ trans('back.Turn_back') }}
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <form action="{{ route('invoice_payments.update', $invoicePayment->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="invoice_id" class="font-weight-bold">{{ trans('back.invoice') }}</label>
                            <b class="text-danger">*</b>
                            <select class="form-control select2" name="invoice_id" required>
                                @foreach ($invoices as $invoice)
                                    <option value="{{ $invoice->id }}" {{ $invoicePayment->invoice_id == $invoice->id ? 'selected' : '' }}>
                                        {{ $invoice->invoice_number }} - {{ $invoice->customer->name }} ({{ number_format($invoice->total, 3) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="payment_method_id" class="font-weight-bold">{{ trans('back.payment_method') }}</label>
                            <b class="text-danger">*</b>
                            <select class="form-control select2" name="payment_method_id" required>
                                @foreach ($paymentMethods as $method)
                                    <option value="{{ $method->id }}" {{ $invoicePayment->payment_method_id == $method->id ? 'selected' : '' }}>
                                        {{ app()->getLocale() == 'ar' ? $method->name_ar : $method->name_en }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="payment_date" class="font-weight-bold">{{ trans('back.payment_date') }}</label>
                            <b class="text-danger">*</b>
                            <input type="date" name="payment_date" class="form-control"
                                value="{{ $invoicePayment->payment_date->format('Y-m-d') }}" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="amount" class="font-weight-bold">{{ trans('back.amount') }}</label>
                            <b class="text-danger">*</b>
                            <input type="number" name="amount" class="form-control" step="0.001"
                                value="{{ $invoicePayment->amount }}" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="notes_ar" class="font-weight-bold">{{ trans('back.notes_ar') }}</label>
                            <textarea name="notes_ar" class="form-control" rows="3">{{ $invoicePayment->notes_ar }}</textarea>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="notes_en" class="font-weight-bold">{{ trans('back.notes_en') }}</label>
                            <textarea name="notes_en" class="form-control" rows="3">{{ $invoicePayment->notes_en }}</textarea>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">{{ trans('back.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@endsection
