<?php

namespace App\Http\Controllers;

use App\Models\IncomesSubCategory;
use App\Http\Requests\StoreIncomesSubCategoryRequest;
use App\Http\Requests\UpdateIncomesSubCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomesSubCategoryController extends Controller
{
    public function index()
    {
        $incomesSubCategories = IncomesSubCategory::orderBy('id', 'desc')->get();
        return view('backend.pages.IncomesSubCategories.index', compact('incomesSubCategories'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'incomes_category_id' => 'required',
            'name_ar' => 'required',
            'name_en' => 'required',
        ]);

        IncomesSubCategory::create([
            'user_id' => Auth::id(),
            'incomes_category_id' => $request->incomes_category_id,
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
            'incomes_category_id' => 'required',
        ]);

        $incomesSubCategory = IncomesSubCategory::find($id);
        $incomesSubCategory->update([
            'user_id' => Auth::id(),
            'incomes_category_id' => $request->incomes_category_id,
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
        ]);

        toast('تم التعديل بنجاح','success');
        return redirect()->back();
    }




    public function destroy($id)
    {
        $incomesSubCategory = IncomesSubCategory::find($id);
        if ($incomesSubCategory->Incomes->count() == 0)
        {
            $incomesSubCategory->delete();
            toast('تم الحذف بنجاح','success');
            return redirect()->back();
        }
        else
        {
            toast('لا يمكن الحذف يوجد إيردات تحت هذا القسم .. قم بحذف الإيردات أولا ','error');
            return redirect()->back();
        }

    }

}
