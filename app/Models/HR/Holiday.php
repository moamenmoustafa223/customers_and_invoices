<?php

namespace App\Models\HR;

use App\Models\HR\CategoryHoliday;
use App\Models\HR\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function User()
    {
        return $this->belongsTo(User::class, );
    }



    public function Employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function CategoryHoliday()
    {
        return $this->belongsTo(CategoryHoliday::class);
    }


}
