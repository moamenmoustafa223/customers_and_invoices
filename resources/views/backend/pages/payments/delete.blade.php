<!-- Modal -->
<div class="modal fade" id="delete_payment{{$payment->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " >
        <div class="modal-content" style=" margin-top: 50px; background-color: rgb(232,234,225)">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">  {{trans('back.Delete_Payment')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-left">

                <form action="{{route('payments.destroy', $payment->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="text-center" >

                        <h4>
                            {{trans('back.Are you sure to delete?')}}
                            <br>
                            <br>
                            {{$payment->payment_number}}
                        </h4>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> {{trans('back.Close')}}</button>
                        <button type="submit" class="btn btn-secondary"> {{trans('back.Delete')}}</button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
