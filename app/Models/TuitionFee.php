<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TuitionFee extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function StudentsContracts()
    {
        return $this->belongsToMany(StudentsContract::class, 'fee_contract');
    }


}
