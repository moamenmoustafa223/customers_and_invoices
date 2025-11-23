<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryEmployeesSeeder extends Seeder
{


    public function run()
    {
        DB::table('category_employees')->insert([
            "user_id" => '1',
            'name' => 'القسم الإداري',
            'name_en' => 'Administrative section',
        ]);

        DB::table('category_employees')->insert([
            "user_id" => '1',
            'name' => 'القسم المالي',
            'name_en' => 'Financial Department',
        ]);

        DB::table('category_employees')->insert([
            "user_id" => '1',
            'name' => 'القسم الفني',
            'name_en' => 'Technical Section',
        ]);
    }
}
