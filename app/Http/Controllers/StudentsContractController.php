<?php

namespace App\Http\Controllers;

use App\Exports\StudentsContractsExport;
use App\Exports\StudentsContractsExport2;
use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\Section;
use App\Models\StudentsContract;
use App\Http\Requests\StoreStudentsContractRequest;
use App\Http\Requests\UpdateStudentsContractRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class StudentsContractController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('query');

        $studentsContracts = StudentsContract::with(['installments', 'Payments', 'Student.Guardian', 'AcademicYear', 'Classroom', 'Section', 'Bus'])
            ->when($search, function ($query) use ($search) {
                $query->where('contract_number', 'LIKE', "%{$search}%")
                    ->orWhere('student_number', 'LIKE', "%{$search}%")
                    ->orWhereHas('Student', function ($q) use ($search) {
                        $q->where('first_name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%")
                            ->orWhere('nationality', 'like', "%{$search}%")
                            ->orWhere('primary_contact', 'like', "%{$search}%"); // ✅ الإضافة هنا
                    })
                    
                    ->orWhereHas('AcademicYear', function ($q) use ($search) {
                        $q->where('academic_year', 'like', "%{$search}%");
                    })
                    ->orWhereHas('Classroom', function ($q) use ($search) {
                        $q->where('name_ar', 'like', "%{$search}%")
                            ->orWhere('name_en', 'like', "%{$search}%");
                    })
                    ->orWhereHas('Section', function ($q) use ($search) {
                        $q->where('name_ar', 'like', "%{$search}%")
                            ->orWhere('name_en', 'like', "%{$search}%");
                    })
                    ->orWhereHas('Bus', function ($q) use ($search) {
                        $q->where('bus_number', 'like', "%{$search}%")
                            ->orWhere('bus_driver', 'like', "%{$search}%")
                            ->orWhere('bus_driver_phone', 'like', "%{$search}%");
                    });
            })

            // Filters
            ->when($request->academic_year_id, fn($q) => $q->where('academic_year_id', $request->academic_year_id))
            ->when($request->classroom_id, fn($q) => $q->where('classroom_id', $request->classroom_id))
            ->when($request->section_id, fn($q) => $q->where('section_id', $request->section_id))

            ->orderBy('id', 'desc')
            ->paginate(10);

        $academicYears = \App\Models\AcademicYear::all();
        $classrooms = \App\Models\Classroom::all();
        $sectionsList = \App\Models\Section::orderBy('name_ar')->get();

        return view('backend.pages.studentsContracts.index', compact('studentsContracts', 'academicYears', 'classrooms', 'sectionsList'));
    }




    public function fetchClassrooms(Request $request)
    {
        $data['Classrooms'] = Classroom::where("academic_year_id", $request->academic_year_id)->get();
        return response()->json($data);
    }

    public function fetchSections(Request $request)
    {
        $data['Sections'] = Section::where("classroom_id", $request->classroom_id)->get();
        return response()->json($data);
    }




    public function showPublic($slug)
    {
        $studentsContract = StudentsContract::where('slug', $slug)->firstOrFail();

        if ($studentsContract->signature) {
            // already signed — show read-only
            return view('backend.pages.studentsContracts.show', compact('studentsContract'));
        }

        return view('backend.pages.studentsContracts.sign', compact('studentsContract'));
    }

    public function storeSignature(Request $request, $slug)
    {
        $request->validate([
            'signature' => 'required|string',
        ], [
            'signature.required' => 'التوقيع مطلوب',
        ]);

        $contract = StudentsContract::where('slug', $slug)->firstOrFail();

        if ($contract->signature) {
            return redirect()->route('studentsContracts.public', $slug)->with('error', 'تم توقيع العقد مسبقاً');
        }

        $folderPath = public_path('images/signature/');
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0755, true);
        }

        $image_parts = explode(";base64,", $request->signature);
        if (count($image_parts) === 2 && strpos($image_parts[0], 'image/') !== false) {
            $image_type = explode("image/", $image_parts[0])[1];
            $image_base64 = base64_decode($image_parts[1]);
            $signature_name = uniqid() . '.' . $image_type;
            file_put_contents($folderPath . $signature_name, $image_base64);

            $contract->update([
                'signature' => 'images/signature/' . $signature_name,
            ]);

            return redirect()->route('studentsContracts.public', $slug)->with('success', 'تم حفظ التوقيع بنجاح');
        } else {
            return back()->with('error', 'تنسيق التوقيع غير صحيح');
        }
    }


    // فلترة العقود حسب السنوات
    public function filter_studentsContracts(Request $request)
    {
        if ($request->academic_year_id == 0) {
            $academicYears = AcademicYear::orderBy('id', 'asc')->get();
            $studentsContracts = StudentsContract::orderBy('id', 'desc')->paginate(100);
            return view('backend.pages.studentsContracts.index', compact('studentsContracts', 'academicYears'));
        } else {
            $academicYears = AcademicYear::orderBy('id', 'asc')->get();
            $studentsContracts = StudentsContract::where('academic_year_id', $request->academic_year_id)
                ->orderBy('id', 'desc')->paginate(100);
            return view('backend.pages.studentsContracts.index', compact('studentsContracts', 'academicYears'));
        }
    }



    // تصدير عقود الطلاب اكسيل
    public function studentsContracts_export_excel(Request $request)
    {
        $academic_year_id = $request->academic_year_id;
        return Excel::download(new StudentsContractsExport($academic_year_id), 'studentsContracts.xlsx');
    }





    public function create()
    {
        return view('backend.pages.studentsContracts.add');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id'             => 'required|exists:students,id',
            'academic_year_id'       => 'required|exists:academic_years,id',
            'classroom_id'           => 'required|exists:classrooms,id',
            'section_id'             => 'required|exists:sections,id',
            'bus_id'                 => 'nullable|exists:buses,id',
            'contract_date'          => 'nullable|date',
            'sub_total'              => 'required|numeric',
            'discount'               => 'nullable|numeric',
            'amount_after_discount'  => 'nullable|numeric',
            'tax_value'              => 'nullable|numeric',
            'total_amount_with_tax'  => 'required|numeric',
            'contract_terms_ar'         => 'nullable|string',
            'contract_terms_en'         => 'nullable|string',
            'notes'                  => 'nullable|string',
            'file'                   => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp,csv,txt,xlx,xls,pdf,docx|max:5048',

            // Installments validation
            'installments'                           => 'nullable|array',
            'installments.*.installment_amount'      => 'required|numeric|min:0',
            'installments.*.rest_amount'             => 'required|numeric|min:0',
            'installments.*.due_date'                => 'required|date',
        ]);

        // Exclude installments from main data
        $data = collect($validated)->except('installments')->toArray();
        $data['slug'] = Str::random(32);
        // Handle file upload
        if ($file = $request->file('file')) {
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $path = 'uploads/studentsContracts/' . $filename;
            Storage::disk('s3')->put($path, file_get_contents($file), [
                'ServerSideEncryption' => 'AES256',
            ]);
            $data['file'] = Storage::disk('s3')->url($path);
        }

        // Assign system-generated values
        $data['user_id'] = Auth::id();
        $data['student_number'] = 'SN' . strtoupper(Str::random(8));
        $latestId = StudentsContract::max('id') ?? 0;
        $data['contract_number'] = 'CON' . str_pad($latestId + 1, 3, '0', STR_PAD_LEFT);
        $data['qrcode_no'] = 'QR' . Str::random(64);

        // Save contract
        $studentsContract = StudentsContract::create($data);
        // Add this student to all previous attendance days in the same section as 'absent'
        $previousDates = \App\Models\DateAttendance::where('section_id', $data['section_id'])->get();

        foreach ($previousDates as $date) {
            \App\Models\Attendance::create([
                'students_contract_id' => $studentsContract->id,
                'academic_year_id'     => $data['academic_year_id'],
                'classroom_id'         => $data['classroom_id'],
                'section_id'           => $data['section_id'],
                'date_attendance_id'   => $date->id,
                'status'               => 0, // absent
                'user_id'              => Auth::id(),
            ]);
        }
        // Attach fees
        if ($request->has('fees')) {
            $fees = [];
        
            foreach ($request->fees as $fee) {
                if (!isset($fee['tuition_fee_id'])) continue;
        
                $fees[$fee['tuition_fee_id']] = [
                    'name'      => $fee['name'] ?? '',
                    'price'     => $fee['price'] ?? 0,
                    'quantity'  => $fee['quantity'] ?? 1,
                    'tax_rate'  => $fee['tax_rate'] ?? 0,
                    'total'     => $fee['total'] ?? 0,
                ];
            }
        
            $studentsContract->TuitionFees()->attach($fees);
        }
        
        

        // Save installments
        if ($request->has('installments')) {
            foreach ($request->installments as $installment) {
                $studentsContract->installments()->create([
                    'installment_amount' => $installment['installment_amount'],
                    'rest_amount'        => $installment['rest_amount'],
                    'due_date'           => $installment['due_date'],
                ]);
            }
        }

        toast('تم الإضافة بنجاح', 'success');
        return redirect()->route('studentsContracts.index');
    }





    public function show($id)
    {
        $studentsContract = StudentsContract::find($id);
        return view('backend.pages.studentsContracts.show', compact('studentsContract'));
    }



    // طباعة عقد الطالب
    public function print_studentsContract($id)
    {
        $studentsContract = StudentsContract::find($id);
        return view('backend.pages.studentsContracts.print_studentsContract', compact('studentsContract'));
    }


    // عرض مدفوعات العقد
    public function show_payments($id)
    {
        $studentsContract = StudentsContract::with([
            'Student',
            'AcademicYear',
            'Classroom',
            'Section',
            'Payments',
            'installments.payments', // load payments for each installment
        ])->findOrFail($id);

        return view('backend.pages.payments.show_payments', compact('studentsContract'));
    }





    public function edit($id)
    {
        $studentsContract = StudentsContract::find($id);
        return view('backend.pages.studentsContracts.edit', compact('studentsContract'));
    }


    public function copy_studentsContract($id)
    {
        $studentsContract = StudentsContract::find($id);
        return view('backend.pages.studentsContracts.copy', compact('studentsContract'));
    }



    public function update(Request $request, $id)
{
    $studentsContract = StudentsContract::findOrFail($id);

    $validated = $request->validate([
        'student_id'             => 'required|exists:students,id',
        'academic_year_id'       => 'required|exists:academic_years,id',
        'classroom_id'           => 'required|exists:classrooms,id',
        'section_id'             => 'required|exists:sections,id',
        'bus_id'                 => 'nullable|exists:buses,id',
        'contract_date'          => 'nullable|date',
        'sub_total'              => 'required|numeric',
        'discount'               => 'nullable|numeric',
        'amount_after_discount'  => 'nullable|numeric',
        'tax_value'              => 'nullable|numeric',
        'total_amount_with_tax'  => 'required|numeric',
        'contract_terms_ar'      => 'nullable|string',
        'contract_terms_en'      => 'nullable|string',
        'notes'                  => 'nullable|string',
        'file'                   => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp,csv,txt,xlx,xls,pdf,docx|max:5048',

        // Installments validation
        'installments'                           => 'nullable|array',
        'installments.*.installment_amount'      => 'required|numeric|min:0',
        'installments.*.rest_amount'             => 'required|numeric|min:0',
        'installments.*.due_date'                => 'required|date',
    ]);

    // فقط الحقول المعتمدة
    $data = collect($validated)->except(['installments', 'fees'])->toArray();

    // Handle file upload
    if ($request->hasFile('file')) {
        if ($studentsContract->file) {
            $oldPath = ltrim(parse_url($studentsContract->file, PHP_URL_PATH), '/');
            if (Storage::disk('s3')->exists($oldPath)) {
                Storage::disk('s3')->delete($oldPath);
            }
        }

        $filename = time() . '_' . preg_replace('/\s+/', '_', $request->file('file')->getClientOriginalName());
        $path = 'uploads/studentsContracts/' . $filename;
        Storage::disk('s3')->put($path, file_get_contents($request->file('file')), [
            'ServerSideEncryption' => 'AES256',
        ]);
        $data['file'] = Storage::disk('s3')->url($path);
    }

    // ثابتة
    $data['user_id'] = Auth::id();
    $data['student_number'] = $studentsContract->student_number;
    $data['contract_number'] = $studentsContract->contract_number;

    $studentsContract->update($data);

    // Sync الرسوم
    if ($request->has('fees')) {
        $syncData = [];
    
        foreach ($request->fees as $feeId => $fee) {
            $syncData[$feeId] = [
                'name'      => $fee['name'] ?? '',
                'price'     => $fee['price'] ?? 0,
                'quantity'  => $fee['quantity'] ?? 1,
                'tax_rate'  => $fee['tax_rate'] ?? 0,
                'total'     => $fee['total'] ?? 0,
            ];
        }
    
        $studentsContract->TuitionFees()->sync($syncData);
    }
    

    // تحديث الأقساط
    $studentsContract->installments()->delete();
    if ($request->has('installments')) {
        foreach ($request->installments as $installment) {
            $studentsContract->installments()->create([
                'installment_amount' => $installment['installment_amount'],
                'rest_amount'        => $installment['rest_amount'],
                'due_date'           => $installment['due_date'],
            ]);
        }
    }

    toast('تم التعديل بنجاح', 'success');
    return redirect()->route('studentsContracts.index');
}






    public function destroy($id)
    {
        $studentsContract = StudentsContract::find($id);

        if ($studentsContract->payments->count() > 0) {
            toast('لا يمكن الحذف يوجد تحته مدفوعات مالية', 'error');
            return redirect()->back();
        }

        // Delete file from S3
        if ($studentsContract->file) {
            $filePath = ltrim(parse_url($studentsContract->file, PHP_URL_PATH), '/');
            if (Storage::disk('s3')->exists($filePath)) {
                Storage::disk('s3')->delete($filePath);
            }
        }

        $studentsContract->delete();

        toast('تم الحذف بنجاح', 'success');
        return redirect()->back();
    }





    // تقرير عقود الطلاب بين تاريخين
    public function reports_students_contracts(Request $request)
    {
        $startDate = $request->input('start_date') ?? now()->toDateString();
        $endDate = $request->input('end_date') ?? now()->toDateString();
        $academicYearId = $request->input('academic_year_id');

        $query = StudentsContract::query();

        if ($startDate && $endDate) {
            $query->whereBetween('contract_date', [$startDate, $endDate]);
        }

        if ($academicYearId && $academicYearId != 0) {
            $query->where('academic_year_id', $academicYearId);
        }

        $totalAmountWithTax = $query->sum('total_amount_with_tax');
        $totalPaid = $query->with('Payments')->get()->sum(fn($contract) => $contract->Payments->sum('payment_amount'));
        $totalRemaining = $totalAmountWithTax - $totalPaid;

        $studentsContracts = $query->orderBy('contract_date', 'asc')->paginate(10)->appends([
            'start_date' => $startDate,
            'end_date' => $endDate,
            'academic_year_id' => $academicYearId,
        ]);

        return view('backend.pages.studentsContracts.reports_students_contracts', [
            'studentsContracts' => $studentsContracts,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'academicYearId' => $academicYearId,
            'academicYears' => AcademicYear::all(),
            'totalAmountWithTax' => $totalAmountWithTax,
            'totalPaid' => $totalPaid,
            'totalRemaining' => $totalRemaining,
        ]);
    }





    public function export_reports_students_contracts_excel(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $academicYearId = $request->input('academic_year_id');
        $search = $request->input('query');

        // Export
        return Excel::download(new StudentsContractsExport2($startDate, $endDate, $academicYearId, $search), 'reports_students_contracts_excel.xlsx');
    }
}
