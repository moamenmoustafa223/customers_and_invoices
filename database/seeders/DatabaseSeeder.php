<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{

    public function run()
    {


        //        \App\Models\Customer::factory(5)->create();


        $this->call([
            SettingSeeder::class,
            PermissionTableSeeder::class,
            CreateAdminUserSeeder::class,
            PaymentMethodSeeder::class,
            CategoryEmployeesSeeder::class,
            EmployeeSeeder::class,
            CategoryHolidaySeeder::class,
            CategoryAllowanceSeeder::class,
            CategoryDiscountsSeeder::class,
            AssetsCategorySeeder::class,
            AssetsSubCategorySeeder::class,
            AssetSeeder::class,
            ExpenseCategorySeeder::class,
            ExpenseSubCategorySeeder::class,
            ExpenseSeeder::class,
            IncomeCategorySeeder::class,
            IncomeSubCategorySeeder::class,
            IncomeSeeder::class,
            CustomerCategorySeeder::class,
            CustomerSeeder::class,
            InvoiceStatusSeeder::class,
            ServiceSeeder::class,

        ]);
    }
}
