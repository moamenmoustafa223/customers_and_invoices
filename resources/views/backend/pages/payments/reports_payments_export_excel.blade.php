<table style="text-align: center; vertical-align: middle">
    <tr style="text-align: center; vertical-align: middle">
        <th colspan="12" style="text-align: center; vertical-align: middle">
            {{trans('back.reports_payments')}}
            من
            {{request()->start_date}}
            إلى تاريخ
            {{request()->end_date}}
        </th>
    </tr>
</table>

<table style="text-align: center; vertical-align: middle">
    <thead>
    <tr style="text-align: center; vertical-align: middle">
        <th style="text-align: center; vertical-align: middle">#</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.receipt_number')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.student')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.phone')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.academic_year')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.classroom')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.contract_number')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.payment_date')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.payment_method')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.payment_amount')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.Created_at')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.User')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($payments as $key => $payment)
        <tr>
            <td style="text-align: center; vertical-align: middle">{{$key+1}}</td>
            <td style="text-align: center; vertical-align: middle">{{$payment->payment_number}}</td>
            <td style="text-align: center; vertical-align: middle">{{$payment->Student->first_name}}</td>
            <td style="text-align: center; vertical-align: middle">{{$payment->Student->phone}}</td>
            <td style="text-align: center; vertical-align: middle">{{$payment->AcademicYear->academic_year}}</td>
            <td style="text-align: center; vertical-align: middle">{{app()->getLocale() == 'ar' ? $payment->Classroom->name_ar : $payment->Classroom->name_en}}</td>
            <td style="text-align: center; vertical-align: middle">{{$payment->StudentsContract->contract_number}}</td>
            <td style="text-align: center; vertical-align: middle">{{$payment->payment_date}}</td>
            <td style="text-align: center; vertical-align: middle">
                @if (app()->getLocale() == 'ar')
                    {{$payment->Payment_method->name_ar}}
                @else
                    {{$payment->Payment_method->name_en}}
                @endif
            </td>
            <td style="text-align: center; vertical-align: middle">{{number_format($payment->payment_amount, 3)}}</td>
            <td style="text-align: center; vertical-align: middle">{{$payment->created_at}}</td>
            <td style="text-align: center; vertical-align: middle">{{$payment->User->name}}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align: center; vertical-align: middle"></td>
            <td style="text-align: center; vertical-align: middle"></td>
            <td style="text-align: center; vertical-align: middle"></td>
            <td style="text-align: center; vertical-align: middle"></td>
            <td style="text-align: center; vertical-align: middle"></td>
            <td style="text-align: center; vertical-align: middle"></td>
            <td style="text-align: center; vertical-align: middle"></td>
            <td style="text-align: center; vertical-align: middle"></td>
            <td style="text-align: center; vertical-align: middle"></td>
            <td style="text-align: center; vertical-align: middle">
                {{trans('back.total_amount')}}
                <br>
                {{number_format($total_payment_amount, 3)}}
            </td>
            <td style="text-align: center; vertical-align: middle"></td>
            <td style="text-align: center; vertical-align: middle"></td>
        </tr>
    </tfoot>
</table>


