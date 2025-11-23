<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\HR\ShiftSchedule;
use Illuminate\Support\Facades\Auth;

class ShiftScheduleController extends Controller
{
    public function index()
    {
        $schedules = ShiftSchedule::with('shift')
            ->where('employee_id', Auth::guard('employee')->id())
            ->where(function ($query) {
                $query->whereNull('effective_to')
                    ->orWhere('effective_to', '>=', now()->toDateString());
            })
            ->orderBy('effective_from', 'desc')
            ->paginate(15);

        return view('Employee.shifts.index', compact('schedules'));
    }
}
