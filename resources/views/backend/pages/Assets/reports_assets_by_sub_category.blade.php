@extends('backend.layouts.master')

@section('page_title')
    {{trans('back.reports_assets_by_sub_category')}}
@endsection


@section('content')

    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('reports_assets_by_sub_category') }}" method="post">
                @csrf
                <div class="row">

                    <div class="form-group col-md-3">
                        <label for="" class="font-weight-bold">
                            {{trans('back.select_category')}}
                        </label>
                        <select class="form-control select2" name="assets_sub_category_id" required>
                            <option value="0">{{trans('back.All')}}</option>
                            @foreach(App\Models\AssetsCategory::all() as $assetsCategory)
                                <optgroup label="{{$assetsCategory->name_ar}}">
                                    @foreach($assetsCategory->AssetsSubCategories as $assets_sub_category)
                                        <option value="{{ $assets_sub_category->id }}" {{ old('assets_sub_category_id', request()->input('assets_sub_category_id')) == $assets_sub_category->id ? 'selected' : null }}>
                                            @if (app()->getLocale() == 'ar')
                                                {{ $assets_sub_category->name_ar ?? "" }}
                                            @else
                                                {{ $assets_sub_category->name_en ?? "" }}
                                            @endif
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label >{{trans('back.start_date')}}</label>
                        <input name="start_date" class="form-control " type="date" value="{{ $start_date??"" }}">
                    </div>
                    <div class="col-md-2">
                        <label > {{trans('back.end_date')}}</label>
                        <input name="end_date" class="form-control " type="date" value="{{ $end_date??"" }}">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary btn-sm" style="margin-top: 25px" type="submit" formaction="{{ route('reports_assets_by_sub_category') }}"> {{trans('back.Search')}}  </button>
                        <button class="btn btn-success btn-sm" style="margin-top: 25px" type="submit" formaction="{{route('reports_assets_by_sub_category_excel')}}"> Excel </button>
                        <a href="{{ route('reports_assets_by_sub_category') }}" style="margin-top: 25px" class="btn btn-warning" type="button" title="Reload">
                            <span class="fas fa-sync-alt"></span>
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
                            <th width="100">{{trans('back.amount_with_tax')}}</th>
                            <th width="100">{{trans('back.description')}}</th>
                            <th width="100">{{trans('back.SubCategory')}}</th>
                            <th width="100">{{trans('back.MainCategory')}}</th>
                            <th width="100">{{trans('back.supplier')}}</th>
                            <th width="100">{{trans('back.supplier_invoice_number')}}</th>
                            <th width="100">{{trans('back.amount')}}</th>
                            <th width="100">{{trans('back.tax_amount')}}</th>
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
                                <td>{{ $asset->amount_with_tax }}</td>
                                <td>{{ $asset->description }}</td>
                                <td> @if (app()->getLocale() == 'ar') {{ $asset->AssetsSubCategory->name_ar ?? "" }} @else  {{ $asset->AssetsSubCategory->name_en ?? "" }} @endif </td>
                                <td> @if (app()->getLocale() == 'ar') {{ $asset->AssetsCategory->name_ar ?? "" }} @else  {{ $asset->AssetsCategory->name_en ?? "" }} @endif </td>
                                <td>{{ $asset->supplier }}</td>
                                <td>{{ $asset->supplier_invoice_number }}</td>
                                <td>{{ $asset->amount }}</td>
                                <td>{{$asset->tax_amount}}</td>
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
                            <td>{{$amount_with_tax}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{$total_assets}}</td>
                            <td>{{$tax_amount}}</td>
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

