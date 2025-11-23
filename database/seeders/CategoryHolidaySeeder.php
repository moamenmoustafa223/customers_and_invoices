<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryHolidaySeeder extends Seeder
{


    public function run()
    {
        DB::table('category_holidays')->insert([
            "user_id" => '1',
            'name' => 'إجازة سنوية',
            'name_en' => 'annual vacation',
        ]);

        DB::table('category_holidays')->insert([
            "user_id" => '1',
            'name' => 'إجازة مرضية',
            'name_en' => 'Sick leave',
        ]);

    }
}
