<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\HR\CategoryAllowance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryAllowanceController extends Controller
{

    public function index()
    {
        $categoriesAllowances = CategoryAllowance::all();
        return view('backend.HR.CategoryAllowances.index', compact('categoriesAllowances'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'name_en' => 'required',
        ], [
            'name.required' => 'الاسم عربي مطلوب',
            'name_en.required' => 'الاسم انجليزي مطلوب',
        ]);

        CategoryAllowance::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'name_en' => $request->name_en,
            'notes' => $request->notes,
        ]);
        toast('تم الإضافة بنجاح','success');
        return redirect()->back();
    }




    public function show(CategoryAllowance $categoryAllowance)
    {
        //
    }




    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ], [
            'name.required' => 'الاسم عربي مطلوب',
            'name_en.required' => 'الاسم انجليزي مطلوب',
        ]);
    
        $categoryAllowance = CategoryAllowance::findOrFail($id);
    
        $categoryAllowance->update([
            'name' => $request->name,
            'name_en' => $request->name_en,
            'notes' => $request->notes,
            'user_id' => Auth::id(), // ✅ move this outside validation
        ]);
    
        toast('تم التعديل بنجاح','success');
        return redirect()->back();
    }
    




    public function destroy($id)
    {
        $categoryAllowance = CategoryAllowance::find($id);
        $categoryAllowance->delete();

        toast('تم الحذف بنجاح','success');
        return redirect()->back();
    }



}
