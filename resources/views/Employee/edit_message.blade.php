@extends('Employee.layouts.master')

@section('pageTitle')
    {{trans('messages.Edite_Message')}}
@endsection

@section('title_page')
    {{trans('messages.Edite_Message')}}
@endsection


@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card-box">

                <form action="{{route('Messages.update', $message->id)}}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <input type="hidden" class="form-control" name="employee_id" value="{{$message->employee_id}}">
                        <input type="hidden" class="form-control" name="reply" value="{{$message->reply}}">

                        <div class="form-group col-md-12">
                            <label for="title"> {{trans('messages.Message_title')}} </label>
                            <input type="text" class="form-control" placeholder="{{trans('messages.Message_title')}} "
                                   name="title" value="{{$message->title}}" required>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="notes"> {{trans('messages.Message_text')}}</label>
                            <textarea class="form-control" name="notes" rows="8">{{$message->notes}}</textarea>
                        </div>

                    </div>

                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-success"> {{trans('messages.Edite_Message')}} </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection
