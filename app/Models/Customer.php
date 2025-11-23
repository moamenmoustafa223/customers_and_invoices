<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address_ar',
        'address_en',
        'customer_category_id',
        'notes_ar',
        'notes_en',
        'status',
    ];

    /**
     * Get the category of this customer
     */
    public function category()
    {
        return $this->belongsTo(CustomerCategory::class, 'customer_category_id');
    }

    /**
     * Get all invoices for this customer
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get all quotations for this customer
     */
    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }
}
