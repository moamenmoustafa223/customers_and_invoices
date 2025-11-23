<!-- Modal -->
<div class="modal fade" id="delete_studentsContract{{$studentsContract->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg  ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> {{trans('back.delete_studentsContract')}} </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-left">

                <form action="{{route('studentsContracts.destroy', $studentsContract->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="text-center" >

                        <h4>
                            {{trans('back.Are_you_sure_to_delete')}}
                        </h4>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{trans('back.Close')}}</button>
                        <button type="submit" class="btn btn-secondary">{{trans('back.Delete')}}</button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
