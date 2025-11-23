@extends('backend.layouts.master')
@section('page_title')
    {{ trans('back.edit_invoice_status') }}
@endsection

@section('content')
    <div>
        <a class="btn btn-primary btn-sm mb-1" href="{{ route('invoice_statuses.index') }}">
            <i class="fas fa-undo"></i>
            {{ trans('back.Turn_back') }}
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <form action="{{ route('invoice_statuses.update', $invoiceStatus->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name_ar" class="font-weight-bold">{{ trans('back.name_ar') }}</label>
                            <b class="text-danger">*</b>
                            <input type="text" name="name_ar" class="form-control" value="{{ $invoiceStatus->name_ar }}" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="name_en" class="font-weight-bold">{{ trans('back.name_en') }}</label>
                            <b class="text-danger">*</b>
                            <input type="text" name="name_en" class="form-control" value="{{ $invoiceStatus->name_en }}" required>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="color" class="font-weight-bold">{{ trans('back.color') }}</label>
                            <b class="text-danger">*</b>
                            <input type="color" name="color" class="form-control" value="{{ $invoiceStatus->color }}" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="description_ar" class="font-weight-bold">{{ trans('back.description_ar') }}</label>
                            <textarea name="description_ar" class="form-control" rows="3">{{ $invoiceStatus->description_ar }}</textarea>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="description_en" class="font-weight-bold">{{ trans('back.description_en') }}</label>
                            <textarea name="description_en" class="form-control" rows="3">{{ $invoiceStatus->description_en }}</textarea>
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
