<table style="text-align: center; vertical-align: middle">
    <tr>
        <th colspan="16" style="text-align: center; vertical-align: middle">
            {{trans('back.reports_assets_by_sub_category')}}
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
        <th style="text-align: center; vertical-align: middle">{{trans('back.depreciation_rate')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.code_no')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($reports_assets as $key => $asset)
        <tr>
            <td style="text-align: center; vertical-align: middle">{{$key+1}}</td>
            <td style="text-align: center; vertical-align: middle">{{ $asset->expense_date }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $asset->amount_with_tax }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $asset->description }}</td>
            <td style="text-align: center; vertical-align: middle"> @if (app()->getLocale() == 'ar') {{ $asset->AssetsSubCategory->name_ar ?? "" }} @else  {{ $asset->AssetsSubCategory->name_en ?? "" }} @endif </td>
            <td style="text-align: center; vertical-align: middle"> @if (app()->getLocale() == 'ar') {{ $asset->AssetsCategory->name_ar ?? "" }} @else  {{ $asset->AssetsCategory->name_en ?? "" }} @endif </td>
            <td style="text-align: center; vertical-align: middle">{{ $asset->supplier }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $asset->supplier_invoice_number }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $asset->amount }}</td>
            <td style="text-align: center; vertical-align: middle">{{$asset->tax_amount}}</td>
            <td style="text-align: center; vertical-align: middle"> @if(app()->getLocale() == 'ar' ) {{ $asset->Payment_method->name_ar }} @else {{ $asset->Payment_method->name_en }} @endif</td>
            <td style="text-align: center; vertical-align: middle">{{ $asset->check_number }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $asset->notes }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $asset->created_at }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $asset->User->name ?? "" }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $asset->depreciation_rate }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $asset->code_no }}</td>
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
        <td style="text-align: center; vertical-align: middle">{{$total_assets}}</td>
        <td style="text-align: center; vertical-align: middle">{{$tax_amount}}</td>
        <td style="text-align: center; vertical-align: middle"></td>
        <td style="text-align: center; vertical-align: middle"></td>
        <td style="text-align: center; vertical-align: middle"></td>
        <td style="text-align: center; vertical-align: middle"></td>
        <td style="text-align: center; vertical-align: middle"></td>
        <td style="text-align: center; vertical-align: middle"></td>
        <td style="text-align: center; vertical-align: middle"></td>
    </tr>
    </tfoot>
</table>
