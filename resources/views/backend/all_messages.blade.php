@extends('backend.layouts.master')

@section('page_title')
    {{ trans('messages.messages') }}
@endsection




@section('content')
    <div class="row">

        <div class="col-md-3 mb-1">
            <form action="{{ route('all_messages') }}" method="GET" role="search">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="query"
                        value="{{ old('query', request()->input('query')) }}" placeholder="search..." id="query">
                    <button class="btn btn-primary btn-sm ml-1" type="submit" title="Search">
                        <span class="fas fa-search"></span>
                    </button>
                    <a href="{{ route('all_messages') }}" class="btn btn-success btn-sm ml-1 " type="button"
                        title="Reload">
                        <span class="fas fa-sync-alt"></span>
                    </a>
                </div>
            </form>
        </div>

    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">


                <div class="table-responsive">
                    <table class="table text-center  table-bordered table-sm ">
                        <thead>
                            <tr style="background-color: rgb(232,245,252)">
                                <th>#</th>
                                <th> {{ trans('messages.Message_title') }}</th>
                                <th>{{ trans('messages.Employee_Name') }} </th>
                                <th>{{ trans('messages.Status') }} </th>
                                <th>{{ trans('messages.Date_Message') }}</th>
                                <th> {{ trans('messages.Actions') }}</th>
                            </tr>
                        </thead>

                        @php $i=1 @endphp
                        <tbody>
                            @foreach ($all_messages as $message)
                                <tr
                                    @if ($message->status == 0) style="background-color: #fcd8d8" @else style="background-color: #d0ffd2" @endif>
                                    <td>{{ $i++ }}</td>
                                    <td> {{ $message->title }}</td>
                                    <td>
                                        @if (app()->getLocale() == 'ar')
                                            {{ $message->employee->name_ar }} <br> {{ $message->employee->phone }}
                                        @else
                                            {{ $message->employee->name_en }} <br> {{ $message->employee->phone }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $message->status() }}
                                    </td>
                                    <td>{{ $message->created_at }}</td>
                                    <td class="text-center">

                                        {{-- Show Message --}}
                                        @can('all_messages_show')
                                            <a href="#" class="btn btn-info btn-sm mx-1"
                                                title="{{ trans('messages.Show_Message') }}" data-bs-toggle="modal"
                                                data-bs-target="#message_details{{ $message->id }}">
                                                <i class="fas fa-envelope-open-text"></i>
                                            </a>
                                        @endcan
                                        @include('backend.message_details')

                                        {{-- Edit Status --}}
                                        @can('all_messages_edit_status')
                                            <a href="#" class="btn btn-warning btn-sm mx-1"
                                                title="{{ trans('messages.Edit_Status') }}" data-bs-toggle="modal"
                                                data-bs-target="#edit_message_status{{ $message->id }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan
                                        @include('backend.edit_message_status')

                                        {{-- Reply --}}
                                        @can('all_messages_reply')
                                            <a href="#" class="btn btn-primary btn-sm mx-1"
                                                title="{{ trans('back.reply') }}" data-bs-toggle="modal"
                                                data-bs-target="#reply_message_{{ $message->id }}">
                                                <i class="fas fa-reply"></i>
                                            </a>
                                        @endcan

                                        <!-- Reply Modal -->
                                        <div class="modal fade" id="reply_message_{{ $message->id }}" tabindex="-1"
                                            aria-labelledby="replyLabel_{{ $message->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="replyLabel_{{ $message->id }}">
                                                            {{ trans('back.reply') }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('reply_message', $message->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="mb-3 text-start">
                                                                <label class="form-label">{{ trans('back.reply') }}</label>
                                                                <textarea class="form-control" name="reply" rows="4" required>{{ old('reply', $message->reply) }}</textarea>
                                                                <input type="hidden" name="status" value="1">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">{{ trans('back.close') }}</button>
                                                            <button type="submit"
                                                                class="btn btn-primary">{{ trans('back.save') }}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
