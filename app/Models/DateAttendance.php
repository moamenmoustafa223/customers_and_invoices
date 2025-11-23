<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DateAttendance extends Model
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

    public function Section()
    {
        return $this->belongsTo(Section::class, );
    }

    public function Attendances()
    {
        return $this->hasMany(Attendance::class, );
    }

    public function StudentsContracts()
    {
        return $this->hasMany(StudentsContract::class, );
    }


}
