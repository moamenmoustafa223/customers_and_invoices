@extends('backend.layouts.master')

@section('page_title')
{{trans('Incomes.Incomes')}}
@endsection


@section('content')

    <div class="row">

        @can('Income_search')
        <div class="col-md-3 mb-1">
            <form action="{{ route('Incomes.index') }}" method="GET" role="search">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="query" value="{{old('query', request()->input('query'))}}" placeholder="{{trans('services.search')}}" id="query" >
                    <button class="btn btn-primary btn-sm ml-1" type="submit" title="Search">
                        <span class="fas fa-search"></span>
                    </button>
                    <a href="{{ route('Incomes.index') }}" class="btn btn-warning btn-sm ml-1 " type="button" title="Reload">
                        <span class="fas fa-sync-alt"></span>
                    </a>
                </div>
            </form>
        </div>
        @endcan

        <div class="col-md-9 mb-1">
            @can('IncomesCategory_add')
            <a class="btn btn-primary btn-sm" href="" data-bs-toggle="modal" data-bs-target="#add_incomesCategory">
                <i class="mdi mdi-plus"></i>
                {{trans('back.IncomesCategory_add')}}
            </a>
            @include('backend.pages.IncomesCategories.add')
            @endcan

            @can('IncomesSubCategory_add')
                    <a class="btn btn-success btn-sm" href="" data-bs-toggle="modal" data-bs-target="#add_IncomesSubCategory">
                        <i class="mdi mdi-plus"></i>
                        {{trans('back.IncomesSubCategory_add')}}
                    </a>
                    @include('backend.pages.IncomesSubCategories.add')
            @endcan

            @can('Income_add')
                <a class="btn btn-info btn-sm" href="" data-bs-toggle="modal" data-bs-target="#add_income">
                    <i class="mdi mdi-plus"></i>
                    {{trans('back.Income_add')}}
                </a>
                @include('backend.pages.Incomes.add')
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
                            <th width="100">{{trans('back.attached')}}</th>
                            <th width="100">{{trans('back.actions')}}</th>
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
                            {{-- File Link --}}
                            <td class="text-center">
                                @if($income->file)
                                    <a href="{{ $income->file }}" target="_blank" class="text-secondary mx-1" title="{{ trans('Incomes.show') }}">
                                        <i class="fas fa-paperclip"></i>
                                    </a>
                                @else
                                    <span class="text-muted">{{ trans('Incomes.none') }}</span>
                                @endif
                            </td>

                            {{-- Edit / Delete Actions --}}
                            <td class="text-center">

                                {{-- Edit --}}
                                @can('Income_edit')
                                    <a href="{{ route('Incomes.edit', $income->id) }}" class="text-primary mx-1" title="{{ trans('back.edit') }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan

                                {{-- Delete --}}
                                @can('Income_delete')
                                    <a href="#" class="text-danger mx-1" title="{{ trans('back.delete') }}" data-bs-toggle="modal" data-bs-target="#delete_income{{ $income->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                    @include('backend.pages.Incomes.delete')
                                @endcan

                            </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                {!! $incomes->appends(Request::all())->links() !!}

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
                url: "{{url('fetchIncomesSubCategories')}}",
                type: "POST",
                data: {
                    incomes_category_id: idCategory,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function(result) {
                    $('.SubCategory').html('<option selected disabled value="">Select</option>');
                    $.each(result.IncomesSubCategories, function (key, value) {
                        $(".SubCategory").append('<option value="' + value
                            .id + '">' + value.name_ar + '</option>');
                    });
                }
            });
        });
    </script>

@endsection


