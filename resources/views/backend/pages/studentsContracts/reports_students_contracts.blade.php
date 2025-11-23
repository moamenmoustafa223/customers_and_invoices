@extends('backend.layouts.master')

@section('page_title')
    {{trans('back.reports_students_contracts')}}
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
                        value="{{ $startDate }}">
                </div>

                {{-- End Date --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">{{ trans('back.end_date') }}</label>
                    <input name="end_date" type="date" class="form-control form-control-sm"
                        value="{{ $endDate }}">
                </div>

                {{-- Academic Year --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">{{ trans('back.academic_year') }}</label>
                    <select class="form-select form-select-sm" name="academic_year_id">
                        <option value="0">{{ trans('back.all') }}</option>
                        @foreach($academicYears as $academicYear)
                            <option value="{{ $academicYear->id }}"
                                {{ $academicYearId == $academicYear->id ? 'selected' : '' }}>
                                {{ $academicYear->academic_year }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Action Buttons --}}
                <div class="col-md-3 d-flex gap-2 mt-2">
                    <button type="submit" formaction="{{ route('reports_students_contracts_post') }}"
                        class="btn btn-sm btn-primary">
                        <i class="fas fa-search me-1"></i> {{ trans('back.Search') }}
                    </button>

                    <button type="submit" formaction="{{ route('export_reports_students_contracts_excel') }}"
                        class="btn btn-sm btn-success">
                        <i class="fas fa-file-excel me-1"></i> Excel
                    </button>

                    <a href="{{ route('reports_students_contracts') }}" class="btn btn-sm btn-warning" title="{{ trans('global.reset') }}">
                        <i class="fas fa-sync-alt"></i>
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>






    <div class="row">

        @if($studentsContracts->count() > 0)
            <div class="col-12">
                <div class="card-box">
                    <div class="table-responsive">
                        <table id="" class="table table-bordered text-center table-sm">
                            <thead>
                            <tr>
                                <th width="30">#</th>
                                <th width="80">{{trans('back.contract_number')}}</th>
                                <th width="200">{{trans('back.student')}}</th>

                                <th width="150">{{trans('back.academic_year')}}</th>

                                <th width="100">{{trans('back.contract_date')}}</th>
                                <th width="100">{{trans('back.bus')}}</th>

                                <th width="80">{{trans('back.sub_total')}}</th>
                                <th width="80">{{trans('back.tax_value')}}</th>
                                <th width="80">{{trans('back.discount')}}</th>


                                <th width="80" style="background-color: #cce5ec">{{trans('back.total_amount_with_tax')}}</th>

                                <th width="80" style="background-color: #d0eccc">{{trans('back.paid')}}</th>
                                <th width="80" style="background-color: #eccccc">{{trans('back.rest_amount')}}</th>


                                <th width="100">{{trans('back.Created_at')}}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($studentsContracts as $key => $studentsContract)
                                <tr>
                                    <td>{{$key+ $studentsContracts->firstItem()}}</td>
                                    <td> {{$studentsContract->contract_number}}</td>
                                    <td>
                                        {{$studentsContract->Student->first_name}} {{$studentsContract->Student->father_name}} {{$studentsContract->Student->grandfather_name}}
                                        <br>
                                        {{$studentsContract->Student->Guardian->phone}}
                                        <br>
                                        {{$studentsContract->student_number}}
                                    </td>

                                    <td>
                                        {{$studentsContract->AcademicYear->academic_year ?? ''}}
                                        <br>
                                        {{app()->getLocale() == 'ar' ? $studentsContract->Classroom->name_ar : $studentsContract->Classroom->name_en}}
                                        <br>
                                        {{app()->getLocale() == 'ar' ? $studentsContract->Section->name_ar : $studentsContract->Section->name_en}}
                                    </td>
                                    <td> {{$studentsContract->contract_date}}</td>
                                    <td>
                                        {{$studentsContract->Bus->bus_number ?? ''}}
                                        <br>
                                        {{$studentsContract->Bus->bus_driver ?? ''}}
                                        <br>
                                        {{$studentsContract->Bus->bus_driver_phone ?? ''}}
                                    </td>

                                    <td> {{$studentsContract->sub_total}}</td>
                                    <td> {{$studentsContract->tax_value}}</td>
                                    <td> {{$studentsContract->discount}}</td>


                                    <td style="background-color: #cce5ec"> {{$studentsContract->total_amount_with_tax}}</td>

                                    <td style="background-color: #d0eccc"> {{$studentsContract->Payments->sum('payment_amount')}}</td>
                                    <td style="background-color: #eccccc"> {{$studentsContract->total_amount_with_tax - $studentsContract->Payments->sum('payment_amount')}}</td>
                                    

                                    <td>{{$studentsContract->created_at}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr style="background-color: #eaf8ef">
                                    <th colspan="9"></th>
                                    <th>{{ number_format($totalAmountWithTax, 2) }}</th>
                                    <th>{{ number_format($totalPaid, 2) }}</th>
                                    <th>{{ number_format($totalRemaining, 2) }}</th>
                                    <th></th>
                                    
                                </tr>
                                </tfoot>
                        </table>
                        {!! $studentsContracts->appends(Request::all())->links() !!}
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-12">
                <div class="alert alert-danger text-center">
                    <h4>{{trans('back.none')}}</h4>
                </div>
            </div>
        @endif
            
        </div>
        
        @endsection
        
        