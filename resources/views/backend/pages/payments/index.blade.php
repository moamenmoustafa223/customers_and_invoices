@extends('backend.layouts.master')

@section('page_title')
    {{ trans('back.payments') }}
@endsection

@section('content')

    <div class="row ">
        @can('payments')
            <div class="row">
                <div class="col-md-12 mb-3">
                    <form action="{{ route('payments.index') }}" method="GET">
                        <div class="row g-2 align-items-end">

                            {{-- 🔍 Search --}}
                            <div class="col-md-3">
                                <label class="form-label fw-semibold small mb-1">{{ trans('back.Search') }}</label>
                                <input type="text" name="query" class="form-control form-control-sm"
                                    placeholder="{{ trans('back.student') }}, {{ trans('back.phone') }}, {{ trans('back.contract_num') }}"
                                    value="{{ request('query') }}">
                            </div>

                            {{-- 📚 Academic Year --}}
                            <div class="col-md-2">
                                <label
                                    class="form-label fw-semibold small mb-1">{{ trans('back.select_academic_year') }}</label>
                                <select name="academic_year_id" class="form-select form-select-sm">
                                    <option value="">{{ trans('back.All') }}</option>
                                    @foreach ($academicYears as $year)
                                        <option value="{{ $year->id }}"
                                            {{ request('academic_year_id') == $year->id ? 'selected' : '' }}>
                                            {{ $year->academic_year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- 🏫 Classroom --}}
                            <div class="col-md-2">
                                <label class="form-label fw-semibold small mb-1">{{ trans('back.select_classroom') }}</label>
                                <select name="classroom_id" class="form-select form-select-sm">
                                    <option value="">{{ trans('back.All') }}</option>
                                    @foreach ($classrooms as $class)
                                        <option value="{{ $class->id }}"
                                            {{ request('classroom_id') == $class->id ? 'selected' : '' }}>
                                            {{ $class->name_ar }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- 👥 Section --}}
                            <div class="col-md-2">
                                <label class="form-label fw-semibold small mb-1">{{ trans('back.select_section') }}</label>
                                <select name="section_id" class="form-select form-select-sm">
                                    <option value="">{{ trans('back.All') }}</option>
                                    @foreach ($sectionsList as $sec)
                                        <option value="{{ $sec->id }}"
                                            {{ request('section_id') == $sec->id ? 'selected' : '' }}>
                                            {{ $sec->name_ar }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- 🔎 Buttons --}}
                            <div class="col-md-1 d-flex align-items-end gap-1">
                                <button class="btn btn-primary btn-sm" type="submit" title="بحث">
                                    <i class="fas fa-search"></i>
                                </button>
                                <a href="{{ route('payments.index') }}" class="btn btn-success btn-sm" title="تحديث">
                                    <i class="fas fa-sync-alt"></i>
                                </a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        @endcan
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card-box">

                <div class="table-responsive">
                    <table class="table table-bordered text-center table-sm">
                        <thead>
                            <tr style="background-color: rgb(232,245,252)">
                                <th width="25">#</th>
                                <th width="100">{{ trans('back.receipt_number') }}</th>
                                <th width="150">{{ trans('back.student') }}</th>
                                <th width="100">{{ trans('back.phone') }}</th>
                                <th width="100">{{ trans('back.academic_year') }}</th>
                                <th width="100">{{ trans('back.classroom') }}</th>
                                <th width="100">{{ trans('back.contract_number') }}</th>
                                <th width="100">{{ trans('back.payment_date') }}</th>
                                <th width="100">{{ trans('back.payment_method') }}</th>
                                <th width="100">{{ trans('back.payment_amount') }}</th>
                                <th width="100">{{ trans('back.Action') }}</th>
                                <th width="100">{{ trans('back.Created_at') }}</th>
                                <th width="100">{{ trans('back.User') }}</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach ($payments as $key => $payment)
                                <tr>
                                    <td>{{ $key + $payments->firstItem() }}</td>
                                    <td>{{ $payment->payment_number }}</td>
                                    <td>{{ $payment->Student->first_name }}</td>
                                    <td>
                                        <a href="https://wa.me/{{ $payment->Student->phone }}" target="_blank">
                                            {{ $payment->Student->phone }}
                                        </a>
                                    </td>
                                    <td>{{ $payment->AcademicYear->academic_year }}</td>
                                    <td>{{ app()->getLocale() == 'ar' ? $payment->Classroom->name_ar : $payment->Classroom->name_en }}
                                    </td>
                                    <td>{{ $payment->StudentsContract->contract_number }}</td>
                                    <td>{{ $payment->payment_date }}</td>
                                    <td>
                                        @if (app()->getLocale() == 'ar')
                                            {{ $payment->Payment_method->name_ar }}
                                        @else
                                            {{ $payment->Payment_method->name_en }}
                                        @endif
                                    </td>
                                    <td>{{ number_format($payment->payment_amount, 3) }}</td>
                                    <td>
                                        <a href="{{ route('payment_number', $payment->payment_number) }}"
                                            class="text-success ml-1" target="_blank">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    </td>
                                    <td>{{ $payment->created_at }}</td>
                                    <td>{{ $payment->User->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {!! $payments->appends(Request::all())->links() !!}

            </div>
        </div>
    </div>

@endsection
@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const academicYearSelect = document.querySelector('select[name="academic_year_id"]');
            const classroomSelect = document.querySelector('select[name="classroom_id"]');
            const sectionSelect = document.querySelector('select[name="section_id"]');

            const loadingText = "{{ trans('back.Loading') }}";
            const allText = "{{ trans('back.All') }}";

            academicYearSelect.addEventListener('change', function() {
                const yearId = this.value;
                classroomSelect.innerHTML = `<option value="">${loadingText}</option>`;
                sectionSelect.innerHTML = `<option value="">${allText}</option>`;

                fetch(`/get-classrooms-by-year/${yearId}`)
                    .then(res => res.json())
                    .then(data => {
                        classroomSelect.innerHTML = `<option value="">${allText}</option>`;
                        data.forEach(item => {
                            classroomSelect.innerHTML +=
                                `<option value="${item.id}">${item.name_ar}</option>`;
                        });
                    });
            });

            classroomSelect.addEventListener('change', function() {
                const classId = this.value;
                sectionSelect.innerHTML = `<option value="">${loadingText}</option>`;

                fetch(`/get-sections-by-classroom/${classId}`)
                    .then(res => res.json())
                    .then(data => {
                        sectionSelect.innerHTML = `<option value="">${allText}</option>`;
                        data.forEach(item => {
                            sectionSelect.innerHTML +=
                                `<option value="${item.id}">${item.name_ar}</option>`;
                        });
                    });
            });
        });
    </script>
@endsection
