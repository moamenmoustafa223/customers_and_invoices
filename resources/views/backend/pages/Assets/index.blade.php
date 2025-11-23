@extends('backend.layouts.master')

@section('page_title')
{{trans('back.assets')}}
@endsection

@section('content')

    <div class="row">

        <div class="col-md-3 mb-1">
            <form action="{{ route('Assets.index') }}" method="GET" role="search">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="query" value="{{old('query', request()->input('query'))}}" placeholder="{{trans('services.search')}}" id="query" >
                    <button class="btn btn-primary btn-sm ml-1" type="submit" title="Search">
                        <span class="fas fa-search"></span>
                    </button>
                    <a href="{{ route('Assets.index') }}" class="btn btn-success btn-sm ml-1 " type="button" title="Reload">
                        <span class="fas fa-sync-alt"></span>
                    </a>
                </div>
            </form>
        </div>

        <div class="col-md-9 mb-1">

            @can('add_new_AssetsCategory')
                <a class="btn btn-primary btn-sm" href="" data-bs-toggle="modal" data-bs-target="#add_expenseCategory">
                    <i class="mdi mdi-plus"></i>
                    {{trans('back.add_new_AssetsCategory')}}
                </a>
                @include('backend.pages.AssetsCategories.add')
            @endcan

            @can('add_new_AssetsSubCategory')
                <a class="btn btn-warning btn-sm text-dark" href="" data-bs-toggle="modal" data-bs-target="#add_AssetsSubCategory">
                    <i class="mdi mdi-plus"></i>
                    {{trans('back.add_new_AssetsSubCategory')}}
                </a>
                @include('backend.pages.AssetsSubCategories.add')
            @endcan

            @can('add_new_asset')
                <a class="btn btn-info btn-sm" href="" data-bs-toggle="modal" data-bs-target="#add_asset">
                    <i class="mdi mdi-plus"></i>
                    {{trans('back.add_new_asset')}}
                </a>
                @include('backend.pages.Assets.add')
            @endcan
        </div>


    </div>

    <div class="row">
        <div class="col-12">
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

                            <th width="100">{{trans('back.attached')}}</th>
                            <th width="100">{{trans('back.actions')}}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($assets as $key => $asset)
                            <tr>
                                <td>{{$key+ $assets->firstItem()}}</td>
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
                                <td class="text-center">
                                    @if($asset->file)
                                        <a href="{{$asset->file}}" target="_blank" class="text-secondary mx-1" title="{{ trans('Incomes.show') }}">
                                            <i class="fas fa-paperclip"></i>
                                        </a>
                                    @else
                                        <span class="text-muted">{{ trans('Incomes.none') }}</span>
                                    @endif
                                </td>
                                
                                <td class="text-center">
                                
                                    {{-- Edit --}}
                                    @can('edit_asset')
                                        <a href="{{ route('Assets.edit', $asset->id) }}" class="text-primary mx-1" title="{{ trans('back.edit') }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan
                                
                                    {{-- Delete --}}
                                    @can('delete_asset')
                                        <a href="#" class="text-danger mx-1" title="{{ trans('back.delete') }}" data-bs-toggle="modal" data-bs-target="#delete_asset{{ $asset->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        @include('backend.pages.Assets.delete')
                                    @endcan
                                
                                </td>
                                
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $assets->appends(Request::all())->links() !!}
                </div>

            </div>
        </div>
    </div>

@endsection


@section('js')

    <script>
        // حساب الضريبة في الاضافة
        $(function() {
            $(".amount, .tax").on("keydown keyup", sum);

            function sum() {
                let amount = Number($('.amount').val()) ||0;
                let tax = Number($(".tax").val()) ||0;
                let tax_amount = amount * (tax/100);
                $('.amount_with_tax').val(amount + tax_amount).toFixed(3);
            }
        });
    </script>


    <script>
        $('.Category').change(function (){

            var idCategory = this.value;

            $(".SubCategory").html('');
            $.ajax({
                url: "{{url('fetchAssetsSubCategories')}}",
                type: "POST",
                data: {
                    assets_category_id: idCategory,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function(result) {
                    $('.SubCategory').html('<option selected disabled value="">Select</option>');
                    $.each(result.AssetsSubCategories, function (key, value) {
                        $(".SubCategory").append('<option value="' + value
                            .id + '">' + value.name_ar + '</option>');
                    });
                }
            });
        });
    </script>

@endsection


