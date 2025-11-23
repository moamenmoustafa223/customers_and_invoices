<table class="table table-bordered text-center table-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('payment_methods.transaction_date') }}</th>
            <th>{{ trans('payment_methods.payment_methods') }}</th>
            <th>{{ trans('payment_methods.type') }}</th>
            <th>{{ trans('payment_methods.amount') }}</th>
            <th>{{ trans('payment_methods.source_type') }}</th>
            <th>{{ trans('payment_methods.description') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions as $key => $txn)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $txn->transaction_date }}</td>
                <td>{{ app()->getLocale() == 'ar' ? $txn->payment_method->name_ar : ($txn->payment_method->name_en ?? '-') }}</td>
                <td class="{{ $txn->type == 'credit' ? 'text-success' : 'text-danger' }}">
                    {{ trans('back.' . $txn->type) }}
                </td>
                <td>{{ number_format($txn->amount, 3) }}</td>
                <td>{{ $txn->source_type }}</td>
                <td>{{ $txn->description }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr style="background-color: #eaf8ef">
            <th colspan="4">{{ trans('back.total_credit') }}:</th>
            <th colspan="3" class="text-success">{{ number_format($totalCredit, 3) }}</th>
        </tr>
        <tr style="background-color: #f8eaea">
            <th colspan="4">{{ trans('back.total_debit') }}:</th>
            <th colspan="3" class="text-danger">{{ number_format($totalDebit, 3) }}</th>
        </tr>
    </tfoot>
</table>

