<table>
    <thead>
        <tr>
            <th colspan="7" style="text-align: center; font-weight: bold; font-size: 16px;">
                {{ trans('back.reports_quotations') }}
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
            <th style="font-weight: bold; background-color: #e8f5fc;">{{ trans('back.quotation_number') }}</th>
            <th style="font-weight: bold; background-color: #e8f5fc;">{{ trans('back.customer') }}</th>
            <th style="font-weight: bold; background-color: #e8f5fc;">{{ trans('back.quotation_date') }}</th>
            <th style="font-weight: bold; background-color: #e8f5fc;">{{ trans('back.valid_until') }}</th>
            <th style="font-weight: bold; background-color: #e8f5fc;">{{ trans('back.status') }}</th>
            <th style="font-weight: bold; background-color: #e8f5fc;">{{ trans('back.total') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($quotations as $key => $quotation)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $quotation->quotation_number }}</td>
            <td>{{ $quotation->customer->name }}</td>
            <td>{{ $quotation->quotation_date->format('Y-m-d') }}</td>
            <td>{{ $quotation->valid_until->format('Y-m-d') }}</td>
            <td>
                @if($quotation->status == 'pending')
                    {{ trans('back.pending') }}
                @elseif($quotation->status == 'accepted')
                    {{ trans('back.accepted') }}
                @elseif($quotation->status == 'rejected')
                    {{ trans('back.rejected') }}
                @else
                    {{ $quotation->status }}
                @endif
            </td>
            <td>{{ number_format($quotation->total, 3) }}</td>
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
