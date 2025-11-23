<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\HR\CategoryDiscounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryDiscountsController extends Controller
{

    public function index()
    {
        $CategoriesDiscounts = CategoryDiscounts::all();
        return view('backend.HR.CategoryDiscounts.index', compact('CategoriesDiscounts'));
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

        CategoryDiscounts::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'name_en' => $request->name_en,
            'notes' => $request->notes,
        ]);
        toast('تم الإضافة بنجاح','success');
        return redirect()->back();
    }




    public function show($id)
    {
        $categoryDiscounts = CategoryDiscounts::find($id);
        return view('backend.HR.categoryDiscounts.show', compact('categoryDiscounts'));
    }





    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'name_en' => 'required',
        ], [
            'name.required' => 'الاسم عربي مطلوب',
            'name_en.required' => 'الاسم انجليزي مطلوب',
        ]);

        $categoryDiscounts = CategoryDiscounts::find($id);

        $categoryDiscounts->update([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'name_en' => $request->name_en,
            'notes' => $request->notes,
        ]);

        toast('تم التعديل بنجاح','success');
        return redirect()->back();
    }



    public function destroy($id)
    {
        $categoryDiscounts = CategoryDiscounts::find($id);
        $categoryDiscounts->delete();
        toast('تم الحذف بنجاح','success');
        return redirect()->back();
    }
}
