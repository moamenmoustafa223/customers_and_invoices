<?php

namespace App\Http\Controllers;

use App\Models\ExpenseSubCategory;
use App\Http\Requests\StoreExpenseSubCategoryRequest;
use App\Http\Requests\UpdateExpenseSubCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseSubCategoryController extends Controller
{
    public function index()
    {
        $expenseSubCategories = ExpenseSubCategory::orderBy('id', 'desc')->get();
        return view('backend.pages.ExpenseSubCategories.index', compact('expenseSubCategories'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'expense_category_id' => 'required',
        ]);

        ExpenseSubCategory::create([
            'user_id' => Auth::id(),
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'expense_category_id' => $request->expense_category_id,
        ]);
        toast('تم الإضافة بنجاح','success');
        return redirect()->back();
    }



    public function show($id)
    {
        $expenseSubCategory = ExpenseSubCategory::find($id);
        return view('backend.pages.ExpenseSubCategories.show', compact('expenseSubCategory'));
    }




    public function update(Request $request, $id)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'expense_category_id' => 'required',
        ]);

        $expenseSubCategory = ExpenseSubCategory::find($id);
        $expenseSubCategory->update([
            'user_id' => Auth::id(),
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'expense_category_id' => $request->expense_category_id,
        ]);

        toast('تم التعديل بنجاح','success');
        return redirect()->back();
    }



    public function destroy($id)
    {
        $expenseSubCategory = ExpenseSubCategory::find($id);
        if ($expenseSubCategory->Expenses->count() == 0)
        {
            $expenseSubCategory->delete();
            toast('تم الحذف بنجاح','success');
            return redirect()->back();
        }
        else
        {
            toast('لا يمكن الحذف يوجد مصروفات تحت هذا القسم .. قم بحذف االمصروفات  أولا ','error');
            return redirect()->back();
        }

    }


}
