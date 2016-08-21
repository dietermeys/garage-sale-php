@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-warning">
                    <div class="panel-heading">Overview of messages</div>

                    <div class="panel-body">
                        @if (Session::has('error_message'))
                            <div class="alert alert-danger" role="alert">
                                {!! Session::get('error_message') !!}
                            </div>
                        @endif
                        @if($threads->count() > 0)
                            @foreach($threads as $thread)
                                <?php $class = $thread->isUnread($currentUserId) ? 'alert-info' : ''; ?>
                                <div class="media alert {!!$class!!}">
                                    <p>
                                        <small><strong>From:</strong> {!! $thread->creator()->name !!}</small>
                                    </p>
                                    <h4 class="media-heading"><a href="{{url('messages/' . $thread->id)}}">{{ $thread->subject }}</a></h4>
                                    <p>{!! str_limit($thread->latestMessage->body,50) !!}</p>
                                    <p>
                                        <small>
                                            <strong>To:</strong> {!! $thread->originalRecipient()->name !!}
                                        </small>
                                    </p>
                                </div>
                                <hr>
                            @endforeach
                        @else
                            <p>No messages yet...</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection