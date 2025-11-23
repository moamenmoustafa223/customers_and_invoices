@extends('backend.layouts.master')

@section('page_title')
   {{trans('allowances.add_new_allowance')}}
@endsection


@section('content')

    <div class="row">
        <div class="col-md-9 mb-1">
            <a class="btn btn-primary btn-sm" href="{{route('Allowances.index')}}">
                <i class="fas fa-arrow-right "></i>
                {{trans('allowances.Back')}}
            </a>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card-box">

                <form action="{{route('Allowances.store')}}" method="post">
                    @csrf
                    <div class="row">

                        <div class="form-group col-md-3">
                            <label for="" class="font-weight-bold">
                               {{trans('allowances.select_category')}}
                            </label>
                            <select class="form-control select2" name="category_allowance_id" required>
                                <option selected disabled value=""> {{trans('allowances.select_category')}}</option>
                                @foreach(App\Models\HR\CategoryAllowance::all() as $categoryAllowance)
                                    <option value="{{ $categoryAllowance->id }}">
                                        @if (app()->getLocale() =='ar')
                                            {{ $categoryAllowance->name }}
                                        @else
                                            {{ $categoryAllowance->name_en }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="" class="font-weight-bold">
                                {{trans('allowances.select_Employee ')}}
                            </label>
                            <select class="form-control select2" name="employee_id" required>
                                <option selected disabled value=""> {{trans('allowances.select_Employee ')}}</option>
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
                            <label for="name">{{trans('allowances.allowance_name')}} </label>
                            <input type="text" class="form-control" placeholder="{{trans('allowances.allowance_name')}} " name="name" value="{{old('name')}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="amount">{{trans('allowances.amount')}}</label>
                            <input type="number" class="form-control" placeholder="{{trans('allowances.amount')}}" name="amount"step="any" value="{{old('amount')}}" required>
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
                            <label for="date">{{trans('allowances.date')}}</label>
                            <input type="date" class="form-control" placeholder="{{trans('allowances.date')}}" name="date" value="{{old('date')}}" required>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="notes">{{trans('allowances.notes')}}</label>
                            <textarea class="form-control" name="notes"  rows="6">{{old('notes')}}</textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"> {{trans('allowances.Add')}} </button>
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


