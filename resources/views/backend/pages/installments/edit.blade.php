<!-- Edit Installment Modal -->
<div class="modal fade" id="editInstallmentModal" tabindex="-1" aria-labelledby="editInstallmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('installments.update', 0) }}" id="editInstallmentForm">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title" id="editInstallmentModalLabel">{{ trans('back.edit_installment') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('back.close') }}"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_installment_id">
                    
                    <div class="form-group mb-3">
                        <label>{{ trans('back.installment_amount') }}</label>
                        <input type="number" step="any" name="installment_amount" id="edit_installment_amount" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>{{ trans('back.due_date') }}</label>
                        <input type="date" name="due_date" id="edit_due_date" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{ trans('back.cancel') }}</button>
                    <button type="submit" class="btn btn-success">{{ trans('back.save_changes') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
