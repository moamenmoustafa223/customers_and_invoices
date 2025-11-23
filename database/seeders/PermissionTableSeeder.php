<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{

    public function run()
    {
        $permissions = [

            // المرفقات
            'attachments',
            'show_attachment',
            'delete_attachment',
             // عقود الطلاب
            'studentsContracts',
            'add_studentsContract',
            'show_studentsContract',
            'edit_studentsContract',
            'delete_studentsContract',
            'search_studentsContract',


            // المدفوعات
            'payments',
            'add_payment',
            'show_payment',
            'edit_payment',
            'delete_payment',
            'search_payment',

            // طرق الدفع
            'payment_methods',
            'payment_methods_add',
            'payment_methods_edit',
            'payment_methods_delete',

            // IncomesCategories
            'IncomesCategories',
            'IncomesCategory_add',
            'IncomesCategory_edit',
            'IncomesCategory_delete',


            // IncomesSubCategories
            'IncomesSubCategories',
            'IncomesSubCategory_add',
            'IncomesSubCategory_edit',
            'IncomesSubCategory_delete',

            // Incomes
            'Incomes',
            'Income_add',
            'Income_show',
            'Income_edit',
            'Income_delete',
            'Income_search',

            'installments',
            'add_installment',
            'show_installment',
            'edit_installment',
            'delete_installment',

            'transactions',
            'add_transaction',
            'show_transaction',
            'edit_transaction',
            'delete_transaction',

            'transfers',
            'add_transfer',
            'show_transfer',
            'edit_transfer',
            'delete_transfer',

            'ExpenseCategories',
            'ExpenseCategory_add',
            'ExpenseCategory_show',
            'ExpenseCategory_edit',
            'ExpenseCategory_delete',


            'ExpenseSubCategories',
            'ExpenseSubCategory_add',
            'ExpenseSubCategory_show',
            'ExpenseSubCategory_edit',
            'ExpenseSubCategory_delete',

            'Expenses',
            'Expense_add',
            'Expense_show',
            'Expense_edit',
            'Expense_delete',
            'Expense_search',

            // أقسام الأصول
            'AssetsCategories',
            'add_new_AssetsCategory',
            'edit_AssetsCategory',
            'delete_AssetsCategory',

            // أقسام الأصول الفرعية
            'AssetsSubCategories',
            'add_new_AssetsSubCategory',
            'edit_AssetsSubCategory',
            'delete_AssetsSubCategory',

            // الأصول
            'assets',
            'add_new_asset',
            'edit_asset',
            'delete_asset',

            // التقارير
            'Reports',
            'reports_Payments',
            'reports_Expenses',
            'reports_Incomes',
            'reports_Assets',
            'reports_all',

            'Employees_Area',

            'Trainees',
            'Trainees_add',
            'Trainees_edit',
            'Trainees_delete',
            'Trainees_show',
            'Trainees_search',

            'CategoryEmployees',
            'CategoryEmployees_add',
            'CategoryEmployees_edit',
            'CategoryEmployees_delete',
            'CategoryEmployees_show',

            'Employees',
            'Employees_add',
            'Employees_edit',
            'Employees_delete',
            'Employees_show',
            'Employees_search',

            'Employees_Images',
            'Employees_Images_add',
            'Employees_Images_edit',
            'Employees_Images_delete',
            'Employees_Images_show',

            'Contracts',
            'Contracts_add',
            'Contracts_edit',
            'Contracts_delete',
            'Contracts_show',
            'Contracts_print',
            'Contracts_search',

            'balances',
            'balances_add',
            'balances_edit',
            'balances_delete',
            'balances_show',

            'CategoryHolidays',
            'CategoryHolidays_add',
            'CategoryHolidays_edit',
            'CategoryHolidays_delete',
            'CategoryHolidays_show',

            'Holidays',
            'Holidays_add',
            'Holidays_edit',
            'Holidays_delete',
            'Holidays_show',
            'Holidays_search',

            'CategoryAllowances',
            'CategoryAllowances_add',
            'CategoryAllowances_edit',
            'CategoryAllowances_delete',
            'CategoryAllowances_show',

            'Allowances',
            'Allowances_add',
            'Allowances_edit',
            'Allowances_delete',
            'Allowances_show',
            'Allowances_search',

            'Salaries',
            'Salaries_add',
            'Salaries_edit',
            'Salaries_delete',
            'Salaries_show',
            'Salaries_print',
            'Salaries_search',

            'CategoryDiscounts',
            'CategoryDiscounts_add',
            'CategoryDiscounts_edit',
            'CategoryDiscounts_delete',
            'CategoryDiscounts_show',

            'Discounts',
            'Discounts_add',
            'Discounts_edit',
            'Discounts_delete',
            'Discounts_show',
            'Discounts_print',
            'Discounts_search',

            'EmployeesCourses',
            'EmployeesCourses_add',
            'EmployeesCourses_edit',
            'EmployeesCourses_delete',
            'EmployeesCourses_show',
            'EmployeesCourses_search',

            'all_messages',
            'all_messages_edit_status',
            'all_messages_delete',
            'all_messages_show',
            'all_messages_reply',

            'users',
            'users_add',
            'users_edit',
            'users_delete',
            'users_show',

            'roles',
            'roles_add',
            'roles_edit',
            'roles_delete',
            'roles_show',

            'Setting',
            'notification',
            'search_dashboard',

            // ===========================================================================================
            // إدارة العملاء والفواتير - Customer & Invoice Management
            // ===========================================================================================

            // أقسام العملاء - Customer Categories
            'customer_categories',
            'add_customer_category',
            'edit_customer_category',
            'delete_customer_category',
            'show_customer_category',

            // العملاء - Customers
            'customers',
            'add_customer',
            'edit_customer',
            'delete_customer',
            'show_customer',
            'search_customer',

            // حالات الفواتير - Invoice Statuses
            'invoice_statuses',
            'add_invoice_status',
            'edit_invoice_status',
            'delete_invoice_status',
            'show_invoice_status',

            // الخدمات - Services
            'services',
            'add_service',
            'edit_service',
            'delete_service',
            'show_service',
            'search_service',

            // الفواتير - Invoices
            'invoices',
            'add_invoice',
            'edit_invoice',
            'delete_invoice',
            'show_invoice',
            'search_invoice',
            'print_invoice',

            // إيرادات الفواتير - Invoice Payments
            'invoice_payments',
            'add_invoice_payment',
            'edit_invoice_payment',
            'delete_invoice_payment',
            'show_invoice_payment',
            'search_invoice_payment',
            'print_invoice_payment',

            // عروض الأسعار - Quotations
            'quotations',
            'add_quotation',
            'edit_quotation',
            'delete_quotation',
            'show_quotation',
            'search_quotation',
            'convert_quotation_to_invoice',

            // أقساط الفواتير - Invoice Installments
            'invoice_installments',
            'add_invoice_installment',
            'edit_invoice_installment',
            'delete_invoice_installment',
            'show_invoice_installment',
            'mark_installment_paid',

            // التقارير - Reports
            'reports_invoices',
            'reports_invoice_payments',
            'reports_quotations',
            'reports_installments',

            // الإعدادات - Settings
            'settings',

        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
