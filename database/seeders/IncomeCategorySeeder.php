<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IncomeCategorySeeder extends Seeder
{
    public function run(): void
    {
        $userId = 1;

        $categories = [
            ['name_ar' => 'الرسوم الدراسية', 'name_en' => 'Tuition Fees'],
            ['name_ar' => 'تبرعات', 'name_en' => 'Donations'],
            ['name_ar' => 'مبيعات', 'name_en' => 'Sales'],
        ];

        foreach ($categories as $category) {
            DB::table('incomes_categories')->insert([
                'user_id' => $userId,
                'name_ar' => $category['name_ar'],
                'name_en' => $category['name_en'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
