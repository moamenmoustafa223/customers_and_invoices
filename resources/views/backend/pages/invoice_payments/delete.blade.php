<div class="modal fade" id="delete_invoice_payment{{ $payment->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('back.delete_invoice_payment') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('invoice_payments.destroy', $payment->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="text-center">
                        <h4>{{ trans('back.are_you_sure') }}</h4>
                        <p><strong>{{ trans('back.payment_number') }}:</strong> {{ $payment->payment_number }}</p>
                        <p><strong>{{ trans('back.amount') }}:</strong> {{ number_format($payment->amount, 3) }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{ trans('back.close') }}</button>
                        <button type="submit" class="btn btn-danger">{{ trans('back.delete') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
