<!-- Delete Installment Modal -->
<div class="modal fade" id="deleteInstallmentModal" tabindex="-1" aria-labelledby="deleteInstallmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('installments.destroy', 0) }}" id="deleteInstallmentForm">
                @csrf
                @method('DELETE')

                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="deleteInstallmentModalLabel">{{ trans('back.confirm_delete') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('back.close') }}"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="delete_installment_id">
                    <p class="text-center">{{ trans('back.are_you_sure_delete') }}</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{ trans('back.cancel') }}</button>
                    <button type="submit" class="btn btn-danger">{{ trans('back.Delete') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
