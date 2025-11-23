<?php

namespace App\Models\HR;

use App\Models\HR\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function Employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
