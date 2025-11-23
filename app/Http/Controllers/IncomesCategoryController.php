<?php

namespace App\Http\Controllers;

use App\Models\IncomesCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomesCategoryController extends Controller
{

    public function index()
    {
        $incomesCategories = IncomesCategory::orderBy('id', 'desc')->get();
        return view('backend.pages.IncomesCategories.index', compact('incomesCategories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
        ]);

        IncomesCategory::create([
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

        $incomesCategory = IncomesCategory::find($id);
        $incomesCategory->update([
            'user_id' => Auth::id(),
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
        ]);

        toast('تم التعديل بنجاح','success');
        return redirect()->back();
    }




    public function destroy($id)
    {
        $incomesCategory = IncomesCategory::find($id);
        if ($incomesCategory->IncomesSubCategories->count() == 0)
        {
            $incomesCategory->delete();
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
