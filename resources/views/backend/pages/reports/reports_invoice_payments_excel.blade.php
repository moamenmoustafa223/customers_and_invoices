<table>
    <thead>
        <tr>
            <th colspan="7" style="text-align: center; font-weight: bold; font-size: 16px;">
                {{ trans('back.reports_invoice_payments') }}
            </th>
        </tr>
        @if($start_date && $end_date)
        <tr>
            <th colspan="7" style="text-align: center;">
                {{ trans('back.from') }}: {{ $start_date }} - {{ trans('back.to') }}: {{ $end_date }}
            </th>
        </tr>
        @endif
        <tr>
            <th style="font-weight: bold; background-color: #e8f5fc;">#</th>
            <th style="font-weight: bold; background-color: #e8f5fc;">{{ trans('back.payment_number') }}</th>
            <th style="font-weight: bold; background-color: #e8f5fc;">{{ trans('back.invoice_number') }}</th>
            <th style="font-weight: bold; background-color: #e8f5fc;">{{ trans('back.customer') }}</th>
            <th style="font-weight: bold; background-color: #e8f5fc;">{{ trans('back.payment_date') }}</th>
            <th style="font-weight: bold; background-color: #e8f5fc;">{{ trans('back.payment_method') }}</th>
            <th style="font-weight: bold; background-color: #e8f5fc;">{{ trans('back.amount') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($invoice_payments as $key => $payment)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $payment->payment_number }}</td>
            <td>{{ $payment->invoice->invoice_number }}</td>
            <td>{{ $payment->invoice->customer->name }}</td>
            <td>{{ $payment->payment_date->format('Y-m-d') }}</td>
            <td>
                @if($payment->paymentMethod)
                    {{ app()->getLocale() == 'ar' ? $payment->paymentMethod->name_ar : $payment->paymentMethod->name_en }}
                @else
                    -
                @endif
            </td>
            <td>{{ number_format($payment->amount, 3) }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="6" style="font-weight: bold; background-color: #e8f5fc;">{{ trans('back.Total') }}</th>
            <th style="font-weight: bold; background-color: #e8f5fc;">{{ number_format($total_amount, 3) }}</th>
        </tr>
    </tfoot>
</table>
