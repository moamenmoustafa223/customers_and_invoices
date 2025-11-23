<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpenseSubCategorySeeder extends Seeder
{
    public function run(): void
    {
        $userId = 1;

        $subCategories = [
            ['category' => 'Electricity', 'name_ar' => 'فاتورة شهرية', 'name_en' => 'Monthly Bill'],
            ['category' => 'Maintenance', 'name_ar' => 'أجهزة', 'name_en' => 'Equipment'],
            ['category' => 'Maintenance', 'name_ar' => 'مباني', 'name_en' => 'Buildings'],
            ['category' => 'Salaries', 'name_ar' => 'مدرسين', 'name_en' => 'Teachers'],
            ['category' => 'Salaries', 'name_ar' => 'إداريين', 'name_en' => 'Administrators'],
        ];

        $categories = DB::table('expense_categories')->get();

        foreach ($subCategories as $sub) {
            $category = $categories->firstWhere('name_en', $sub['category']);

            if ($category) {
                DB::table('expense_sub_categories')->insert([
                    'user_id' => $userId,
                    'expense_category_id' => $category->id,
                    'name_ar' => $sub['name_ar'],
                    'name_en' => $sub['name_en'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
