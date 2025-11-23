<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpenseCategorySeeder extends Seeder
{
    public function run(): void
    {
        $userId = 1;

        $categories = [
            ['name_ar' => 'كهرباء', 'name_en' => 'Electricity'],
            ['name_ar' => 'صيانة', 'name_en' => 'Maintenance'],
            ['name_ar' => 'رواتب', 'name_en' => 'Salaries'],
        ];

        foreach ($categories as $category) {
            DB::table('expense_categories')->insert([
                'user_id' => $userId,
                'name_ar' => $category['name_ar'],
                'name_en' => $category['name_en'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
