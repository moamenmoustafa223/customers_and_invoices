<table style="text-align: center; width: 100%;">
    <tr>
        <th colspan="8" style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 500px; ">
            تقرير المصاريف من
            {{request()->start_date}}
            إلى تاريخ
            {{request()->end_date}}
        </th>
    </tr>
</table>
<table class="text-center">
    <thead>
    <tr>
        <th style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 25px;">#</th>
        <th style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 150px;">{{trans('Expenses.the_expense_for_him')}}</th>
        <th style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 100px;">{{trans('Expenses.expense_category')}}</th>

        <th style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 100px;">{{trans('back.MainCategory')}}</th>
        <th style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 100px;">{{trans('back.SubCategory')}}</th>

        <th style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 100px;">{{trans('back.Tax_Amount')}}</th>
        <th style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 100px;"> {{trans('back.expense_amount_with_tax')}}</th>

        <th style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 100px;">{{trans('Expenses.expense_date')}}</th>
        <th style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 150px;">{{trans('Expenses.Created_at')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($reports_Expenses as $key => $expense)
        <tr>
            <td style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 25px;">{{$key+1}}</td>
            <td style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 150px;">{{ $expense->name }}</td>

            <td style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 100px;">
                @if (app()->getLocale() == 'ar')
                    {{ $expense->expense_category->name_ar ?? "" }}
                @else
                    {{ $expense->expense_category->name_en ?? "" }}
                @endif
            </td>

            <td style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 100px;">
                @if (app()->getLocale() == 'ar')
                    {{ $expense->ExpenseSubCategory->name_ar ?? "" }}
                @else
                    {{ $expense->ExpenseSubCategory->name_en ?? "" }}
                @endif
            </td>

            <td style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 100px;">{{ $expense->amount }}</td>
            <td style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 100px;"> {{ $expense->expense_amount_with_tax - $expense->amount  }}</td>
            <td style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 100px;"> {{ $expense->expense_amount_with_tax }}</td>
            <td style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 100px;">{{ $expense->expense_date }}</td>
            <td style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 150px;">{{ $expense->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 25px;"></td>
        <td style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 150px;"></td>
        <td style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 150px;"></td>
        <td style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 100px;"></td>
        <td style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 100px;"><b>{{ $total_Expenses }}</b></td>
        <td style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 100px;"><b>{{ $expense_amount_with_tax - $total_Expenses }}</b></td>
        <td style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 100px;"><b>{{ $expense_amount_with_tax }}</b></td>
        <td style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 100px;"></td>
        <td style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 150px;"></td>
    </tr>
    </tfoot>
</table>
