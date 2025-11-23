<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentsContract extends Model
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

    public function Student()
    {
        return $this->belongsTo(Student::class, );
    }


    public function Classroom()
    {
        return $this->belongsTo(Classroom::class, );
    }

    public function Section()
    {
        return $this->belongsTo(Section::class, );
    }
    public function installments()
    {
        return $this->hasMany(Installment::class);
    }

    public function certificate()
    {
        return $this->hasOne(StudentCertificate::class, 'students_contract_id');
    }
    
    public function TuitionFees()
    {
        return $this->belongsToMany(TuitionFee::class, 'fee_contract', 'students_contract_id', 'tuition_fee_id')
            ->withPivot(['name', 'price', 'quantity', 'tax_rate', 'total']);
    }
    


    public function payments()
    {
        return $this->hasMany(Payment::class, );
    }


    public function Attendances()
    {
        return $this->hasMany(Attendance::class, );
    }

    public function DateAttendance()
    {
        return $this->belongsTo(DateAttendance::class, );
    }

    public function Bus()
    {
        return $this->belongsTo(Bus::class);
    }


}
