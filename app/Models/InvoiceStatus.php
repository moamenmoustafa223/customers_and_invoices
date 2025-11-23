<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'color',
        'description_ar',
        'description_en',
    ];

    /**
     * Get all invoices with this status
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'invoice_status_id');
    }
}
