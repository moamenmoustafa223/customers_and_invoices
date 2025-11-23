<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HR\Payslip;

class EmployeePayslipController extends Controller
{
    public function index(Request $request)
    {
        $employee = $request->user();
        $payslips = Payslip::where('employee_id', $employee->id)->orderBy('year', 'desc')->orderBy('month', 'desc')->paginate(12);
        return view('employee.payslips.index', compact('payslips'));
    }

    public function show(Request $request, Payslip $payslip)
    {
        $employee = $request->user();
        if ($payslip->employee_id != $employee->id) abort(403);
        return view('employee.payslips.show', compact('payslip'));
    }
}
