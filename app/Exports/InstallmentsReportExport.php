<?php

namespace App\Exports;

use App\Models\InvoiceInstallment;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class InstallmentsReportExport implements FromView, WithEvents, ShouldAutoSize
{
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
            },
        ];
    }

    protected $status;
    protected $start_date;
    protected $end_date;
    protected $show_overdue_only;

    function __construct($status, $start_date, $end_date, $show_overdue_only)
    {
        $this->status = $status;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->show_overdue_only = $show_overdue_only;
    }

    public function view(): View
    {
        $query = InvoiceInstallment::with(['invoice.customer']);

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->start_date && $this->end_date) {
            $query->whereBetween('due_date', [$this->start_date, $this->end_date]);
        }

        if ($this->show_overdue_only) {
            $query->where('status', 'unpaid')
                ->where('due_date', '<', now()->toDateString());
        }

        // Calculate summary
        $total_amount = $query->sum('amount');

        $installments = $query->orderBy('due_date', 'asc')->get();

        return view('backend.pages.reports.reports_installments_excel', [
            'installments' => $installments,
            'total_amount' => $total_amount,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);
    }
}
