<div class="modal fade" id="add_customer_category" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('back.add_customer_category') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('customer_categories.store') }}" method="post">
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
                            <label for="status" class="font-weight-bold">{{ trans('back.status') }}</label>
                            <b class="text-danger">*</b>
                            <select class="form-control" name="status" required>
                                <option value="active" selected>{{ trans('back.active') }}</option>
                                <option value="inactive">{{ trans('back.inactive') }}</option>
                            </select>
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
