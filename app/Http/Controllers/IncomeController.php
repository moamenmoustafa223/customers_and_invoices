<?php

namespace App\Http\Controllers;

use App\Exports\ReportsIncomesByMainCategoriesExport;
use App\Exports\ReportsIncomesBySubCategoriesExport;
use App\Models\Income;
use App\Models\IncomesSubCategory;
use App\Models\PaymentMethodBalance;
use App\Models\PaymentMethodTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class IncomeController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('query');
        $incomes = Income::query()
            ->where('supplier', 'LIKE', "%{$search}%")
            ->where('expense_date', 'LIKE', "%{$search}%")
            ->where('description', 'LIKE', "%{$search}%")
            ->orderBy('id', 'desc')->paginate(100);

        return view('backend.pages.Incomes.index', compact('incomes'));
    }


    function fetchIncomesSubCategories(Request $request)
    {
        $data['IncomesSubCategories'] = IncomesSubCategory::where("incomes_category_id", $request->incomes_category_id)->get();
        return response()->json($data);
    }



    public function store(Request $request)
    {
        $request->validate([
            'incomes_category_id' => 'required',
            'payment_method_id' => 'required',
            'supplier' => 'required',
            'file' => 'max:5048',
        ]);

        $path = 'uploads/incomes/';
    
        if ($file = $request->file('file')) {
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $fullPath = $path . $filename;
            Storage::disk('s3')->put($fullPath, file_get_contents($file), [
                'ServerSideEncryption' => 'AES256',
            ]);
            $data['file'] = Storage::disk('s3')->url($fullPath);
        }

        $data['user_id'] = Auth::id();
        $data['incomes_category_id'] = $request->input('incomes_category_id');
        $data['incomes_sub_category_id'] = $request->input('incomes_sub_category_id');
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

        $income = Income::create($data);

        // 🔁 Build description
        $description = 'دخل: ' . ($income->description ?? 'بدون وصف') .
            ' - من المورد: ' . $income->supplier .
            ' - بتاريخ: ' . $income->expense_date;

        // 🔁 Add transaction
        PaymentMethodTransaction::create([
            'payment_method_id' => $income->payment_method_id,
            'transaction_date'  => now(),
            'amount' => $income->amount_with_tax,
            'type' => 'credit',
            'source_type' => 'واردات',
            'source_id' => $income->id,
            'description' => $description,
        ]);

        // 🔁 Update balance
        $balance = PaymentMethodBalance::where('payment_method_id', $income->payment_method_id)->first();
        if ($balance && $income->amount_with_tax > 0) {
            $balance->current_balance += $income->amount_with_tax;
            $balance->save();
        }

        toast('تم الإضافة بنجاح', 'success');
        return redirect()->route('Incomes.index');
    }




    public function show($id)
    {
        $income = Income::find($id);
        return view('backend.pages.Incomes.show', compact('income'));
    }



    public function edit($id)
    {
        $income = Income::find($id);
        return view('backend.pages.Incomes.edit', compact('income'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'incomes_category_id' => 'required',
            'payment_method_id' => 'required',
            'supplier' => 'required',
            'file' => 'max:5048',
        ]);

        $income = Income::findOrFail($id);

        // 🔁 Reverse old credit
        $oldAmount = $income->amount_with_tax;
        $oldPaymentMethodId = $income->payment_method_id;

        $oldBalance = PaymentMethodBalance::where('payment_method_id', $oldPaymentMethodId)->first();
        if ($oldBalance) {
            $oldBalance->current_balance -= $oldAmount;
            $oldBalance->save();
        }

        $path = 'uploads/incomes/';
    
        if ($file = $request->file('file')) {
            // حذف الملف القديم من S3
            if ($income->file) {
                $oldPath = ltrim(parse_url($income->file, PHP_URL_PATH), '/');
                if (Storage::disk('s3')->exists($oldPath)) {
                    Storage::disk('s3')->delete($oldPath);
                }
            }
    
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $fullPath = $path . $filename;
            Storage::disk('s3')->put($fullPath, file_get_contents($file), [
                'ServerSideEncryption' => 'AES256',
            ]);
            $data['file'] = Storage::disk('s3')->url($fullPath);
        }

        $data['user_id'] = Auth::id();
        $data['incomes_category_id'] = $request->input('incomes_category_id');
        $data['incomes_sub_category_id'] = $request->input('incomes_sub_category_id');
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

        $income->update($data);

        // 🔁 Build transaction description
        $description = 'دخل: ' . ($income->description ?? 'بدون وصف') .
            ' - من المورد: ' . $income->supplier .
            ' - بتاريخ: ' . $income->expense_date;

        // 🔁 Update existing transaction
        $transaction = PaymentMethodTransaction::where([
            'source_type' => 'واردات',
            'source_id' => $income->id,
        ])->first();

        if ($transaction) {
            $transaction->update([
                'payment_method_id' => $income->payment_method_id,
                'transaction_date'  => now(),
                'amount' => $income->amount_with_tax,
                'type' => 'credit',
                'description' => $description,
            ]);
        }

        // 🔁 Add new credit to updated balance
        $newBalance = PaymentMethodBalance::where('payment_method_id', $income->payment_method_id)->first();
        if ($newBalance && $income->amount_with_tax > 0) {
            $newBalance->current_balance += $income->amount_with_tax;
            $newBalance->save();
        }

        toast('تم التعديل بنجاح', 'success');
        return redirect()->route('Incomes.index');
    }



    public function destroy($id)
    {
        $income = Income::findOrFail($id);

        $amount = $income->amount_with_tax;
        $paymentMethodId = $income->payment_method_id;
        if ($income->file) {
            $filePath = ltrim(parse_url($income->file, PHP_URL_PATH), '/');
            if (Storage::disk('s3')->exists($filePath)) {
                Storage::disk('s3')->delete($filePath);
            }
        }
        // 1️⃣ Restore balance (since it was a credit)
        $balance = PaymentMethodBalance::where('payment_method_id', $paymentMethodId)->first();
        if ($balance && $amount > 0) {
            $balance->current_balance -= $amount;
            $balance->save();
        }

        // 2️⃣ Delete related transaction
        PaymentMethodTransaction::where([
            'payment_method_id' => $paymentMethodId,
            'source_type' => 'واردات',
            'source_id' => $income->id,
        ])->delete();

        // 3️⃣ Delete income
        $income->delete();

        toast('تم الحذف بنجاح', 'success');
        return redirect()->back();
    }




    // تقارير الإيرادات
    public function reports_incomes(Request $request)
    {
        $start_date = $request->filled('start_date')
            ? Carbon::parse($request->start_date)->format('Y-m-d')
            : Carbon::today()->format('Y-m-d');

        $end_date = $request->filled('end_date')
            ? Carbon::parse($request->end_date)->format('Y-m-d')
            : Carbon::today()->format('Y-m-d');

        $categoryId = $request->incomes_category_id ?? 0;
        $subCategoryId = $request->incomes_sub_category_id ?? 0;

        $query = Income::whereBetween('expense_date', [$start_date, $end_date]);

        if ($categoryId != 0) {
            $query->where('incomes_category_id', $categoryId);
        }

        if ($subCategoryId != 0) {
            $query->where('incomes_sub_category_id', $subCategoryId);
        }

        $incomes = $query->orderBy('expense_date', 'asc')->paginate(100);
        $total_Incomes = (clone $query)->sum('amount');
        $amount_with_tax = (clone $query)->sum('amount_with_tax');
        $tax_amount = (clone $query)->sum('tax_amount');

        $mainCategories = \App\Models\IncomesCategory::all();
        $subCategories = \App\Models\IncomesSubCategory::all();

        return view('backend.pages.Incomes.reports_incomes', compact(
            'start_date',
            'end_date',
            'incomes',
            'total_Incomes',
            'amount_with_tax',
            'tax_amount',
            'mainCategories',
            'subCategories',
            'categoryId',
            'subCategoryId'
        ));
    }
    public function reports_incomes_excel(Request $request)
    {
        $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $end_date = Carbon::parse($request->end_date)->format('Y-m-d');
        $category_id = $request->incomes_category_id ?? 0;
        $sub_category_id = $request->incomes_sub_category_id ?? 0;

        return Excel::download(
            new \App\Exports\UnifiedIncomesReportExport($start_date, $end_date, $category_id, $sub_category_id),
            'reports_incomes.xlsx'
        );
    }
}
