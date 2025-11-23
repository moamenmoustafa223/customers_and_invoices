<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
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


    public function StudentsContract()
    {
        return $this->belongsTo(StudentsContract::class, );
    }


    public function Section()
    {
        return $this->belongsTo(Section::class, );
    }


    public function DateAttendance()
    {
        return $this->belongsTo(DateAttendance::class, );
    }

}
