@extends('backend.layouts.master')

@section('page_title')
    {{trans('discounts.add_new_discount')}}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-9 mb-1">
            <a class="btn btn-primary btn-sm" href="{{route('Discounts.index')}}">
                <i class="fas fa-arrow-right me-1"></i>
                {{trans('discounts.Back')}}
            </a>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card-box">

                <form action="{{route('Discounts.store')}}" method="post">
                    @csrf
                    <div class="row">

                        <div class="form-group col-md-3">
                            <label for="" class="font-weight-bold">
                                {{trans('discounts.select_category')}}
                            </label>
                            <select class="form-control select2" name="category_discount_id" required>
                                <option selected disabled value=""> {{trans('discounts.select_category')}}</option>
                                @foreach(App\Models\HR\CategoryDiscounts::all() as $categoryDiscounts)
                                    <option value="{{ $categoryDiscounts->id }}">
                                        @if (app()->getLocale() == 'ar')
                                            {{ $categoryDiscounts->name }}
                                        @else
                                            {{ $categoryDiscounts->name_en }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="" class="font-weight-bold">
                               {{trans('discounts.select_Employee ')}}
                            </label>
                            <select class="form-control select2" name="employee_id" required>
                                <option selected disabled value=""> {{trans('discounts.select_Employee ')}}</option>
                                @foreach(App\Models\HR\Employee::all() as $employee)
                                    <option value="{{ $employee->id }}">
                                        @if (app()->getLocale() == 'ar')
                                            {{ $employee->name_ar }}
                                        @else
                                            {{ $employee->name_en }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="name">{{trans('discounts.discount_name')}} </label>
                            <input type="text" class="form-control" placeholder="{{trans('discounts.discount_name')}}" name="name" value="{{old('name')}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="amount">{{trans('discounts.amount')}}</label>
                            <input type="number" class="form-control" placeholder="{{trans('discounts.amount')}}" name="amount"step="any" value="{{old('amount')}}" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="payment_method_id" >{{trans('payment_methods.select_payment_method')}}:</label>
                            <b class="text-danger">*</b>
                            <select class="form-control " name="payment_method_id" required>
                                <option value="">{{trans('payment_methods.select_payment_method')}}</option>
                                @foreach(App\Models\Payment_method::all() as $payment_method)
                                    <option value="{{ $payment_method->id }}">
                                        @if(app()->getLocale() == 'ar')
                                            {{ $payment_method->name_ar }}
                                        @else
                                            {{ $payment_method->name_en }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="date">{{trans('discounts.date')}}</label>
                            <input type="date" class="form-control" placeholder="{{trans('discounts.date')}}" name="date" value="{{date('Y-m-d')}}" required>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="notes">{{trans('discounts.notes')}}</label>
                            <textarea class="form-control" name="notes"  rows="6">{{old('notes')}}</textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"> {{trans('discounts.Add')}} </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection


@section('js')
    <script>

    </script>
@endsection


