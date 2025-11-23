<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\HR\OvertimeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class OvertimeController extends Controller
{
    public function index()
    {
        $employee = Auth::guard('employee')->user();
        $requests = OvertimeRequest::where('employee_id', $employee->id)
            ->orderBy('date', 'desc')
            ->paginate(15);
        return view('Employee.overtime.index', compact('requests'));
    }

    public function create()
    {
        return view('Employee.overtime.create');
    }

    public function store(Request $request)
    {
        $employee = Auth::guard('employee')->user();
        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'reason' => 'nullable|string',
        ]);
        $hours = max(0, Carbon::createFromFormat('H:i', $request->start_time)->floatDiffInHours(Carbon::createFromFormat('H:i', $request->end_time)));
        OvertimeRequest::create([
            'user_id' => $employee->user_id,
            'employee_id' => $employee->id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'hours' => $hours,
            'reason' => $request->reason,
            'status' => 0,
        ]);
        toast(__('back.added_successfully'), 'success');
        return redirect()->route('employee.overtime.index');
    }
}


