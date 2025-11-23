<!-- Modal -->
<div class="modal fade" id="delete_invoice{{$invoice->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('back.delete_invoice')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-left">

                <form action="{{route('invoices.destroy', $invoice->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="text-center">

                        <h4>
                            {{trans('back.Are_you_sure_to_delete')}}
                        </h4>

                        <div class="alert alert-warning mt-3">
                            <strong>{{trans('back.invoice_number')}}:</strong> {{ $invoice->invoice_number }}
                            <br>
                            <strong>{{trans('back.customer')}}:</strong> {{ $invoice->customer->name }}
                            <br>
                            <strong>{{trans('back.total')}}:</strong> {{ number_format($invoice->total, 3) }}
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{trans('back.Close')}}</button>
                        <button type="submit" class="btn btn-danger">{{trans('back.Delete')}}</button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
