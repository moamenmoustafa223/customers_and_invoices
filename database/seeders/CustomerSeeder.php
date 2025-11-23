<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'name' => 'أحمد محمد العلي',
                
                'phone' => '+966501234567',
                'email' => 'ahmed.ali@example.com',
                'address_ar' => 'الرياض، حي النخيل، شارع الملك فهد',
                'address_en' => 'Riyadh, Al Nakheel District, King Fahd Street',
                'customer_category_id' => 1,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'شركة المستقبل للتجارة',
              
                'phone' => '+966502345678',
                'email' => 'info@future-trading.com',
                'address_ar' => 'جدة، حي الزهراء، طريق الملك عبدالعزيز',
                'address_en' => 'Jeddah, Al Zahra District, King Abdulaziz Road',
                'customer_category_id' => 2,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'فاطمة عبدالله السالم',
                
                'phone' => '+966503456789',
                'email' => 'fatima.salem@example.com',
                'address_ar' => 'الدمام، حي الفيصلية، شارع الأمير محمد',
                'address_en' => 'Dammam, Al Faisaliyah District, Prince Mohammed Street',
                'customer_category_id' => 3,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'وزارة التعليم',
                
                'phone' => '+966504567890',
                'email' => 'contact@moe.gov.sa',
                'address_ar' => 'الرياض، حي السفارات، طريق الملك سلمان',
                'address_en' => 'Riyadh, Al Safarat District, King Salman Road',
                'customer_category_id' => 4,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'متجر النور للإلكترونيات',
                
                'phone' => '+966505678901',
                'email' => 'sales@alnoor-electronics.com',
                'address_ar' => 'مكة المكرمة، حي العزيزية، شارع إبراهيم الخليل',
                'address_en' => 'Makkah, Al Aziziyah District, Ibrahim Al Khalil Street',
                'customer_category_id' => 5,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'خالد سعيد المطيري',
               
                'phone' => '+966506789012',
                'email' => 'khaled.mutairi@example.com',
                'address_ar' => 'المدينة المنورة، حي العوالي، طريق الهجرة',
                'address_en' => 'Madinah, Al Awali District, Al Hijrah Road',
                'customer_category_id' => 1,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'مؤسسة البناء الحديث',
                
                'phone' => '+966507890123',
                'email' => 'info@modern-construction.sa',
                'address_ar' => 'الخبر، حي الثقبة، شارع الملك خالد',
                'address_en' => 'Khobar, Al Thuqbah District, King Khaled Street',
                'customer_category_id' => 2,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'نورة حسن القحطاني',
                
                'phone' => '+966508901234',
                'email' => 'noura.qahtani@example.com',
                'address_ar' => 'أبها، حي المنهل، طريق الملك فيصل',
                'address_en' => 'Abha, Al Manhal District, King Faisal Road',
                'customer_category_id' => 3,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'الهيئة العامة للزكاة والدخل',
                
                'phone' => '+966509012345',
                'email' => 'support@gazt.gov.sa',
                'address_ar' => 'الرياض، حي الملز، شارع العليا العام',
                'address_en' => 'Riyadh, Al Malaz District, Al Olaya General Street',
                'customer_category_id' => 4,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'سوبر ماركت الرحمة',
                
                'phone' => '+966500123456',
                'email' => 'info@alrahma-market.com',
                'address_ar' => 'الطائف، حي الشهداء، شارع الملك فهد',
                'address_en' => 'Taif, Al Shuhada District, King Fahd Street',
                'customer_category_id' => 5,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('customers')->insert($customers);
    }
}
