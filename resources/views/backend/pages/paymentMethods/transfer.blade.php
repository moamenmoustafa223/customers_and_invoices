<div class="modal fade" id="transfer_payment_method_{{ $current->id }}" tabindex="-1" aria-labelledby="transferModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="transferModalLabel">{{ trans('payment_methods.transfer_between_methods') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('customers.Close') }}"></button>
            </div>

            <div class="modal-body text-start">
                <form action="{{ route('PaymentMethod.transfer') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="from_payment_method_id" value="{{ $current->id }}">

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{ trans('payment_methods.from_payment_method') }}</label>
                            <input type="text" class="form-control" value="{{ $current->name_ar }}" disabled>
                            <small class="form-text text-success">
                                {{ trans('payment_methods.current_balance') }}:
                                <strong>{{ number_format($current->balance->current_balance, 3) }}</strong>
                            </small>
                        </div>
                        

                        <div class="form-group col-md-6">
                            <label>{{ trans('payment_methods.to_payment_method') }} <b class="text-danger">*</b></label>
                            <select name="to_payment_method_id" class="form-control" required>
                                @foreach($paymentMethods as $method)
                                    @if($method->id != $current->id)
                                        <option value="{{ $method->id }}">{{ $method->name_ar }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6 mt-2">
                            <label>{{ trans('payment_methods.amount') }} <b class="text-danger">*</b></label>
                            <input type="number" step="0.001" name="amount" class="form-control" required>
                        </div>

                        <div class="form-group col-md-6 mt-2">
                            <label>{{ trans('payment_methods.transfer_date') }} <b class="text-danger">*</b></label>
                            <input type="date" name="transfer_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        

                        <div class="form-group col-md-12 mt-2">
                            <label>{{ trans('payment_methods.notes') }}</label>
                            <textarea name="notes" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="form-group col-md-12 mt-2">
                            <label>{{ trans('payment_methods.attachment') }}</label>
                            <input type="file" name="attachment" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                            <small class="text-muted">{{ trans('payment_methods.allowed_files') }}: PDF, JPG, PNG, DOC, DOCX</small>
                        </div>
                    </div>

                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{ trans('customers.Close') }}</button>
                        <button type="submit" class="btn btn-success">{{ trans('customers.Add') }}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
