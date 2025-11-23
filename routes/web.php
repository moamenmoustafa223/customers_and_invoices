<?php

use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetsCategoryController;
use App\Http\Controllers\AssetsSubCategoryController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\DateAttendanceController;
use App\Http\Controllers\Employee\EmployeeAnnouncementsController;
use App\Http\Controllers\Employee\EmployeeProfileController;
use App\Http\Controllers\Employee\HomeEmployeeController;
use App\Http\Controllers\Employee\MessageController;
use App\Http\Controllers\Employee\ShiftScheduleController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseSubCategoryController;
use App\Http\Controllers\FrontendController;

use App\Http\Controllers\GuardianController;
use App\Http\Controllers\HR\AllowanceController;
use App\Http\Controllers\HR\BalanceController;
use App\Http\Controllers\HR\CategoryAllowanceController;
use App\Http\Controllers\HR\CategoryDiscountsController;
use App\Http\Controllers\HR\CategoryEmployeesController;
use App\Http\Controllers\HR\CategoryHolidayController;
use App\Http\Controllers\HR\ContractController;
use App\Http\Controllers\HR\DiscountController;
use App\Http\Controllers\HR\EmployeeController;
use App\Http\Controllers\HR\EmployeesCourseController;
use App\Http\Controllers\HR\EmployeesImageController;
use App\Http\Controllers\HR\HolidayController;
use App\Http\Controllers\HR\SalaryController;
use App\Http\Controllers\HR\TraineeController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\IncomesCategoryController;
use App\Http\Controllers\IncomesSubCategoryController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PaymentMethodTransactionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StoreInvoiceController;
use App\Http\Controllers\StoreProductController;
use App\Http\Controllers\Student\HomeStudentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentsCertificateController;
use App\Http\Controllers\StudentsContractController;
use App\Http\Controllers\Teacher\HomeTeacherController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TuitionFeeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
*/



// Login ====================================================
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {

        Route::resource('/', FrontendController::class);
        Route::get('login_admin', [FrontendController::class, 'login_admin'])->name('login_admin');
        Route::get('login_employee', [FrontendController::class, 'login_employee'])->name('login_employee');
        Route::get('login_guardian', [FrontendController::class, 'login_guardian'])->name('login_guardian');
        Route::get('login_teacher', [FrontendController::class, 'login_teacher'])->name('login_teacher');
        Route::get('login_student', [FrontendController::class, 'login_student'])->name('login_student');

        Route::get('/contract/{contract_number}', [ContractController::class, 'contract_number'])->name('contract_number');
        // طباعة عقد الطالب
        Route::get('studentsContract/{id}', [StudentsContractController::class, 'print_studentsContract'])->name('print_studentsContract');
        Route::get('studentsContracts/public/{slug}', [StudentsContractController::class, 'showPublic'])->name('studentsContracts.public');
        Route::post('studentsContracts/public/{slug}/sign', [StudentsContractController::class, 'storeSignature'])->name('studentsContracts.sign');
        
        // طباعة سند قبض للدفع
        Route::get('payment/{payment_number}', [PaymentController::class, 'payment_number'])->name('payment_number');
        require __DIR__ . '/auth.php';
    }
);



// Backend ====================================================
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:web']
    ],
    function () {

        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
        Route::resource('Setting', SettingController::class);
        Route::resource('dashboard', BackendController::class);

        // عرض جميع الاشعارات
        Route::get('/show_notification_all', [BackendController::class, 'show_notification_all'])->name('show_notification_all');

        Route::get('/all_messages', [BackendController::class, 'all_messages'])->name('all_messages');
        Route::put('/edit_messages_status/{id}', [BackendController::class, 'edit_messages_status'])->name('edit_messages_status');

        Route::resource('PaymentMethod', PaymentMethodController::class);
        Route::post('payment-methods/transfer', [PaymentMethodController::class, 'transfer'])->name('PaymentMethod.transfer');
        Route::get('payment-methods/transfers', [PaymentMethodController::class, 'transfers'])->name('paymentMethods.transfers');
        Route::get('payment-methods/transfer-history/export', [PaymentMethodController::class, 'exportTransferHistory'])->name('paymentMethods.exportTransferHistory');

        Route::get('payment-method-transactions', [PaymentMethodTransactionController::class, 'index'])->name('payment_method_transactions.index');
        Route::get('payment_method_transactions/export_excel', [PaymentMethodTransactionController::class, 'exportExcel'])
            ->name('payment_method_transactions.export_excel');
        // الإيرادات
        Route::resource('IncomesCategories', IncomesCategoryController::class);
        Route::resource('IncomesSubCategories', IncomesSubCategoryController::class);
        Route::resource('Incomes', IncomeController::class);
        // جلب الأقسام الفرعية للايرادات
        Route::post('fetchIncomesSubCategories', [IncomeController::class, 'fetchIncomesSubCategories'])->name('fetchIncomesSubCategories');

        // تقارير الإيرادات حسب الأقسام الرئيسية
        Route::get('reports_incomes', [IncomeController::class, 'reports_incomes'])->name('reports_incomes');
        Route::post('reports_incomes', [IncomeController::class, 'reports_incomes'])->name('reports_incomes_post');
        Route::post('reports_incomes_excel', [IncomeController::class, 'reports_incomes_excel'])->name('reports_incomes_excel');




        // الأصول
        Route::resource('AssetsCategories', AssetsCategoryController::class);
        Route::resource('AssetsSubCategories', AssetsSubCategoryController::class);
        Route::resource('Assets', AssetController::class);
        Route::post('fetchAssetsSubCategories', [AssetController::class, 'fetchAssetsSubCategories'])->name('fetchAssetsSubCategories');

        // تقارير الأصول حسب الأقسام الرئيسية
        Route::match(['get', 'post'], 'reports_assets', [AssetController::class, 'reports_assets'])->name('reports_assets');
        Route::post('reports_assets_excel', [AssetController::class, 'reports_assets_excel'])->name('reports_assets_excel');




        // المصروفات =================================================================================
        Route::resource('ExpenseCategories', ExpenseCategoryController::class);
        Route::resource('ExpenseSubCategories', ExpenseSubCategoryController::class);
        Route::resource('Expenses', ExpenseController::class);
        // جلب اقسام المصروفات الفرعية التابعة لقسم
        Route::post('fetchExpenseSubCategories', [ExpenseController::class, 'fetchExpenseSubCategories'])->name('fetchExpenseSubCategories');

        // تقارير المصروفات حسب الأقسام الرئيسية
        Route::get('reports_expenses', [ExpenseController::class, 'reports_expenses'])->name('reports_expenses');
        Route::post('reports_expenses', [ExpenseController::class, 'reports_expenses'])->name('reports_expenses_post');
        Route::post('reports_expenses_excel', [ExpenseController::class, 'reports_expenses_excel'])->name('reports_expenses_excel');


        // مسح الاشعارات
        Route::get('/markAsRead_all', [BackendController::class, 'markAsRead_all'])->name('markAsRead_all');
        Route::get('/markAsRead/{id}', [BackendController::class, 'markAsRead'])->name('markAsRead');


        // تقارير الكل
        Route::get('/reports_all_between_two_dates/', [BackendController::class, 'reports_all_between_two_dates'])->name('reports_all_between_two_dates');
        Route::post('/reports_all_between_two_dates/', [BackendController::class, 'reports_all_between_two_dates'])->name('reports_all_between_two_dates_post');

        // عرض التقرير الاجمالية
        Route::get('/show_reports_all', [BackendController::class, 'show_reports_all'])->name('show_reports_all');

        Route::resource('installments', InstallmentController::class);
        Route::get('installment/overdue', [InstallmentController::class, 'overdueInstallments'])->name('installments.overdue');

        // عقود الطلاب
        Route::resource('studentsContracts', StudentsContractController::class);
        // جلب الصفوف الدراسية التابعة لسنة دراسية
        Route::post('fetchClassrooms', [StudentsContractController::class, 'fetchClassrooms'])->name('fetchClassrooms');
        // جلب الشعب التابعة لصف دراسي
        Route::post('fetchSections', [StudentsContractController::class, 'fetchSections'])->name('fetchSections');
        Route::get('studentsContracts/{}', [StudentsContractController::class, 'filter_studentsContracts'])->name('filter_studentsContracts');

        // فلترة العقود حسب الطلاب
        Route::get('filter_studentsContracts', [StudentsContractController::class, 'filter_studentsContracts'])->name('filter_studentsContracts');
        // تصدير عقود الطلاب لملف اكسيل
        Route::get('studentsContracts_export_excel', [StudentsContractController::class, 'studentsContracts_export_excel'])->name('studentsContracts_export_excel');
        // نسخ عقد طالب
        Route::get('copy_studentsContract/{id}', [StudentsContractController::class, 'copy_studentsContract'])->name('copy_studentsContract');
        Route::get('installments/{installment}/payments-modal', [App\Http\Controllers\PaymentController::class, 'getInstallmentPayments'])->name('installments.payments.modal');
        Route::delete('payments/{payment}', [App\Http\Controllers\PaymentController::class, 'destroy'])->name('payments.destroy');

        // تقارير عقود الطلاب
        Route::get('/reports_students_contracts', [StudentsContractController::class, 'reports_students_contracts'])->name('reports_students_contracts');
        Route::post('/reports_students_contracts', [StudentsContractController::class, 'reports_students_contracts'])->name('reports_students_contracts_post');
        Route::post('/export_reports_students_contracts_excel', [StudentsContractController::class, 'export_reports_students_contracts_excel'])->name('export_reports_students_contracts_excel');





        // عرض مدفوعات العقد
        Route::get('show_payments/{id}', [StudentsContractController::class, 'show_payments'])->name('show_payments');
        // مدفوعات الطلاب
        Route::resource('payments', PaymentController::class);
        // تقارير مدفوعات العقود
        Route::get('/reports_payments', [PaymentController::class, 'reports_payments'])->name('reports_payments');
        Route::post('/reports_payments', [PaymentController::class, 'reports_payments'])->name('reports_payments_post');
        Route::post('/export_reports_payments_excel', [PaymentController::class, 'export_reports_payments_excel'])->name('export_reports_payments_excel');


        // مرفقات الطلاب
        Route::resource('attachments', AttachmentController::class);

        // الحضور والغياب
        Route::resource('attendances', AttendanceController::class);
        // web.php
        Route::get('/get-classrooms-by-year/{year_id}', function ($year_id) {
            return \App\Models\Classroom::where('academic_year_id', $year_id)->get();
        });

        Route::get('/get-sections-by-classroom/{class_id}', function ($class_id) {
            return \App\Models\Section::where('classroom_id', $class_id)->get();
        });


        // عرض الحضور والانصراف لشهر
        Route::get('show_students_attendances/{id}', [AttendanceController::class, 'show_students_attendances'])->name('show_students_attendances');
        
        // الموارد البشرية =========================================================================================
        Route::resource('Trainees', TraineeController::class);

        Route::resource('CategoryEmployees', CategoryEmployeesController::class);
        Route::resource('Employees', EmployeeController::class);
        Route::resource('EmployeesCourses', EmployeesCourseController::class);
        Route::resource('EmployeesImages', EmployeesImageController::class);


        Route::resource('Contracts', ContractController::class);

        Route::resource('Salaries', SalaryController::class);
        Route::get('Salary/create-multiple', [SalaryController::class, 'createMultiple'])->name('Salaries.create_multiple');
        Route::post('Salary/store-multiple', [SalaryController::class, 'storeMultiple'])->name('Salaries.store_multiple');


        Route::resource('CategoryAllowances', CategoryAllowanceController::class);
        Route::resource('Allowances', AllowanceController::class);

        Route::resource('CategoryDiscounts', CategoryDiscountsController::class);
        Route::resource('Discounts', DiscountController::class);

        Route::resource('CategoryHolidays', CategoryHolidayController::class);
        Route::resource('Holidays', HolidayController::class);
        Route::resource('Balances', BalanceController::class);

        // مسح الاشعارات
        Route::get('/markAsRead_all', [BackendController::class, 'markAsRead_all'])->name('markAsRead_all');
        Route::get('/markAsRead/{id}', [BackendController::class, 'markAsRead'])->name('markAsRead');
        Route::put('/reply_message/{id}', [BackendController::class, 'reply_message'])->name('reply_message');
        // تقرير الموارد البشرية بين تاريخين
        Route::get('reports_hr_between_two_dates', [BackendController::class, 'reports_hr_between_two_dates'])->name('reports_hr_between_two_dates');
        Route::post('reports_hr_between_two_dates', [BackendController::class, 'reports_hr_between_two_dates'])->name('reports_hr_between_two_dates');

        // ===========================================================================================
        // إدارة العملاء والفواتير - Customer & Invoice Management
        // ===========================================================================================

        // أقسام العملاء - Customer Categories
        Route::resource('customer_categories', App\Http\Controllers\CustomerCategoryController::class);

        // العملاء - Customers
        Route::resource('customers', App\Http\Controllers\CustomerController::class);

        // حالات الفواتير - Invoice Statuses
        Route::resource('invoice_statuses', App\Http\Controllers\InvoiceStatusController::class);

        // الخدمات - Services
        Route::resource('services', App\Http\Controllers\ServiceController::class);

        // الفواتير - Invoices
        Route::resource('invoices', App\Http\Controllers\InvoiceController::class);
        Route::get('invoices/{id}/print', [App\Http\Controllers\InvoiceController::class, 'print'])->name('invoices.print');
        Route::get('invoices/{id}/installments-payments', [App\Http\Controllers\InvoiceController::class, 'show_invoice_installments_payments'])->name('invoices.show_installments_payments');

        // إيرادات الفواتير - Invoice Payments
        Route::resource('invoice_payments', App\Http\Controllers\InvoicePaymentController::class);
        Route::get('invoice_payments/{id}/print', [App\Http\Controllers\InvoicePaymentController::class, 'print'])->name('invoice_payments.print');
        Route::get('invoice_payment/{payment_number}', [App\Http\Controllers\InvoicePaymentController::class, 'payment_number'])->name('invoice_payment_number');

        // أقساط الفواتير - Invoice Installments
        Route::get('invoice_installments', [App\Http\Controllers\InvoiceInstallmentController::class, 'index'])->name('invoice_installments.index');
        Route::get('invoice_installments/overdue', [App\Http\Controllers\InvoiceInstallmentController::class, 'overdue'])->name('invoice_installments.overdue');
        Route::post('invoice_installments/{id}/mark-paid', [App\Http\Controllers\InvoiceInstallmentController::class, 'markAsPaid'])->name('invoice_installments.markAsPaid');
        Route::delete('invoice_installments/{id}', [App\Http\Controllers\InvoiceInstallmentController::class, 'destroy'])->name('invoice_installments.destroy');

        // عروض الأسعار - Quotations
        Route::resource('quotations', App\Http\Controllers\QuotationController::class);
        Route::post('quotations/{id}/convert-to-invoice', [App\Http\Controllers\QuotationController::class, 'convertToInvoice'])->name('quotations.convertToInvoice');
        Route::patch('quotations/{id}/update-status', [App\Http\Controllers\QuotationController::class, 'updateStatus'])->name('quotations.updateStatus');

        // ===========================================================================================
        // تقارير الفواتير - Invoice Reports
        // ===========================================================================================

        // تقرير الفواتير - Invoices Report
        Route::get('reports_invoices', [BackendController::class, 'reports_invoices'])->name('reports_invoices');
        Route::post('reports_invoices', [BackendController::class, 'reports_invoices'])->name('reports_invoices_post');
        Route::post('export_reports_invoices_excel', [BackendController::class, 'export_reports_invoices_excel'])->name('export_reports_invoices_excel');

        // تقرير مدفوعات الفواتير - Invoice Payments Report
        Route::get('reports_invoice_payments', [BackendController::class, 'reports_invoice_payments'])->name('reports_invoice_payments');
        Route::post('reports_invoice_payments', [BackendController::class, 'reports_invoice_payments'])->name('reports_invoice_payments_post');
        Route::post('export_reports_invoice_payments_excel', [BackendController::class, 'export_reports_invoice_payments_excel'])->name('export_reports_invoice_payments_excel');

        // تقرير عروض الأسعار - Quotations Report
        Route::get('reports_quotations', [BackendController::class, 'reports_quotations'])->name('reports_quotations');
        Route::post('reports_quotations', [BackendController::class, 'reports_quotations'])->name('reports_quotations_post');
        Route::post('export_reports_quotations_excel', [BackendController::class, 'export_reports_quotations_excel'])->name('export_reports_quotations_excel');

        // تقرير الأقساط - Installments Report
        Route::get('reports_installments', [BackendController::class, 'reports_installments'])->name('reports_installments');
        Route::post('reports_installments', [BackendController::class, 'reports_installments'])->name('reports_installments_post');
        Route::post('export_reports_installments_excel', [BackendController::class, 'export_reports_installments_excel'])->name('export_reports_installments_excel');
    }
);


// Employee ====================================================
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:employee']
    ],
    function () {

        Route::resource('employee', HomeEmployeeController::class);
        Route::resource('Messages', MessageController::class);
                // Employee Self Service
        Route::get('announcements', [EmployeeAnnouncementsController::class, 'index'])->name('employee.announcements.index');

        // Employee profile
        Route::get('profile', [EmployeeProfileController::class, 'show'])->name('employee.profile.show');
        Route::post('profile', [EmployeeProfileController::class, 'update'])->name('employee.profile.update');
    }
);
