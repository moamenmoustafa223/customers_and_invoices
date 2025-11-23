<table style="text-align: center; vertical-align: middle">
    <tr>
        <th colspan="15">
            {{ trans('back.reports_expenses_by_main_categories') }}
            {{ trans('back.from') }}
            {{ request()->start_date }}
            {{ trans('back.to') }}
            {{ request()->end_date }}
        </th>
    </tr>
</table>

<table class="text-center" style="width:100%; border-collapse: collapse">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('back.expense_date') }}</th>
            <th>{{ trans('back.description') }}</th>
            <th>{{ trans('back.SubCategory') }}</th>
            <th>{{ trans('back.MainCategory') }}</th>
            <th>{{ trans('back.supplier') }}</th>
            <th>{{ trans('back.supplier_invoice_number') }}</th>
            <th>{{ trans('back.amount') }}</th>
            <th>{{ trans('back.tax_amount') }}</th>
            <th>{{ trans('back.amount_with_tax') }}</th>
            <th>{{ trans('back.payment_methods') }}</th>
            <th>{{ trans('back.Check_number') }}</th>
            <th>{{ trans('back.notes') }}</th>
            <th>{{ trans('back.Created_at') }}</th>
            <th>{{ trans('back.User') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reports_expenses as $key => $expense)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $expense->expense_date }}</td>
                <td>{{ $expense->description }}</td>
                <td>{{ app()->getLocale() == 'ar' ? $expense->ExpenseSubCategory->name_ar ?? '' : $expense->ExpenseSubCategory->name_en ?? '' }}</td>
                <td>{{ app()->getLocale() == 'ar' ? $expense->ExpenseCategory->name_ar ?? '' : $expense->ExpenseCategory->name_en ?? '' }}</td>
                <td>{{ $expense->supplier }}</td>
                <td>{{ $expense->supplier_invoice_number }}</td>
                <td>{{ number_format($expense->amount, 3) }}</td>
                <td>{{ number_format($expense->tax_amount, 3) }}</td>
                <td>{{ number_format($expense->amount_with_tax, 3) }}</td>
                <td>{{ app()->getLocale() == 'ar' ? $expense->Payment_method->name_ar ?? '' : $expense->Payment_method->name_en ?? '' }}</td>
                <td>{{ $expense->check_number }}</td>
                <td>{{ $expense->notes }}</td>
                <td>{{ $expense->created_at }}</td>
                <td>{{ $expense->User->name ?? '' }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td></td>
            <td colspan="5"></td>
            <td>{{ number_format($total_expenses, 3) }}</td>
            <td>{{ number_format($tax_amount, 3) }}</td>
            <td>{{ number_format($amount_with_tax, 3) }}</td>
            <td colspan="5"></td>
        </tr>
    </tfoot>
</table>
