<div class="modal fade" id="add_invoice_status" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('back.add_invoice_status') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('invoice_statuses.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name_ar" class="font-weight-bold">{{ trans('back.name_ar') }}</label>
                            <b class="text-danger">*</b>
                            <input type="text" name="name_ar" class="form-control" value="{{ old('name_ar') }}" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="name_en" class="font-weight-bold">{{ trans('back.name_en') }}</label>
                            <b class="text-danger">*</b>
                            <input type="text" name="name_en" class="form-control" value="{{ old('name_en') }}" required>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="color" class="font-weight-bold">{{ trans('back.color') }}</label>
                            <b class="text-danger">*</b>
                            <input type="color" name="color" class="form-control" value="{{ old('color', '#6c757d') }}" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="description_ar" class="font-weight-bold">{{ trans('back.description_ar') }}</label>
                            <textarea name="description_ar" class="form-control" rows="3">{{ old('description_ar') }}</textarea>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="description_en" class="font-weight-bold">{{ trans('back.description_en') }}</label>
                            <textarea name="description_en" class="form-control" rows="3">{{ old('description_en') }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{ trans('back.close') }}</button>
                        <button type="submit" class="btn btn-success">{{ trans('back.add') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
