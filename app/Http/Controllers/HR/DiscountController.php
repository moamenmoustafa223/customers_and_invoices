<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\HR\Discount;
use App\Models\PaymentMethodBalance;
use App\Models\PaymentMethodTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscountController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('query');
        $discounts = Discount::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhereHas('Employee', function ($query) use ($search) {
                $query->where('name_ar', 'like', '%' . $search . '%')
                    ->orWhere('name_en', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            })
            ->orderBy('id', 'desc')->paginate(10);

        return view('backend.HR.Discounts.index', compact('discounts'));
    }



    public function create()
    {
        return view('backend.HR.Discounts.add');
    }



    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'category_discount_id' => 'required',
            'payment_method_id' => 'required',
            'name' => 'required',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        // 1️⃣ Create the discount
        $discount = Discount::create([
            'user_id' => Auth::id(),
            'employee_id' => $request->employee_id,
            'category_discount_id' => $request->category_discount_id,
            'payment_method_id' => $request->payment_method_id,
            'name' => $request->name,
            'amount' => $request->amount,
            'date' => $request->date,
            'notes' => $request->notes,
        ]);

        // 2️⃣ Build clear transaction description
        $description = 'خصم: ' . $discount->name .
            ' - للموظف: ' . $discount->employee->name .
            ' - الفئة: ' . $discount->CategoryDiscount->name .
            ' - بتاريخ: ' . $discount->date;

        // 3️⃣ Record the transaction
        PaymentMethodTransaction::create([
            'payment_method_id' => $discount->payment_method_id,
            'transaction_date'  => now(),
            'amount' => $discount->amount,
            'type' => 'credit', // This adds to the balance
            'source_type' => 'خصم',
            'description' => $description,
            'source_id' => $discount->id,
        ]);

        // 4️⃣ Update balance
        $balance = PaymentMethodBalance::where('payment_method_id', $discount->payment_method_id)->first();
        if ($balance && $discount->amount > 0) {
            $balance->current_balance += $discount->amount;
            $balance->save();
        }

        toast('تم الإضافة بنجاح', 'success');
        return redirect()->route('Discounts.index');
    }




    public function show($id)
    {
        $discount = Discount::find($id);
        return view('backend.HR.Discounts.show');
    }




    public function edit($id)
    {
        $discount = Discount::find($id);
        return view('backend.HR.Discounts.edit', compact('discount'));
    }




    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_id' => 'required',
            'category_discount_id' => 'required',
            'payment_method_id' => 'required',
            'name' => 'required',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        $discount = Discount::findOrFail($id);

        $oldAmount = $discount->amount;
        $oldPaymentMethodId = $discount->payment_method_id;

        // 1️⃣ Reverse old credit effect
        $oldBalance = PaymentMethodBalance::where('payment_method_id', $oldPaymentMethodId)->first();
        if ($oldBalance) {
            $oldBalance->current_balance -= $oldAmount;
            $oldBalance->save();
        }

        // 2️⃣ Update discount record
        $discount->update([
            'user_id' => Auth::id(),
            'employee_id' => $request->employee_id,
            'category_discount_id' => $request->category_discount_id,
            'payment_method_id' => $request->payment_method_id,
            'name' => $request->name,
            'amount' => $request->amount,
            'date' => $request->date,
            'notes' => $request->notes,
        ]);

        // 3️⃣ Description
        $description = 'خصم: ' . $discount->name .
            ' - للموظف: ' . $discount->employee->name .
            ' - الفئة: ' . $discount->CategoryDiscount->name .
            ' - بتاريخ: ' . $discount->date;

        // 4️⃣ Update existing transaction
        $transaction = PaymentMethodTransaction::where([
            'source_type' => 'خصم',
            'source_id' => $discount->id,
        ])->first();

        if ($transaction) {
            $transaction->update([
                'payment_method_id' => $discount->payment_method_id,
                'transaction_date'  => now(),
                'amount' => $discount->amount,
                'type' => 'credit',
                'description' => $description,
            ]);
        }

        // 5️⃣ Apply new credit effect to new balance
        $newBalance = PaymentMethodBalance::where('payment_method_id', $discount->payment_method_id)->first();
        if ($newBalance && $discount->amount > 0) {
            $newBalance->current_balance += $discount->amount;
            $newBalance->save();
        }

        return redirect()->route('Discounts.index')->with('success', 'تم التحديث بنجاح');
    }




    public function destroy($id)
    {
        $discount = Discount::findOrFail($id);

        $amount = $discount->amount;
        $paymentMethodId = $discount->payment_method_id;

        // 1️⃣ Reverse balance impact (was a credit → subtract back)
        $balance = PaymentMethodBalance::where('payment_method_id', $paymentMethodId)->first();
        if ($balance && $amount > 0) {
            $balance->current_balance -= $amount;
            $balance->save();
        }

        // 2️⃣ Delete the related transaction
        PaymentMethodTransaction::where([
            'source_type' => 'خصم',
            'source_id' => $discount->id,
        ])->delete();

        // 3️⃣ Delete the discount record
        $discount->delete();

        toast('تم الحذف بنجاح', 'success');
        return redirect()->back();
    }
    
}
