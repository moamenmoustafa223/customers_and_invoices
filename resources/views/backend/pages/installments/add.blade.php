<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('payments.store') }}" method="POST" class="text-left" id="paymentForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="paymentModalLabel">{{ trans('back.add_payment') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('back.close') }}"></button>
                </div>

                <div class="modal-body row">
                    {{-- Hidden fields --}}
                    <input type="hidden" name="student_id" id="modal_student_id">
                    <input type="hidden" name="academic_year_id" id="modal_academic_year_id">
                    <input type="hidden" name="classroom_id" id="modal_classroom_id">
                    <input type="hidden" name="students_contract_id" id="modal_contract_id">
                    <input type="hidden" id="total_amount_with_tax">
                    <input type="hidden" name="installment_id" id="installment_id">
                    
                    

                    {{-- Payment fields --}}
                    <div class="form-group col-md-2">
                        <label>{{ trans('back.payment_amount') }} <b class="text-danger">*</b></label>
                        <input type="number" step="any" class="form-control" name="payment_amount" id="payment_amount" required>
                    </div>

                    <div class="form-group col-md-2">
                        <label>{{ trans('back.rest_amount') }} <b class="text-danger">*</b></label>
                        <input type="number" step="any" class="form-control" name="rest_amount" id="rest_amount" readonly>
                    </div>

                    <div class="form-group col-md-3">
                        <label>{{ trans('back.payment_date') }} <b class="text-danger">*</b></label>
                        <input type="date" class="form-control" name="payment_date" id="payment_date" value="{{ date('Y-m-d') }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label>{{ trans('back.select_payment_method') }} <b class="text-danger">*</b></label>
                        <select class="form-control" name="payment_method_id" required>
                            <option value="">{{ trans('back.select_payment_method') }}</option>
                            @foreach(App\Models\Payment_method::all() as $method)
                                <option value="{{ $method->id }}">
                                    {{ app()->getLocale() == 'ar' ? $method->name_ar : $method->name_en }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label>{{ trans('back.check_number_if_any') }}</label>
                        <input type="text" class="form-control" name="check_number" placeholder="{{ trans('back.check_number') }}">
                    </div>

                    <div class="form-group col-md-12 mt-2">
                        <label>{{ trans('back.payment_about') }}</label>
                        <input type="text" class="form-control" name="payment_about" id="payment_about">
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> {{ trans('back.Add') }}
                        </button>
                    </div>

                    <div class="col-md-12">
                        <hr>
                        <h5 class="text-primary">{{ trans('back.previous_payments') }}</h5>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered text-center mb-0">
                                <thead style="background:#f3f9fc;">
                                    <tr>
                                        <th>{{ trans('back.amount') }}</th>
                                        <th>{{ trans('back.payment_method') }}</th>
                                        <th>{{ trans('back.about') }}</th>
                                        <th>{{ trans('back.date') }}</th>
                                        <th>{{ trans('back.action') }}</th>
                                        <th>{{ trans('back.delete') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="installment-payments-table-body">
                                    <tr><td colspan="6" class="text-muted">لا توجد دفعات</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">{{ trans('back.cancel') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>