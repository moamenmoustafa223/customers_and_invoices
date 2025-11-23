<?php

namespace App\Exports;

use App\Models\AcademicYear;
use App\Models\StudentsContract;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class StudentsContractsExport2 implements FromView, WithEvents, ShouldAutoSize
{
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
            },
        ];
    }

    protected $startDate;
    protected $endDate;
    protected $academicYearId;
    protected $search;

    function __construct($startDate, $endDate, $academicYearId, $search) {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->academicYearId = $academicYearId;
        $this->search = $search;
    }

    public function view(): View
    {
        $query = StudentsContract::query();

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('contract_date', [$this->startDate, $this->endDate]);
        }

        if ($this->academicYearId && $this->academicYearId != 0) {
            $query->where('academic_year_id', $this->academicYearId);
        }

        // يجب استخدام query هنا لحساب المجموعات
        $totalAmountWithTax = $query->sum('total_amount_with_tax');
        $totalPaid = $query->with('Payments')->get()->sum(function ($contract) {
            return $contract->Payments->sum('payment_amount');
        });
        $totalRemaining = $totalAmountWithTax - $totalPaid;

        $studentsContracts = $query->orderBy('contract_date', 'asc')->get();

        return view('backend.pages.studentsContracts.studentsContracts_export_excel', [
            'studentsContracts' => $studentsContracts,
            'startDate' => $this->startDate,
            'endDate' => $this->startDate,
            'academicYearId' => $this->academicYearId,
            'academicYears' => AcademicYear::all(),
            'totalAmountWithTax' => $totalAmountWithTax??0,
            'totalPaid' => $totalPaid,
            'totalRemaining' => $totalRemaining
        ]);
    }





}
