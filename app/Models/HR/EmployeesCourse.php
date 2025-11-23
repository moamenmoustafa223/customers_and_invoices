<?php

namespace App\Models\HR;

use App\Models\User;
use App\Models\HR\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeesCourse extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function User()
    {
        return $this->belongsTo(User::class, );
    }



    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }


}
