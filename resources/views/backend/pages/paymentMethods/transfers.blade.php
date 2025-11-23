@extends('backend.layouts.master')

@section('page_title')
    {{ trans('payment_methods.transfer_history') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 ">
            <form method="GET" action="{{ route('paymentMethods.transfers') }}">
                <div class="row align-items-end">

                    {{-- From Date --}}
                    <div class="col-md-2">
                        <label class="form-label">{{ trans('payment_methods.from_date') }}</label>
                        <input type="date" name="from_date" class="form-control form-control-sm"
                            value="{{ request('from_date', \Carbon\Carbon::today()->toDateString()) }}">
                    </div>

                    {{-- To Date --}}
                    <div class="col-md-2">
                        <label class="form-label">{{ trans('payment_methods.to_date') }}</label>
                        <input type="date" name="to_date" class="form-control form-control-sm"
                            value="{{ request('to_date', \Carbon\Carbon::today()->toDateString()) }}">
                    </div>

                    {{-- Action Buttons --}}
                    {{-- Action Buttons --}}
                    <div class="col-md-4 d-flex gap-1">
                        <button type="submit" class="btn btn-primary ">
                            <i class="fas fa-search"></i>
                        </button>

                        <a href="{{ route('paymentMethods.transfers') }}" class="btn btn-warning "
                            title="{{ trans('global.reset') }}">
                            <i class="fas fa-sync-alt"></i>
                        </a>

                        <button formaction="{{ route('paymentMethods.exportTransferHistory', request()->all()) }}"
                            class="btn btn-success " type="submit">
                            <i class="fas fa-file-excel"></i>
                        </button>
                    </div>


                </div>
            </form>
        </div>
    </div>



    <div class="card shadow-sm border-0 rounded-4 p-4 bg-white mt-2">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="text-primary fw-bold mb-0">
                <i class="fas fa-random me-2 text-success"></i>
                {{ trans('payment_methods.transfer_history') }}
            </h5>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-center small">
                <thead class="bg-light text-dark fw-bold">
                    <tr>
                        <th>#</th>
                        <th><i class="fas fa-arrow-circle-left me-1 text-muted"></i> {{ trans('payment_methods.from') }}
                        </th>
                        <th><i class="fas fa-arrow-circle-right me-1 text-muted"></i> {{ trans('payment_methods.to') }}
                        </th>
                        <th><i class="fas fa-coins me-1 text-muted"></i> {{ trans('payment_methods.amount') }}</th>
                        <th><i class="fas fa-calendar-alt me-1 text-muted"></i>
                            {{ trans('payment_methods.transfer_date') }}</th>
                        <th><i class="fas fa-sticky-note me-1 text-muted"></i> {{ trans('payment_methods.notes') }}</th>
                        <th><i class="fas fa-paperclip me-1 text-muted"></i> {{ trans('payment_methods.attachment') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($paymentMethodTransfers as $key => $transfer)
                        <tr>
                            <td>{{ $key + $paymentMethodTransfers->firstItem() }}</td>
                            <td class="text-danger">{{ $transfer->fromPaymentMethod->name_ar }}</td>
                            <td class="text-success">{{ $transfer->toPaymentMethod->name_ar }}</td>
                            <td class="fw-bold text-primary">{{ number_format($transfer->amount, 3) }}</td>
                            <td>{{ \Carbon\Carbon::parse($transfer->transfer_date)->format('Y-m-d') }}</td>
                            <td class="text-secondary">{{ $transfer->notes ?: '-' }}</td>
                            <td>
                                @if($transfer->attachment)
                                    <a href="{{ Storage::disk('s3')->url($transfer->attachment) }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="fas fa-download"></i> {{ trans('payment_methods.view') }}
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-danger">{{ trans('payment_methods.no_transfer_history') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3 d-flex justify-content-center">
            {{ $paymentMethodTransfers->appends(request()->all())->links() }}
        </div>
    </div>
@endsection
