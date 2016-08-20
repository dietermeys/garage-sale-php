@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{!! $thread->subject !!}</div>

                    <div class="panel-body">
                        @foreach($thread->messages as $message)
                            <div class="media">
                                <div class="media-body">
                                    <h5 class="media-heading">{!! $message->user->name !!}</h5>
                                    <p>{!! $message->body !!}</p>
                                    <div class="text-muted"><small>Posted {!! $message->created_at->diffForHumans() !!}</small></div>
                                </div>
                            </div>
                        @endforeach

                        <h2>Add a new message</h2>
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('messages.update', $thread) }}"
                              name="messages.update" enctype="multipart/form-data">
                            {{ method_field('PUT') }}
                            {{ csrf_field() }}

                        <div class="form-group">
                            <textarea id="message" class="form-control" name="message"></textarea>
                        </div>

                        <div class="form-group">
                            <button type="Submit" class="btn btn-primary form-control">
                                <i class="fa fa-btn fa-user"></i> Send
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection