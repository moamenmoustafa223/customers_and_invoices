<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;

class EmployeeAnnouncementsController extends Controller
{
    public function index(Request $request)
    {
        $employee = $request->user();
        $announcements = Announcement::where(function ($q) use ($employee) {
            $q->whereNull('employee_id')->orWhere('employee_id', $employee->id);
        })->latest()->paginate(15);
        return view('employee.announcements.index', compact('announcements'));
    }
}
