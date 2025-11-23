<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
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


    public function Sections()
    {
        return $this->hasMany(Section::class, );
    }


    public function Students()
    {
        return $this->hasMany(Student::class, );
    }


    public function StudentsContracts()
    {
        return $this->hasMany(StudentsContract::class, );
    }


    public function payments()
    {
        return $this->hasMany(Payment::class, );
    }

    public function DateAttendances()
    {
        return $this->hasMany(DateAttendance::class, );
    }

}
