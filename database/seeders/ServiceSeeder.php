<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name_ar' => 'استشارات إدارية',
                'name_en' => 'Management Consulting',
                'description_ar' => 'خدمات استشارية متخصصة في إدارة الأعمال والتطوير المؤسسي',
                'description_en' => 'Specialized consulting services in business management and institutional development',
                'price' => 50.000,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'تصميم المواقع الإلكترونية',
                'name_en' => 'Website Design',
                'description_ar' => 'تصميم وتطوير مواقع إلكترونية احترافية متجاوبة مع جميع الأجهزة',
                'description_en' => 'Design and development of professional responsive websites for all devices',
                'price' => 100.000,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'تسويق رقمي',
                'name_en' => 'Digital Marketing',
                'description_ar' => 'حملات تسويقية رقمية شاملة على منصات التواصل الاجتماعي ومحركات البحث',
                'description_en' => 'Comprehensive digital marketing campaigns on social media and search engines',
                'price' => 250.000,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'تطوير تطبيقات الجوال',
                'name_en' => 'Mobile App Development',
                'description_ar' => 'تطوير تطبيقات جوال احترافية لأنظمة iOS و Android',
                'description_en' => 'Professional mobile application development for iOS and Android systems',
                'price' => 500.000,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'إدارة أنظمة المعلومات',
                'name_en' => 'Information Systems Management',
                'description_ar' => 'إدارة وصيانة أنظمة المعلومات والبنية التحتية التقنية',
                'description_en' => 'Management and maintenance of information systems and technical infrastructure',
                'price' => 750.000,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'تدريب وتطوير',
                'name_en' => 'Training and Development',
                'description_ar' => 'برامج تدريبية متخصصة لتطوير مهارات الموظفين والكوادر',
                'description_en' => 'Specialized training programs for employee and staff skill development',
                'price' => 1000.000,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'الأمن السيبراني',
                'name_en' => 'Cybersecurity',
                'description_ar' => 'حلول أمنية متكاملة لحماية البيانات والأنظمة من التهديدات الإلكترونية',
                'description_en' => 'Comprehensive security solutions to protect data and systems from cyber threats',
                'price' => 1500.000,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'الحوسبة السحابية',
                'name_en' => 'Cloud Computing',
                'description_ar' => 'خدمات الحوسبة السحابية والاستضافة وإدارة الخوادم',
                'description_en' => 'Cloud computing services, hosting, and server management',
                'price' => 2000.000,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'تحليل البيانات',
                'name_en' => 'Data Analysis',
                'description_ar' => 'تحليل البيانات واستخراج الرؤى والتقارير التحليلية المتقدمة',
                'description_en' => 'Data analysis and extraction of insights with advanced analytical reports',
                'price' => 2500.000,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'الذكاء الاصطناعي',
                'name_en' => 'Artificial Intelligence',
                'description_ar' => 'حلول الذكاء الاصطناعي والتعلم الآلي لتحسين العمليات التجارية',
                'description_en' => 'AI and machine learning solutions to improve business processes',
                'price' => 3000.000,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'إدارة المشاريع',
                'name_en' => 'Project Management',
                'description_ar' => 'إدارة المشاريع الاحترافية وفق أفضل المعايير والممارسات العالمية',
                'description_en' => 'Professional project management according to best international standards and practices',
                'price' => 3500.000,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'تخطيط موارد المؤسسات',
                'name_en' => 'Enterprise Resource Planning',
                'description_ar' => 'تطبيق وتخصيص أنظمة تخطيط موارد المؤسسات ERP',
                'description_en' => 'Implementation and customization of ERP systems',
                'price' => 4000.000,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'إدارة علاقات العملاء',
                'name_en' => 'Customer Relationship Management',
                'description_ar' => 'تطبيق وإدارة أنظمة CRM لتحسين خدمة العملاء',
                'description_en' => 'Implementation and management of CRM systems to improve customer service',
                'price' => 4500.000,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'التحول الرقمي',
                'name_en' => 'Digital Transformation',
                'description_ar' => 'استراتيجيات وحلول التحول الرقمي الشاملة للمؤسسات',
                'description_en' => 'Comprehensive digital transformation strategies and solutions for organizations',
                'price' => 5000.000,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'الدعم الفني',
                'name_en' => 'Technical Support',
                'description_ar' => 'خدمات الدعم الفني المتواصل والصيانة الدورية للأنظمة',
                'description_en' => 'Continuous technical support and regular system maintenance services',
                'price' => 100.000,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('services')->insert($services);
    }
}
