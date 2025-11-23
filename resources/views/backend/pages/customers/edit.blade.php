@extends('backend.layouts.master')
@section('page_title')
    {{ trans('back.edit_customer') }}
@endsection

@section('content')
    <div>
        <a class="btn btn-primary btn-sm mb-1" href="{{ route('customers.index') }}">
            <i class="fas fa-undo"></i>
            {{ trans('back.Turn_back') }}
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <form action="{{ route('customers.update', $customer->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name" class="font-weight-bold">{{ trans('back.customer_name') }}</label>
                            <b class="text-danger">*</b>
                            <input type="text" name="name" class="form-control" value="{{ $customer->name }}" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="customer_category_id" class="font-weight-bold">{{ trans('back.customer_category') }}</label>
                            <b class="text-danger">*</b>
                            <select class="form-control" name="customer_category_id" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $customer->customer_category_id == $category->id ? 'selected' : '' }}>
                                        {{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="phone" class="font-weight-bold">{{ trans('back.phone') }}</label>
                            <input type="text" name="phone" class="form-control" value="{{ $customer->phone }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="email" class="font-weight-bold">{{ trans('back.email') }}</label>
                            <input type="email" name="email" class="form-control" value="{{ $customer->email }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="address_ar" class="font-weight-bold">{{ trans('back.address_ar') }}</label>
                            <textarea name="address_ar" class="form-control" rows="3">{{ $customer->address_ar }}</textarea>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="address_en" class="font-weight-bold">{{ trans('back.address_en') }}</label>
                            <textarea name="address_en" class="form-control" rows="3">{{ $customer->address_en }}</textarea>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="notes_ar" class="font-weight-bold">{{ trans('back.notes_ar') }}</label>
                            <textarea name="notes_ar" class="form-control" rows="3">{{ $customer->notes_ar }}</textarea>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="notes_en" class="font-weight-bold">{{ trans('back.notes_en') }}</label>
                            <textarea name="notes_en" class="form-control" rows="3">{{ $customer->notes_en }}</textarea>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="status" class="font-weight-bold">{{ trans('back.status') }}</label>
                            <b class="text-danger">*</b>
                            <select class="form-control" name="status" required>
                                <option value="active" {{ $customer->status == 'active' ? 'selected' : '' }}>{{ trans('back.active') }}</option>
                                <option value="inactive" {{ $customer->status == 'inactive' ? 'selected' : '' }}>{{ trans('back.inactive') }}</option>
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
