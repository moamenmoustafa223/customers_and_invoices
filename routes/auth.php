<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Employee\Auth\LoginEmployeeController;
use App\Http\Controllers\Guardian\Auth\LoginGuardianController;
use App\Http\Controllers\Student\Auth\LoginStudentController;
use App\Http\Controllers\Teacher\Auth\LoginTeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->middleware('guest')->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');

// employee =======================================================
Route::post('/employee_login', [LoginEmployeeController::class, 'store'])->middleware('guest:employee')->name('employee_login_store');
Route::post('/employee_logout', [LoginEmployeeController::class, 'destroy'])->name('employee_logout')->middleware('auth:employee');