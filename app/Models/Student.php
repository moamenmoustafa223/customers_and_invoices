<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Student extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class,);
    }

    public function storeInvoices()
    {
        return $this->hasMany(StoreInvoice::class);
    }
    public function Guardian()
    {
        return $this->belongsTo(Guardian::class,);
    }


    public function AcademicYear()
    {
        return $this->belongsTo(AcademicYear::class,);
    }

    public function Classroom()
    {
        return $this->belongsTo(Classroom::class,);
    }


    public function StudentsContracts()
    {
        return $this->hasMany(StudentsContract::class,);
    }


    public function payments()
    {
        return $this->hasMany(Payment::class,);
    }


    public function Attachments()
    {
        return $this->hasMany(Attachment::class,);
    }
}
