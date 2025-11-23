<div class="sidenav-menu">

    <!-- Brand Logo -->
    <a href="{{ route('dashboard.index') }}" class="logo">
        <span class="logo-lg"><img src="{{ asset(App\Models\Setting::first()->logo) }}" style="height: 65px"
                alt="logo"></span>
        <span class="logo-sm"><img src="{{ asset(App\Models\Setting::first()->logo) }}" alt="small logo"></span>
    </a>

    <!-- Sidebar Hover Menu Toggle Button -->
    <button class="button-sm-hover">
        <i class="ri-circle-line align-middle"></i>
    </button>

    <!-- Sidebar Menu Toggle Button -->
    <button class="sidenav-toggle-button">
        <i class="ri-menu-5-line fs-20"></i>
    </button>

    <!-- Full Sidebar Menu Close Button -->
    <button class="button-close-fullsidebar">
        <i class="ti ti-x align-middle"></i>
    </button>

    <div data-simplebar>
        <!--- SidenavSidenav Menu -->
        <ul class="side-nav">
            <li class="side-nav-item">
                <a href="{{ route('dashboard.index') }}" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-layout-dashboard"></i></span>
                    <span class="menu-text"> {{ __('back.dashboard') }} </span>
                </a>
            </li>

            
            {{-- إدارة العملاء والفواتير --}}
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarCustomersInvoices" aria-expanded="false"
                    aria-controls="sidebarCustomersInvoices" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-file-invoice"></i></span>
                    <span class="menu-text">{{ __('back.customer_invoice_management') }}</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarCustomersInvoices">
                    <ul class="sub-menu">
                        @can('customer_categories')
                            <li class="side-nav-item">
                                <a href="{{ route('customer_categories.index') }}" class="side-nav-link">
                                    <span class="menu-text">{{ __('back.customer_categories') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('customers')
                            <li class="side-nav-item">
                                <a href="{{ route('customers.index') }}" class="side-nav-link">
                                    <span class="menu-text">{{ __('back.customers') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('invoice_statuses')
                            <li class="side-nav-item">
                                <a href="{{ route('invoice_statuses.index') }}" class="side-nav-link">
                                    <span class="menu-text">{{ __('back.invoice_statuses') }}</span>
                                </a>
                            </li>
                        @endcan
                        {{-- @can('services')
                            <li class="side-nav-item">
                                <a href="{{ route('services.index') }}" class="side-nav-link">
                                    <span class="menu-text">{{ __('back.services') }}</span>
                                </a>
                            </li>
                        @endcan --}}
                        @can('invoices')
                            <li class="side-nav-item">
                                <a href="{{ route('invoices.index') }}" class="side-nav-link">
                                    <span class="menu-text">{{ __('back.invoices') }}</span>
                                </a>
                            </li>
                        @endcan
                        <li class="side-nav-item">
                            <a href="{{ route('invoice_installments.index') }}" class="side-nav-link">
                                <span class="menu-text">{{ trans('back.invoice_installments') }}</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('invoice_installments.overdue') }}" class="side-nav-link">
                                <span class="menu-text">{{ trans('back.overdue_installments') }}</span>
                            </a>
                        </li>
                        @can('invoice_payments')
                            <li class="side-nav-item">
                                <a href="{{ route('invoice_payments.index') }}" class="side-nav-link">
                                    <span class="menu-text">{{ __('back.invoice_payments') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('quotations')
                            <li class="side-nav-item">
                                <a href="{{ route('quotations.index') }}" class="side-nav-link">
                                    <span class="menu-text">{{ __('back.quotations') }}</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </li>
            


            {{-- المحاسبة --}}
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarAccounting" aria-expanded="false"
                    aria-controls="sidebarAccounting" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-cash"></i></span> {{-- تم تغيير الأيقونة لتناسب theme الجديد --}}
                    <span class="menu-text">{{ __('back.Accounting') }}</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarAccounting">
                    <ul class="sub-menu">
                        @can('payment_methods')
                            <li class="side-nav-item">
                                <a href="{{ route('PaymentMethod.index') }}" class="side-nav-link">
                                    <span class="menu-text">{{ __('menu.payment_methods') }}</span>
                                </a>
                            </li>
                        @endcan

                        @can('transfers')
                            <li class="side-nav-item">
                                <a href="{{ route('paymentMethods.transfers') }}" class="side-nav-link">
                                    <span class="menu-text">{{ trans('payment_methods.transfer_history') }}</span>
                                </a>
                            </li>
                        @endcan

                        @can('transactions')
                            <li class="side-nav-item">
                                <a href="{{ route('payment_method_transactions.index') }}" class="side-nav-link">
                                    <span class="menu-text">{{ __('back.transactions_report') }}</span>
                                </a>
                            </li>
                        @endcan


                        {{-- الأصول --}}
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarAssets" aria-expanded="false"
                                aria-controls="sidebarAssets" class="side-nav-link">
                                <span class="menu-icon"><i class="ti ti-building-warehouse"></i></span>
                                {{-- تم تغيير الأيقونة لتناسب theme الجديد --}}
                                <span class="menu-text">{{ __('back.assets') }}</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarAssets">
                                <ul class="sub-menu">
                                    @can('AssetsCategories')
                                        <li class="side-nav-item">
                                            <a href="{{ route('AssetsCategories.index') }}" class="side-nav-link">
                                                <span class="menu-text">{{ __('back.AssetsCategories') }}</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('AssetsSubCategories')
                                        <li class="side-nav-item">
                                            <a href="{{ route('AssetsSubCategories.index') }}" class="side-nav-link">
                                                <span class="menu-text">{{ __('back.AssetsSubCategories') }}</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('assets')
                                        <li class="side-nav-item">
                                            <a href="{{ route('Assets.index') }}" class="side-nav-link">
                                                <span class="menu-text">{{ __('back.Show_all_assets') }}</span>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>

                        {{-- الإيرادات --}}
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarIncomes" aria-expanded="false"
                                aria-controls="sidebarIncomes" class="side-nav-link">
                                <span class="menu-icon"><i class="ti ti-coin"></i></span> {{-- تم تغيير الأيقونة لتناسب theme الجديد --}}
                                <span class="menu-text">{{ __('back.Incomes') }}</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarIncomes">
                                <ul class="sub-menu">
                                    @can('IncomesCategories')
                                        <li class="side-nav-item">
                                            <a href="{{ route('IncomesCategories.index') }}" class="side-nav-link">
                                                <span class="menu-text">{{ __('back.IncomesCategories') }}</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('IncomesSubCategories')
                                        <li class="side-nav-item">
                                            <a href="{{ route('IncomesSubCategories.index') }}" class="side-nav-link">
                                                <span class="menu-text">{{ __('back.IncomesSubCategories') }}</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('Incomes')
                                        <li class="side-nav-item">
                                            <a href="{{ route('Incomes.index') }}" class="side-nav-link">
                                                <span class="menu-text">{{ __('back.Show_all_Incomes') }}</span>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>

                        {{-- المصروفات --}}
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarExpenses" aria-expanded="false"
                                aria-controls="sidebarExpenses" class="side-nav-link">
                                <span class="menu-icon"><i class="ti ti-receipt"></i></span> {{-- تم تغيير الأيقونة لتناسب theme الجديد --}}
                                <span class="menu-text">{{ __('menu.Expenses') }}</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarExpenses">
                                <ul class="sub-menu">
                                    @can('ExpenseCategories')
                                        <li class="side-nav-item">
                                            <a href="{{ route('ExpenseCategories.index') }}" class="side-nav-link">
                                                <span class="menu-text">{{ __('menu.ExpenseCategories') }}</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('ExpenseSubCategories')
                                        <li class="side-nav-item">
                                            <a href="{{ route('ExpenseSubCategories.index') }}" class="side-nav-link">
                                                <span class="menu-text">{{ __('back.ExpenseSubCategories') }}</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('Expenses')
                                        <li class="side-nav-item">
                                            <a href="{{ route('Expenses.index') }}" class="side-nav-link">
                                                <span class="menu-text">{{ __('back.Show_all_Expenses') }}</span>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- التقارير --}}
            @can('Reports')
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarReports" aria-expanded="false"
                        aria-controls="sidebarReports" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-chart-bar"></i></span>
                        <span class="menu-text">{{ __('back.reports') }}</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarReports">
                        <ul class="sub-menu">
                            @can('reports_all')
                                <li class="side-nav-item">
                                    <a href="{{ route('show_reports_all') }}" class="side-nav-link">
                                        <span class="menu-text">{{ __('menu.reports_all') }}</span>
                                    </a>
                                </li>
                                <li class="side-nav-item">
                                    <a href="{{ route('reports_all_between_two_dates') }}" class="side-nav-link">
                                        <span class="menu-text">{{ __('back.All_report_between_two_dates') }}</span>
                                    </a>
                                </li>
                           
                            @endcan

                            {{-- تقارير نظام الفواتير --}}
                            @can('reports_all')
                                <li class="side-nav-item">
                                    <a href="{{ route('reports_invoices') }}" class="side-nav-link">
                                        <span class="menu-text">{{ trans('back.reports_invoices') }}</span>
                                    </a>
                                </li>
                                <li class="side-nav-item">
                                    <a href="{{ route('reports_invoice_payments') }}" class="side-nav-link">
                                        <span class="menu-text">{{ trans('back.reports_invoice_payments') }}</span>
                                    </a>
                                </li>
                                <li class="side-nav-item">
                                    <a href="{{ route('reports_quotations') }}" class="side-nav-link">
                                        <span class="menu-text">{{ trans('back.reports_quotations') }}</span>
                                    </a>
                                </li>
                                <li class="side-nav-item">
                                    <a href="{{ route('reports_installments') }}" class="side-nav-link">
                                        <span class="menu-text">{{ trans('back.reports_installments') }}</span>
                                    </a>
                                </li>

                            @endcan

                            {{-- تقارير الأصول --}}
                            @can('reports_Assets')
                                <li class="side-nav-item">
                                    <a href="{{ route('reports_assets') }}" class="side-nav-link">
                                        <span class="menu-text">{{ __('back.reports_assets') }}</span>
                                    </a>
                                </li>
                            @endcan



                            {{-- تقارير المصروفات --}}
                            @can('reports_Expenses')
                                <li class="side-nav-item">
                                    <a href="{{ route('reports_expenses') }}" class="side-nav-link">
                                        <span class="menu-text">{{ __('back.reports_expenses') }}</span>
                                    </a>
                                </li>
                            @endcan

                            {{-- تقارير الإيرادات --}}
                            @can('reports_Incomes')
                                <li class="side-nav-item">
                                    <a href="{{ route('reports_incomes') }}" class="side-nav-link">
                                        <span class="menu-text">{{ __('back.reports_incomes') }}</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endcan

            {{-- HR --}}
            @can('Employees_Area')
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarHR" aria-expanded="false" aria-controls="sidebarHR"
                        class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-users"></i></span> {{-- تم تغيير الأيقونة لتناسب theme الجديد --}}
                        <span class="menu-text">{{ __('back.HR') }}</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarHR">
                        <ul class="sub-menu">
                            <li class="side-nav-item">
                                <a href="{{ route('reports_hr_between_two_dates') }}" class="side-nav-link">
                                    <span class="menu-text">{{ __('back.reports_hr_between_two_dates') }}</span>
                                </a>
                            </li>
                            @can('CategoryEmployees')
                                <li class="side-nav-item">
                                    <a href="{{ route('CategoryEmployees.index') }}" class="side-nav-link">
                                        <span class="menu-text">{{ __('back.CategoryEmployees') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('Employees')
                                <li class="side-nav-item">
                                    <a href="{{ route('Employees.index') }}" class="side-nav-link">
                                        <span class="menu-text">{{ __('back.Employees') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('Trainees')
                                <li class="side-nav-item">
                                    <a href="{{ route('Trainees.index') }}" class="side-nav-link">
                                        <span class="menu-text">{{ __('back.Trainees') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('Contracts')
                                <li class="side-nav-item">
                                    <a href="{{ route('Contracts.index') }}" class="side-nav-link">
                                        <span class="menu-text">{{ __('back.Contracts') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('Salaries')
                                <li class="side-nav-item">
                                    <a href="{{ route('Salaries.index') }}" class="side-nav-link">
                                        <span class="menu-text">{{ __('back.Salaries') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('balances')
                                <li class="side-nav-item">
                                    <a href="{{ route('Balances.index') }}" class="side-nav-link">
                                        <span class="menu-text">{{ __('back.balances') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('CategoryHolidays')
                                <li class="side-nav-item">
                                    <a href="{{ route('CategoryHolidays.index') }}" class="side-nav-link">
                                        <span class="menu-text">{{ __('back.CategoryHolidays') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('Holidays')
                                <li class="side-nav-item">
                                    <a href="{{ route('Holidays.index') }}" class="side-nav-link">
                                        <span class="menu-text">{{ __('back.Holidays') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('CategoryAllowances')
                                <li class="side-nav-item">
                                    <a href="{{ route('CategoryAllowances.index') }}" class="side-nav-link">
                                        <span class="menu-text">{{ __('back.CategoryAllowances') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('Allowances')
                                <li class="side-nav-item">
                                    <a href="{{ route('Allowances.index') }}" class="side-nav-link">
                                        <span class="menu-text">{{ __('back.Allowances') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('CategoryDiscounts')
                                <li class="side-nav-item">
                                    <a href="{{ route('CategoryDiscounts.index') }}" class="side-nav-link">
                                        <span class="menu-text">{{ __('back.CategoryDiscounts') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('Discounts')
                                <li class="side-nav-item">
                                    <a href="{{ route('Discounts.index') }}" class="side-nav-link">
                                        <span class="menu-text">{{ __('back.Discounts') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('EmployeesCourses')
                                <li class="side-nav-item">
                                    <a href="{{ route('EmployeesCourses.index') }}" class="side-nav-link">
                                        <span class="menu-text">{{ __('back.Employees_Courses') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('all_messages')
                                <li class="side-nav-item">
                                    <a href="{{ route('all_messages') }}" class="side-nav-link">
                                        <span class="menu-text">{{ __('back.all_messages') }}</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endcan


            {{-- الإعدادات --}}
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarsetting" aria-expanded="false"
                    aria-controls="sidebarsetting" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-settings"></i></span>
                    <span class="menu-text"> {{ __('back.Setting') }}</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarsetting">
                    <ul class="sub-menu">
                        @can('users')
                            <li class="side-nav-item">
                                <a href="{{ route('users.index') }}" class="side-nav-link">
                                    <span class="menu-text">{{ __('menu.users') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('roles')
                            <li class="side-nav-item">
                                <a href="{{ route('roles.index') }}" class="side-nav-link">
                                    <span class="menu-text">{{ __('menu.roles') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('Setting')
                            <li class="side-nav-item">
                                <a href="{{ route('Setting.index') }}" class="side-nav-link">
                                    <span class="menu-text">{{ __('menu.Setting') }}</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
</div>
