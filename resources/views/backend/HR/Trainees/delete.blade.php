<!-- Modal -->
<div class="modal fade" id="delete_trainee{{$trainee->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('trainees.delete_trainee')}} </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action="{{route('Trainees.destroy', $trainee->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="text-center" >

                        <h4>
                            {{trans('trainees.Are you sure to delete?')}}
                            <br>
                            <br>
                            {{$trainee->name_ar}} / {{$trainee->name_en}}
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
