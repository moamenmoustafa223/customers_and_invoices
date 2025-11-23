<?php

namespace App\Http\Controllers;

use App\Models\AssetsCategory;
use App\Http\Requests\StoreAssetsCategoryRequest;
use App\Http\Requests\UpdateAssetsCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetsCategoryController extends Controller
{
    public function index()
    {
        $assetsCategories = AssetsCategory::orderBy('id', 'desc')->get();
        return view('backend.pages.AssetsCategories.index', compact('assetsCategories'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
        ]);

        AssetsCategory::create([
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

        $assetsCategory = AssetsCategory::find($id);

        $assetsCategory->update([
            'user_id' => Auth::id(),
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
        ]);

        toast('تم التعديل بنجاح','success');
        return redirect()->back();
    }



    public function destroy($id)
    {
        $assetsCategory = AssetsCategory::find($id);
        if ($assetsCategory->AssetsSubCategories->count() == 0)
        {
            $assetsCategory->delete();
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
