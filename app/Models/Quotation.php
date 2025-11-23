<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_number',
        'customer_id',
        'user_id',
        'quotation_date',
        'valid_until',
        'slug',
        'subtotal',
        'discount',
        'tax',
        'total',
        'notes_ar',
        'notes_en',
        'status',
        'converted_invoice_id',
    ];

    protected $casts = [
        'quotation_date' => 'date',
        'valid_until' => 'date',
        'subtotal' => 'decimal:3',
        'discount' => 'decimal:3',
        'tax' => 'decimal:3',
        'total' => 'decimal:3',
    ];

    /**
     * Get the customer for this quotation
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the user who created this quotation
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all items for this quotation
     */
    public function items()
    {
        return $this->hasMany(QuotationItem::class);
    }

    /**
     * Get the invoice this quotation was converted to (if any)
     */
    public function convertedInvoice()
    {
        return $this->belongsTo(Invoice::class, 'converted_invoice_id');
    }
}
