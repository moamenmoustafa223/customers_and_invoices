@extends('backend.layouts.master')

@section('page_title')
    {{ trans('dashboard.dashboard') }}
@endsection

@section('content')

<style>
    .transition {
        transition: all 0.3s ease;
    }
    .card.transition:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
    }
</style>

<div class="row justify-content-center g-2">

    <div class="col-md-12 text-center mb-2">
        <img src="{{ asset(App\Models\Setting::first()->logo) }}" alt="image" width="100">
    </div>

    @php
        $primaryColor = App\Models\Setting::first()->primary_color;
        $cards = [
            ['icon' => 'fa-users', 'route' => 'customers.index', 'text' => 'back.customers', 'permission' => 'customers'],
            ['icon' => 'fa-file-invoice', 'route' => 'invoices.index', 'text' => 'back.invoices', 'permission' => 'invoices'],
            ['icon' => 'fa-file-alt', 'route' => 'quotations.index', 'text' => 'back.quotations', 'permission' => 'quotations'],
            ['icon' => 'fa-dollar-sign', 'route' => 'invoice_payments.index', 'text' => 'back.invoice_payments', 'permission' => 'invoice_payments'],
            ['icon' => 'fa-calendar-check', 'route' => 'invoice_installments.index', 'text' => 'back.installments', 'permission' => 'invoice_installments'],
            ['icon' => 'fa-concierge-bell', 'route' => 'services.index', 'text' => 'back.services', 'permission' => 'services'],
            ['icon' => 'fa-credit-card', 'route' => 'PaymentMethod.index', 'text' => 'back.payment_methods', 'permission' => 'payment_methods'],
            ['icon' => 'fa-chart-bar', 'route' => 'show_reports_all', 'text' => 'back.reports', 'permission' => 'reports'],
            ['icon' => 'fa-cogs', 'route' => 'Setting.index', 'text' => 'back.settings', 'permission' => 'settings'],
        ];
    @endphp

    @foreach($cards as $card)
        @can($card['permission'])
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm border-0 rounded-4 text-center position-relative bg-white bg-opacity-75 transition">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center py-2">
                        <i class="fas {{ $card['icon'] }} mb-2 text-primary" style="font-size: 32px;"></i>
                        <h5 class="fw-semibold mb-0">{{ trans($card['text']) }}</h5>
                        <a href="{{ route($card['route']) }}" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        @endcan
    @endforeach

</div>
@endsection
