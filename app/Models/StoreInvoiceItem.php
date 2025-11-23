<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreInvoiceItem extends Model
{
    //
    use HasFactory;
    protected $guarded = [];
    public function invoice()
{
    return $this->belongsTo(StoreInvoice::class, 'store_invoice_id');
}

public function product()
{
    return $this->belongsTo(StoreProduct::class, 'store_product_id');
}
}
