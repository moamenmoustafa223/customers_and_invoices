<!-- Horizontal Menu Start -->
<header class="topnav">
    <nav class="navbar navbar-expand-lg">
        <nav class="container-fluid">
            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    {{-- Dashboard --}}
                    <li class="nav-item dropdown hover-dropdown">
                        <a class="nav-link dropdown-toggle drop-arrow-none" href="{{ route('dashboard.index') }}">
                            <span class="menu-icon"><i class="ti ti-layout-dashboard"></i></span>
                            <span class="menu-text"> {{ __('back.dashboard') }} </span>
                        </a>
                    </li>

                    {{-- Customers --}}
                    <li class="nav-item dropdown hover-dropdown">
                        <a class="nav-link dropdown-toggle drop-arrow-none" href="#" id="topnav-customers" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="menu-icon"><i class="ti ti-users"></i></span>
                            <span class="menu-text">{{ __('back.customers') }}</span>
                            <div class="menu-arrow"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-customers">
                            @can('customer_categories')
                                <a href="{{ route('customer_categories.index') }}" class="dropdown-item">{{ __('back.customer_categories') }}</a>
                            @endcan
                            @can('customers')
                                <a href="{{ route('customers.index') }}" class="dropdown-item">{{ __('back.customers') }}</a>
                            @endcan
                        </div>
                    </li>

                    {{-- Invoices --}}
                    <li class="nav-item dropdown hover-dropdown">
                        <a class="nav-link dropdown-toggle drop-arrow-none" href="#" id="topnav-invoices" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="menu-icon"><i class="ti ti-file-invoice"></i></span>
                            <span class="menu-text">{{ __('back.invoices') }}</span>
                            <div class="menu-arrow"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-invoices">
                            @can('invoice_statuses')
                                <a href="{{ route('invoice_statuses.index') }}" class="dropdown-item">{{ __('back.invoice_statuses') }}</a>
                            @endcan
                            {{-- @can('services')
                                <a href="{{ route('services.index') }}" class="dropdown-item">{{ __('back.services') }}</a>
                            @endcan --}}
                            @can('invoices')
                                <a href="{{ route('invoices.index') }}" class="dropdown-item">{{ __('back.invoices') }}</a>
                            @endcan
                            <a href="{{ route('invoice_installments.index') }}" class="dropdown-item">{{ trans('back.invoice_installments') }}</a>
                            <a href="{{ route('invoice_installments.overdue') }}" class="dropdown-item">{{ trans('back.overdue_installments') }}</a>
                            @can('invoice_payments')
                                <a href="{{ route('invoice_payments.index') }}" class="dropdown-item">{{ __('back.invoice_payments') }}</a>
                            @endcan
                            @can('quotations')
                                <a href="{{ route('quotations.index') }}" class="dropdown-item">{{ __('back.quotations') }}</a>
                            @endcan
                        </div>
                    </li>

                    {{-- Accounting --}}
                    <li class="nav-item dropdown hover-dropdown">
                        <a class="nav-link dropdown-toggle drop-arrow-none" href="#" id="topnav-accounting" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="menu-icon"><i class="ti ti-cash"></i></span>
                            <span class="menu-text">{{ __('back.Accounting') }}</span>
                            <div class="menu-arrow"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-accounting">
                            @can('payment_methods')
                                <a href="{{ route('PaymentMethod.index') }}" class="dropdown-item">{{ __('menu.payment_methods') }}</a>
                            @endcan
                            @can('transfers')
                                <a href="{{ route('paymentMethods.transfers') }}" class="dropdown-item">{{ trans('payment_methods.transfer_history') }}</a>
                            @endcan
                            @can('transactions')
                                <a href="{{ route('payment_method_transactions.index') }}" class="dropdown-item">{{ __('back.transactions_report') }}</a>
                            @endcan
                            @can('AssetsCategories')
                                <a href="{{ route('AssetsCategories.index') }}" class="dropdown-item">{{ __('back.AssetsCategories') }}</a>
                            @endcan
                            @can('AssetsSubCategories')
                                <a href="{{ route('AssetsSubCategories.index') }}" class="dropdown-item">{{ __('back.AssetsSubCategories') }}</a>
                            @endcan
                            @can('assets')
                                <a href="{{ route('Assets.index') }}" class="dropdown-item">{{ __('back.Show_all_assets') }}</a>
                            @endcan
                            @can('IncomesCategories')
                                <a href="{{ route('IncomesCategories.index') }}" class="dropdown-item">{{ __('back.IncomesCategories') }}</a>
                            @endcan
                            @can('IncomesSubCategories')
                                <a href="{{ route('IncomesSubCategories.index') }}" class="dropdown-item">{{ __('back.IncomesSubCategories') }}</a>
                            @endcan
                            @can('Incomes')
                                <a href="{{ route('Incomes.index') }}" class="dropdown-item">{{ __('back.Show_all_Incomes') }}</a>
                            @endcan
                            @can('ExpenseCategories')
                                <a href="{{ route('ExpenseCategories.index') }}" class="dropdown-item">{{ __('menu.ExpenseCategories') }}</a>
                            @endcan
                            @can('ExpenseSubCategories')
                                <a href="{{ route('ExpenseSubCategories.index') }}" class="dropdown-item">{{ __('back.ExpenseSubCategories') }}</a>
                            @endcan
                            @can('Expenses')
                                <a href="{{ route('Expenses.index') }}" class="dropdown-item">{{ __('back.Show_all_Expenses') }}</a>
                            @endcan
                        </div>
                    </li>

                    {{-- Reports --}}
                    @can('Reports')
                        <li class="nav-item dropdown hover-dropdown">
                            <a class="nav-link dropdown-toggle drop-arrow-none" href="#" id="topnav-reports" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="menu-icon"><i class="ti ti-chart-bar"></i></span>
                                <span class="menu-text">{{ __('back.reports') }}</span>
                                <div class="menu-arrow"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-reports">
                                @can('reports_all')
                                    <a href="{{ route('show_reports_all') }}" class="dropdown-item">{{ __('menu.reports_all') }}</a>
                                    <a href="{{ route('reports_all_between_two_dates') }}" class="dropdown-item">{{ __('back.All_report_between_two_dates') }}</a>
                                    <a href="{{ route('reports_invoices') }}" class="dropdown-item">{{ trans('back.reports_invoices') }}</a>
                                    <a href="{{ route('reports_invoice_payments') }}" class="dropdown-item">{{ trans('back.reports_invoice_payments') }}</a>
                                    <a href="{{ route('reports_quotations') }}" class="dropdown-item">{{ trans('back.reports_quotations') }}</a>
                                    <a href="{{ route('reports_installments') }}" class="dropdown-item">{{ trans('back.reports_installments') }}</a>
                                @endcan
                                @can('reports_Assets')
                                    <a href="{{ route('reports_assets') }}" class="dropdown-item">{{ __('back.reports_assets') }}</a>
                                @endcan
                                @can('reports_Expenses')
                                    <a href="{{ route('reports_expenses') }}" class="dropdown-item">{{ __('back.reports_expenses') }}</a>
                                @endcan
                                @can('reports_Incomes')
                                    <a href="{{ route('reports_incomes') }}" class="dropdown-item">{{ __('back.reports_incomes') }}</a>
                                @endcan
                            </div>
                        </li>
                    @endcan

                    {{-- HR --}}
                    @can('Employees_Area')
                        <li class="nav-item dropdown hover-dropdown">
                            <a class="nav-link dropdown-toggle drop-arrow-none" href="#" id="topnav-hr" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="menu-icon"><i class="ti ti-users"></i></span>
                                <span class="menu-text">{{ __('back.HR') }}</span>
                                <div class="menu-arrow"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-hr">
                                <a href="{{ route('reports_hr_between_two_dates') }}" class="dropdown-item">{{ __('back.reports_hr_between_two_dates') }}</a>
                                @can('CategoryEmployees')
                                    <a href="{{ route('CategoryEmployees.index') }}" class="dropdown-item">{{ __('back.CategoryEmployees') }}</a>
                                @endcan
                                @can('Employees')
                                    <a href="{{ route('Employees.index') }}" class="dropdown-item">{{ __('back.Employees') }}</a>
                                @endcan
                                @can('Trainees')
                                    <a href="{{ route('Trainees.index') }}" class="dropdown-item">{{ __('back.Trainees') }}</a>
                                @endcan
                                @can('Contracts')
                                    <a href="{{ route('Contracts.index') }}" class="dropdown-item">{{ __('back.Contracts') }}</a>
                                @endcan
                                @can('Salaries')
                                    <a href="{{ route('Salaries.index') }}" class="dropdown-item">{{ __('back.Salaries') }}</a>
                                @endcan
                                @can('balances')
                                    <a href="{{ route('Balances.index') }}" class="dropdown-item">{{ __('back.balances') }}</a>
                                @endcan
                                @can('CategoryHolidays')
                                    <a href="{{ route('CategoryHolidays.index') }}" class="dropdown-item">{{ __('back.CategoryHolidays') }}</a>
                                @endcan
                                @can('Holidays')
                                    <a href="{{ route('Holidays.index') }}" class="dropdown-item">{{ __('back.Holidays') }}</a>
                                @endcan
                                @can('CategoryAllowances')
                                    <a href="{{ route('CategoryAllowances.index') }}" class="dropdown-item">{{ __('back.CategoryAllowances') }}</a>
                                @endcan
                                @can('Allowances')
                                    <a href="{{ route('Allowances.index') }}" class="dropdown-item">{{ __('back.Allowances') }}</a>
                                @endcan
                                @can('CategoryDiscounts')
                                    <a href="{{ route('CategoryDiscounts.index') }}" class="dropdown-item">{{ __('back.CategoryDiscounts') }}</a>
                                @endcan
                                @can('Discounts')
                                    <a href="{{ route('Discounts.index') }}" class="dropdown-item">{{ __('back.Discounts') }}</a>
                                @endcan
                                @can('EmployeesCourses')
                                    <a href="{{ route('EmployeesCourses.index') }}" class="dropdown-item">{{ __('back.Employees_Courses') }}</a>
                                @endcan
                                @can('all_messages')
                                    <a href="{{ route('all_messages') }}" class="dropdown-item">{{ __('back.all_messages') }}</a>
                                @endcan
                            </div>
                        </li>
                    @endcan

                    {{-- Settings --}}
                    <li class="nav-item dropdown hover-dropdown">
                        <a class="nav-link dropdown-toggle drop-arrow-none" href="#" id="topnav-settings" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="menu-icon"><i class="ti ti-settings"></i></span>
                            <span class="menu-text">{{ __('back.Setting') }}</span>
                            <div class="menu-arrow"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-settings">
                            @can('users')
                                <a href="{{ route('users.index') }}" class="dropdown-item">{{ __('menu.users') }}</a>
                            @endcan
                            @can('roles')
                                <a href="{{ route('roles.index') }}" class="dropdown-item">{{ __('menu.roles') }}</a>
                            @endcan
                            @can('Setting')
                                <a href="{{ route('Setting.index') }}" class="dropdown-item">{{ __('menu.Setting') }}</a>
                            @endcan
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </nav>
</header>
<!-- Horizontal Menu End -->
