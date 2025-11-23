<?php

namespace App\Exports;

use App\Models\Quotation;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class QuotationsReportExport implements FromView, WithEvents, ShouldAutoSize
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
    protected $status;
    protected $start_date;
    protected $end_date;

    function __construct($customer_id, $status, $start_date, $end_date)
    {
        $this->customer_id = $customer_id;
        $this->status = $status;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function view(): View
    {
        $query = Quotation::with(['customer', 'user', 'convertedInvoice']);

        if ($this->customer_id) {
            $query->where('customer_id', $this->customer_id);
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->start_date && $this->end_date) {
            $query->whereBetween('quotation_date', [$this->start_date, $this->end_date]);
        }

        // Calculate summary
        $total_amount = $query->sum('total');

        $quotations = $query->orderBy('quotation_date', 'desc')->get();

        return view('backend.pages.reports.reports_quotations_excel', [
            'quotations' => $quotations,
            'total_amount' => $total_amount,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);
    }
}
