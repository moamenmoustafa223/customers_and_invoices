<?php

namespace App\Http\Controllers;

use App\Models\AssetsSubCategory;
use App\Http\Requests\StoreAssetsSubCategoryRequest;
use App\Http\Requests\UpdateAssetsSubCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetsSubCategoryController extends Controller
{
    public function index()
    {
        $assetsSubCategories = AssetsSubCategory::orderBy('id', 'desc')->get();
        return view('backend.pages.AssetsSubCategories.index', compact('assetsSubCategories'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'assets_category_id' => 'required',
        ]);

        AssetsSubCategory::create([
            'user_id' => Auth::id(),
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'assets_category_id' => $request->assets_category_id,
        ]);
        toast('تم الإضافة بنجاح','success');
        return redirect()->back();
    }



    public function show($id)
    {
        $assetsSubCategory = AssetsSubCategory::find($id);
        return view('backend.pages.ExpenseSubCategories.show', compact('assetsSubCategory'));
    }




    public function update(Request $request, $id)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'assets_category_id' => 'required',
        ]);

        $assetsSubCategory = AssetsSubCategory::find($id);
        $assetsSubCategory->update([
            'user_id' => Auth::id(),
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'assets_category_id' => $request->assets_category_id,
        ]);

        toast('تم التعديل بنجاح','success');
        return redirect()->back();
    }



    public function destroy($id)
    {
        $assetsSubCategory = AssetsSubCategory::find($id);
        if ($assetsSubCategory->Assets->count() == 0)
        {
            $assetsSubCategory->delete();
            toast('تم الحذف بنجاح','success');
            return redirect()->back();
        }
        else
        {
            toast('لا يمكن الحذف يوجد أصول تحت هذا القسم .. قم بحذف الأصول أولا ','error');
            return redirect()->back();
        }

    }

}
