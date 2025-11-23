<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethodBalance extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function Payment_method()
    {
        return $this->belongsTo(Payment_method::class);
    }
}
