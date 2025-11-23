<?php

namespace App\Http\Controllers;

use App\Models\Installment;
use Illuminate\Http\Request;

class InstallmentController extends Controller
{

    public function overdueInstallments(Request $request)
    {
        $query = Installment::with(['studentsContract.Student', 'studentsContract.Classroom'])
            ->where('status', 'unpaid')
            ->whereDate('due_date', '<', now());

        // 🔍 بحث باسم الطالب أو رقم الهاتف
        if ($request->filled('query')) {
            $search = $request->input('query');
            $query->whereHas('studentsContract.Student', function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%")
                    ->orWhere('primary_contact', 'like', "%$search%");
            });
        }
        

        // 📅 فلترة بالشهر
        if ($request->filled('due_year_month')) {
            $yearMonth = explode('-', $request->due_year_month);
            if (count($yearMonth) === 2) {
                $query->whereYear('due_date', $yearMonth[0])
                    ->whereMonth('due_date', $yearMonth[1]);
            }
        }

        // 🏫 فلترة بالسنة الدراسية
        if ($request->filled('academic_year_id')) {
            $query->whereHas('studentsContract', function ($q) use ($request) {
                $q->where('academic_year_id', $request->academic_year_id);
            });
        }

        // 🏫 فلترة بالصف
        if ($request->filled('classroom_id')) {
            $query->whereHas('studentsContract', function ($q) use ($request) {
                $q->where('classroom_id', $request->classroom_id);
            });
        }

        // 👥 فلترة بالشعبة
        if ($request->filled('section_id')) {
            $query->whereHas('studentsContract', function ($q) use ($request) {
                $q->where('section_id', $request->section_id);
            });
        }

        // 🧾 فلترة برقم العقد
        if ($request->filled('contract_number')) {
            $query->whereHas('studentsContract', function ($q) use ($request) {
                $q->where('contract_number', 'like', "%{$request->contract_number}%");
            });
        }

        // 📊 جلب النتائج بترتيب تاريخ الاستحقاق
        $installments = $query->orderBy('due_date', 'asc')->paginate(15);

        // 📥 بيانات الفلاتر
        $academicYears = \App\Models\AcademicYear::all();
        $classrooms = \App\Models\Classroom::all();
        $sectionsList = \App\Models\Section::orderBy('name_ar')->get();

        return view('backend.pages.installments.overdue', compact(
            'installments',
            'academicYears',
            'classrooms',
            'sectionsList'
        ));
    }


    public function index(Request $request)
    {
        $query = Installment::with(['studentsContract.Student', 'studentsContract.Classroom']);

        // 🔍 بحث باسم الطالب أو رقم الهاتف
        if ($request->filled('query')) {
            $search = $request->input('query');
            $query->whereHas('studentsContract.Student', function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                    ->orWhere('father_name', 'like', "%$search%")
                    ->orWhere('primary_contact', 'like', "%$search%");
            });
        }
        

        // ✅ فلترة بالحالة (مدفوع / غير مدفوع)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 📅 فلترة بالشهر
        if ($request->filled('due_year_month')) {
            $yearMonth = explode('-', $request->due_year_month);
            if (count($yearMonth) === 2) {
                $query->whereYear('due_date', $yearMonth[0])
                    ->whereMonth('due_date', $yearMonth[1]);
            }
        }

        // 🏫 فلترة بالسنة الدراسية
        if ($request->filled('academic_year_id')) {
            $query->whereHas('studentsContract', function ($q) use ($request) {
                $q->where('academic_year_id', $request->academic_year_id);
            });
        }

        // 🏫 فلترة بالصف
        if ($request->filled('classroom_id')) {
            $query->whereHas('studentsContract', function ($q) use ($request) {
                $q->where('classroom_id', $request->classroom_id);
            });
        }

        // 👥 فلترة بالشعبة
        if ($request->filled('section_id')) {
            $query->whereHas('studentsContract', function ($q) use ($request) {
                $q->where('section_id', $request->section_id);
            });
        }

        // 🧾 فلترة برقم العقد
        if ($request->filled('contract_number')) {
            $query->whereHas('studentsContract', function ($q) use ($request) {
                $q->where('contract_number', 'like', "%{$request->contract_number}%");
            });
        }

        // 📊 جلب النتائج بترتيب تاريخ الاستحقاق
        $installments = $query->orderBy('due_date', 'asc')->paginate(15);

        // 📥 بيانات الفلاتر
        $academicYears = \App\Models\AcademicYear::all();
        $classrooms = \App\Models\Classroom::all();
        $sectionsList = \App\Models\Section::orderBy('name_ar')->get();

        return view('backend.pages.installments.index', compact(
            'installments',
            'academicYears',
            'classrooms',
            'sectionsList'
        ));
    }



    public function edit($id)
    {
        $installment = Installment::findOrFail($id);

        return response()->json([
            'status' => true,
            'html' => view('backend.pages.installments._edit_modal', compact('installment'))->render(),
        ]);
    }


    public function update(Request $request, $id)
    {
        $installment = Installment::findOrFail($id);

        $request->validate([
            'installment_amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
        ]);

        // Calculate total paid on this installment
        $paid = $installment->payments()->sum('payment_amount');

        // Prevent update if new amount is less than already paid
        if ($request->installment_amount < $paid) {
            return redirect()->back()->with('error', 'لا يمكن تقليل مبلغ القسط إلى أقل من المبلغ المدفوع (' . number_format($paid, 3) . ').');
        }

        $installment->update([
            'installment_amount' => $request->installment_amount,
            'due_date' => $request->due_date,
        ]);

        toast('تم التحديث بنجاح', 'success');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $installment = Installment::findOrFail($id);

        // Check if installment has any payments
        if ($installment->payments()->exists()) {
            return redirect()->back()->with('error', 'لا يمكن حذف القسط لوجود دفعات مرتبطة به.');
        }

        $installment->delete();
        toast('تم الحذف بنجاح', 'success');
        return redirect()->back();
    }
}
