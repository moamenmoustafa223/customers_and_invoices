<!-- Delete Category Allowance Modal -->
<div class="modal fade" id="delete_CategoryAllowances{{ $categoryAllowance->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $categoryAllowance->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel{{ $categoryAllowance->id }}">
                    {{ trans('cat_allowances.delete_category') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('back.close') }}"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('CategoryAllowances.destroy', $categoryAllowance->id) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="text-center">
                        <h5 class="text-danger mb-3">
                            {{ trans('cat_allowances.Are you sure to delete?') }}
                        </h5>
                        <strong class="text-dark">{{ app()->getLocale() == 'ar' ? $categoryAllowance->name : $categoryAllowance->name_en }}</strong>
                    </div>

                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{ trans('back.close') }}</button>
                        <button type="submit" class="btn btn-danger">{{ trans('back.Delete') }}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
