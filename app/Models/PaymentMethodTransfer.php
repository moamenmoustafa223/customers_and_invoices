<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethodTransfer extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function fromPaymentMethod()
    {
        return $this->belongsTo(Payment_method::class, 'from_payment_method_id');
    }

    public function toPaymentMethod()
    {
        return $this->belongsTo(Payment_method::class, 'to_payment_method_id');
    }
}
