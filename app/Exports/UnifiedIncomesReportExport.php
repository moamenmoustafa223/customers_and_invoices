<?php

namespace App\Exports;

use App\Models\Income;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class UnifiedIncomesReportExport implements FromView, WithEvents, ShouldAutoSize
{
    protected $start_date;
    protected $end_date;
    protected $category_id;
    protected $sub_category_id;

    public function __construct($start_date, $end_date, $category_id = 0, $sub_category_id = 0)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->category_id = $category_id;
        $this->sub_category_id = $sub_category_id;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
            },
        ];
    }

    public function view(): View
    {
        $query = Income::whereBetween('expense_date', [$this->start_date, $this->end_date]);

        if ($this->category_id != 0) {
            $query->where('incomes_category_id', $this->category_id);
        }

        if ($this->sub_category_id != 0) {
            $query->where('incomes_sub_category_id', $this->sub_category_id);
        }

        $incomes = $query->orderBy('expense_date', 'asc')->get();
        $total_Incomes = (clone $query)->sum('amount');
        $amount_with_tax = (clone $query)->sum('amount_with_tax');
        $tax_amount = (clone $query)->sum('tax_amount');

        return view('backend.pages.Incomes.reports_incomes_unified_excel', [
            'incomes' => $incomes,
            'total_Incomes' => $total_Incomes,
            'amount_with_tax' => $amount_with_tax,
            'tax_amount' => $tax_amount,
        ]);
    }
}
