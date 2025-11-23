<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class Teacher extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class);
    }
    public function students()
{
    return $this->hasManyThrough(
        \App\Models\Student::class,
        \App\Models\StudentsContract::class,
        'section_id',          // Foreign key on students_contracts
        'id',                  // Local key on students
        'id',                  // Local key on teacher (this)
        'student_id'           // Foreign key on students_contracts
    )->whereIn('section_id', $this->sections()->pluck('sections.id'));
}
public function getAssignedStudents()
{
    $sectionIds = $this->sections()->pluck('sections.id');

    return \App\Models\Student::whereHas('contracts', function ($query) use ($sectionIds) {
        $query->whereIn('section_id', $sectionIds);
    })->get();
}
}
