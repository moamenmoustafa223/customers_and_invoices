@extends('backend.layouts.master')

@section('page_title')
    {{ trans('menu.payment_methods') }}
@endsection

@section('content')

    <div class="row ">
        <div class="col-md-12 ">
            @can('payment_methods_add')
                <a class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#add_payment_method">
                    <i class="mdi mdi-plus"></i>
                    {{ trans('payment_methods.Add_New_payment_methods') }}
                </a>
                @include('backend.pages.paymentMethods.add')
            @endcan
        </div>
        <div class="col-md-12 mt-2">
            <div class="alert alert-success" role="alert">
                <strong>ملاحظة هامة:</strong>
                يتم إعداد وإضافة طرق الدفع لمرة واحدة فقط، لأنها مرتبطة بعمليات الدفع في النظام. التعديل أو الحذف قد يسبب خللاً في العمليات الحسابية.
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card-box">

            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered text-center table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><i class="fas fa-money-bill-wave text-muted me-1"></i>{{ trans('payment_methods.name_ar') }}</th>
                            <th>{{ trans('payment_methods.name_en') }}</th>

                            <th><i class="fas fa-wallet text-muted me-1"></i>{{ trans('payment_methods.current_balance') }}</th>
                            <th><i class="fas fa-calendar-alt text-muted me-1"></i>{{ trans('customers.Created_at') }}</th>
                            <th><i class="fas fa-tools text-muted me-1"></i>{{ trans('customers.Action') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($paymentMethods as $key => $payment_method)
                            @php
                                $balance = $payment_method->balance->current_balance ?? 0;
                            @endphp
                            <tr>
                                <td>{{ $key + $paymentMethods->firstItem() }}</td>
                                <td class="text-danger fw-semibold">{{ $payment_method->name_ar }}</td>
                                <td>{{ $payment_method->name_en }}</td>

                                <td class="{{ $balance >= 0 ? 'text-success' : 'text-danger' }}">
                                    <strong>{{ number_format($balance, 3) }}</strong>
                                </td>
                                <td>{{ $payment_method->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        @can('payment_methods_edit')
                                            <a href="#" class="btn btn-outline-primary btn-sm me-1" title="{{ trans('verbs.edit') }}"
                                               data-bs-toggle="modal" data-bs-target="#edit_payment_method{{ $payment_method->id }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @include('backend.pages.paymentMethods.edit')
                                        @endcan
                                        @can('add_transfer')
                                            @if($balance > 0)
                                                <a href="#" class="btn btn-outline-success btn-sm" title="{{ trans('payment_methods.transfer_between_methods') }}"
                                                   data-bs-toggle="modal" data-bs-target="#transfer_payment_method_{{ $payment_method->id }}">
                                                    <i class="fas fa-random"></i>
                                                </a>
                                                @include('backend.pages.paymentMethods.transfer', ['current' => $payment_method])
                                            @endif
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {!! $paymentMethods->appends(request()->all())->links() !!}
            </div>

        </div>
    </div>

@endsection
