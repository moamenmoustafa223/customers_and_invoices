<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function User()
    {
        return $this->belongsTo(User::class);
    }


    public function ExpenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class, );
    }


    public function ExpenseSubCategory()
    {
        return $this->belongsTo(ExpenseSubCategory::class, );
    }


    public function Payment_method()
    {
        return $this->belongsTo(Payment_method::class);
    }


}
