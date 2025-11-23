<?php

namespace App\Exports;

use App\Models\Student;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class StudentsReportExport implements FromView, WithEvents, ShouldAutoSize
{
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
            },
        ];
    }



    protected $startDate;
    protected $endDate;
    protected $search;

    public function __construct($startDate, $endDate, $search = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->search = $search;
    }

    public function view(): View
    {
        $students = Student::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('first_name', 'LIKE', "%{$this->search}%")
                        ->orWhere('father_name', 'LIKE', "%{$this->search}%")
                        ->orWhere('grandfather_name', 'LIKE', "%{$this->search}%")
                        ->orWhere('civil_id', 'LIKE', "%{$this->search}%");
                })
                    ->orWhereHas('Guardian', function ($q) {
                        $q->where('guardian_name', 'LIKE', "%{$this->search}%")
                            ->orWhere('phone', 'LIKE', "%{$this->search}%");
                    });
            })
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereDate('created_at', '>=', $this->startDate)
                    ->whereDate('created_at', '<=', $this->endDate);
            })
            ->orderBy('id', 'asc')
            ->get();

        return view('backend.pages.students.export_students_report_excel', [
            'students' => $students,
        ]);
    }
}
