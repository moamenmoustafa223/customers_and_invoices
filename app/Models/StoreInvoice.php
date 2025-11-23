<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreInvoice extends Model
{
    //
    use HasFactory;
    protected $guarded = [];
    public function items()
{
    return $this->hasMany(StoreInvoiceItem::class, 'store_invoice_id');
}

public function student()
{
    return $this->belongsTo(Student::class);
}

public function paymentMethod()
{
    return $this->belongsTo(Payment_method::class);
}
}
