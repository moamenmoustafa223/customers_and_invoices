<?php

namespace App\Models\HR;

use App\Models\HR\EmployeesCourse;
use App\Models\HR\EmployeesImage;
use App\Models\HR\Holiday;
use App\Models\HR\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $guarded = [];

//    protected $fillable = [
//        'category_employees_id',
//        'branch_id',
//        'image',
//        'name',
//        'name_en',
//        'email',
//        'password',
//        'id_number',
//        'jop',
//        'jop_en',
//        'phone',
//        'Nationality',
//        'address',
//        'notes',
//    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function User()
    {
        return $this->belongsTo(User::class, );
    }



    public function CategoryEmployees()
    {
        return $this->belongsTo(CategoryEmployees::class);
    }

    public function Contracts()
    {
        return $this->hasMany(Contract::class);
    }


    public function Holidays()
    {
        return $this->hasMany(Holiday::class);
    }

    public function Balances()
    {
        return $this->hasMany(Balance::class);
    }


    public function Salaries()
    {
        return $this->hasMany(Salary::class);
    }


    public function Allowances()
    {
        return $this->hasMany(Allowance::class);
    }


    public function Discounts()
    {
        return $this->hasMany(Discount::class);
    }


    public function messages()
    {
        return $this->hasMany(Message::class);
    }


    public function employees_images()
    {
        return $this->hasMany(EmployeesImage::class);
    }


    public function employees_courses()
    {
        return $this->hasMany(EmployeesCourse::class);
    }


    public function status()
    {
        return $this->status ? trans("back.inactive") : trans("back.active");
    }



}
