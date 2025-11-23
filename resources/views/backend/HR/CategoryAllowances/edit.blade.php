<!-- Edit Category Allowance Modal -->
<div class="modal fade" id="edit_CategoryAllowances{{ $categoryAllowance->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $categoryAllowance->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{ $categoryAllowance->id }}">{{ trans('cat_allowances.edit_category') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('back.Close') }}"></button>
            </div>
            
            <div class="modal-body">
                <form action="{{ route('CategoryAllowances.update', $categoryAllowance->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Arabic Name -->
                        <div class="form-group col-md-6">
                            <label for="name">{{ trans('cat_allowances.category_name_ar') }}</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $categoryAllowance->name }}">
                        </div>

                        <!-- English Name -->
                        <div class="form-group col-md-6">
                            <label for="name_en_{{ $categoryAllowance->id }}">{{ trans('cat_allowances.category_name_en') }}</label>
                            <input type="text" class="form-control" id="name_en_{{ $categoryAllowance->id }}" name="name_en" value="{{ $categoryAllowance->name_en }}" required>
                        </div>

                        <!-- Notes -->
                        <div class="form-group col-md-12 mt-2">
                            <label for="notes_{{ $categoryAllowance->id }}">{{ trans('cat_allowances.notes') }}</label>
                            <textarea class="form-control" id="notes_{{ $categoryAllowance->id }}" name="notes" rows="3">{{ $categoryAllowance->notes }}</textarea>
                        </div>
                    </div>

                    <!-- Footer Buttons -->
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{ trans('back.Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ trans('back.Save') }}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
