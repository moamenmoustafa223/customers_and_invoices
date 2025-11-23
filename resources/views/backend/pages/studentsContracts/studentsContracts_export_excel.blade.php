<table style="text-align: center; vertical-align: middle">
    <tr>
        <th colspan="15" style="text-align: center; vertical-align: middle">
            {{trans('back.reports_students_contracts')}}
        </th>
    </tr>
</table>

<table style="text-align: center; vertical-align: middle">
    <thead>
    <tr>
        <th style="text-align: center; vertical-align: middle">#</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.contract_number')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.student')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.academic_year')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.contract_date')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.bus')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.sub_total')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.discount')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.amount_after_discount')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.tax_value')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.total_amount_with_tax')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.paid')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.rest_amount')}}</th>
        <th style="text-align: center; vertical-align: middle">{{trans('back.Created_at')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($studentsContracts as $key => $studentsContract)
        <tr>
            <td style="text-align: center; vertical-align: middle">{{$key+1}}</td>
            <td style="text-align: center; vertical-align: middle">{{$studentsContract->contract_number}}</td>
            <td style="text-align: center; vertical-align: middle">
                {{$studentsContract->Student->first_name}} {{$studentsContract->Student->father_name}} {{$studentsContract->Student->grandfather_name}}
                <br>
                {{$studentsContract->Student->Guardian->phone}}
                <br>
                {{$studentsContract->student_number}}
            </td>
            <td style="text-align: center; vertical-align: middle">
                {{$studentsContract->AcademicYear->academic_year ?? ''}}
                <br>
                {{app()->getLocale() == 'ar' ? $studentsContract->Classroom->name_ar : $studentsContract->Classroom->name_en}}
                <br>
                {{app()->getLocale() == 'ar' ? $studentsContract->Section->name_ar : $studentsContract->Section->name_en}}
            </td>
            <td style="text-align: center; vertical-align: middle"> {{$studentsContract->contract_date}}</td>
            <td style="text-align: center; vertical-align: middle">
                {{$studentsContract->Bus->bus_number ?? ''}}
                <br>
                {{$studentsContract->Bus->bus_driver ?? ''}}
                <br>
                {{$studentsContract->Bus->bus_driver_phone ?? ''}}
            </td>

            <td style="text-align: center; vertical-align: middle"> {{$studentsContract->sub_total}}</td>
            <td style="text-align: center; vertical-align: middle"> {{$studentsContract->discount}}</td>
            <td style="text-align: center; vertical-align: middle"> {{$studentsContract->amount_after_discount}}</td>
            <td style="text-align: center; vertical-align: middle"> {{$studentsContract->tax_value}}</td>
            <td style="text-align: center; vertical-align: middle"> {{$studentsContract->total_amount_with_tax}}</td>

            <td style="text-align: center; vertical-align: middle"> {{$studentsContract->Payments->sum('payment_amount')}}</td>
            <td style="text-align: center; vertical-align: middle"> {{$studentsContract->total_amount_with_tax - $studentsContract->Payments->sum('payment_amount')}}</td>
            <td style="text-align: center; vertical-align: middle">{{$studentsContract->created_at}}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr style="text-align: center; vertical-align: middle">
        <th style="text-align: center; vertical-align: middle" colspan="11"></th>
        <th style="text-align: center; vertical-align: middle">{{ number_format($studentsContracts->sum('total_amount_with_tax'), 2) }}</th>
        <th style="text-align: center; vertical-align: middle">
            {{ number_format($studentsContracts->flatMap->Payments->sum('payment_amount'), 2) }}
        </th>
        <th style="text-align: center; vertical-align: middle">{{ number_format($studentsContracts->sum('total_amount_with_tax') - $studentsContracts->flatMap->Payments->sum('payment_amount'), 2) }}</th>
        <th style="text-align: center; vertical-align: middle"></th>
    </tr>
    </tfoot>
</table>
