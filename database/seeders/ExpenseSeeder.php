<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ExpenseSeeder extends Seeder
{
    public function run(): void
    {
        $userId = 1;
        $paymentMethodId = 1;

        $categories = DB::table('expense_categories')->get();
        $subCategories = DB::table('expense_sub_categories')->get();

        $expenses = [
            [
                'supplier' => 'Oman Electricity Co.',
                'supplier_invoice_number' => 'E-001',
                'amount' => 300.000,
                'tax' => 5,
                'expense_date' => '2025-07-01',
                'description' => 'June Electricity Bill',
            ],
            [
                'supplier' => 'FixIt Maintenance',
                'supplier_invoice_number' => 'M-001',
                'amount' => 1200.000,
                'tax' => 5,
                'expense_date' => '2025-07-02',
                'description' => 'Air conditioner repair',
            ],
        ];

        foreach ($expenses as $expense) {
            // Pick random matching category and sub
            $sub = $subCategories->random();
            $categoryId = $sub->expense_category_id;

            $taxAmount = ($expense['amount'] * $expense['tax']) / 100;
            $amountWithTax = $expense['amount'] + $taxAmount;

            DB::table('expenses')->insert([
                'user_id' => $userId,
                'expense_category_id' => $categoryId,
                'expense_sub_category_id' => $sub->id,
                'payment_method_id' => $paymentMethodId,

                'check_number' => Str::random(6),
                'supplier' => $expense['supplier'],
                'supplier_invoice_number' => $expense['supplier_invoice_number'],

                'amount' => $expense['amount'],
                'tax' => $expense['tax'],
                'tax_amount' => $taxAmount,
                'amount_with_tax' => $amountWithTax,

                'expense_date' => $expense['expense_date'],
                'description' => $expense['description'],
                'notes' => 'Test seeded expense',
                'file' => null,

                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
