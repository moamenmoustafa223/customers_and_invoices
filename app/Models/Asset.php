<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, );
    }

    public function AssetsCategory()
    {
        return $this->belongsTo(AssetsCategory::class, );
    }

    public function AssetsSubCategory()
    {
        return $this->belongsTo(AssetsSubCategory::class, );
    }


    public function Payment_method()
    {
        return $this->belongsTo(Payment_method::class, );
    }

}
