<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Attendance;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Models\DateAttendance;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentsContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{

    public function index(Request $request)
    {
        $query = Section::query();

        // فلترة بالكلمات المفتاحية
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name_ar', 'like', '%' . $request->search . '%')
                    ->orWhere('name_en', 'like', '%' . $request->search . '%')
                    ->orWhereHas('classroom', function ($sub) use ($request) {
                        $sub->where('name_ar', 'like', '%' . $request->search . '%')
                            ->orWhere('name_en', 'like', '%' . $request->search . '%');
                    });
            });
        }

        // فلترة بالشعبة
        if ($request->filled('section_id')) {
            $query->where('id', $request->section_id);
        }

        // فلترة بالسنة الدراسية
        if ($request->filled('academic_year_id')) {
            $query->where('academic_year_id', $request->academic_year_id);
        }

        // فلترة بالصف
        if ($request->filled('classroom_id')) {
            $query->where('classroom_id', $request->classroom_id);
        }

        $sections = $query->orderBy('id', 'asc')->get();

        $academicYears = \App\Models\AcademicYear::all();
        $classrooms = \App\Models\Classroom::all();
        $sectionsList = \App\Models\Section::orderBy('name_ar')->get();

        return view('backend.pages.attendances.index', compact('sections', 'academicYears', 'classrooms', 'sectionsList'));
    }


    public function getClassroomsByYear($year_id)
    {
        $classrooms = \App\Models\Classroom::where('academic_year_id', $year_id)->get();
        return response()->json($classrooms);
    }

    public function getSectionsByClassroom($classroom_id)
    {
        $sections = \App\Models\Section::where('classroom_id', $classroom_id)->get();
        return response()->json($sections);
    }


    public function students_attendances($id)
    {
        $date_attendance = DateAttendance::findOrFail($id);
        $existingAttendances = $date_attendance->Attendances->pluck('students_contract_id')->toArray();

        $studentsContracts = StudentsContract::where('section_id', $date_attendance->section_id)
            ->whereNotIn('id', $existingAttendances)
            ->get();

        return view('backend.pages.date_attendances.students_attendances', compact('date_attendance', 'studentsContracts'));
    }




    public function store(Request $request)
    {
        // ✅ تحقق من صحة البيانات
        $request->validate([
            'academic_year_id'    => 'required|exists:academic_years,id',
            'classroom_id'        => 'required|exists:classrooms,id',
            'section_id'          => 'required|exists:sections,id',
            'date_attendance_id'  => 'required|exists:date_attendances,id',
            'attendances'         => 'required|array',
        ]);

        $dateAttendanceId = $request->date_attendance_id;

        foreach ($request->attendances as $studentsContractId => $attendanceStatus) {

            // ✅ تأكد من أن الطالب لم يُسجل حضوره/غيابه من قبل في هذا اليوم
            $alreadyExists = Attendance::where([
                ['students_contract_id', $studentsContractId],
                ['date_attendance_id', $dateAttendanceId],
            ])->exists();

            if (!$alreadyExists) {
                // ✅ حدد الحالة
                $status = $attendanceStatus === 'presence' ? true : false;

                // ✅ أنشئ السجل
                Attendance::create([
                    'user_id'              => Auth::id(),
                    'students_contract_id' => $studentsContractId,
                    'academic_year_id'     => $request->academic_year_id,
                    'classroom_id'         => $request->classroom_id,
                    'section_id'           => $request->section_id,
                    'date_attendance_id'   => $dateAttendanceId,
                    'status'               => $status,
                ]);
            }
        }
        toast('تم الإضافة بنجاح', 'success');
        return redirect()->back();
    }




    // تحديث الحضور والغياب لصالب
    public function update(Request $request, $id)
    {
        $attendance = Attendance::find($id);
        $attendance->update([
            'status' => $request->status,
        ]);
        toast('تم التعديل بنجاح', 'success');
        return redirect()->back();
    }



    public function show_students_attendances(Request $request, $id)
    {
        if ($request->date == 0) {
            $section = Section::find($id);
            $studentsContracts = $section->StudentsContracts()->get();
            $attendances = $section->Attendances()->get();
            $presence_count = $section->Attendances()->where('status', 1)->count();
            $absence_count = $section->Attendances()->where('status', 0)->count();
            return view('backend.pages.attendances.show_students_attendances', compact('section', 'studentsContracts', 'attendances', 'presence_count', 'absence_count'));
        } else {
            $section = Section::find($id);
            $studentsContracts = $section->StudentsContracts()->get();
            $attendances = $section->Attendances()->where('date', $request->date)->get();
            $presence_count = $section->Attendances()->where('status', 1)->where('date', $request->date)->count();
            $absence_count = $section->Attendances()->where('status', 0)->where('date', $request->date)->count();
            return view('backend.pages.attendances.show_students_attendances', compact('section', 'studentsContracts', 'attendances', 'presence_count', 'absence_count'));
        }
    }






    public function destroy(Attendance $attendance)
    {
        //
    }
}
