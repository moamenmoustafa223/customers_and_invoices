<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function User()
    {
        return $this->belongsTo(User::class);
    }


    public function IncomesCategory()
    {
        return $this->belongsTo(IncomesCategory::class, );
    }


    public function IncomesSubCategory()
    {
        return $this->belongsTo(IncomesSubCategory::class, );
    }


    public function Payment_method()
    {
        return $this->belongsTo(Payment_method::class);
    }


}
