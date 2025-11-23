@extends('backend.layouts.master')

@section('page_title')
    {{ trans('salaries.add_salary_multiple') }}
@endsection

@section('content')
    <form action="{{ route('Salaries.store_multiple') }}" method="post">
        @csrf

        <div class="card-box">
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center" id="salary-multiple-table">
                    <thead class="bg-light">
                    <tr>
                        <th>{{ trans('salaries.Employee_name') }}</th>
                        <th>{{ trans('salaries.salary_name') }}</th>
                        <th>{{ trans('salaries.amount') }}</th>
                        <th>{{ trans('payment_methods.select_payment_method') }}</th>
                        <th>{{ trans('salaries.date') }}</th>
                        <th>{{ trans('salaries.notes') }}</th>
                        <th>{{ trans('back.Action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($employees as $index => $employee)
                        @php
                            $latestContract = $employee->Contracts()->latest()->first();
                            $totalSalary = $latestContract ? $latestContract->total_salary : '';
                        @endphp
                        <tr class="employee-salary-row" data-index="{{ $index }}">
                            <td>
                                <strong>{{ app()->getLocale() == 'ar' ? $employee->name_ar : $employee->name_en }}</strong>
                                <input type="hidden" name="salaries[{{ $index }}][employee_id]" value="{{ $employee->id }}">
                            </td>

                            <td>
                                <input type="text" name="salaries[{{ $index }}][name]" class="form-control"
                                       value="{{ 'راتب شهر ' . now()->format('m') }}" required>
                            </td>

                            <td>
                                <input type="number" name="salaries[{{ $index }}][amount]" class="form-control employee-salary" data-employee-id="{{ $employee->id }}" value="{{ $totalSalary }}" step="any" required>
                            </td>

                            <td>
                                <select name="salaries[{{ $index }}][payment_method_id]" class="form-control" required>
                                    <option value="">{{ trans('back.Choose') }}</option>
                                    @foreach($paymentMethods as $method)
                                        <option value="{{ $method->id }}">
                                            {{ app()->getLocale() == 'ar' ? $method->name_ar : $method->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                <input type="date" name="salaries[{{ $index }}][date]" class="form-control"
                                       value="{{ now()->format('Y-m-d') }}" required>
                            </td>

                            <td>
                                <textarea name="salaries[{{ $index }}][notes]" class="form-control" rows="1"></textarea>
                            </td>

                            <td>
                                <button type="button" class="btn btn-sm btn-danger delete-row">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success mt-3">
                    <i class="fas fa-save me-1"></i> {{ trans('salaries.Add') }}
                </button>
            </div>
        </div>
    </form>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const table = document.getElementById('salary-multiple-table');

        table.addEventListener('click', function (e) {
            if (e.target.closest('.delete-row')) {
                const row = e.target.closest('tr');
                if (row) row.remove();
            }
        });
    });
</script>
@endsection
