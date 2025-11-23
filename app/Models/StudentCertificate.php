<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCertificate extends Model
{
    //
    use HasFactory;

    protected $guarded = [];
    
    protected $casts = [
        'subjects' => 'array',
    ];

    public function contract()
    {
        return $this->belongsTo(StudentsContract::class, 'students_contract_id');
    }
}
