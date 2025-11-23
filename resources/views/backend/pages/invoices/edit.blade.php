@extends('backend.layouts.master')

@section('page_title')
    {{trans('back.edit_invoice')}} : {{$invoice->invoice_number}}
@endsection


@section('content')

    <div class="row">
        <div class="col-sm-12">
            <a href="{{route('invoices.index')}}" class="btn btn-info btn-sm mb-2">
                <i class="fas fa-arrow-left me-1"></i>
                {{trans('back.invoices')}}
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <form action="{{route('invoices.update', $invoice->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        {{-- Customer --}}
                        <div class="form-group col-md-4">
                            <label for="customer_id" class="font-weight-bold">{{trans('back.select_customer')}}</label>
                            <b class="text-danger">*</b>
                            <select class="form-control select2" name="customer_id" required>
                                <option selected disabled value="">{{trans('back.Select')}}</option>
                                @foreach(App\Models\Customer::all() as $customer)
                                    <option value="{{ $customer->id }}" {{ $customer->id == $invoice->customer_id ? 'selected' : '' }}>
                                        {{ $customer->name }} / {{ $customer->phone }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Status --}}
                        <div class="form-group col-md-3">
                            <label for="invoice_status_id" class="font-weight-bold">{{trans('back.status')}}</label>
                            <b class="text-danger">*</b>
                            <select class="form-control select2" name="invoice_status_id" required>
                                <option selected disabled value="">{{trans('back.Select')}}</option>
                                @foreach(App\Models\InvoiceStatus::all() as $status)
                                    <option value="{{ $status->id }}" {{ $status->id == $invoice->invoice_status_id ? 'selected' : '' }}>
                                        {{ app()->getLocale() == 'ar' ? $status->name_ar : $status->name_en }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Invoice Date --}}
                        <div class="form-group col-md-2">
                            <label for="invoice_date">{{trans('back.invoice_date')}}</label>
                            <b class="text-danger">*</b>
                            <input type="date" class="form-control" name="invoice_date" value="{{$invoice->invoice_date->format('Y-m-d')}}" required>
                        </div>

                        {{-- Due Date --}}
                        <div class="form-group col-md-3">
                            <label for="due_date">{{trans('back.due_date')}}</label>
                            <b class="text-danger">*</b>
                            <input type="date" class="form-control" name="due_date" value="{{$invoice->due_date->format('Y-m-d')}}" required>
                        </div>


                        {{-- Totals Row --}}
                        <div class="form-group col-md-2">
                            <label for="subtotal">{{ trans('back.subtotal') }}</label>
                            <input type="number" class="form-control form-control-sm subtotal text-center"
                                name="subtotal" step="any" value="{{$invoice->subtotal}}" readonly>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="discount">{{ trans('back.discount') }}</label>
                            <input type="number" class="form-control form-control-sm discount" name="discount"
                                step="0.001" value="{{$invoice->discount ?? 0}}" min="0">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="discount_display">{{ trans('back.after_discount') }}</label>
                            @php
                                $totalAfterDiscount = $invoice->subtotal - ($invoice->discount ?? 0);
                            @endphp
                            <input type="number" class="form-control form-control-sm total-after-discount text-center"
                                name="total_after_discount" step="any" value="{{$totalAfterDiscount}}" readonly>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="tax_percentage">{{ trans('back.tax') }} (%)</label>
                            @php
                                $taxPercentage = $totalAfterDiscount > 0 ? ($invoice->tax / $totalAfterDiscount * 100) : 15;
                            @endphp
                            <input type="number" class="form-control form-control-sm tax-percentage"
                                name="tax_percentage" step="0.01" value="{{number_format($taxPercentage, 2)}}" min="0" max="100">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="tax">{{ trans('back.tax_amount') }}</label>
                            <input type="number" class="form-control form-control-sm tax text-center"
                                name="tax" step="any" value="{{$invoice->tax}}" readonly>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="total" class="font-weight-bold">{{ trans('back.final_total') }}</label>
                            <input type="number" class="form-control form-control-sm total text-center font-weight-bold text-danger"
                                name="total" step="any" value="{{$invoice->total}}" readonly>
                        </div>

                        <div class="col-md-12 mt-0">
                            <hr class="mt-0 pt-0">
                        </div>
                    </div>

                    {{-- Service Items Section --}}
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="card shadow-sm border-0">
                                <div class="card-header py-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <h5 class="mb-0 text-white">
                                        <i class="fas fa-list-alt me-2"></i>{{trans('back.invoice_items')}}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="35%">{{trans('back.service')}}</th>
                                                    <th width="15%" class="text-center">{{trans('back.quantity')}}</th>
                                                    <th width="18%" class="text-center">{{trans('back.unit_price')}}</th>
                                                    <th width="20%" class="text-center">{{trans('back.total')}}</th>
                                                    <th width="12%" class="text-center">{{trans('back.action')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody id="items-container">
                                                @foreach($invoice->items as $index => $item)
                                                    <tr class="item-row" data-item-index="{{ $index }}">
                                                        <td>
                                                            <input type="text" name="items[{{ $index }}][service_name]" class="form-control form-control-sm" value="{{ $item->service_name }}" placeholder="{{trans('back.service')}}" required>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="items[{{ $index }}][quantity]" class="form-control form-control-sm item-quantity text-center" value="{{ $item->quantity }}" min="1" step="1" required>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="items[{{ $index }}][unit_price]" class="form-control form-control-sm item-price text-center" value="{{ $item->unit_price }}" step="any" required>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control form-control-sm item-total bg-light text-center fw-bold" value="{{ number_format($item->total_price, 3) }}" step="any" readonly>
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-danger btn-sm remove-item" {{ $index == 0 ? 'disabled' : '' }}>
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm mt-2" id="add-item-btn">
                                        <i class="fas fa-plus-circle me-1"></i> {{trans('back.add_service')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Installments Section --}}
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="card shadow-sm border-0"> 
                                <div class="card-header py-3" style="background: linear-gradient(135deg, #11998e 0%, #29a458 100%);">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0 text-white">
                                            <i class="fas fa-money-check-alt me-2"></i>{{trans('back.installments')}} <small>({{trans('back.optional')}})</small>
                                        </h5>
                                        <div class="badge bg-white text-dark" id="remaining-amount-badge">
                                            {{trans('back.remaining_amount')}}: <span id="remaining-to-allocate">0.000</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="35%">{{trans('back.due_date')}}</th>
                                                    <th width="30%" class="text-center">{{trans('back.amount')}}</th>
                                                    <th width="25%" class="text-center">{{trans('back.remaining_amount')}}</th>
                                                    <th width="10%" class="text-center">{{trans('back.action')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody id="installments-container">
                                                @foreach($invoice->installments as $index => $installment)
                                                    <tr class="installment-row" data-installment-index="{{ $index }}">
                                                        <td>
                                                            <input type="date" name="installments[{{ $index }}][due_date]" class="form-control form-control-sm" value="{{ $installment->due_date->format('Y-m-d') }}">
                                                        </td>
                                                        <td>
                                                            <input type="number" name="installments[{{ $index }}][amount]" class="form-control form-control-sm installment-amount text-center" step="any" value="{{ $installment->amount }}">
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control form-control-sm remaining-after-installment bg-light text-center fw-bold" step="any" value="0.000" readonly>
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-danger btn-sm remove-installment" {{ $index == 0 ? 'disabled' : '' }}>
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="button" class="btn btn-success btn-sm mt-2" id="add-installment-btn">
                                        <i class="fas fa-plus-circle me-1"></i> {{trans('back.add_installment')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Notes Section --}}
                    <div class="row mt-1">
                        <div class="col-md-12">
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="notes_ar">{{trans('back.notes_ar')}}</label>
                                    <textarea name="notes_ar" class="form-control" rows="3">{{ $invoice->notes_ar }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="notes_en">{{trans('back.notes_en')}}</label>
                                    <textarea name="notes_en" class="form-control" rows="3">{{ $invoice->notes_en }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-2">
                        <button type="submit" class="btn btn-success w">{{trans('back.update')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
<script>
    $(document).ready(function () {
        let itemIndex = {{ $invoice->items->count() }};
        let installmentIndex = {{ $invoice->installments->count() }};

        // ------------------------------
        // SERVICE ITEMS LOGIC
        // ------------------------------

        // Add Item
        $('#add-item-btn').on('click', function() {
            let html = `
            <tr class="item-row" data-item-index="${itemIndex}">
                <td>
                    <input type="text" name="items[${itemIndex}][service_name]" class="form-control form-control-sm" placeholder="{{trans('back.service')}}" required>
                </td>
                <td>
                    <input type="number" name="items[${itemIndex}][quantity]" class="form-control form-control-sm item-quantity text-center" value="1" min="1" step="1" required>
                </td>
                <td>
                    <input type="number" name="items[${itemIndex}][unit_price]" class="form-control form-control-sm item-price text-center" value="0" step="any" required>
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm item-total bg-light text-center fw-bold" value="0.000" step="any" readonly>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm remove-item">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            </tr>`;
            $('#items-container').append(html);
            itemIndex++;
        });

        // Remove Item
        $('body').on('click', '.remove-item', function() {
            $(this).closest('.item-row').remove();
            recalculateAll();
        });

        // Update totals when quantity or price changes
        $('body').on('input', '.item-quantity, .item-price', function () {
            let row = $(this).closest('.item-row');
            let quantity = parseFloat(row.find('.item-quantity').val()) || 0;
            let price = parseFloat(row.find('.item-price').val()) || 0;
            let total = quantity * price;
            row.find('.item-total').val(total.toFixed(3));
            recalculateAll();
        });

        // Update tax when percentage changes
        $('body').on('input', '.tax-percentage', function () {
            recalculateAll();
        });

        // Update totals when discount changes
        $('body').on('input', '.discount', function () {
            recalculateAll();
        });

        // Update validation when installment amounts change
        $('body').on('input', '.installment-amount', function () {
            validateInstallments();
        });

        // Calculate Subtotal
        function calculateSubtotal() {
            let subtotal = 0;
            $('.item-row').each(function () {
                let quantity = parseFloat($(this).find('.item-quantity').val()) || 0;
                let price = parseFloat($(this).find('.item-price').val()) || 0;
                subtotal += quantity * price;
            });
            return subtotal;
        }

        // Calculate Discount
        function calculateDiscount() {
            let discount = parseFloat($('.discount').val()) || 0;
            return discount;
        }

        // Calculate Total After Discount
        function calculateTotalAfterDiscount() {
            let subtotal = calculateSubtotal();
            let discount = calculateDiscount();
            return subtotal - discount;
        }

        // Calculate Tax
        function calculateTax() {
            let totalAfterDiscount = calculateTotalAfterDiscount();
            let taxPercentage = parseFloat($('.tax-percentage').val()) || 0;
            return (totalAfterDiscount * taxPercentage / 100);
        }

        // Calculate Total
        function calculateTotal() {
            let totalAfterDiscount = calculateTotalAfterDiscount();
            let tax = calculateTax();
            return totalAfterDiscount + tax;
        }

        // Recalculate All
        function recalculateAll() {
            let subtotal = calculateSubtotal();
            let discount = calculateDiscount();
            let totalAfterDiscount = calculateTotalAfterDiscount();
            let tax = calculateTax();
            let total = calculateTotal();

            $('.subtotal').val(subtotal.toFixed(3));
            $('.total-after-discount').val(totalAfterDiscount.toFixed(3));
            $('.tax').val(tax.toFixed(3));
            $('.total').val(total.toFixed(3));

            // Update remaining amounts for installments
            updateInstallmentsRemaining();
            validateInstallments();
        }

        // Update Installments Remaining Amount
        function updateInstallmentsRemaining() {
            let total = calculateTotal();
            let runningTotal = total;

            $('.installment-row').each(function() {
                let amount = parseFloat($(this).find('.installment-amount').val()) || 0;
                runningTotal -= amount;
                $(this).find('.remaining-after-installment').val(runningTotal.toFixed(3));
            });

            // Update the remaining to allocate badge
            let installmentsTotal = 0;
            $('.installment-amount').each(function() {
                installmentsTotal += parseFloat($(this).val()) || 0;
            });
            let remainingToAllocate = total - installmentsTotal;
            $('#remaining-to-allocate').text(remainingToAllocate.toFixed(3));
        }

        // Validate Installments
        function validateInstallments() {
            let total = calculateTotal();
            let installmentsTotal = 0;

            $('.installment-amount').each(function () {
                let amount = parseFloat($(this).val()) || 0;
                installmentsTotal += amount;
            });

            // Remove any existing warning
            $('#installments-warning').remove();

            // Only validate if there are installments with amounts
            if (installmentsTotal > 0) {
                let difference = Math.abs(total - installmentsTotal);

                if (difference > 0.01) { // Allow for small rounding differences
                    let warningHtml = `
                        <div id="installments-warning" class="alert alert-warning mt-2" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>{{trans('back.warning')}}:</strong> {{trans('back.installments_total_mismatch')}}
                            <br>
                            <small>{{trans('back.invoice_total')}}: ${total.toFixed(3)} | {{trans('back.installments_total')}}: ${installmentsTotal.toFixed(3)}</small>
                        </div>`;
                    $('#installments-container').after(warningHtml);
                }
            }
        }

        // ------------------------------
        // INSTALLMENTS LOGIC
        // ------------------------------

        // Add Installment
        $('#add-installment-btn').on('click', function () {
            let html = `
                <tr class="installment-row" data-installment-index="${installmentIndex}">
                    <td>
                        <input type="date" name="installments[${installmentIndex}][due_date]" class="form-control form-control-sm">
                    </td>
                    <td>
                        <input type="number" name="installments[${installmentIndex}][amount]" class="form-control form-control-sm installment-amount text-center" step="any">
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm remaining-after-installment bg-light text-center fw-bold" step="any" value="0.000" readonly>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm remove-installment">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>`;
            $('#installments-container').append(html);
            installmentIndex++;
            updateInstallmentsRemaining();
        });

        // Remove Installment
        $('body').on('click', '.remove-installment', function () {
            $(this).closest('.installment-row').remove();
            updateInstallmentsRemaining();
            validateInstallments();
        });

        // Initialize remaining amounts on page load
        updateInstallmentsRemaining();
    });
</script>
@endsection
