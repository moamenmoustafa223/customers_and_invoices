<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetsCategorySeeder extends Seeder
{
    public function run(): void
    {
        $userId = 1;

        $categories = [
            ['name_ar' => 'أجهزة إلكترونية', 'name_en' => 'Electronics'],
            ['name_ar' => 'أثاث', 'name_en' => 'Furniture'],
            ['name_ar' => 'معدات مكتبية', 'name_en' => 'Office Equipment'],
        ];

        foreach ($categories as $category) {
            DB::table('assets_categories')->insert([
                'user_id' => $userId,
                'name_ar' => $category['name_ar'],
                'name_en' => $category['name_en'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
