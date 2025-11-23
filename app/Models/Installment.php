<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function studentsContract()
    {
        return $this->belongsTo(StudentsContract::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    

    public function getIsPaidAttribute()
    {
        return $this->payment !== null;
    }
}
