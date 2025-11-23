<?php

namespace Database\Seeders;

use App\Models\Payment_method;
use App\Models\PaymentMethodBalance;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{


    public function run()
    {
        $methods = [
            [
                'user_id' => 1,
                'name_ar' => 'حساب الصندوق (نقداً)',
                'name_en' => 'Cash Fund Account',
                'initial_amount' => 0.000,
            ],
            [
                'user_id' => 1,
                'name_ar' => 'الحساب البنكي (فيزا)',
                'name_en' => 'Bank Account (Visa)',
                'initial_amount' => 0.000,
            ],
        ];
    
        foreach ($methods as $methodData) {
            $paymentMethod = Payment_method::create([
                'user_id' => $methodData['user_id'],
                'name_ar' => $methodData['name_ar'],
                'name_en' => $methodData['name_en'],
            ]);
    
            PaymentMethodBalance::create([
                'payment_method_id' => $paymentMethod->id,
                'initial_amount' => $methodData['initial_amount'],
                'current_balance' => $methodData['initial_amount'],
            ]);
        }
    }
    
}
