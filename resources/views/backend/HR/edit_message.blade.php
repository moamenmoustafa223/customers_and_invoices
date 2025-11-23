<!-- Modal -->
<div class="modal fade" id="edit_message{{$message->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('messages.Edit_Status')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-left">

                <form action="{{route('edit_messages_status', $message->id)}}" method="post">
                    @csrf
                    @method('PUT')

                    <input type="hidden" class="form-control"  name="employee_id" value="{{$message->employee_id}}" >
                    <input type="hidden" class="form-control"  name="title" value="{{$message->title}}" >
                    <input type="hidden" class="form-control"  name="notes" value="{{$message->notes}}" >

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="gender">{{trans('messages.select_Status')}}</label>
                                <select name="status" class="form-control">
                                    <option value="0" {{ old('status', $message->status) == 0 ? 'selected' : null }}>{{trans('messages.New')}}</option>
                                    <option value="1" {{ old('status', $message->status) == 1 ? 'selected' : null }}>{{trans('messages.Complete')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="reply"> {{trans('back.reply')}}</label>
                            <textarea class="form-control" name="reply" rows="5"> {{$message->reply}}</textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{trans('back.close')}} </button>
                        <button type="submit" class="btn btn-success">{{trans('back.Save')}}</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
