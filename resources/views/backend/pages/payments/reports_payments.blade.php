@extends('backend.layouts.master')

@section('page_title')
    {{trans('back.reports_payments')}}
@endsection

@section('content')

<div class="row">
    <div class="col-md-12 mb-2">
        {{-- Filter Form --}}
        <form method="POST">
            @csrf
            <div class="row g-3 align-items-end">

                {{-- Start Date --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">{{ trans('back.start_date') }}</label>
                    <input name="start_date" type="date" class="form-control form-control-sm"
                        value="{{ old('start_date', $startDate ?? now()->toDateString()) }}">
                </div>

                {{-- End Date --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">{{ trans('back.end_date') }}</label>
                    <input name="end_date" type="date" class="form-control form-control-sm"
                        value="{{ old('end_date', $endDate ?? now()->toDateString()) }}">
                </div>

                {{-- Action Buttons --}}
                <div class="col-md-6 d-flex gap-2 mt-2">
                    <button type="submit" formaction="{{ route('reports_payments_post') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-search me-1"></i> {{ trans('back.Search') }}
                    </button>

                    <button type="submit" formaction="{{ route('export_reports_payments_excel') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-file-excel me-1"></i> Excel
                    </button>

                    <a href="{{ route('reports_payments') }}" class="btn btn-sm btn-warning" title="{{ trans('global.reset') }}">
                        <i class="fas fa-sync-alt"></i>
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>



    <div class="row">
        <div class="col-12">
            <div class="card-box">

                <!-- تحقق من وجود تواريخ البحث قبل عرض الجدول -->
                @if($startDate && $endDate)
                <div class="table-responsive">
                    <table class="table table-bordered text-center table-sm">
                        <thead>
                        <tr style="background-color: rgb(232,245,252)">
                            <th width="25">#</th>
                            <th width="100">{{trans('back.receipt_number')}}</th>
                            <th width="150">{{trans('back.student')}}</th>
                            <th width="100">{{trans('back.phone')}}</th>
                            <th width="100">{{trans('back.academic_year')}}</th>
                            <th width="100">{{trans('back.classroom')}}</th>
                            <th width="100">{{trans('back.contract_number')}}</th>
                            <th width="100">{{trans('back.payment_date')}}</th>
                            <th width="100">{{trans('back.payment_method')}}</th>
                            <th width="100">{{trans('back.payment_amount')}}</th>
                            <th width="100">{{trans('back.Action')}}</th>
                            <th width="100">{{trans('back.Created_at')}}</th>
                            <th width="100">{{trans('back.User')}}</th>
                        </tr>
                        </thead>


                        <tbody>
                        @foreach($payments as $key=> $payment)
                            <tr>
                                <td>{{$key+ $payments->firstItem()}}</td>
                                <td>{{$payment->payment_number}}</td>
                                <td>{{$payment->Student->first_name}}</td>
                                <td>
                                    <a href="https://wa.me/{{$payment->Student->phone}}" target="_blank" >
                                        {{$payment->Student->phone}}
                                    </a>
                                </td>
                                <td>{{$payment->AcademicYear->academic_year}}</td>
                                <td>{{app()->getLocale() == 'ar' ? $payment->Classroom->name_ar : $payment->Classroom->name_en}}</td>
                                <td>{{$payment->StudentsContract->contract_number}}</td>
                                <td>{{$payment->payment_date}}</td>
                                <td>
                                    @if (app()->getLocale() == 'ar')
                                        {{$payment->Payment_method->name_ar}}
                                    @else
                                        {{$payment->Payment_method->name_en}}
                                    @endif
                                </td>
                                <td>{{number_format($payment->payment_amount, 3)}}</td>
                                <td>
                                    <a href="{{route('payment_number', $payment->payment_number)}}" class="text-success ml-1" target="_blank">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </td>
                                <td>{{$payment->created_at}}</td>
                                <td>{{$payment->User->name}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>{{number_format($total_payment_amount, 3)}}</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </tfoot>
                    </table>
                </div>

                    {!! $payments->appends(Request::all())->links() !!}
                    
                    @else
                    <div class="alert alert-info text-center">
                        {{ trans('back.please_search_to_view_results') }}
                    </div>
                    @endif
                    
                </div>
            </div>
        </div>
        
        
        @endsection
        
        
        
        