<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CustomerCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'status',
    ];

    /**
     * Get all customers in this category
     */
    public function customers()
    {
        return $this->hasMany(Customer::class, 'customer_category_id');
    }
}
