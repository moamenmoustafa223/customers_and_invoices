<table>
    <thead>
        <tr>
            <th colspan="9" style="text-align: center; font-weight: bold; font-size: 16px;">
                {{ trans('back.reports_invoices') }}
            </th>
        </tr>
        @if($start_date && $end_date)
        <tr>
            <th colspan="9" style="text-align: center;">
                {{ trans('back.from') }}: {{ $start_date }} - {{ trans('back.to') }}: {{ $end_date }}
            </th>
        </tr>
        @endif
        <tr>
            <th style="font-weight: bold; background-color: #e8f5fc;">#</th>
            <th style="font-weight: bold; background-color: #e8f5fc;">{{ trans('back.invoice_number') }}</th>
            <th style="font-weight: bold; background-color: #e8f5fc;">{{ trans('back.customer') }}</th>
            <th style="font-weight: bold; background-color: #e8f5fc;">{{ trans('back.invoice_date') }}</th>
            <th style="font-weight: bold; background-color: #e8f5fc;">{{ trans('back.due_date') }}</th>
            <th style="font-weight: bold; background-color: #e8f5fc;">{{ trans('back.status') }}</th>
            <th style="font-weight: bold; background-color: #e8f5fc;">{{ trans('back.total') }}</th>
            <th style="font-weight: bold; background-color: #e8f5fc;">{{ trans('back.paid_amount') }}</th>
            <th style="font-weight: bold; background-color: #e8f5fc;">{{ trans('back.remaining_amount') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($invoices as $key => $invoice)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $invoice->invoice_number }}</td>
            <td>{{ $invoice->customer->name }}</td>
            <td>{{ $invoice->invoice_date->format('Y-m-d') }}</td>
            <td>{{ $invoice->due_date->format('Y-m-d') }}</td>
            <td>{{ app()->getLocale() == 'ar' ? $invoice->status->name_ar : $invoice->status->name_en }}</td>
            <td>{{ number_format($invoice->total, 3) }}</td>
            <td>{{ number_format($invoice->paid_amount, 3) }}</td>
            <td>{{ number_format($invoice->remaining_amount, 3) }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="6" style="font-weight: bold; background-color: #e8f5fc;">{{ trans('back.Total') }}</th>
            <th style="font-weight: bold; background-color: #e8f5fc;">{{ number_format($total_amount, 3) }}</th>
            <th style="font-weight: bold; background-color: #e8f5fc;">{{ number_format($total_paid, 3) }}</th>
            <th style="font-weight: bold; background-color: #e8f5fc;">{{ number_format($total_remaining, 3) }}</th>
        </tr>
    </tfoot>
</table>
