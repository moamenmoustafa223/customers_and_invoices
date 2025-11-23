<?php

namespace App\Models\HR;

use App\Models\HR\Employee;
use App\Models\HR\Holiday;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryHoliday extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function User()
    {
        return $this->belongsTo(User::class, );
    }



    public function Employees()
    {
        return $this->hasMany(Employee::class);
    }


    public function Holidays()
    {
        return $this->hasMany(Holiday::class);
    }


}
