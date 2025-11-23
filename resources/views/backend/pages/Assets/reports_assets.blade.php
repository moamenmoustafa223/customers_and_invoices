@extends('backend.layouts.master')

@section('page_title')
    {{trans('back.reports_assets_by_main_categories')}}
@endsection

@section('content')

<div class="row">
    <div class="col-md-12 mb-2">
        <form method="POST" action="{{ route('reports_assets') }}">
            @csrf
            <div class="row g-1 align-items-end">

                {{-- Main Category --}}
                <div class="col-md-2">
                    <label class="form-label fw-semibold">{{ trans('back.select_main_category') }}</label>
                    <select name="assets_category_id" class="form-select form-select-sm">
                        <option value="0">{{ trans('back.All') }}</option>
                        @foreach($mainCategories as $category)
                            <option value="{{ $category->id }}" {{ old('assets_category_id', $mainCategoryId ?? '') == $category->id ? 'selected' : '' }}>
                                {{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Sub Category --}}
                <div class="col-md-2">
                    <label class="form-label fw-semibold">{{ trans('back.select_sub_category') }}</label>
                    <select name="assets_sub_category_id" class="form-select form-select-sm">
                        <option value="0">{{ trans('back.All') }}</option>
                        @foreach($subCategories as $sub)
                            <option value="{{ $sub->id }}" {{ old('assets_sub_category_id', $subCategoryId ?? '') == $sub->id ? 'selected' : '' }}>
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
                <div class="col-md-2 d-flex gap-1 flex-wrap mt-2">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-search me-1"></i> {{ trans('back.Search') }}
                    </button>

                    <button type="submit" formaction="{{ route('reports_assets_excel') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-file-excel me-1"></i> Excel
                    </button>

                    <a href="{{ route('reports_assets') }}" class="btn btn-sm btn-warning" title="{{ trans('global.reset') }}">
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
                            <th width="50">#</th>
                            <th width="100">{{trans('back.expense_date')}}</th>
                            <th width="100">{{trans('back.description')}}</th>
                            <th width="100">{{trans('back.SubCategory')}}</th>
                            <th width="100">{{trans('back.MainCategory')}}</th>
                            <th width="100">{{trans('back.supplier')}}</th>
                            <th width="100">{{trans('back.supplier_invoice_number')}}</th>
                            <th width="100">{{trans('back.amount')}}</th>
                            <th width="100">{{trans('back.tax_amount')}}</th>
                            <th width="100">{{trans('back.amount_with_tax')}}</th>
                            <th width="100">{{trans('back.payment_methods')}}</th>
                            <th width="100">{{trans('back.Check_number')}}</th>
                            <th width="100">{{trans('back.notes')}}</th>
                            <th width="100">{{trans('back.Created_at')}}</th>
                            <th width="100">{{trans('back.User')}}</th>
                            <th width="100">{{trans('back.depreciation_rate')}}</th>
                            <th width="100">{{trans('back.code_no')}}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($reports_assets as $key => $asset)
                            <tr>
                                <td>{{$key+ $reports_assets->firstItem()}}</td>
                                <td>{{ $asset->expense_date }}</td>
                                <td>{{ $asset->description }}</td>
                                <td> @if (app()->getLocale() == 'ar') {{ $asset->AssetsSubCategory->name_ar ?? "" }} @else  {{ $asset->AssetsSubCategory->name_en ?? "" }} @endif </td>
                                <td> @if (app()->getLocale() == 'ar') {{ $asset->AssetsCategory->name_ar ?? "" }} @else  {{ $asset->AssetsCategory->name_en ?? "" }} @endif </td>
                                <td>{{ $asset->supplier }}</td>
                                <td>{{ $asset->supplier_invoice_number }}</td>
                                <td>{{ $asset->amount }}</td>
                                <td>{{$asset->tax_amount}}</td>
                                <td>{{ $asset->amount_with_tax }}</td>
                                <td> @if(app()->getLocale() == 'ar' ) {{ $asset->Payment_method->name_ar }} @else {{ $asset->Payment_method->name_en }} @endif</td>
                                <td>{{ $asset->check_number }}</td>
                                <td>{{ $asset->notes }}</td>
                                <td>{{ $asset->created_at }}</td>
                                <td>{{ $asset->User->name ?? "" }}</td>
                                <td>{{ $asset->depreciation_rate }}</td>
                                <td>{{ $asset->code_no }}</td>
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
                            <td>{{$total_assets}}</td>
                            <td>{{$tax_amount}}</td>
                            <td>{{$amount_with_tax}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tfoot>
                    </table>
                    {!! $reports_assets->appends(Request::all())->links() !!}
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mainCategorySelect = document.querySelector('select[name="assets_category_id"]');
        const subCategorySelect = document.querySelector('select[name="assets_sub_category_id"]');

        mainCategorySelect.addEventListener('change', function () {
            const mainCategoryId = this.value;

            // Reset subcategory dropdown
            subCategorySelect.innerHTML = '<option value="0">{{ trans('back.All') }}</option>';

            if (mainCategoryId == 0) return;

            fetch("{{ route('fetchAssetsSubCategories') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ assets_category_id: mainCategoryId })
            })
            .then(response => response.json())
            .then(data => {
                data.AssetsSubCategories.forEach(sub => {
                    const option = document.createElement("option");
                    option.value = sub.id;
                    option.text = '{{ app()->getLocale() == "ar" ? "__ar__" : "__en__" }}'
                        .replace("__ar__", sub.name_ar)
                        .replace("__en__", sub.name_en);
                    subCategorySelect.appendChild(option);
                });
            })
            .catch(error => console.error("Error fetching subcategories:", error));
        });
    });
</script>
@endsection