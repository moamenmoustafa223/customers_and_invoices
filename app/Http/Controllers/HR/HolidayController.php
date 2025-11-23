<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\HR\Holiday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HolidayController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('query');
        $holidays = Holiday::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhereHas('Employee', function ($query) use($search){
                $query->where('name_ar', 'like', '%'.$search.'%')
                    ->orWhere('name_en', 'like', '%'.$search.'%')
                    ->orWhere('phone', 'like', '%'.$search.'%');
            })
            ->orderBy('id', 'desc')->paginate(10);

        return view('backend.HR.Holidays.index', compact('holidays'));
    }


    public function create()
    {
        return view('backend.HR.Holidays.add');
    }



    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'category_holiday_id' => 'required',
            'name' => 'required',
            'number' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        Holiday::create([
            'user_id' => Auth::id(),
            'employee_id' => $request->employee_id,
            'category_holiday_id' => $request->category_holiday_id,
            'name' => $request->name,
            'number' => $request->number,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'date_request' => $request->date_request,
            'date_work' => $request->date_work,
            'substitute_employee' => $request->substitute_employee,
            'notes' => $request->notes,
        ]);
        toast('تم الإضافة بنجاح','success');
        return redirect()->route('Holidays.index');

    }



    public function show(Holiday $holiday)
    {
        //
    }




    public function edit($id)
    {
        $holiday = Holiday::find($id);
        return view('backend.HR.Holidays.edit', compact('holiday'));
    }




    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_id' => 'required',
            'category_holiday_id' => 'required',
            'name' => 'required',
            'number' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $holiday = Holiday::find($id);

        $holiday->update([
            'user_id' => Auth::id(),
            'employee_id' => $request->employee_id,
            'category_holiday_id' => $request->category_holiday_id,
            'name' => $request->name,
            'number' => $request->number,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'date_request' => $request->date_request,
            'date_work' => $request->date_work,
            'substitute_employee' => $request->substitute_employee,
            'notes' => $request->notes,
        ]);

        return redirect()->route('Holidays.index')->with('success','تم التحديث بنجاح');
    }




    public function destroy($id)
    {
        $holiday = Holiday::find($id);
        $holiday->delete();
        toast('تم الحذف بنجاح','success');
        return redirect()->back();
    }


}
