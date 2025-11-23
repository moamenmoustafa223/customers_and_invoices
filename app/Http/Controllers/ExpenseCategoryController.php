<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseCategoryController extends Controller
{

    public function index()
    {
        $expenseCategories = ExpenseCategory::orderBy('id', 'desc')->get();
        return view('backend.pages.ExpenseCategories.index', compact('expenseCategories'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
        ]);

        ExpenseCategory::create([
            'user_id' => Auth::id(),
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
        ]);
        toast('تم الإضافة بنجاح','success');
        return redirect()->back();
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
        ]);

        $expenseCategory = ExpenseCategory::find($id);

        $expenseCategory->update([
            'user_id' => Auth::id(),
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
        ]);

        toast('تم التعديل بنجاح','success');
        return redirect()->back();
    }



    public function destroy($id)
    {
        $expenseCategory = ExpenseCategory::find($id);
        if ($expenseCategory->ExpenseSubCategories->count() == 0)
        {
            $expenseCategory->delete();
            toast('تم الحذف بنجاح','success');
            return redirect()->back();
        }
        else
        {
            toast('لا يمكن الحذف يوجد أقسام فرعية تحت هذا القسم .. قم بحذف الأقسام الفرعية أولا ','error');
            return redirect()->back();
        }


    }
}
