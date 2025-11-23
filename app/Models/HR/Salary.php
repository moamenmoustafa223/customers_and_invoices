<?php

namespace App\Models\HR;
use App\Models\HR\Employee;
use App\Models\Payment_method;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function Employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function Payment_method()
    {
        return $this->belongsTo(Payment_method::class, );
    }

}
