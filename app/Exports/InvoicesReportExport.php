<?php

namespace App\Exports;

use App\Models\Invoice;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class InvoicesReportExport implements FromView, WithEvents, ShouldAutoSize
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
    protected $invoice_status_id;
    protected $start_date;
    protected $end_date;

    function __construct($customer_id, $invoice_status_id, $start_date, $end_date)
    {
        $this->customer_id = $customer_id;
        $this->invoice_status_id = $invoice_status_id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function view(): View
    {
        $query = Invoice::with(['customer', 'status', 'user']);

        if ($this->customer_id) {
            $query->where('customer_id', $this->customer_id);
        }

        if ($this->invoice_status_id) {
            $query->where('invoice_status_id', $this->invoice_status_id);
        }

        if ($this->start_date && $this->end_date) {
            $query->whereBetween('invoice_date', [$this->start_date, $this->end_date]);
        }

        // Calculate summary
        $total_amount = $query->sum('total');
        $total_paid = $query->sum('paid_amount');
        $total_remaining = $query->sum('remaining_amount');

        $invoices = $query->orderBy('invoice_date', 'desc')->get();

        return view('backend.pages.reports.reports_invoices_excel', [
            'invoices' => $invoices,
            'total_amount' => $total_amount,
            'total_paid' => $total_paid,
            'total_remaining' => $total_remaining,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);
    }
}
