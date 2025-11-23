<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetsSubCategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function AssetsCategory()
    {
        return $this->belongsTo(AssetsCategory::class);
    }


    public function Assets()
    {
        return $this->hasMany(Asset::class);
    }


}
