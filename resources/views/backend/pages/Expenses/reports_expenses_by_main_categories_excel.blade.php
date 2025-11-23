<table style="text-align: center; vertical-align: middle">
    <tr>
        <th colspan="14" style="text-align: center; vertical-align: middle">
            {{trans('back.reports_expenses_by_main_categories')}}
            من
            {{request()->start_date}}
            إلى تاريخ
            {{request()->end_date}}
        </th>
    </tr>
</table>


<table class="text-center">
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
    @foreach($reports_Expenses as $key => $expense)
        <tr>
            <td style="text-align: center; vertical-align: middle" >{{$key+1}}</td>
            <td style="text-align: center; vertical-align: middle">{{ $expense->expense_date }}</td>
            <td style="text-align: center; vertical-align: middle"> {{ $expense->amount_with_tax }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $expense->description }}</td>
            <td style="text-align: center; vertical-align: middle"> @if (app()->getLocale() == 'ar') {{ $expense->ExpenseSubCategory->name_ar ?? "" }} @else  {{ $expense->ExpenseSubCategory->name_en ?? "" }} @endif </td>
            <td style="text-align: center; vertical-align: middle"> @if (app()->getLocale() == 'ar') {{ $expense->ExpenseCategory->name_ar ?? "" }} @else  {{ $expense->ExpenseCategory->name_en ?? "" }} @endif </td>
            <td style="text-align: center; vertical-align: middle">{{ $expense->supplier }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $expense->supplier_invoice_number }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $expense->amount }}</td>
            <td style="text-align: center; vertical-align: middle"> {{ $expense->tax_amount }}</td>
            <td style="text-align: center; vertical-align: middle"> @if(app()->getLocale() == 'ar' ) {{ $expense->Payment_method->name_ar }} @else {{ $expense->Payment_method->name_en }} @endif</td>
            <td style="text-align: center; vertical-align: middle">{{ $expense->check_number }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $expense->notes }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $expense->created_at }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $expense->User->name ?? "" }}</td>
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
        <td style="text-align: center; vertical-align: middle">{{$total_Expenses}}</td>
        <td style="text-align: center; vertical-align: middle">{{$tax_amount}}</td>
        <td style="text-align: center; vertical-align: middle"></td>
        <td style="text-align: center; vertical-align: middle"></td>
        <td style="text-align: center; vertical-align: middle"></td>
        <td style="text-align: center; vertical-align: middle"></td>
        <td style="text-align: center; vertical-align: middle"></td>
    </tr>
    </tfoot>
</table>
