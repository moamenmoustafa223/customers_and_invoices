<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\HR\Allowance;
use App\Models\PaymentMethodBalance;
use App\Models\PaymentMethodTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AllowanceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('query');
        $allowances = Allowance::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhereHas('Employee', function ($query) use ($search) {
                $query->where('name_ar', 'like', '%' . $search . '%')
                    ->orWhere('name_en', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            })
            ->orderBy('id', 'desc')->paginate(10);

        return view('backend.HR.Allowances.index', compact('allowances'));
    }



    public function create()
    {
        return view('backend.HR.Allowances.add');
    }




    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'category_allowance_id' => 'required',
            'payment_method_id' => 'required',
            'name' => 'required',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        // Create allowance
        $allowance = Allowance::create([
            'user_id' => Auth::id(),
            'employee_id' => $request->employee_id,
            'category_allowance_id' => $request->category_allowance_id,
            'payment_method_id' => $request->payment_method_id,
            'name' => $request->name,
            'amount' => $request->amount,
            'date' => $request->date,
            'notes' => $request->notes,
        ]);

        // Insert into payment_method_transactions
        PaymentMethodTransaction::create([
            'payment_method_id' => $allowance->payment_method_id,
            'transaction_date'  => now(),
            'amount' => $allowance->amount,
            'type' => 'debit',
            'source_type' => 'بدل',
            'description' => 'بدل: ' . $allowance->name .
                ' - للموظف: ' . $allowance->employee->name .
                ' - الفئة: ' . $allowance->CategoryAllowance->name .
                ' - بتاريخ: ' . $allowance->date,
            'source_id' => $allowance->id,
        ]);

        // Update the current balance
        $balance = PaymentMethodBalance::where('payment_method_id', $allowance->payment_method_id)->first();
        if ($balance && $allowance->amount > 0) {
            $balance->current_balance -= $allowance->amount;
            $balance->save();
        }

        toast('تم الإضافة بنجاح', 'success');
        return redirect()->route('Allowances.index');
    }




    public function show($id)
    {
        $allowance = Allowance::find($id);
        return view('backend.HR.Allowances.show', compact('allowance'));
    }




    public function edit($id)
    {
        $allowance = Allowance::find($id);
        return view('backend.HR.Allowances.edit', compact('allowance'));
    }




    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_id' => 'required',
            'category_allowance_id' => 'required',
            'payment_method_id' => 'required',
            'name' => 'required',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        $allowance = Allowance::findOrFail($id);

        $oldAmount = $allowance->amount;
        $oldPaymentMethodId = $allowance->payment_method_id;

        // 1️⃣ Reverse old balance
        $oldBalance = PaymentMethodBalance::where('payment_method_id', $oldPaymentMethodId)->first();
        if ($oldBalance) {
            $oldBalance->current_balance += $oldAmount; // reverse debit
            $oldBalance->save();
        }

        // 2️⃣ Update the allowance
        $allowance->update([
            'user_id' => Auth::id(),
            'employee_id' => $request->employee_id,
            'category_allowance_id' => $request->category_allowance_id,
            'payment_method_id' => $request->payment_method_id,
            'name' => $request->name,
            'amount' => $request->amount,
            'date' => $request->date,
            'notes' => $request->notes,
        ]);

        // 3️⃣ Update existing transaction
        $transaction = PaymentMethodTransaction::where([
            'source_type' => 'بدل',
            'source_id' => $allowance->id,
        ])->first();

        $description = 'بدل: ' . $allowance->name .
            ' - للموظف: ' . $allowance->employee->name .
            ' - الفئة: ' . $allowance->CategoryAllowance->name .
            ' - بتاريخ: ' . $allowance->date;

        if ($transaction) {
            $transaction->update([
                'payment_method_id' => $allowance->payment_method_id,
                'transaction_date'  => now(),
                'amount' => $allowance->amount,
                'type' => 'debit',
                'description' => $description,
            ]);
        }

        // 4️⃣ Apply new amount to new balance
        $newBalance = PaymentMethodBalance::where('payment_method_id', $allowance->payment_method_id)->first();
        if ($newBalance) {
            $newBalance->current_balance -= $allowance->amount;
            $newBalance->save();
        }

        toast('تم التعديل بنجاح', 'success');
        return redirect()->route('Allowances.index');
    }




    public function destroy($id)
    {
        $allowance = Allowance::findOrFail($id);

        $amount = $allowance->amount;
        $paymentMethodId = $allowance->payment_method_id;

        // 1️⃣ Reverse balance (it was a debit, so add back)
        $balance = PaymentMethodBalance::where('payment_method_id', $paymentMethodId)->first();
        if ($balance && $amount > 0) {
            $balance->current_balance += $amount;
            $balance->save();
        }

        // 2️⃣ Delete related transaction
        PaymentMethodTransaction::where([
            'source_type' => 'بدل',
            'source_id' => $allowance->id,
        ])->delete();

        // 3️⃣ Delete the allowance record
        $allowance->delete();

        toast('تم الحذف بنجاح', 'success');
        return redirect()->back();
    }
    
}
