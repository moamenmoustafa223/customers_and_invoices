<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'name_ar' => 'مسودة',
                'name_en' => 'Draft',
                'color' => '#6c757d',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'قيد الانتظار',
                'name_en' => 'Pending',
                'color' => '#ffc107',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'موافق عليها',
                'name_en' => 'Approved',
                'color' => '#28a745',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'مدفوعة',
                'name_en' => 'Paid',
                'color' => '#17a2b8',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'مدفوعة جزئياً',
                'name_en' => 'Partial',
                'color' => '#fd7e14',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'متأخرة',
                'name_en' => 'Overdue',
                'color' => '#dc3545',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'ملغية',
                'name_en' => 'Cancelled',
                'color' => '#343a40',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('invoice_statuses')->insert($statuses);
    }
}
