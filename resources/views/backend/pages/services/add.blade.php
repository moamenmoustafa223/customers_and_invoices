<div class="modal fade" id="add_service" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('back.add_service') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('services.store') }}" method="post">
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

                        <div class="form-group col-md-6">
                            <label for="price" class="font-weight-bold">{{ trans('back.price') }}</label>
                            <b class="text-danger">*</b>
                            <input type="number" step="0.001" name="price" class="form-control" value="{{ old('price') }}" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="status" class="font-weight-bold">{{ trans('back.status') }}</label>
                            <b class="text-danger">*</b>
                            <select class="form-control" name="status" required>
                                <option value="active" selected>{{ trans('back.active') }}</option>
                                <option value="inactive">{{ trans('back.inactive') }}</option>
                            </select>
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
