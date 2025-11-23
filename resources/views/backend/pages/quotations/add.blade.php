@extends('backend.layouts.master')

@section('page_title')
    {{ trans('back.add_quotation') }}
@endsection


@section('content')
    <div class="row">
        <div class="col-sm-12">
            <a href="{{ route('quotations.index') }}" class="btn btn-info btn-sm mb-2">
                <i class="fas fa-arrow-left me-1"></i>
                {{ trans('back.quotations') }}
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <form action="{{ route('quotations.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        {{-- Customer --}}
                        <div class="form-group col-md-6">
                            <label for="customer_id" class="font-weight-bold">{{ trans('back.select_customer') }}</label>
                            <b class="text-danger">*</b>
                            <select class="form-control select2" name="customer_id" required>
                                <option selected disabled value="">{{ trans('back.Select') }}</option>
                                @foreach (App\Models\Customer::all() as $customer)
                                    <option value="{{ $customer->id }}">
                                        {{ $customer->name }} / {{ $customer->phone }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Quotation Date --}}
                        <div class="form-group col-md-3">
                            <label for="quotation_date">{{ trans('back.quotation_date') }}</label>
                            <b class="text-danger">*</b>
                            <input type="date" class="form-control" name="quotation_date" value="{{ date('Y-m-d') }}"
                                required>
                        </div>

                        {{-- Valid Until --}}
                        <div class="form-group col-md-3">
                            <label for="valid_until">{{ trans('back.valid_until') }}</label>
                            <b class="text-danger">*</b>
                            <input type="date" class="form-control" name="valid_until"
                                value="{{ date('Y-m-d', strtotime('+30 days')) }}" required>
                        </div>

                        {{-- Totals Display - Moved to top --}}
                        <div class="col-md-12 mb-3">
                            <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <div class="card-body py-2">
                                    <div class="row text-white">
                                        <div class="col-md-3">
                                            <label class="small mb-1">{{ trans('back.subtotal') }}</label>
                                            <input type="number"
                                                class="form-control form-control-sm subtotal text-center fw-bold bg-white"
                                                name="subtotal" step="any" value="0.000" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="small mb-1">{{ trans('back.discount') }}</label>
                                            <input type="number"
                                                class="form-control form-control-sm discount-input text-center"
                                                name="discount" step="any" value="0.000" min="0">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="small mb-1">{{ trans('back.tax') }} (%)</label>
                                            <input type="number"
                                                class="form-control form-control-sm tax-percentage text-center"
                                                name="tax_percentage" step="0.01" value="{{ $setting->tax_percentage ?? 15 }}" min="0"
                                                max="100">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="small mb-1">{{ trans('back.tax') }}</label>
                                            <input type="number"
                                                class="form-control form-control-sm tax text-center fw-bold bg-white"
                                                name="tax" step="any" value="0.000" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="small mb-1">{{ trans('back.total') }}</label>
                                            <input type="number"
                                                class="form-control form-control-sm total text-center fw-bold bg-white text-danger"
                                                name="total" step="any" value="0.000" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                        <i class="fas fa-list-alt me-2"></i>{{ trans('back.quotation_items') }}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="35%">{{ trans('back.service') }}</th>
                                                    <th width="15%" class="text-center">{{ trans('back.quantity') }}</th>
                                                    <th width="18%" class="text-center">{{ trans('back.unit_price') }}</th>
                                                    <th width="20%" class="text-center">{{ trans('back.total') }}</th>
                                                    <th width="12%" class="text-center">{{ trans('back.action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody id="items-container">
                                                <tr class="item-row" data-item-index="0">
                                                    <td>
                                                        <input type="text" name="items[0][service_name]" class="form-control form-control-sm" placeholder="{{ trans('back.service') }}" required>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="items[0][quantity]" class="form-control form-control-sm item-quantity text-center" value="1" min="1" step="1" required>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="items[0][unit_price]" class="form-control form-control-sm item-price text-center" value="0" step="any" required>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control form-control-sm item-total bg-light text-center fw-bold" value="0.000" step="any" readonly>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-danger btn-sm remove-item" disabled>
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm mt-2" id="add-item-btn">
                                        <i class="fas fa-plus-circle me-1"></i> {{ trans('back.add_service') }}
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
                                    <label for="notes_ar">{{ trans('back.notes_ar') }}</label>
                                    <textarea name="notes_ar" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="notes_en">{{ trans('back.notes_en') }}</label>
                                    <textarea name="notes_en" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-2">
                        <button type="submit"
                                class="btn btn-success">{{ trans('back.create_quotation') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            let itemIndex = 1;

            // ------------------------------
            // SERVICE ITEMS LOGIC
            // ------------------------------

            // Add Item
            $('#add-item-btn').on('click', function() {
                let html = `
                <tr class="item-row" data-item-index="${itemIndex}">
                    <td>
                        <input type="text" name="items[${itemIndex}][service_name]" class="form-control form-control-sm" placeholder="{{ trans('back.service') }}" required>
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
            $('body').on('input', '.item-quantity, .item-price', function() {
                let row = $(this).closest('.item-row');
                let quantity = parseFloat(row.find('.item-quantity').val()) || 0;
                let price = parseFloat(row.find('.item-price').val()) || 0;
                let total = quantity * price;
                row.find('.item-total').val(total.toFixed(3));
                recalculateAll();
            });

            // Update tax when percentage changes or discount changes
            $('body').on('input', '.tax-percentage, .discount-input', function() {
                recalculateAll();
            });

            // Calculate Subtotal
            function calculateSubtotal() {
                let subtotal = 0;
                $('.item-row').each(function() {
                    let quantity = parseFloat($(this).find('.item-quantity').val()) || 0;
                    let price = parseFloat($(this).find('.item-price').val()) || 0;
                    subtotal += quantity * price;
                });
                return subtotal;
            }

            // Calculate Tax
            function calculateTax() {
                let subtotal = calculateSubtotal();
                let discount = parseFloat($('.discount-input').val()) || 0;
                let subtotalAfterDiscount = subtotal - discount;
                let taxPercentage = parseFloat($('.tax-percentage').val()) || 0;
                return (subtotalAfterDiscount * taxPercentage / 100);
            }

            // Calculate Total
            function calculateTotal() {
                let subtotal = calculateSubtotal();
                let discount = parseFloat($('.discount-input').val()) || 0;
                let tax = calculateTax();
                return subtotal - discount + tax;
            }

            // Recalculate All
            function recalculateAll() {
                let subtotal = calculateSubtotal();
                let tax = calculateTax();
                let total = calculateTotal();

                $('.subtotal').val(subtotal.toFixed(3));
                $('.tax').val(tax.toFixed(3));
                $('.total').val(total.toFixed(3));
            }

        });
    </script>
@endsection
