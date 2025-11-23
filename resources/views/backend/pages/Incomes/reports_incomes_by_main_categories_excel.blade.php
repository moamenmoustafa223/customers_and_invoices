<table style="text-align: center; vertical-align: middle">
    <tr>
        <th colspan="13" style="text-align: center; vertical-align: middle">
            {{trans('back.reports_incomes_by_main_categories')}}
            من
            {{request()->start_date}}
            إلى تاريخ
            {{request()->end_date}}
        </th>
    </tr>
</table>

<table style="text-align: center; vertical-align: middle">
    <thead>
    <tr>
        <th style="text-align: center; vertical-align: middle">#</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.expense_date')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.amount_with_tax')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.description')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.SubCategory')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.MainCategory')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.supplier')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.supplier_invoice_number')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.amount')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.tax_amount')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.payment_methods')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.Check_number')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.notes')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.Created_at')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.User')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($incomes as $key => $income)
        <tr>
            <td style="text-align: center; vertical-align: middle">{{$key+1}}</td>
            <td style="text-align: center; vertical-align: middle">{{ $income->expense_date }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $income->amount_with_tax }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $income->description }}</td>
            <td style="text-align: center; vertical-align: middle"> @if (app()->getLocale() == 'ar') {{ $income->IncomesSubCategory->name_ar ?? "" }} @else  {{ $income->IncomesSubCategory->name_en ?? "" }} @endif </td>
            <td style="text-align: center; vertical-align: middle"> @if (app()->getLocale() == 'ar') {{ $income->IncomesCategory->name_ar ?? "" }} @else  {{ $income->IncomesCategory->name_en ?? "" }} @endif </td>
            <td style="text-align: center; vertical-align: middle">{{ $income->supplier }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $income->supplier_invoice_number }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $income->amount }}</td>
            <td style="text-align: center; vertical-align: middle">{{$income->tax_amount}}</td>
            <td style="text-align: center; vertical-align: middle"> @if(app()->getLocale() == 'ar' ) {{ $income->Payment_method->name_ar }} @else {{ $income->Payment_method->name_en }} @endif</td>
            <td style="text-align: center; vertical-align: middle">{{ $income->check_number }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $income->notes }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $income->created_at }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $income->User->name ?? "" }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td style="text-align: center; vertical-align: middle"></td>
        <td style="text-align: center; vertical-align: middle"></td>
        <td style="text-align: center; vertical-align: middle">{{$amount_with_tax}}</td>
        <td style="text-align: center; vertical-align: middle"></td>
        <td style="text-align: center; vertical-align: middle"></td>
        <td style="text-align: center; vertical-align: middle"></td>
        <td style="text-align: center; vertical-align: middle"></td>
        <td style="text-align: center; vertical-align: middle"></td>
        <td style="text-align: center; vertical-align: middle">{{$total_Incomes}}</td>
        <td style="text-align: center; vertical-align: middle">{{$tax_amount}}</td>
        <td style="text-align: center; vertical-align: middle"></td>
        <td style="text-align: center; vertical-align: middle"></td>
        <td style="text-align: center; vertical-align: middle"></td>
        <td style="text-align: center; vertical-align: middle"></td>
        <td style="text-align: center; vertical-align: middle"></td>
    </tr>
    </tfoot>
</table>
