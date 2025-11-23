@extends('backend.layouts.master')
@section('page_title')
    {{ trans('back.show_customer_category') }}
@endsection

@section('content')
    <div>
        <a class="btn btn-primary btn-sm mb-1" href="{{ route('customer_categories.index') }}">
            <i class="fas fa-undo"></i>
            {{ trans('back.Turn_back') }}
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center font-weight-bold mb-3">
                            <h4>{{ trans('back.customer_category') }}</h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <td width="200"><strong>{{ trans('back.name_ar') }}:</strong></td>
                                <td>{{ $customerCategory->name_ar }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ trans('back.name_en') }}:</strong></td>
                                <td>{{ $customerCategory->name_en }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ trans('back.status') }}:</strong></td>
                                <td>
                                    @if ($customerCategory->status == 'active')
                                        <span class="badge bg-success">{{ trans('back.active') }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ trans('back.inactive') }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>{{ trans('back.customers') }}:</strong></td>
                                <td>{{ $customerCategory->customers->count() }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if ($customerCategory->customers->count() > 0)
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="mb-3">{{ trans('back.customers') }}</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered text-center table-sm">
                                    <thead class="thead-light">
                                        <tr style="background-color: #b5d7ea">
                                            <th>#</th>
                                            <th>{{ trans('back.customer_name') }}</th>
                                            <th>{{ trans('back.phone') }}</th>
                                            <th>{{ trans('back.email') }}</th>
                                            <th>{{ trans('back.status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customerCategory->customers as $key => $customer)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $customer->name }}</td>
                                                <td>{{ $customer->phone }}</td>
                                                <td>{{ $customer->email }}</td>
                                                <td>
                                                    @if ($customer->status == 'active')
                                                        <span class="badge bg-success">{{ trans('back.active') }}</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ trans('back.inactive') }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
