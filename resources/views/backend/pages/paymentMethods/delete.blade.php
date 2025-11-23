<!-- Modal -->
<div class="modal fade" id="delete_payment_method{{$payment_method->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('payment_methods.Delete_payment_methods')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action="{{route('PaymentMethod.destroy', $payment_method->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="text-center" >

                        <h4>
                            {{trans('customers.Are you sure to delete?')}}
                            <br>
                            <br>
                            {{$payment_method->name_ar}} /
                            {{$payment_method->name_en}}
                        </h4>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{trans('customers.Close')}} </button>
                        <button type="submit" class="btn btn-danger">{{trans('customers.Delete')}}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
