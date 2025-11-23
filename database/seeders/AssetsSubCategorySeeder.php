<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetsSubCategorySeeder extends Seeder
{
    public function run(): void
    {
        $userId = 1;

        $subCategories = [
            ['category' => 'Electronics', 'name_ar' => 'حاسوب محمول', 'name_en' => 'Laptop'],
            ['category' => 'Electronics', 'name_ar' => 'طابعة', 'name_en' => 'Printer'],
            ['category' => 'Furniture', 'name_ar' => 'مكتب', 'name_en' => 'Desk'],
            ['category' => 'Furniture', 'name_ar' => 'كرسي', 'name_en' => 'Chair'],
            ['category' => 'Office Equipment', 'name_ar' => 'ماكينة تصوير', 'name_en' => 'Copier'],
        ];

        $categories = DB::table('assets_categories')->get();

        foreach ($subCategories as $sub) {
            $category = $categories->firstWhere('name_en', $sub['category']);

            if ($category) {
                DB::table('assets_sub_categories')->insert([
                    'user_id' => $userId,
                    'assets_category_id' => $category->id,
                    'name_ar' => $sub['name_ar'],
                    'name_en' => $sub['name_en'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
