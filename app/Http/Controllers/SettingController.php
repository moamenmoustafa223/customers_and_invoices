<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{


    public function index()
    {
        $setting = Setting::first();
        return view('backend.pages.setting.index', compact('setting'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'company_name_ar' => 'required',
            'company_name_en' => 'required',
        ]);

        $setting = Setting::find($id);

        if ($request->hasFile('logo')) {
            $image = $request->logo;
            $newImage = time() . $image->getClientOriginalName();
            $image->move('uploads/setting', $newImage);
            $setting->logo = 'uploads/setting/' . $newImage;
            $setting->save();
        }

        if ($request->hasFile('header')) {
            $image = $request->header;
            $newImage = time() . $image->getClientOriginalName();
            $image->move('uploads/setting', $newImage);
            $setting->header = 'uploads/setting/' . $newImage;
            $setting->save();
        }
        if ($request->hasFile('header_contract_image')) {
            $image = $request->header_contract_image;
            $newImage = time() . $image->getClientOriginalName();
            $image->move('uploads/setting', $newImage);
            $setting->header_contract_image = 'uploads/setting/' . $newImage;
            $setting->save();
        }

        if ($request->hasFile('stamp')) {
            $image = $request->stamp;
            $newImage = time() . $image->getClientOriginalName();
            $image->move('uploads/setting', $newImage);
            $setting->stamp = 'uploads/setting/' . $newImage;
            $setting->save();
        }


        $setting->update([
            'company_name_ar' => $request->input('company_name_ar'),
            'company_name_en' => $request->input('company_name_en'),
            'cr_no' => $request->input('cr_no'),

            'address_ar' => $request->input('address_ar'),
            'address_en' => $request->input('address_en'),

            'governorate_ar' => $request->input('governorate_ar'),
            'governorate_en' => $request->input('governorate_en'),

            'wilayat_ar' => $request->input('wilayat_ar'),
            'wilayat_en' => $request->input('wilayat_en'),

            'building_no' => $request->input('building_no'),
            'PO_box' => $request->input('PO_box'),
            'pc' => $request->input('pc'),
            'email' => $request->input('email'),
            'phone' => normalizePhoneNumber($request->input('phone'), $request->input('phone_code')),

            'phone_code' => $request->input('phone_code'),
            'tax_no' => $request->input('tax_no'),
            'tax' => $request->input('tax'),
            'tax_percentage' => $request->input('tax_percentage', 15),

            'contract_terms_ar' => $request->input('contract_terms_ar'),
            'contract_terms_en' => $request->input('contract_terms_en'),

        ]);

        return redirect()->back()->with('success', 'تم التعديل بنجاح');
    }
}
