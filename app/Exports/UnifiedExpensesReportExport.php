<?php

namespace App\Exports;

use App\Models\Expense;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class UnifiedExpensesReportExport implements FromView, WithEvents, ShouldAutoSize
{
    protected $start_date;
    protected $end_date;
    protected $main_category_id;
    protected $sub_category_id;

    public function __construct($start_date, $end_date, $main_category_id = 0, $sub_category_id = 0)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->main_category_id = $main_category_id;
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
        $query = Expense::whereBetween('expense_date', [$this->start_date, $this->end_date]);

        if (!empty($this->main_category_id) && $this->main_category_id != 0) {
            $query->where('expense_category_id', $this->main_category_id);
        }

        if (!empty($this->sub_category_id) && $this->sub_category_id != 0) {
            $query->where('expense_sub_category_id', $this->sub_category_id);
        }

        $reports_expenses = $query->orderBy('expense_date', 'asc')->get();
        $total_expenses = $query->clone()->sum('amount');
        $amount_with_tax = $query->clone()->sum('amount_with_tax');
        $tax_amount = $query->clone()->sum('tax_amount');

        return view('backend.pages.expenses.reports_expenses_unified_excel', [
            'reports_expenses' => $reports_expenses,
            'total_expenses' => $total_expenses,
            'amount_with_tax' => $amount_with_tax,
            'tax_amount' => $tax_amount,
        ]);
    }
}
