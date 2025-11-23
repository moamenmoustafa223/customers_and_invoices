<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $employees = [
            [
                "employee_no" => '001',
                'category_employees_id' => 1,
                'name_ar' => 'محمد احمد خالد',
                'name_en' => 'Mohamed Ahmed Khaled',
                'id_number' => '65987469',
                'jop_ar' => 'مدير الشركة',
                'jop_en' => 'Company Director',
                'phone' => '95445431',
                'email' => 'mohamed@company.com',
                'Nationality' => 'عماني',
                'address' => 'مسقط - القرم',
            ],
            [
                "employee_no" => '002',
                'category_employees_id' => 2,
                'name_ar' => 'خالد سعيد العامري',
                'name_en' => 'Khalid Said Al Amri',
                'id_number' => '78854123',
                'jop_ar' => 'محاسب أول',
                'jop_en' => 'Senior Accountant',
                'phone' => '95445432',
                'email' => 'khalid@company.com',
                'Nationality' => 'عماني',
                'address' => 'السيب - المعبيلة',
            ],
            [
                "employee_no" => '003',
                'category_employees_id' => 3,
                'name_ar' => 'سارة ناصر الزدجالي',
                'name_en' => 'Sara Nasser Al Zadjali',
                'id_number' => '77452136',
                'jop_ar' => 'مهندسة نظم',
                'jop_en' => 'System Engineer',
                'phone' => '95445433',
                'email' => 'sara@company.com',
                'Nationality' => 'عمانية',
                'address' => 'العامرات - الحاجر',
            ],
            [
                "employee_no" => '004',
                'category_employees_id' => 1,
                'name_ar' => 'عبدالله حمد الرواحي',
                'name_en' => 'Abdullah Hamad Al Rawahi',
                'id_number' => '66554432',
                'jop_ar' => 'سكرتير إداري',
                'jop_en' => 'Administrative Secretary',
                'phone' => '95445434',
                'email' => 'abdullah@company.com',
                'Nationality' => 'عماني',
                'address' => 'بوشر - الخوض',
            ],
        ];

        foreach ($employees as $employee) {
            DB::table('employees')->insert([
                "user_id" => 1,
                "employee_no" => $employee['employee_no'],
                "category_employees_id" => $employee['category_employees_id'],
                "image" => 'avatar.png',

                "name_ar" => $employee['name_ar'],
                "name_en" => $employee['name_en'],
                "id_number" => $employee['id_number'],

                "jop_ar" => $employee['jop_ar'],
                "jop_en" => $employee['jop_en'],

                "phone" => $employee['phone'],
                "email" => $employee['email'],
                "password" => Hash::make('123123'),

                "Nationality" => $employee['Nationality'],
                "address" => $employee['address'],
                "created_at" => now(),
                "updated_at" => now(),
            ]);
        }
    }
}
