<?php

namespace App\Exports;

use App\Models\InvoicePayment;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class InvoicePaymentsReportExport implements FromView, WithEvents, ShouldAutoSize
{
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
            },
        ];
    }

    protected $customer_id;
    protected $payment_method_id;
    protected $start_date;
    protected $end_date;

    function __construct($customer_id, $payment_method_id, $start_date, $end_date)
    {
        $this->customer_id = $customer_id;
        $this->payment_method_id = $payment_method_id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function view(): View
    {
        $query = InvoicePayment::with(['invoice.customer', 'paymentMethod', 'user']);

        if ($this->customer_id) {
            $query->whereHas('invoice', function ($q) {
                $q->where('customer_id', $this->customer_id);
            });
        }

        if ($this->payment_method_id) {
            $query->where('payment_method_id', $this->payment_method_id);
        }

        if ($this->start_date && $this->end_date) {
            $query->whereBetween('payment_date', [$this->start_date, $this->end_date]);
        }

        // Calculate summary
        $total_amount = $query->sum('amount');

        $invoice_payments = $query->orderBy('payment_date', 'desc')->get();

        return view('backend.pages.reports.reports_invoice_payments_excel', [
            'invoice_payments' => $invoice_payments,
            'total_amount' => $total_amount,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);
    }
}
