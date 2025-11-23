@extends('backend.layouts.master')

@section('page_title')
    {{trans('back.studentsContracts')}}
@endsection


@section('content')
<style>
.table-responsive {
  overflow: visible !important;
  position: relative;
}


</style>
<div class="row g-1 align-items-end mb-2">
    <div class="col-md-12">
        <form action="{{ route('studentsContracts.index') }}" method="GET">
            <div class="row g-1">

                {{-- 🔍 البحث النصي --}}
                <div class="col-md-2">
                    <label class="form-label fw-semibold small mb-1">{{ trans('back.Search') }}</label>
                    <input type="text" name="query" class="form-control form-control-sm"
                        placeholder="{{ trans('back.student') }}, {{ trans('back.phone') }}, {{ trans('back.contract_num') }}"
                        value="{{ request('query') }}">
                </div>

                {{-- 📚 السنة الدراسية --}}
                <div class="col-md-2">
                    <label class="form-label fw-semibold small mb-1">{{ trans('back.select_academic_year') }}</label>
                    <select name="academic_year_id" class="form-select form-select-sm">
                        <option value="">{{ trans('back.All') }}</option>
                        @foreach($academicYears as $academicYear)
                            <option value="{{ $academicYear->id }}" {{ request('academic_year_id') == $academicYear->id ? 'selected' : '' }}>
                                {{ $academicYear->academic_year }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- 🏫 الصف --}}
                <div class="col-md-2">
                    <label class="form-label fw-semibold small mb-1">{{ trans('back.select_classroom') }}</label>
                    <select name="classroom_id" class="form-select form-select-sm">
                        <option value="">{{ trans('back.All') }}</option>
                        @foreach($classrooms as $classroom)
                            <option value="{{ $classroom->id }}" {{ request('classroom_id') == $classroom->id ? 'selected' : '' }}>
                                {{ $classroom->name_ar }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- 👥 الشعبة --}}
                <div class="col-md-2">
                    <label class="form-label fw-semibold small mb-1">{{ trans('back.select_section') }}</label>
                    <select name="section_id" class="form-select form-select-sm">
                        <option value="">{{ trans('back.All') }}</option>
                        @foreach($sectionsList as $section)
                            <option value="{{ $section->id }}" {{ request('section_id') == $section->id ? 'selected' : '' }}>
                                {{ $section->name_ar }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- 🔎 أزرار البحث والتحديث --}}
                <div class="col-md-4 d-flex gap-1 align-items-end">
                    <button class="btn btn-primary " type="submit" title="بحث">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="{{ route('studentsContracts.index') }}" class="btn btn-success" title="تحديث">
                        <i class="fas fa-sync-alt"></i>
                    </a>
                    <button class="btn btn-outline-primary" formaction="{{ route('studentsContracts_export_excel') }}">
                        <i class="fas fa-file-excel"></i>
                    </button>
                    @can('add_studentsContract')
                        <a href="{{ route('studentsContracts.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus me-1"></i> {{ trans('back.add_studentsContract') }}
                        </a>
                    @endcan
                </div>

            </div>
        </form>
    </div>
</div>


{{-- @include('backend.pages.studentsContracts._filter')--}}

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

                                <th width="220">{{trans('back.actions')}}</th>
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
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="contractActions{{ $studentsContract->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-cogs me-1"></i> الإجراءات
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="contractActions{{ $studentsContract->id }}">
                                                <li>
                                                    <a href="{{ route('studentsContracts.public', $studentsContract->slug) }}" class="dropdown-item text-info" target="_blank">
                                                        <i class="fas fa-signature me-1"></i> {{ trans('back.guardian_signature') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <button type="button" class="dropdown-item text-warning" data-bs-toggle="modal" data-bs-target="#installmentsModal{{ $studentsContract->id }}">
                                                        <i class="fas fa-money-bill-wave me-1"></i> {{ trans('back.view_installments') }}
                                                    </button>
                                                </li>
                                                
                                                <li>
                                                    <a href="{{ route('print_studentsContract', $studentsContract->id) }}" class="dropdown-item text-secondary" target="_blank">
                                                        <i class="fas fa-print me-1"></i> {{ trans('back.print') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('show_payments', $studentsContract->id) }}" class="dropdown-item text-success">
                                                        <i class="fas fa-dollar-sign me-1"></i> {{ trans('back.payments') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('studentsContracts.edit', $studentsContract->id) }}" class="dropdown-item text-primary">
                                                        <i class="fas fa-edit me-1"></i> {{ trans('back.edit') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#delete_studentsContract{{ $studentsContract->id }}">
                                                        <i class="fas fa-trash-alt me-1"></i> {{ trans('back.delete') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('copy_studentsContract', $studentsContract->id) }}" class="dropdown-item text-warning">
                                                        <i class="fas fa-copy me-1"></i> {{ trans('back.copy') }}
                                                    </a>
                                                </li>
                                                @php
                                                    $certificate = \App\Models\StudentCertificate::where('students_contract_id', $studentsContract->id)->first();
                                                @endphp
                                                <li>
                                                    <a href="{{ route('studentsCertificates.create', $studentsContract->id) }}" class="dropdown-item text-dark">
                                                        <i class="fas fa-certificate me-1"></i>
                                                        {{ $certificate ? trans('back.edit_certificate') : trans('back.add_certificate') }}
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                        {{-- Include delete modal --}}
                                        @include('backend.pages.studentsContracts.delete')
                                    </td>


                                    <td>{{$studentsContract->created_at}}</td>
                                </tr>
                            @endforeach
                            </tbody>
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
    @foreach($studentsContracts as $studentsContract)

    <div class="modal fade" id="installmentsModal{{ $studentsContract->id }}" tabindex="-1" aria-labelledby="installmentsModalLabel{{ $studentsContract->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="installmentsModalLabel{{ $studentsContract->id }}">
                        {{ trans('back.installments_for_contract') }} #{{ $studentsContract->contract_number }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($studentsContract->installments->count())
                        <div class="table-responsive">
                            <table class="table table-bordered text-center table-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('back.installment_amount') }}</th>
                                        <th>{{ trans('back.paid_amount') }}</th>
                                        <th>{{ trans('back.rest_amount') }}</th>
                                        <th>{{ trans('back.due_date') }}</th>
                                        <th>{{ trans('back.status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($studentsContract->installments as $index => $installment)
                                    @php
                                    $payments = $installment->payments ?? collect();
                                    $paidAmount = $payments->sum('payment_amount');
                                    @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ number_format($installment->installment_amount, 3) }}</td>
                                            <td>{{ number_format($paidAmount, 3) }}</td>
                                            <td>{{ number_format($installment->rest_amount, 3) }}</td>
                                            <td>{{ $installment->due_date }}</td>
                                            <td>
                                                <span class="badge bg-{{ $installment->status == 'paid' ? 'success' : 'danger' }}">
                                                    {{ trans('back.' . $installment->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-warning text-center">
                            {{ trans('back.no_installments_found') }}
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('back.close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection


@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const academicYearSelect = document.querySelector('select[name="academic_year_id"]');
        const classroomSelect = document.querySelector('select[name="classroom_id"]');
        const sectionSelect = document.querySelector('select[name="section_id"]');

        const loadingText = "{{ trans('back.Loading') }}";
        const allText = "{{ trans('back.All') }}";

        academicYearSelect?.addEventListener('change', function () {
            const yearId = this.value;
            classroomSelect.innerHTML = `<option value="">${loadingText}</option>`;
            sectionSelect.innerHTML = `<option value="">${allText}</option>`;

            fetch(`/get-classrooms-by-year/${yearId}`)
                .then(res => res.json())
                .then(data => {
                    classroomSelect.innerHTML = `<option value="">${allText}</option>`;
                    data.forEach(item => {
                        classroomSelect.innerHTML += `<option value="${item.id}">${item.name_ar}</option>`;
                    });
                });
        });

        classroomSelect?.addEventListener('change', function () {
            const classId = this.value;
            sectionSelect.innerHTML = `<option value="">${loadingText}</option>`;

            fetch(`/get-sections-by-classroom/${classId}`)
                .then(res => res.json())
                .then(data => {
                    sectionSelect.innerHTML = `<option value="">${allText}</option>`;
                    data.forEach(item => {
                        sectionSelect.innerHTML += `<option value="${item.id}">${item.name_ar}</option>`;
                    });
                });
        });
    });
</script>
@endsection

