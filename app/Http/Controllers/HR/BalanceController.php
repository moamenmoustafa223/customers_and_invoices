<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\HR\Balance;
use Illuminate\Http\Request;

class BalanceController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('query');
        $balances = Balance::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('number', 'LIKE', "%{$search}%")
            ->orWhereHas('Employee', function ($query) use($search){
                $query->where('name_ar', 'like', '%'.$search.'%')
                    ->orWhere('name_en', 'like', '%'.$search.'%')
                    ->orWhere('phone', 'like', '%'.$search.'%');
            })
            ->orderBy('id', 'desc')->paginate(25);
        return view('backend.HR.Balances.index', compact('balances'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'name' => 'required',
            'number' => 'required',
        ], [
            'name.required' => 'الاسم  مطلوب',
            'number.required' => 'عدد الأيام مطلوب',
        ]);

        Balance::create([
            'employee_id' => $request->employee_id,
            'name' => $request->name,
            'number' => $request->number,
            'notes' => $request->notes,
        ]);
        toast('تم الإضافة بنجاح','success');
        return redirect()->back();
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_id' => 'required',
            'name' => 'required',
            'number' => 'required',
        ], [
            'name.required' => 'الاسم  مطلوب',
            'number.required' => 'عدد الأيام مطلوب',
        ]);

        $balance = Balance::find($id);

        $balance->update([
            'employee_id' => $request->employee_id,
            'name' => $request->name,
            'number' => $request->number,
            'notes' => $request->notes,
        ]);
        toast('تم التعديل بنجاح','success');
        return redirect()->back();
    }



    public function destroy($id)
    {
        $balance = Balance::find($id);
        $balance->delete();
        toast('تم الحذف بنجاح','success');
        return redirect()->back();
    }
}
