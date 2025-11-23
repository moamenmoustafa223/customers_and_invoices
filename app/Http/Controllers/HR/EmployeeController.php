<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\HR\Employee;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{


    public function index(Request $request)
    {
        $search = $request->input('query');
        $employees = Employee::query()
            ->where('name_ar', 'LIKE', "%{$search}%")
            ->orWhere('name_en', 'LIKE', "%{$search}%")
            ->orWhere('phone', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->orderBy('id', 'desc')->paginate(10);

        return view('backend.HR.Employees.index', compact('employees'));
    }


    public function create()
    {
        return view('backend.HR.Employees.add');
    }



    public function store(Request $request)
    {
        $request->validate([
            'category_employees_id' => 'required',
            'name_ar' => 'required',
            'name_en' => 'required',
            'employee_no' => ['required', 'unique:employees,employee_no'],
            'id_number' => 'required',
            'jop_ar' => 'required',
            'jop_en' => 'required',
            'phone' => ['required', 'unique:employees,phone'],
            'password' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,gif,png|max:20000',
        ]);

        if ($image = $request->file('image')){
            $filename = time().$image->getClientOriginalName();
            $image->move('images/employees/', $filename);
            $data['image'] = 'images/employees/'.$filename;
        }

        $data['user_id'] = Auth::id();
        $data['category_employees_id'] = $request->category_employees_id;

        $data['name_ar'] = $request->name_ar;
        $data['name_en'] = $request->name_en;

        $data['employee_no'] = $request->employee_no;
        $data['Join_date'] = $request->Join_date;

        $data['phone'] = normalizePhoneNumber($request->phone, Setting::first()->phone_code ?? '968');

        $data['email'] = $request->email;
        $data['password'] = hash::make($request->password);

        $data['birth_date'] = $request->birth_date;
        $data['gender'] = $request->gender;
        $data['Nationality'] = $request->Nationality;
        $data['religion'] = $request->religion;
        $data['social_status'] = $request->social_status;

        $data['id_number'] = $request->id_number;
        $data['start_date_id'] = $request->start_date_id;
        $data['end_date_id'] = $request->end_date_id;

        $data['passport_number'] = $request->passport_number;
        $data['start_date_passport'] = $request->start_date_passport;
        $data['end_date_passport'] = $request->end_date_passport;
        $data['Place'] = $request->Place;

        $data['academic'] = $request->academic;
        $data['type_academic'] = $request->type_academic;
        $data['date_academic'] = $request->date_academic;
        $data['place_academic'] = $request->place_academic;

        $data['jop_ar'] = $request->jop_ar;
        $data['jop_en'] = $request->jop_en;

        $data['address'] = $request->address;
        $data['notes'] = $request->notes;

        $data['status'] = $request->status;

        Employee::create($data);

        toast('تم الإضافة بنجاح','success');
        return redirect()->route('Employees.index');
    }



    public function show($id)
    {
        $employee = Employee::find($id);
        return view('backend.HR.Employees.show', compact('employee'));
    }



    public function edit($id)
    {
        $employee = Employee::find($id);
        return view('backend.HR.Employees.edit', compact('employee'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'category_employees_id' => 'required',
            'name_ar' => 'required',
            'name_en' => 'required',
            'employee_no' => ['required', 'unique:employees,employee_no,' .$id],
            'id_number' => 'required',
            'jop_ar' => 'required',
            'jop_en' => 'required',
            'phone' => ['required', 'unique:employees,phone,' .$id],
            'image' => 'nullable|image|mimes:jpg,jpeg,gif,png|max:20000',
        ]);

        $employee = Employee::find($id);

        if ($image = $request->file('image')){
            $filename = time().$image->getClientOriginalName();
            $image->move('images/employees/', $filename);
            $data['image'] = 'images/employees/'.$filename;
        }

        $data['user_id'] = Auth::id();
        $data['category_employees_id'] = $request->category_employees_id;

        $data['name_ar'] = $request->name_ar;
        $data['name_en'] = $request->name_en;

        $data['employee_no'] = $request->employee_no;
        $data['Join_date'] = $request->Join_date;

        $data['phone'] = $request->phone;
        $data['email'] = $request->email;
        $data['password'] = hash::make($request->password);

        $data['birth_date'] = $request->birth_date;
        $data['gender'] = $request->gender;
        $data['Nationality'] = $request->Nationality;
        $data['religion'] = $request->religion;
        $data['social_status'] = $request->social_status;

        $data['id_number'] = $request->id_number;
        $data['start_date_id'] = $request->start_date_id;
        $data['end_date_id'] = $request->end_date_id;

        $data['passport_number'] = $request->passport_number;
        $data['start_date_passport'] = $request->start_date_passport;
        $data['end_date_passport'] = $request->end_date_passport;
        $data['Place'] = $request->Place;

        $data['academic'] = $request->academic;
        $data['type_academic'] = $request->type_academic;
        $data['date_academic'] = $request->date_academic;
        $data['place_academic'] = $request->place_academic;

        $data['jop_ar'] = $request->jop_ar;
        $data['jop_en'] = $request->jop_en;

        $data['address'] = $request->address;
        $data['notes'] = $request->notes;

        $data['status'] = $request->status;

        $employee->update($data);

        toast('تم التعديل بنجاح','success');
        return redirect()->route('Employees.index');
    }










    public function destroy($id)
    {
        $employee = Employee::find($id);
        if ($employee->Contracts->count() == 0
            || $employee->Holidays->count() == 0
            || $employee->Balances->count() == 0
            || $employee->Salaries->count() == 0
            || $employee->Allowances->count() == 0
            || $employee->Discounts->count() == 0)
        {
            $employee->delete();
            toast('تم الحذف بنجاح','success');
            return redirect()->back();
        }
        else
        {
            toast('لا يمكن الحذف يوجد تحته متعلقات أخرى','errer');
            return redirect()->back();
        }

    }


}
