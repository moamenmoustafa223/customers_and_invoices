<div class="modal fade" id="delete_customer{{ $customer->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('back.delete_customer') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('customers.destroy', $customer->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="text-center">
                        <h4>{{ trans('back.are_you_sure') }}<br><br>{{ $customer->name }}</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{ trans('back.close') }}</button>
                        <button type="submit" class="btn btn-danger">{{ trans('back.delete') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
