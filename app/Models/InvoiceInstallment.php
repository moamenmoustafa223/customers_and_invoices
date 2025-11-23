<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class InvoiceInstallment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'due_date',
        'amount',
        'paid_amount',
        'status',
    ];

    protected $casts = [
        'due_date' => 'date',
        'amount' => 'decimal:3',
        'paid_amount' => 'decimal:3',
    ];

    /**
     * Get the invoice this installment belongs to
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Get all payments for this installment
     */
    public function payments()
    {
        return $this->hasMany(InvoicePayment::class, 'invoice_installment_id');
    }
}
