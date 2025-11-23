<!-- Modal -->
<div class="modal fade" id="add_payment_method" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('payment_methods.Add_New_payment_methods')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action=" {{ route('PaymentMethod.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="name_ar">{{trans('payment_methods.name_ar')}} </label>
                            <b class="text-danger">*</b>
                            <input type="text" class="form-control"   name="name_ar" placeholder="{{trans('payment_methods.name_ar')}}" value="{{ old('name_ar') }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="name_en">{{trans('payment_methods.name_en')}} </label>
                            <b class="text-danger">*</b>
                            <input type="text" class="form-control"   name="name_en" placeholder="{{trans('payment_methods.name_en')}}" value="{{ old('name_en') }}">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{trans('customers.Close')}}</button>
                        <button type="submit" class="btn btn-success">{{trans('customers.Add')}}</button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
