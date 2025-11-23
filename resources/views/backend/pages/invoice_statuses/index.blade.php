@extends('backend.layouts.master')
@section('page_title')
    {{ trans('back.invoice_statuses') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-3">
            <form action="{{ route('invoice_statuses.index') }}" method="GET">
                <div class="row g-2 align-items-end">
                    <div class="col-md-8 d-flex justify-content-start align-items-end">
                        @can('add_invoice_status')
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#add_invoice_status">
                                <i class="fas fa-plus"></i> {{ trans('back.add_invoice_status') }}
                            </button>
                        @endcan
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small mb-1">{{ trans('back.search') }}</label>
                        <input type="text" name="query" value="{{ request('query') }}" class="form-control form-control-sm"
                            placeholder="{{ trans('back.search') }}...">
                    </div>
                    <div class="col-md-1 d-flex align-items-end gap-1">
                        <button class="btn btn-primary btn-sm" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('invoice_statuses.index') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="table-responsive">
                    <table class="table table-bordered text-center table-sm">
                        <thead>
                            <tr style="background-color: rgb(232,245,252)">
                                <th width="25">#</th>
                                <th>{{ trans('back.name_ar') }}</th>
                                <th>{{ trans('back.name_en') }}</th>
                                <th>{{ trans('back.color') }}</th>
                                <th>{{ trans('back.invoices') }}</th>
                                <th width="150">{{ trans('back.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoiceStatuses as $key => $status)
                                <tr>
                                    <td>{{ $key + $invoiceStatuses->firstItem() }}</td>
                                    <td>{{ $status->name_ar }}</td>
                                    <td>{{ $status->name_en }}</td>
                                    <td>
                                        <span class="badge" style="background-color: {{ $status->color }}">
                                            {{ $status->color }}
                                        </span>
                                    </td>
                                    <td>{{ $status->invoices_count }}</td>
                                    <td>
                                        @can('show_invoice_status')
                                            <a href="{{ route('invoice_statuses.show', $status->id) }}" class="text-info"
                                                title="{{ trans('back.show') }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endcan
                                        @can('edit_invoice_status')
                                            <a href="{{ route('invoice_statuses.edit', $status->id) }}" class="text-primary"
                                                title="{{ trans('back.edit') }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan
                                        @can('delete_invoice_status')
                                            <a href="#" class="text-danger" data-bs-toggle="modal"
                                                data-bs-target="#delete_invoice_status{{ $status->id }}"
                                                title="{{ trans('back.delete') }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                                @include('backend.pages.invoice_statuses.delete')
                            @empty
                                <tr>
                                    <td colspan="6">{{ trans('back.no_data_available') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {!! $invoiceStatuses->appends(Request::all())->links() !!}
            </div>
        </div>
    </div>

    @include('backend.pages.invoice_statuses.add')
@endsection
