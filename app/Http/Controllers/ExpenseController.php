<?php

namespace App\Http\Controllers;

use App\Exports\ExpensesExport;
use App\Exports\ReportsExpensesByMainCategoriesExport;
use App\Exports\ReportsExpensesBySubCategoriesExport;
use App\Models\Expense;
use App\Models\ExpenseSubCategory;
use App\Models\PaymentMethodBalance;
use App\Models\PaymentMethodTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ExpenseController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('query');
        $expenses = Expense::query()
            ->where('supplier', 'LIKE', "%{$search}%")
            ->where('expense_date', 'LIKE', "%{$search}%")
            ->where('description', 'LIKE', "%{$search}%")
            ->orderBy('id', 'desc')->paginate(100);

        return view('backend.pages.Expenses.index', compact('expenses'));
    }


    function fetchExpenseSubCategories(Request $request)
    {
        $data['ExpenseSubCategories'] = ExpenseSubCategory::where("expense_category_id", $request->expense_category_id)->get();
        return response()->json($data);
    }





    public function store(Request $request)
    {
        $request->validate([
            'expense_category_id' => 'required',
            'payment_method_id' => 'required',
            'supplier' => 'required',
            'file' => 'max:5048',
        ]);

        $data = [];

        if ($file = $request->file('file')) {
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $path = 'uploads/expenses/' . $filename;
    
            Storage::disk('s3')->put($path, file_get_contents($file), [
                'ServerSideEncryption' => 'AES256',
            ]);
    
            $data['file'] = Storage::disk('s3')->url($path);
        }

        // 🔢 Core fields
        $data['user_id'] = Auth::id();
        $data['expense_category_id'] = $request->input('expense_category_id');
        $data['expense_sub_category_id'] = $request->input('expense_sub_category_id');
        $data['payment_method_id'] = $request->input('payment_method_id');
        $data['check_number'] = $request->input('check_number');
        $data['supplier'] = $request->input('supplier');
        $data['supplier_invoice_number'] = $request->input('supplier_invoice_number');

        $data['amount'] = $request->input('amount');
        $data['tax'] = $request->input('tax');
        $data['amount_with_tax'] = $request->input('amount_with_tax');
        $data['tax_amount'] = $request->input('amount_with_tax') - $request->input('amount');

        $data['expense_date'] = $request->input('expense_date');
        $data['description'] = $request->input('description');
        $data['notes'] = $request->input('notes');

        // 🧾 Create Expense
        $expense = Expense::create($data);

        // 📝 Build description
        $description = 'مصروف: ' . ($expense->description ?? 'بدون وصف') .
            ' - للمورد: ' . $expense->supplier .
            ' - بتاريخ: ' . $expense->expense_date;

        // 💸 Record in transactions
        PaymentMethodTransaction::create([
            'payment_method_id' => $expense->payment_method_id,
            'transaction_date'  => now(),
            'amount' => $expense->amount_with_tax,
            'type' => 'debit', // Because it's an expense
            'description' => $description,
            'source_type' => 'مصروفات',
            'source_id' => $expense->id,
        ]);

        // 💰 Update payment method balance
        $balance = PaymentMethodBalance::where('payment_method_id', $expense->payment_method_id)->first();
        if ($balance && $expense->amount_with_tax > 0) {
            $balance->current_balance -= $expense->amount_with_tax;
            $balance->save();
        }

        toast('تم الإضافة بنجاح', 'success');
        return redirect()->route('Expenses.index');
    }





    public function show($id)
    {
        $expense = Expense::find($id);
        return view('backend.pages.Expenses.show', compact('expense'));
    }

    public function edit($id)
    {
        $expense = Expense::find($id);
        return view('backend.pages.Expenses.edit', compact('expense'));
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'expense_category_id' => 'required',
            'payment_method_id' => 'required',
            'supplier' => 'required',
            'file' => 'max:5048',
        ]);

        $expense = Expense::findOrFail($id);

        $oldAmount = $expense->amount_with_tax;
        $oldPaymentMethodId = $expense->payment_method_id;

        $data = [];

        // 📁 File update
        if ($file = $request->file('file')) {
            // حذف القديم
            if ($expense->file) {
                $oldPath = parse_url($expense->file, PHP_URL_PATH);
                $oldPath = ltrim($oldPath, '/');
                if (Storage::disk('s3')->exists($oldPath)) {
                    Storage::disk('s3')->delete($oldPath);
                }
            }
        
            // رفع الجديد
            $path = 'uploads/expenses/';
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $fullPath = $path . $filename;
        
            Storage::disk('s3')->put($fullPath, file_get_contents($file), [
                'ServerSideEncryption' => 'AES256',
            ]);
        
            $data['file'] = Storage::disk('s3')->url($fullPath);
        }

        // 🧾 Prepare new data
        $data['user_id'] = Auth::id();
        $data['expense_category_id'] = $request->input('expense_category_id');
        $data['expense_sub_category_id'] = $request->input('expense_sub_category_id');
        $data['payment_method_id'] = $request->input('payment_method_id');
        $data['check_number'] = $request->input('check_number');
        $data['supplier'] = $request->input('supplier');
        $data['supplier_invoice_number'] = $request->input('supplier_invoice_number');

        $data['amount'] = $request->input('amount');
        $data['tax'] = $request->input('tax');
        $data['amount_with_tax'] = $request->input('amount_with_tax');
        $data['tax_amount'] = $request->input('amount_with_tax') - $request->input('amount');
        $data['expense_date'] = $request->input('expense_date');
        $data['description'] = $request->input('description');
        $data['notes'] = $request->input('notes');

        // ✏️ Update the expense
        $expense->update($data);

        // 1️⃣ Reverse old impact
        $oldBalance = PaymentMethodBalance::where('payment_method_id', $oldPaymentMethodId)->first();
        if ($oldBalance) {
            $oldBalance->current_balance += $oldAmount;
            $oldBalance->save();
        }

        // 📝 Build description
        $description = 'مصروف: ' . ($expense->description ?? 'بدون وصف') .
            ' - للمورد: ' . $expense->supplier .
            ' - بتاريخ: ' . $expense->expense_date;

        // 2️⃣ Update or recreate transaction
        $transaction = PaymentMethodTransaction::where([
            'source_type' => 'مصروفات',
            'source_id' => $expense->id,
        ])->first();

        if ($transaction) {
            $transaction->update([
                'payment_method_id' => $expense->payment_method_id,
                'transaction_date' => now(),
                'amount' => $expense->amount_with_tax,
                'type' => 'debit',
                'description' => $description,
            ]);
        } else {
            PaymentMethodTransaction::create([
                'payment_method_id' => $expense->payment_method_id,
                'transaction_date'  => now(),
                'amount' => $expense->amount_with_tax,
                'type' => 'debit',
                'description' => $description,
                'source_type' => 'مصروفات',
                'source_id' => $expense->id,
            ]);
        }

        // 3️⃣ Apply new impact
        $newBalance = PaymentMethodBalance::where('payment_method_id', $expense->payment_method_id)->first();
        if ($newBalance && $expense->amount_with_tax > 0) {
            $newBalance->current_balance -= $expense->amount_with_tax;
            $newBalance->save();
        }

        toast('تم التعديل بنجاح', 'success');
        return redirect()->route('Expenses.index');
    }





    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);
    
        $amount = $expense->amount_with_tax;
        $paymentMethodId = $expense->payment_method_id;
        
        if ($expense->file) {
            $path = parse_url($expense->file, PHP_URL_PATH);
            $path = ltrim($path, '/');
            if (Storage::disk('s3')->exists($path)) {
                Storage::disk('s3')->delete($path);
            }
        }
        // 1️⃣ Restore balance
        $balance = PaymentMethodBalance::where('payment_method_id', $paymentMethodId)->first();
        if ($balance && $amount > 0) {
            $balance->current_balance += $amount;
            $balance->save();
        }
    
        // 2️⃣ Delete related transaction
        PaymentMethodTransaction::where([
            'payment_method_id' => $paymentMethodId,
            'source_type' => 'مصروفات',
            'source_id' => $expense->id,
        ])->delete();
    
        // 3️⃣ Delete the expense
        $expense->delete();
    
        toast('تم الحذف بنجاح', 'success');
        return redirect()->back();
    }
    


    public function reports_expenses(Request $request)
    {
        $start_date = $request->filled('start_date') 
            ? Carbon::parse($request->start_date)->format('Y-m-d') 
            : Carbon::today()->format('Y-m-d');
    
        $end_date = $request->filled('end_date') 
            ? Carbon::parse($request->end_date)->format('Y-m-d') 
            : Carbon::today()->format('Y-m-d');
    
        $query = Expense::whereDate('expense_date', '>=', $start_date)
            ->whereDate('expense_date', '<=', $end_date);
    
        $expenseCategoryId = $request->expense_category_id ?? 0;
        $expenseSubCategoryId = $request->expense_sub_category_id ?? 0;
    
        if ($expenseCategoryId != 0) {
            $query->where('expense_category_id', $expenseCategoryId);
        }
    
        if ($expenseSubCategoryId != 0) {
            $query->where('expense_sub_category_id', $expenseSubCategoryId);
        }
    
        $reports_Expenses = $query->orderBy('expense_date', 'asc')->paginate(100);
    
        $total_Expenses = (clone $query)->sum('amount');
        $amount_with_tax = (clone $query)->sum('amount_with_tax');
        $tax_amount = (clone $query)->sum('tax_amount');
    
        $mainCategories = \App\Models\ExpenseCategory::all();
        $subCategories = \App\Models\ExpenseSubCategory::all();
    
        return view('backend.pages.Expenses.reports_expenses', compact(
            'start_date',
            'end_date',
            'reports_Expenses',
            'total_Expenses',
            'amount_with_tax',
            'tax_amount',
            'mainCategories',
            'subCategories',
            'expenseCategoryId',
            'expenseSubCategoryId'
        ));
    }
    
    // تقارير المصروفات
    public function reports_expenses_excel(Request $request)
{
    $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
    $end_date = Carbon::parse($request->end_date)->format('Y-m-d');
    $expense_category_id = $request->expense_category_id ?? 0;
    $expense_sub_category_id = $request->expense_sub_category_id ?? 0;

    return Excel::download(
        new \App\Exports\UnifiedExpensesReportExport($start_date, $end_date, $expense_category_id, $expense_sub_category_id),
        'reports_expenses.xlsx'
    );
}

}
