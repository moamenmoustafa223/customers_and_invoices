<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function Classrooms()
    {
        return $this->hasMany(Classroom::class, );
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


    public function Payment()
    {
        return $this->hasMany(Payment::class, );
    }

    public function Buses()
    {
        return $this->hasMany(Bus::class, );
    }


    public function DateAttendances()
    {
        return $this->hasMany(DateAttendance::class, );
    }
}
