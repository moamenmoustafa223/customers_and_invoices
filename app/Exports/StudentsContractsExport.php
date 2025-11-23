<?php

namespace App\Exports;

use App\Models\AcademicYear;
use App\Models\Asset;
use App\Models\Classroom;
use App\Models\StudentsContract;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class StudentsContractsExport implements FromView, WithEvents, ShouldAutoSize
{

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
            },
        ];
    }


    protected $academic_year_id;

    function __construct($academic_year_id) {

        $this->academic_year_id = $academic_year_id;
    }



    public function view(): View
    {
        if ($this->academic_year_id == 0)
        {
            $studentsContracts = StudentsContract::orderBy('id', 'asc')->get();
            return view('backend.pages.studentsContracts.studentsContracts_export_excel', [
                'studentsContracts' => $studentsContracts,
            ]);
        }
        else
        {
            $studentsContracts = StudentsContract::where('academic_year_id', request()->academic_year_id)->orderBy('id', 'asc')->get();
            return view('backend.pages.studentsContracts.studentsContracts_export_excel', [
                'studentsContracts' => $studentsContracts,
            ]);
        }

    }


}
