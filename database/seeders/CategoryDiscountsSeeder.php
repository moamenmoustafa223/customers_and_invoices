<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryDiscountsSeeder extends Seeder
{


    public function run()
    {
        DB::table('category_discounts')->insert([
            "user_id" => '1',
            'name' => 'خصم غياب',
            'name_en' => 'absence discount',
        ]);

        DB::table('category_discounts')->insert([
            "user_id" => '1',
            'name' => 'خصم تأخير',
            'name_en' => 'delay discount',
        ]);

    }
}
