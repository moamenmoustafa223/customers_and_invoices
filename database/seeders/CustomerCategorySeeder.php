<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name_ar' => 'عملاء VIP',
                'name_en' => 'VIP Customers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'شركات',
                'name_en' => 'Corporate',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'أفراد',
                'name_en' => 'Individual',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'حكومي',
                'name_en' => 'Government',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'تجزئة',
                'name_en' => 'Retail',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('customer_categories')->insert($categories);
    }
}
