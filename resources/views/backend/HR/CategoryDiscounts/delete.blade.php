<!-- Modal -->
<div class="modal fade" id="delete_CategoryDiscounts{{$CategoryDiscounts->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('cat_discounts.delete_category')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action="{{route('CategoryDiscounts.destroy', $CategoryDiscounts->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="text-center" >

                        <h4>
                            {{trans('cat_discounts.Are you sure to delete?')}}
                            <br>
                            <br>
                            {{$CategoryDiscounts->name}}
                        </h4>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{trans('back.close')}} </button>
                        <button type="submit" class="btn btn-danger">{{trans('back.Delete')}}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
