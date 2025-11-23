<?php

namespace App\Http\Controllers;

use App\Exports\PaymentsExport;
use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\PaymentMethodBalance;
use App\Models\PaymentMethodTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class PaymentController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('query');

        $payments = Payment::query()
            ->when($search, function ($query) use ($search) {
                $query->where('payment_number', 'LIKE', "%{$search}%")
                    ->orWhereHas('StudentsContract', function ($q) use ($search) {
                        $q->where('contract_number', 'like', "%{$search}%");
                    })
                    ->orWhereHas('Payment_method', function ($q) use ($search) {
                        $q->where('name_ar', 'like', "%{$search}%")
                            ->orWhere('name_en', 'like', "%{$search}%");
                    })
                    ->orWhereHas('Student', function ($q) use ($search) {
                        $q->where('first_name', 'like', "%{$search}%")
                            ->orWhere('father_name', 'like', "%{$search}%")
                            ->orWhere('nationality', 'like', "%{$search}%")
                            ->orWhere('primary_contact', 'like', "%{$search}%"); // ✅ تمت الإضافة هنا
                    })                    
                    ->orWhereHas('AcademicYear', function ($q) use ($search) {
                        $q->where('academic_year', 'like', "%{$search}%");
                    })
                    ->orWhereHas('Classroom', function ($q) use ($search) {
                        $q->where('name_ar', 'like', "%{$search}%")
                            ->orWhere('name_en', 'like', "%{$search}%");
                    });
            })

            // Filters
            ->when($request->academic_year_id, fn($q) => $q->where('academic_year_id', $request->academic_year_id))
            ->when($request->classroom_id, fn($q) => $q->where('classroom_id', $request->classroom_id))
            ->when($request->section_id, function ($q) use ($request) {
                $q->whereHas('StudentsContract', function ($sub) use ($request) {
                    $sub->where('section_id', $request->section_id);
                });
            })


            ->orderBy('id', 'desc')
            ->paginate(25);

        $academicYears = \App\Models\AcademicYear::all();
        $classrooms = \App\Models\Classroom::all();
        $sectionsList = \App\Models\Section::orderBy('name_ar')->get();

        return view('backend.pages.payments.index', compact('payments', 'academicYears', 'classrooms', 'sectionsList'));
    }



    public function store(Request $request)
    {
        // Generate payment number
        $payment_number = Payment::count() > 0
            ? Payment::latest()->first()->id + 1
            : 1;

        // Build data
        $data = [
            'user_id'              => Auth::id(),
            'student_id'           => $request->student_id,
            'academic_year_id'     => $request->academic_year_id,
            'classroom_id'         => $request->classroom_id,
            'students_contract_id' => $request->students_contract_id,
            'payment_method_id'    => $request->payment_method_id,
            'payment_number'       => 'NOTION000' . $payment_number,
            'check_number'         => $request->check_number,
            'payment_amount'       => $request->payment_amount,
            'rest_amount'          => $request->rest_amount,
            'payment_date'         => now(),
            'payment_about'        => $request->payment_about,
            'installment_id'       => $request->installment_id,
        ];

        // Save payment
        $payment = Payment::create($data);

        // ✅ Add transaction entry
        $description = 'دفعة للطالب: #' . $payment->first_name .
            ' - سبب الدفع: ' . ($payment->payment_about ?? 'غير محدد');

        PaymentMethodTransaction::create([
            'payment_method_id' => $payment->payment_method_id,
            'transaction_date'  => now(), // ⬅️ Set to current datetime
            'amount'            => $payment->payment_amount,
            'type'              => 'credit',
            'source_type'       => 'مدفوعات',
            'source_id'         => $payment->id,
            'description'       => $description,
        ]);


        // ✅ Update balance
        $balance = PaymentMethodBalance::where('payment_method_id', $payment->payment_method_id)->first();
        if ($balance) {
            $balance->current_balance += $payment->payment_amount;
            $balance->save();
        }

        // ✅ Update installment if applicable
        if ($request->filled('installment_id')) {
            $installment = \App\Models\Installment::find($request->installment_id);

            if ($installment) {
                $totalPaid = Payment::where('installment_id', $installment->id)->sum('payment_amount');
                $newRest = $installment->installment_amount - $totalPaid;

                $installment->update([
                    'rest_amount' => max($newRest, 0),
                    'status'      => $newRest <= 0 ? 'paid' : 'unpaid',
                ]);
            }
        }

        toast('تم الإضافة بنجاح', 'success');
        return redirect()->back();
    }





    public function show($id)
    {
        $payment = Payment::find($id);
        return view('backend.pages.payments.print_payment', compact('payment'));
    }


    public function payment_number($payment_number)
    {
        $payment = Payment::where('payment_number', $payment_number)->firstOrFail();

        // المتبقي من نفس القسط
        $installmentRest = $payment->installment_id ? optional($payment->installment)->rest_amount : null;

        // المبلغ الإجمالي المتبقي من كامل العقد
        $contractRest = $payment->StudentsContract->total_amount_with_tax
            - $payment->StudentsContract->payments->sum('payment_amount');

        return view('backend.pages.payments.print_payment', compact('payment', 'installmentRest', 'contractRest'));
    }



    public function getInstallmentPayments($installmentId)
    {
        $installment = \App\Models\Installment::with(['payments'])->findOrFail($installmentId);

        return response()->json([
            'html' => view('backend.pages.installments.modal_content', compact('installment'))->render()
        ]);
    }

    public function destroy($id)
    {
        $payment = \App\Models\Payment::findOrFail($id);
        $installment = $payment->installment;

        // 🔄 Reverse balance update
        $balance = \App\Models\PaymentMethodBalance::where('payment_method_id', $payment->payment_method_id)->first();
        if ($balance) {
            $balance->current_balance -= $payment->payment_amount;
            $balance->save();
        }

        // 🗑️ Delete related transaction
        \App\Models\PaymentMethodTransaction::where('source_type', 'مدفوعات')
            ->where('source_id', $payment->id)
            ->delete();

        // 💵 Delete the payment
        $payment->delete();

        // 🔁 Recalculate rest amount and status for the installment
        if ($installment) {
            $totalPaid = $installment->payments()->sum('payment_amount');
            $rest = $installment->installment_amount - $totalPaid;

            $installment->update([
                'rest_amount' => $rest,
                'status' => $rest <= 0 ? 'paid' : 'unpaid',
            ]);
        }

        return back()->with('success', 'تم الحذف بنجاح');
    }






    // تقارير المدفوعات
    public function reports_payments(Request $request)
    {
        $startDate = $request->input('start_date', now()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());

        $query = Payment::query();

        if ($startDate && $endDate) {
            $query->whereBetween('payment_date', [$startDate, $endDate]);
        }

        $total_payment_amount = $query->sum('payment_amount');

        $payments = $query->orderBy('payment_date', 'asc')->paginate(10)->appends([
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);

        return view('backend.pages.payments.reports_payments', [
            'payments' => $payments,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'total_payment_amount' => $total_payment_amount,
        ]);
    }



    public function export_reports_payments_excel(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Export
        return Excel::download(new PaymentsExport($startDate, $endDate), 'reports_payments_excel.xlsx');
    }
}
