<?php

namespace App\Http\Controllers;

use App\Exports\ReportsAssetsByMainCategoriesExport;
use App\Exports\ReportsAssetsBySubCategoriesExport;
use App\Exports\UnifiedAssetsReportExport;
use App\Models\Asset;
use App\Http\Requests\StoreAssetRequest;
use App\Http\Requests\UpdateAssetRequest;
use App\Models\AssetsSubCategory;
use App\Models\PaymentMethodBalance;
use App\Models\PaymentMethodTransaction;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('query');
        $assets = Asset::query()
            ->where('supplier', 'LIKE', "%{$search}%")
            ->OrWhere('expense_date', 'LIKE', "%{$search}%")
            ->OrWhere('description', 'LIKE', "%{$search}%")
            ->orderBy('id', 'desc')->paginate(100);

        return view('backend.pages.Assets.index', compact('assets'));
    }


    function fetchAssetsSubCategories(Request $request)
    {
        $data['AssetsSubCategories'] = AssetsSubCategory::where("assets_category_id", $request->assets_category_id)->get();
        return response()->json($data);
    }



    public function store(Request $request)
{
    $request->validate([
        'assets_category_id' => 'required',
        'payment_method_id' => 'required',
        'amount' => 'required',
        'depreciation_rate' => 'required',
        'file' => 'max:5048',
    ]);

    $data = [];

    // 📁 File upload
    if ($file = $request->file('file')) {
        $originalName = preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
        $filename = time() . '_' . $originalName;
        $path = 'uploads/assets/' . $filename;

        Storage::disk('s3')->put($path, file_get_contents($file), [
            'ServerSideEncryption' => 'AES256',
        ]);

        $data['file'] = Storage::disk('s3')->url($path);
    }

    // 🔢 Generate code number
    $code_no = Asset::count() ? Asset::latest()->first()->id + 1 : 1;
    $data['code_no'] = date('Ymd') . '0' . $code_no;

    // 🧾 Core fields
    $data['user_id'] = Auth::id();
    $data['assets_category_id'] = $request->input('assets_category_id');
    $data['assets_sub_category_id'] = $request->input('assets_sub_category_id');
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
    $data['depreciation_rate'] = $request->input('depreciation_rate');

    // 🏗️ Create the asset
    $asset = Asset::create($data);

    toast('تم الإضافة بنجاح', 'success');
    return redirect()->back();
}






    public function edit($id)
    {
        $asset = Asset::find($id);
        return view('backend.pages.Assets.edit', compact('asset'));
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'assets_category_id' => 'required',
            'amount' => 'required',
            'depreciation_rate' => 'required',
            'file' => 'max:5048',
        ]);

        $asset = Asset::findOrFail($id);

        $data = [];

        // 📁 File update
        if ($file = $request->file('file')) {
            if ($asset->file) {
                $oldPath = parse_url($asset->file, PHP_URL_PATH);
                $oldPath = ltrim($oldPath, '/');
                if (Storage::disk('s3')->exists($oldPath)) {
                    Storage::disk('s3')->delete($oldPath);
                }
            }

            $originalName = preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $filename = time() . '_' . $originalName;
            $path = 'uploads/assets/' . $filename;

            Storage::disk('s3')->put($path, file_get_contents($file), [
                'ServerSideEncryption' => 'AES256',
            ]);

            $data['file'] = Storage::disk('s3')->url($path);
        }

        // 🧾 Update fields
        $data['user_id'] = Auth::id();
        $data['assets_category_id'] = $request->input('assets_category_id');
        $data['assets_sub_category_id'] = $request->input('assets_sub_category_id');
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
        $data['depreciation_rate'] = $request->input('depreciation_rate');

        // 💾 Update the asset
        $asset->update($data);

        toast('تم التعديل بنجاح', 'success');
        return redirect()->route('Assets.index');
    }





    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);

        // Delete file from S3 if exists
        if ($asset->file) {
            $oldPath = parse_url($asset->file, PHP_URL_PATH);
            $oldPath = ltrim($oldPath, '/');
            if (Storage::disk('s3')->exists($oldPath)) {
                Storage::disk('s3')->delete($oldPath);
            }
        }

        $asset->delete();

        toast('تم الحذف بنجاح', 'success');
        return redirect()->back();
    }
    


    public function reports_assets(Request $request)
    {
        $start_date = $request->start_date ?? now()->toDateString();
        $end_date = $request->end_date ?? now()->toDateString();
        $mainCategoryId = $request->assets_category_id;
        $subCategoryId = $request->assets_sub_category_id;
    
        $query = Asset::query()->whereBetween('expense_date', [$start_date, $end_date]);
    
        if (!empty($mainCategoryId) && $mainCategoryId != 0) {
            $query->where('assets_category_id', $mainCategoryId);
        }
    
        if (!empty($subCategoryId) && $subCategoryId != 0) {
            $query->where('assets_sub_category_id', $subCategoryId);
        }
    
        $reports_assets = $query->orderBy('expense_date', 'asc')->paginate(10);
    
        $total_assets = $query->clone()->sum('amount');
        $amount_with_tax = $query->clone()->sum('amount_with_tax');
        $tax_amount = $query->clone()->sum('tax_amount');
    
        $mainCategories = \App\Models\AssetsCategory::all();
        $subCategories = \App\Models\AssetsSubCategory::all();
    
        return view('backend.pages.Assets.reports_assets', compact(
            'start_date',
            'end_date',
            'mainCategoryId',
            'subCategoryId',
            'reports_assets',
            'total_assets',
            'amount_with_tax',
            'tax_amount',
            'mainCategories',
            'subCategories'
        ));
    }
    
    // تقارير الأصول حسب الأقسام الرئيسية
    public function reports_assets_excel(Request $request)
{
    $start_date = $request->start_date ?? now()->toDateString();
    $end_date = $request->end_date ?? now()->toDateString();
    $mainCategoryId = $request->assets_category_id;
    $subCategoryId = $request->assets_sub_category_id;

    return Excel::download(
        new UnifiedAssetsReportExport($start_date, $end_date, $mainCategoryId, $subCategoryId),
        'assets_report.xlsx'
    );
}

}
