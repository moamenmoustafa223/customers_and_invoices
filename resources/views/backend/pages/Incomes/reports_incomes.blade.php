@extends('backend.layouts.master')

@section('page_title')
    {{trans('back.reports_incomes_by_main_categories')}}
@endsection


@section('content')

<div class="row">
    <div class="col-md-12 mb-2">
        <form method="POST" action="{{ route('reports_incomes') }}">
            @csrf
            <div class="row g-1 align-items-end">

                {{-- Main Category --}}
                <div class="col-md-2">
                    <label class="form-label fw-semibold">{{ trans('back.select_main_category') }}</label>
                    <select name="incomes_category_id" id="incomes-main-category" class="form-select form-select-sm">
                        <option value="0">{{ trans('back.All') }}</option>
                        @foreach($mainCategories as $category)
                            <option value="{{ $category->id }}" {{ old('incomes_category_id', $categoryId ?? '') == $category->id ? 'selected' : '' }}>
                                {{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Sub Category --}}
                <div class="col-md-2">
                    <label class="form-label fw-semibold">{{ trans('back.select_sub_category') }}</label>
                    <select name="incomes_sub_category_id" id="incomes-sub-category" class="form-select form-select-sm">
                        <option value="0">{{ trans('back.All') }}</option>
                        @foreach($subCategories as $sub)
                            <option value="{{ $sub->id }}" {{ old('incomes_sub_category_id', $subCategoryId ?? '') == $sub->id ? 'selected' : '' }}>
                                {{ app()->getLocale() == 'ar' ? $sub->name_ar : $sub->name_en }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Start Date --}}
                <div class="col-md-2">
                    <label class="form-label fw-semibold">{{ trans('back.start_date') }}</label>
                    <input type="date" name="start_date" class="form-control form-control-sm" value="{{ $start_date }}">
                </div>

                {{-- End Date --}}
                <div class="col-md-2">
                    <label class="form-label fw-semibold">{{ trans('back.end_date') }}</label>
                    <input type="date" name="end_date" class="form-control form-control-sm" value="{{ $end_date }}">
                </div>

                {{-- Action Buttons --}}
                <div class="col-md-4 d-flex gap-1 flex-wrap mt-2">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-search me-1"></i> {{ trans('back.Search') }}
                    </button>

                    <button type="submit" formaction="{{ route('reports_incomes_excel') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-file-excel me-1"></i> Excel
                    </button>

                    <a href="{{ route('reports_incomes') }}" class="btn btn-sm btn-warning" title="{{ trans('global.reset') }}">
                        <i class="fas fa-sync-alt"></i>
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>


    <div class="row">
        <div class="col-md-12">
            <div class="card-box">
                <div class="table-responsive">
                    <table  class="table text-center  table-striped  table-bordered table-sm ">
                        <thead>
                        <tr style="background-color: rgb(232,245,252)">
                            <th width="30">#</th>
                            <th width="100">{{trans('back.expense_date')}}</th>
                            <th width="100">{{trans('back.description')}}</th>
                            <th width="100">{{trans('back.SubCategory')}}</th>
                            <th width="100">{{trans('back.MainCategory')}}</th>
                            <th width="100">{{trans('back.supplier')}}</th>
                            <th width="100">{{trans('back.Supplier_invoice_number')}}</th>
                            <th width="100">{{trans('back.amount')}}</th>
                            <th width="100">{{trans('back.tax_amount')}}</th>
                            <th width="100">{{trans('back.amount_with_tax')}}</th>
                            <th width="100">{{trans('back.payment_methods')}}</th>
                            <th width="100">{{trans('back.Check_number')}}</th>
                            <th width="100">{{trans('back.notes')}}</th>
                            <th width="100">{{trans('back.Created_at')}}</th>
                            <th width="100">{{trans('back.User')}}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($incomes as $key => $income)
                            <tr>
                                <td>{{$key+ $incomes->firstItem()}}</td>
                                <td>{{ $income->expense_date }}</td>
                                <td>{{ $income->description }}</td>
                                <td> @if (app()->getLocale() == 'ar') {{ $income->IncomesSubCategory->name_ar ?? "" }} @else  {{ $income->IncomesSubCategory->name_en ?? "" }} @endif </td>
                                <td> @if (app()->getLocale() == 'ar') {{ $income->IncomesCategory->name_ar ?? "" }} @else  {{ $income->IncomesCategory->name_en ?? "" }} @endif </td>
                                <td>{{ $income->supplier }}</td>
                                <td>{{ $income->supplier_invoice_number }}</td>
                                <td>{{ $income->amount }}</td>
                                <td>{{$income->tax_amount}}</td>
                                <td>{{ $income->amount_with_tax }}</td>
                                <td> @if(app()->getLocale() == 'ar' ) {{ $income->Payment_method->name_ar }} @else {{ $income->Payment_method->name_en }} @endif</td>
                                <td>{{ $income->check_number }}</td>
                                <td>{{ $income->notes }}</td>
                                <td>{{ $income->created_at }}</td>
                                <td>{{ $income->User->name ?? "" }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr style="background-color: #daf1e6">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{$total_Incomes}}</td>
                            <td>{{$tax_amount}}</td>
                            <td>{{$amount_with_tax}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tfoot>
                    </table>
                    {!! $incomes->appends(Request::all())->links() !!}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const incomesMain = document.getElementById('incomes-main-category');
        const incomesSub = document.getElementById('incomes-sub-category');

        incomesMain.addEventListener('change', function () {
            const mainId = this.value;

            // Reset subcategories list
            incomesSub.innerHTML = '<option value="0">{{ trans('back.All') }}</option>';

            if (mainId == 0) return;

            fetch("{{ route('fetchIncomesSubCategories') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ incomes_category_id: mainId })
            })
            .then(response => response.json())
            .then(data => {
                data.IncomesSubCategories.forEach(sub => {
                    const option = document.createElement("option");
                    option.value = sub.id;
                    option.text = '{{ app()->getLocale() == "ar" ? "__ar__" : "__en__" }}'
                        .replace("__ar__", sub.name_ar)
                        .replace("__en__", sub.name_en);
                    incomesSub.appendChild(option);
                });
            })
            .catch(error => console.error("Error loading income subcategories:", error));
        });
    });
</script>

@endsection 
