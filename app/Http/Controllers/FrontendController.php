<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        return view('index');
    }



    public function login_admin()
    {
        return view('auth.login_admin');
    }


    public function login_employee()
    {
        return view('auth.login_employee');
    }


    public function login_guardian()
    {
        return view('auth.login_guardian');
    }
    public function login_teacher()
    {
        return view('auth.login_teacher');
    }


    public function login_student()
    {
        return view('auth.login_student');
    }

}
