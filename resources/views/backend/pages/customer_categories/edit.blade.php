@extends('backend.layouts.master')
@section('page_title')
    {{ trans('back.edit_customer_category') }}
@endsection

@section('content')
    <div>
        <a class="btn btn-primary btn-sm mb-1" href="{{ route('customer_categories.index') }}">
            <i class="fas fa-undo"></i>
            {{ trans('back.Turn_back') }}
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <form action="{{ route('customer_categories.update', $customerCategory->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name_ar" class="font-weight-bold">{{ trans('back.name_ar') }}</label>
                            <b class="text-danger">*</b>
                            <input type="text" name="name_ar" class="form-control" value="{{ $customerCategory->name_ar }}" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="name_en" class="font-weight-bold">{{ trans('back.name_en') }}</label>
                            <b class="text-danger">*</b>
                            <input type="text" name="name_en" class="form-control" value="{{ $customerCategory->name_en }}" required>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="status" class="font-weight-bold">{{ trans('back.status') }}</label>
                            <b class="text-danger">*</b>
                            <select class="form-control" name="status" required>
                                <option value="active" {{ $customerCategory->status == 'active' ? 'selected' : '' }}>{{ trans('back.active') }}</option>
                                <option value="inactive" {{ $customerCategory->status == 'inactive' ? 'selected' : '' }}>{{ trans('back.inactive') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">{{ trans('back.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
