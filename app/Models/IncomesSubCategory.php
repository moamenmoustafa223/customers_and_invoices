<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomesSubCategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function IncomesCategory()
    {
        return $this->belongsTo(IncomesCategory::class);
    }

    public function Incomes()
    {
        return $this->hasMany(Income::class);
    }


}
