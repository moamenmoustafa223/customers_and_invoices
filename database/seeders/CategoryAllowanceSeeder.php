<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryAllowanceSeeder extends Seeder
{


    public function run()
    {
        DB::table('category_allowances')->insert([
            "user_id" => '1',
            'name' => 'بدل سفر',
            'name_en' => 'Travel allowance',
        ]);

        DB::table('category_allowances')->insert([
            "user_id" => '1',
            'name' => 'بدل بترول',
            'name_en' => 'Petrol allowance',
        ]);

        DB::table('category_allowances')->insert([
            "user_id" => '1',
            'name' => 'حوافز نهاية العام',
            'name_en' => 'End of the year incentives',
        ]);


    }
}
