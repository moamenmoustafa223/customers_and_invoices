<!-- Modal -->
<div class="modal fade" id="message_details{{$message->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> {{trans('messages.Message_details')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class=" text-center">
                            <h4>
                                <span class="text-danger font-weight-bold"> {{trans('messages.Employee_Name')}} :</span>
                                {{$message->employee->name_ar}}
                            </h4>
                            <h4>
                                <span class="text-danger font-weight-bold"> {{trans('messages.Message_title')}} :</span>
                                {{$message->title}}
                            </h4>

                            <h4>
                                <span class="text-danger font-weight-bold"> {{trans('messages.Date_Message')}} :</span>
                                {{$message->created_at}}
                            </h4>

                            <br>
                            <p>
                                <span class="text-danger font-weight-bold"> {{trans('messages.Message_details')}} :</span>
                                <br>
                                {!! $message->notes !!}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{trans('back.close')}} </button>
                </div>

            </div>
        </div>
    </div>
</div>
