<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function teachers()
{
    return $this->belongsToMany(Teacher::class);
}

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

    public function Students()
    {
        return $this->hasMany(Student::class, );
    }


    public function StudentsContracts()
    {
        return $this->hasMany(StudentsContract::class, 'section_id');
    }
    


    public function payments()
    {
        return $this->hasMany(Payment::class, );
    }


    public function Attendances()
    {
        return $this->hasMany(Attendance::class, );
    }


    public function DateAttendances()
    {
        return $this->hasMany(DateAttendance::class, );
    }

}
