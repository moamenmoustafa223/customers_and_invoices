<!-- Convert to Invoice Modal -->
<div class="modal fade" id="convert_quotation{{ $quotation->id }}" tabindex="-1" aria-labelledby="convertModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="convertModalLabel">
                    <i class="fas fa-exchange-alt me-2"></i>
                    {{ trans('back.convert_to_invoice') }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body text-left">

                <form action="{{ route('quotations.convertToInvoice', $quotation->id) }}" method="post">
                    @csrf

                    <div class="text-center mb-4">
                        <i class="fas fa-file-invoice fa-3x text-success mb-3"></i>
                        <h4>{{ trans('back.are_you_sure_convert_to_invoice') }}</h4>
                        <p class="text-muted">{{ trans('back.convert_quotation_info') }}</p>
                    </div>

                    <div class="alert alert-info">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>{{ trans('back.quotation_number') }}:</strong>
                                <span class="badge bg-primary">{{ $quotation->quotation_number }}</span>
                            </div>
                            <div class="col-md-6">
                                <strong>{{ trans('back.customer') }}:</strong>
                                <span>{{ $quotation->customer->name }}</span>
                            </div>
                        </div>
                        <hr class="my-2">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>{{ trans('back.subtotal') }}:</strong>
                                {{ number_format($quotation->subtotal, 3) }}
                            </div>
                            <div class="col-md-3">
                                <strong>{{ trans('back.discount') }}:</strong>
                                @if ($quotation->discount > 0)
                                    <span class="text-danger">-{{ number_format($quotation->discount, 3) }}</span>
                                @else
                                    {{ number_format($quotation->discount, 3) }}
                                @endif
                            </div>
                            <div class="col-md-3">
                                <strong>{{ trans('back.tax') }}:</strong>
                                {{ number_format($quotation->tax, 3) }}
                            </div>
                            <div class="col-md-3">
                                <strong>{{ trans('back.total') }}:</strong>
                                <span class="text-danger fw-bold">{{ number_format($quotation->total, 3) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>{{ trans('back.note') }}:</strong>
                        {{ trans('back.invoice_will_create_with_one_installment') }}
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>
                            {{ trans('back.Close') }}
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check me-1"></i>
                            {{ trans('back.convert_to_invoice') }}
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
