<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IncomeSubCategorySeeder extends Seeder
{
    public function run(): void
    {
        $userId = 1;

        $subCategories = [
            ['category' => 'Tuition Fees', 'name_ar' => 'رسوم الفصل الأول', 'name_en' => 'Semester 1 Fees'],
            ['category' => 'Tuition Fees', 'name_ar' => 'رسوم الفصل الثاني', 'name_en' => 'Semester 2 Fees'],
            ['category' => 'Donations', 'name_ar' => 'تبرع عام', 'name_en' => 'General Donation'],
            ['category' => 'Sales', 'name_ar' => 'بيع كتب', 'name_en' => 'Book Sales'],
            ['category' => 'Sales', 'name_ar' => 'بيع زي مدرسي', 'name_en' => 'Uniform Sales'],
        ];

        $categories = DB::table('incomes_categories')->get();

        foreach ($subCategories as $sub) {
            $category = $categories->firstWhere('name_en', $sub['category']);

            if ($category) {
                DB::table('incomes_sub_categories')->insert([
                    'user_id' => $userId,
                    'incomes_category_id' => $category->id,
                    'name_ar' => $sub['name_ar'],
                    'name_en' => $sub['name_en'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
