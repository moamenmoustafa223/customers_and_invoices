<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeEmployeeController extends Controller
{
    public function index()
    {
        $employee = Auth::guard('employee')->user();
        return view('Employee.home', compact('employee'));
    }
}
