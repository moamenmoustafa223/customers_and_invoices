<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_id',
        'service_id',
        'service_name',
        'quantity',
        'unit_price',
        'total_price',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:3',
        'total_price' => 'decimal:3',
    ];

    /**
     * Get the quotation this item belongs to
     */
    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    /**
     * Get the service for this item
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
