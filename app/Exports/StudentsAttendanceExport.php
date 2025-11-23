<?php
namespace App\Exports;

use App\Models\DateAttendance;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class StudentsAttendanceExport implements FromView, WithEvents, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view(): View
    {
        $date_attendances = DateAttendance::with(['Section', 'Classroom', 'AcademicYear', 'Attendances'])
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->orderBy('date', 'asc')
            ->get();

        return view('backend.pages.sections.attendance_report_excel', compact('date_attendances'));
    }



public function registerEvents(): array
{
    return [
        AfterSheet::class => function (AfterSheet $event) {
            $sheet = $event->sheet->getDelegate();

            $sheet->getStyle('A1:D1000')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:D1000')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A1:D1000')->getFont()->setName('Tahoma')->setSize(12);
            $sheet->setRightToLeft(true);

            // Optional: column widths
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(30);
            $sheet->getColumnDimension('C')->setWidth(45);
            $sheet->getColumnDimension('D')->setWidth(20);
        },
    ];
}

}