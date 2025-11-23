<?php

namespace App\Exports;

use App\Models\Payment;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class PaymentsExport implements FromView, WithEvents, ShouldAutoSize
{

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
            },
        ];
    }


    protected $startDate;
    protected $endDate;

    function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }



    public function view(): View
    {
        $query = Payment::query();

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('payment_date', [$this->startDate, $this->endDate]);
        }

        // حساب مجموع المبالغ الكلي لجميع النتائج
        $total_payment_amount = $query->sum('payment_amount');

        // جلب النتائج بعد التصفية
        $payments = $query->orderBy('payment_date', 'asc')->get();

        return view('backend.pages.payments.reports_payments_export_excel', [
            'payments' => $payments,
            'total_payment_amount' => $total_payment_amount,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ]);
    }


}
