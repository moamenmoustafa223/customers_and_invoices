<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\HR\Salary;
use App\Models\PaymentMethodBalance;
use App\Models\PaymentMethodTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalaryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('query');
        $salaries = Salary::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhereHas('Employee', function ($query) use ($search) {
                $query->where('name_ar', 'like', '%' . $search . '%')
                    ->orWhere('name_en', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            })
            ->orderBy('id', 'desc')->paginate(10);

        return view('backend.HR.Salaries.index', compact('salaries'));
    }


    public function create()
    {
        return view('backend.HR.Salaries.add');
    }
    public function createMultiple()
    {
        $employees = \App\Models\HR\Employee::all();
        $paymentMethods = \App\Models\Payment_method::all();
        return view('backend.HR.Salaries.create_multiple', compact('employees', 'paymentMethods'));
    }

    public function storeMultiple(Request $request)
    {
        $request->validate([
            'salaries' => 'required|array|min:1',
            'salaries.*.employee_id' => 'required|integer|exists:employees,id',
            'salaries.*.name' => 'required|string',
            'salaries.*.amount' => 'required|numeric|min:0',
            'salaries.*.payment_method_id' => 'required|integer|exists:payment_methods,id',
            'salaries.*.date' => 'required|date',
            'salaries.*.notes' => 'nullable|string',
        ]);

        foreach ($request->salaries as $salaryData) {
            $salary = \App\Models\HR\Salary::create([
                'employee_id' => $salaryData['employee_id'],
                'name' => $salaryData['name'],
                'amount' => $salaryData['amount'],
                'payment_method_id' => $salaryData['payment_method_id'],
                'date' => $salaryData['date'],
                'notes' => $salaryData['notes'] ?? null,
                'user_id' => auth()->id(),
            ]);

            $employee = \App\Models\HR\Employee::find($salaryData['employee_id']);

            $description = 'راتب: ' . $salary->name .
                ' - للموظف: ' . ($employee ? $employee->name_ar : 'غير معروف') .
                ' - بتاريخ: ' . $salary->date;

            PaymentMethodTransaction::create([
                'payment_method_id' => $salary->payment_method_id,
                'transaction_date'  => now(),
                'amount' => $salary->amount,
                'type' => 'debit',
                'source_type' => 'راتب',
                'description' => $description,
                'source_id' => $salary->id,
            ]);

            $balance = PaymentMethodBalance::where('payment_method_id', $salary->payment_method_id)->first();
            if ($balance && $salary->amount > 0) {
                $balance->current_balance -= $salary->amount;
                $balance->save();
            }
        }

        toast('تمت إضافة الرواتب المتعددة بنجاح', 'success');
        return redirect()->route('Salaries.index');
    }





    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'payment_method_id' => 'required',
            'name' => 'required',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        // Create salary record
        $salary = Salary::create([
            'user_id' => Auth::id(),
            'employee_id' => $request->employee_id,
            'payment_method_id' => $request->payment_method_id,
            'name' => $request->name,
            'amount' => $request->amount,
            'date' => $request->date,
            'notes' => $request->notes,
        ]);

        // Create transaction
        $description = 'راتب: ' . $salary->name .
            ' - للموظف: ' . $salary->employee->name .
            ' - بتاريخ: ' . $salary->date;

        PaymentMethodTransaction::create([
            'payment_method_id' => $salary->payment_method_id,
            'transaction_date'  => now(),
            'amount' => $salary->amount,
            'type' => 'debit',
            'source_type' => 'راتب',
            'description' => $description,
            'source_id' => $salary->id,
        ]);

        // Update balance
        $balance = PaymentMethodBalance::where('payment_method_id', $salary->payment_method_id)->first();
        if ($balance && $salary->amount > 0) {
            $balance->current_balance -= $salary->amount;
            $balance->save();
        }

        toast('تم الإضافة بنجاح', 'success');
        return redirect()->route('Salaries.index');
    }



    public function show($id)
    {
        $salary = Salary::find($id);
        return view('backend.HR.Salaries.show');
    }



    public function edit($id)
    {
        $salary = Salary::find($id);
        return view('backend.HR.Salaries.edit', compact('salary'));
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_id' => 'required',
            'payment_method_id' => 'required',
            'name' => 'required',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        $salary = Salary::findOrFail($id);

        $oldAmount = $salary->amount;
        $oldPaymentMethodId = $salary->payment_method_id;

        // 1️⃣ Reverse old balance
        $oldBalance = PaymentMethodBalance::where('payment_method_id', $oldPaymentMethodId)->first();
        if ($oldBalance) {
            $oldBalance->current_balance += $oldAmount; // reverse previous debit
            $oldBalance->save();
        }

        // 2️⃣ Update salary record
        $salary->update([
            'user_id' => Auth::id(),
            'employee_id' => $request->employee_id,
            'payment_method_id' => $request->payment_method_id,
            'name' => $request->name,
            'amount' => $request->amount,
            'date' => $request->date,
            'notes' => $request->notes,
        ]);

        // 3️⃣ Update existing transaction
        $transaction = PaymentMethodTransaction::where([
            'source_type' => 'راتب',
            'source_id' => $salary->id,
        ])->first();

        $description = 'راتب: ' . $salary->name .
            ' - للموظف: ' . $salary->employee->name .
            ' - بتاريخ: ' . $salary->date;

        if ($transaction) {
            $transaction->update([
                'payment_method_id' => $salary->payment_method_id,
                'transaction_date'  => now(),
                'amount' => $salary->amount,
                'type' => 'debit',
                'description' => $description,
            ]);
        }

        // 4️⃣ Subtract new amount from new balance
        $newBalance = PaymentMethodBalance::where('payment_method_id', $salary->payment_method_id)->first();
        if ($newBalance && $salary->amount > 0) {
            $newBalance->current_balance -= $salary->amount;
            $newBalance->save();
        }

        toast('تم التعديل بنجاح', 'success');
        return redirect()->route('Salaries.index');
    }




    public function destroy($id)
    {
        $salary = Salary::findOrFail($id);

        $amount = $salary->amount;
        $paymentMethodId = $salary->payment_method_id;

        // 1️⃣ Reverse balance impact (was a debit → add back)
        $balance = PaymentMethodBalance::where('payment_method_id', $paymentMethodId)->first();
        if ($balance && $amount > 0) {
            $balance->current_balance += $amount;
            $balance->save();
        }

        // 2️⃣ Delete the related transaction
        PaymentMethodTransaction::where([
            'source_type' => 'راتب',
            'source_id' => $salary->id,
        ])->delete();

        // 3️⃣ Delete the salary record
        $salary->delete();

        toast('تم الحذف بنجاح', 'success');
        return redirect()->back();
    }
}
