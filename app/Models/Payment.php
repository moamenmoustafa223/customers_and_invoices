<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, );
    }


    public function AcademicYear()
    {
        return $this->belongsTo(AcademicYear::class, );
    }

    public function Classroom()
    {
        return $this->belongsTo(Classroom::class, );
    }


    public function Student()
    {
        return $this->belongsTo(Student::class, );
    }



    public function installment()
    {
        return $this->belongsTo(Installment::class);
    }
    
    public function studentsContract()
    {
        return $this->belongsTo(StudentsContract::class);
    }


    public function Payment_method()
    {
        return $this->belongsTo(Payment_method::class, );
    }
}
