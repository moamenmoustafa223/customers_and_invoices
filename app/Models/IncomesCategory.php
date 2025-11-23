<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomesCategory extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function IncomesSubCategories()
    {
        return $this->hasMany(IncomesSubCategory::class);
    }

    public function Incomes()
    {
    return $this->hasMany(Income::class);
    }


}
