<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\HR\Contract;
use App\Models\StudentsContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ContractController extends Controller
{


    public function index(Request $request)
    {
        $search = $request->input('query');
        $contracts = Contract::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('date', 'LIKE', "%{$search}%")
            ->orWhereHas('Employee', function ($query) use($search){
                $query->where('name_ar', 'like', '%'.$search.'%')
                    ->orWhere('name_en', 'like', '%'.$search.'%')
                    ->orWhere('phone', 'like', '%'.$search.'%');
            })
            ->orderBy('id', 'desc')->paginate(10);
        return view('backend.HR.Contracts.index', compact('contracts'));
    }



    public function create()
    {
        return view('backend.HR.Contracts.add');
    }



    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'name' => 'required',
            'job_name_ar' => 'required',
            'job_name_en' => 'required',
            'basic_salary' => 'required',
        ]);

        $day = date('Ymd');

        Contract::create([
            'user_id' => Auth::id(),
            'employee_id' => $request->employee_id,

            'contract_number' => 'CON' . $day. Str::random(64),
            'name' => $request->name,

            'job_name_ar' => $request->job_name_ar,
            'job_name_en' => $request->job_name_en,

            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'date' => $request->date,

            'basic_salary' => $request->basic_salary,

            'cost_of_living_allowance' => $request->cost_of_living_allowance,
            'food_allowance' => $request->food_allowance,
            'housing_allowance' => $request->housing_allowance,
            'transfer_allowance' => $request->transfer_allowance,
            'overtime' => $request->overtime,
            'phone_allowance' => $request->phone_allowance,
            'medical' => $request->medical,
            'other_allowance' => $request->other_allowance,

            'Social_insurance_discount' => $request->Social_insurance_discount,

            'total_salary' => $request->total_salary,

            'contract_duration' => $request->contract_duration,
            'contract_terms_ar' => $request->contract_terms_ar,
            'contract_terms_en' => $request->contract_terms_en,
            'notes' => $request->notes,
        ]);
        toast('تم الإضافة بنجاح','success');
        return redirect()->route('Contracts.index');
    }



    public function show($id)
    {
        $contract = Contract::find($id);
        return view('backend.HR.Contracts.show', compact('contract'));
    }




    // طباعة عقد الموظف
    public function contract_number($order_number)
    {
        $contract = Contract::where('contract_number', $order_number)->firstOrFail();
        return view('backend.HR.Contracts.show2', compact('contract'));
    }



    public function edit($id)
    {
        $contract = Contract::find($id);
        return view('backend.HR.Contracts.edit', compact('contract'));
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_id' => 'required',
            'name' => 'required',
            'job_name_ar' => 'required',
            'job_name_en' => 'required',
            'basic_salary' => 'required',
        ]);

        $contract = Contract::find($id);
        $contract->update([
            'user_id' => Auth::id(),
            'employee_id' => $request->employee_id,

            'name' => $request->name,

            'job_name_ar' => $request->job_name_ar,
            'job_name_en' => $request->job_name_en,

            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'date' => $request->date,

            'basic_salary' => $request->basic_salary,

            'cost_of_living_allowance' => $request->cost_of_living_allowance,
            'food_allowance' => $request->food_allowance,
            'housing_allowance' => $request->housing_allowance,
            'transfer_allowance' => $request->transfer_allowance,
            'overtime' => $request->overtime,
            'phone_allowance' => $request->phone_allowance,
            'medical' => $request->medical,
            'other_allowance' => $request->other_allowance,

            'Social_insurance_discount' => $request->Social_insurance_discount,

            'total_salary' => $request->total_salary,

            'contract_duration' => $request->contract_duration,
            'contract_terms_ar' => $request->contract_terms_ar,
            'contract_terms_en' => $request->contract_terms_en,
            'notes' => $request->notes,
        ]);

        return redirect()->route('Contracts.index')->with('success','تم التحديث بنجاح');
    }



    public function destroy($id)
    {
        $contract = Contract::find($id);
        $contract->delete();
        toast('تم الحذف بنجاح','success');
        return redirect()->back();

    }
}
