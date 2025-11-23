<table>
    <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('payment_methods.from') }}</th>
            <th>{{ trans('payment_methods.to') }}</th>
            <th>{{ trans('payment_methods.amount') }}</th>
            <th>{{ trans('payment_methods.transfer_date') }}</th>
            <th>{{ trans('payment_methods.notes') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transfers as $key => $transfer)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $transfer->fromPaymentMethod->name_ar }}</td>
                <td>{{ $transfer->toPaymentMethod->name_ar }}</td>
                <td>{{ number_format($transfer->amount, 3) }}</td>
                <td>{{ $transfer->transfer_date }}</td>
                <td>{{ $transfer->notes ?: '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
