<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class InvoicePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'invoice_installment_id',
        'user_id',
        'payment_method_id',
        'payment_date',
        'payment_number',
        'slug',
        'amount',
        'payment_method',
        'notes_ar',
        'notes_en',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:3',
    ];

    /**
     * Get the invoice this payment belongs to
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Get the installment this payment belongs to
     */
    public function installment()
    {
        return $this->belongsTo(InvoiceInstallment::class, 'invoice_installment_id');
    }

    /**
     * Get the user who recorded this payment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the payment method used
     */
    public function paymentMethod()
    {
        return $this->belongsTo(Payment_method::class, 'payment_method_id');
    }
}
