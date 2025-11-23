<table>
    <thead>
        <tr>
            <th colspan="7" style="text-align: center; font-weight: bold; font-size: 16px;">
                {{ trans('back.reports_installments') }}
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
            <th style="font-weight: bold; background-color: #e8f5fc;">{{ trans('back.invoice_number') }}</th>
            <th style="font-weight: bold; background-color: #e8f5fc;">{{ trans('back.customer') }}</th>
            <th style="font-weight: bold; background-color: #e8f5fc;">{{ trans('back.due_date') }}</th>
            <th style="font-weight: bold; background-color: #e8f5fc;">{{ trans('back.amount') }}</th>
            <th style="font-weight: bold; background-color: #e8f5fc;">{{ trans('back.status') }}</th>
            <th style="font-weight: bold; background-color: #e8f5fc;">{{ trans('back.days_overdue') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($installments as $key => $installment)
        @php
            $daysOverdue = 0;
            if($installment->status == 'unpaid' && $installment->due_date < now()) {
                $daysOverdue = $installment->due_date->diffInDays(now());
            }
        @endphp
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $installment->invoice->invoice_number }}</td>
            <td>{{ $installment->invoice->customer->name }}</td>
            <td>{{ $installment->due_date->format('Y-m-d') }}</td>
            <td>{{ number_format($installment->amount, 3) }}</td>
            <td>
                @if($installment->status == 'paid')
                    {{ trans('back.paid') }}
                @else
                    {{ trans('back.unpaid') }}
                @endif
            </td>
            <td>{{ $daysOverdue > 0 ? $daysOverdue . ' ' . trans('back.days') : '-' }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="4" style="font-weight: bold; background-color: #e8f5fc;">{{ trans('back.Total') }}</th>
            <th style="font-weight: bold; background-color: #e8f5fc;">{{ number_format($total_amount, 3) }}</th>
            <th colspan="2" style="font-weight: bold; background-color: #e8f5fc;"></th>
        </tr>
    </tfoot>
</table>
