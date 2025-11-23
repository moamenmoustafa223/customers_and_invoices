<?php

namespace App\Models;

use App\Models\HR\Allowance;
use App\Models\HR\Discount;
use App\Models\HR\Salary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_method extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function User()
    {
        return $this->belongsTo(User::class);
    }


    public function Payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function storeInvoices()
    {
        return $this->hasMany(StoreInvoice::class);
    }

    public function Assets()
    {
        return $this->hasMany(Asset::class);
    }


    public function Incomes()
    {
        return $this->hasMany(Income::class);
    }



    public function Expense()
    {
        return $this->hasMany(Expense::class);
    }
    public function Salary()
    {
        return $this->hasMany(Salary::class);
    }
    public function Discount()
    {
        return $this->hasMany(Discount::class);
    }
    public function Allowance()
    {
        return $this->hasMany(Allowance::class);
    }
    public function balance()
    {
        return $this->hasOne(PaymentMethodBalance::class);
    }

    public function transactions()
    {
        return $this->hasMany(PaymentMethodTransaction::class);
    }

    public function transfersFrom()
    {
        return $this->hasMany(PaymentMethodTransfer::class, 'from_payment_method_id');
    }

    public function transfersTo()
    {
        return $this->hasMany(PaymentMethodTransfer::class, 'to_payment_method_id');
    }
}
