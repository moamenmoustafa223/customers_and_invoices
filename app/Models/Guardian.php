<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Guardian extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, );
    }


    public function Students()
    {
        return $this->hasMany(Student::class, );
    }

    public function studentsContracts()
    {
        return $this->hasMany(StudentsContract::class, );
    }

}
