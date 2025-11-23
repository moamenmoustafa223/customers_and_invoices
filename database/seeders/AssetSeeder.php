<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AssetSeeder extends Seeder
{
    public function run(): void
    {
        $userId = 1;
        $paymentMethodId = 1; // use actual ID from your system

        $categories = DB::table('assets_categories')->get();
        $subCategories = DB::table('assets_sub_categories')->get();

        $assets = [
            [
                'code_no' => 'ASSET-1001',
                'supplier' => 'TechStore LLC',
                'supplier_invoice_number' => 'INV-00123',
                'amount' => 1200.000,
                'tax' => 5,
                'expense_date' => '2025-07-01',
                'description' => 'Dell Latitude Laptop',
                'depreciation_rate' => '10%',
            ],
            [
                'code_no' => 'ASSET-1002',
                'supplier' => 'OfficePlus',
                'supplier_invoice_number' => 'INV-00456',
                'amount' => 850.000,
                'tax' => 5,
                'expense_date' => '2025-07-02',
                'description' => 'Office Desk with drawers',
                'depreciation_rate' => '15%',
            ],
        ];

        foreach ($assets as $asset) {
            // pick a matching category/subcategory
            $sub = $subCategories->random();
            $categoryId = $sub->assets_category_id;

            $taxAmount = ($asset['amount'] * $asset['tax']) / 100;
            $amountWithTax = $asset['amount'] + $taxAmount;

            DB::table('assets')->insert([
                'user_id' => $userId,
                'assets_category_id' => $categoryId,
                'assets_sub_category_id' => $sub->id,
                'payment_method_id' => $paymentMethodId,

                'check_number' => Str::random(6),
                'code_no' => $asset['code_no'],
                'supplier' => $asset['supplier'],
                'supplier_invoice_number' => $asset['supplier_invoice_number'],

                'amount' => $asset['amount'],
                'tax' => $asset['tax'],
                'tax_amount' => $taxAmount,
                'amount_with_tax' => $amountWithTax,

                'expense_date' => $asset['expense_date'],
                'description' => $asset['description'],
                'depreciation_rate' => $asset['depreciation_rate'],
                'file' => null,
                'notes' => 'Sample asset entry',

                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
