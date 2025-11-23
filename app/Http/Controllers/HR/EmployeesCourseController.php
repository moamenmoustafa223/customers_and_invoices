<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\HR\EmployeesCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeesCourseController extends Controller
{


    public function index(Request $request)
    {
        $search = $request->input('query');
        $employeesCourses = EmployeesCourse::query()
            ->where('name', 'like', "%{$search}%")
            ->orWhereHas('Employee', function ($query) use($search){
                $query->where('name_en', 'like', '%'.$search.'%')
                    ->orWhere('name_ar', 'like', '%'.$search.'%')
                    ->orWhere('phone', 'like', '%'.$search.'%');
            })
            ->orderBy('id', 'desc')->paginate(10);

        return view('backend.HR.EmployeesCourses.index', compact('employeesCourses'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $data['user_id'] = Auth::id();
        $data['employee_id'] = $request->employee_id;
        $data['name'] = $request->name;
        $data['start'] = $request->start;
        $data['end'] = $request->end;
        $data['notes'] = $request->notes;
        EmployeesCourse::create($data);

        toast('تم الإضافة بنجاح','success');
        return redirect()->back();
    }




    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $employeesCourse = EmployeesCourse::find($id);

        $data['user_id'] = Auth::id();
        $data['employee_id'] = $request->employee_id;
        $data['name'] = $request->name;
        $data['start'] = $request->start;
        $data['end'] = $request->end;
        $data['notes'] = $request->notes;

        $employeesCourse->update($data);

        toast('تم الإضافة بنجاح','success');
        return redirect()->back();
    }



    public function destroy($id)
    {
        $employeesCourse = EmployeesCourse::find($id);
        $employeesCourse->delete();
        toast('تم الحذف بنجاح','success');
        return redirect()->back();
    }
}
