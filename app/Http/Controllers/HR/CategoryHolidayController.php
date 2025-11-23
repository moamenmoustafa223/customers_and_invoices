<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\HR\CategoryHoliday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryHolidayController extends Controller
{

    public function index()
    {
        $categoriesHolidays = CategoryHoliday::all();
        return view('backend.HR.CategoryHolidays.index', compact('categoriesHolidays'));
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

        CategoryHoliday::create([
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
        $categoryHoliday = CategoryHoliday::find($id);
        return view('backend.HR.CategoryHolidays.show', compact('categoryHoliday'));

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

        $categoryHoliday = CategoryHoliday::find($id);

        $categoryHoliday->update([
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
        $categoryHoliday = CategoryHoliday::find($id);
        $categoryHoliday->delete();
        toast('تم الحذف بنجاح','success');
        return redirect()->back();
    }
}
