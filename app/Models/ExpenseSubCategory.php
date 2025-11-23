<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseSubCategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function User()
    {
        return $this->belongsTo(User::class, );
    }

    public function ExpenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class, );
    }

    public function Expenses()
    {
        return $this->hasMany(Expense::class);
    }


}
