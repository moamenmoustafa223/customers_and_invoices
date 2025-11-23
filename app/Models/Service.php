<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'price',
        'description_ar',
        'description_en',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:3',
    ];

    /**
     * Get all invoice items using this service
     */
    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    /**
     * Get all quotation items using this service
     */
    public function quotationItems()
    {
        return $this->hasMany(QuotationItem::class);
    }
}
