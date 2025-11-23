<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'customer_id',
        'invoice_status_id',
        'user_id',
        'invoice_date',
        'due_date',
        'slug',
        'subtotal',
        'discount',
        'tax',
        'total',
        'paid_amount',
        'remaining_amount',
        'notes_ar',
        'notes_en',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'subtotal' => 'decimal:3',
        'discount' => 'decimal:3',
        'tax' => 'decimal:3',
        'total' => 'decimal:3',
        'paid_amount' => 'decimal:3',
        'remaining_amount' => 'decimal:3',
    ];

    /**
     * Get the customer for this invoice
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the status of this invoice
     */
    public function status()
    {
        return $this->belongsTo(InvoiceStatus::class, 'invoice_status_id');
    }

    /**
     * Get the user who created this invoice
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all items for this invoice
     */
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    /**
     * Get all installments for this invoice
     */
    public function installments()
    {
        return $this->hasMany(InvoiceInstallment::class);
    }

    /**
     * Get all payments for this invoice
     */
    public function payments()
    {
        return $this->hasMany(InvoicePayment::class);
    }

    /**
     * Get the quotation that was converted to this invoice (if any)
     */
    public function convertedFromQuotation()
    {
        return $this->hasOne(Quotation::class, 'converted_invoice_id');
    }
}
