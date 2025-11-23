<?php

namespace App\Models\HR;

use App\Models\HR\CategoryAllowance;
use App\Models\HR\Employee;
use App\Models\Payment_method;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allowance extends Model
{
    use HasFactory;

    protected $guarded = [];



    public function User()
    {
        return $this->belongsTo(User::class, );
    }

    public function Employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function CategoryAllowance()
    {
        return $this->belongsTo(CategoryAllowance::class);
    }
    public function Payment_method()
    {
        return $this->belongsTo(Payment_method::class, );
    }


}
