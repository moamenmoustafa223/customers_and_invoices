<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function User()
    {
        return $this->belongsTo(User::class, );
    }

    public function StudentsContracts()
    {
        return $this->hasMany(StudentsContract::class, );
    }

    public function AcademicYear()
    {
        return $this->belongsTo(AcademicYear::class, );
    }


}
