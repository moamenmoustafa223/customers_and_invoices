<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\HR\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $employee = Auth::guard('employee')->user();
        $attendances = Attendance::where('employee_id', $employee->id)
            ->orderBy('date', 'desc')
            ->paginate(20);
        return view('Employee.attendance.index', compact('attendances'));
    }

    public function checkIn(Request $request)
    {
        $employee = Auth::guard('employee')->user();
        $today = Carbon::now()->toDateString();
        Attendance::updateOrCreate(
            [
                'user_id' => $employee->user_id,
                'employee_id' => $employee->id,
                'date' => $today,
            ],
            [
                'check_in' => Carbon::now(),
                'status' => 0,
            ]
        );
        toast(__('back.added_successfully'), 'success');
        return redirect()->route('employee.attendance.index');
    }

    public function checkOut(Request $request)
    {
        $employee = Auth::guard('employee')->user();
        $today = Carbon::now()->toDateString();
        $attendance = Attendance::where('employee_id', $employee->id)
            ->where('date', $today)
            ->first();
        if ($attendance) {
            $attendance->check_out = Carbon::now();
            if ($attendance->check_in) {
                $attendance->total_hours = max(0, Carbon::parse($attendance->check_in)->floatDiffInHours($attendance->check_out));
            }
            $attendance->save();
        }
        toast(__('back.updated_successfully'), 'success');
        return redirect()->route('employee.attendance.index');
    }
}


