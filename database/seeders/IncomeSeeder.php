<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IncomeSeeder extends Seeder
{
    public function run(): void
    {
        $userId = 1;
        $paymentMethodId = 1;

        $categories = DB::table('incomes_categories')->get();
        $subCategories = DB::table('incomes_sub_categories')->get();

        $incomes = [
            [
                'supplier' => 'Parent Ahmed',
                'supplier_invoice_number' => 'INV-1001',
                'amount' => 1500.000,
                'tax' => 0,
                'expense_date' => '2025-07-01',
                'description' => 'Tuition for Semester 1',
            ],
            [
                'supplier' => 'Donor Zaid',
                'supplier_invoice_number' => 'INV-1002',
                'amount' => 1000.000,
                'tax' => 0,
                'expense_date' => '2025-07-03',
                'description' => 'Donation for school supplies',
            ],
        ];

        foreach ($incomes as $income) {
            $sub = $subCategories->random();
            $categoryId = $sub->incomes_category_id;

            $taxAmount = ($income['amount'] * $income['tax']) / 100;
            $amountWithTax = $income['amount'] + $taxAmount;

            DB::table('incomes')->insert([
                'user_id' => $userId,
                'incomes_category_id' => $categoryId,
                'incomes_sub_category_id' => $sub->id,
                'payment_method_id' => $paymentMethodId,

                'check_number' => Str::random(6),
                'supplier' => $income['supplier'],
                'supplier_invoice_number' => $income['supplier_invoice_number'],

                'amount' => $income['amount'],
                'tax' => $income['tax'],
                'tax_amount' => $taxAmount,
                'amount_with_tax' => $amountWithTax,

                'expense_date' => $income['expense_date'],
                'description' => $income['description'],
                'notes' => 'Seeded income entry',
                'file' => null,

                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
