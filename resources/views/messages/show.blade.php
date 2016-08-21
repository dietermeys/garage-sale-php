@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-warning">
                    <div class="panel-heading"><h4>{!! $thread->subject !!}</h4></div>

                    <div class="panel-body">
                        @foreach($thread->messages as $message)
                            <div class="media">
                                <div class="media-body">
                                    <h4>{!! $message->body !!}</h4>
                                    <p>{!! $message->user->name !!}</p>
                                    <div class="text-muted"><small>Posted {!! $message->created_at->diffForHumans() !!}</small></div>
                                </div>
                            </div>
                            <hr>
                        @endforeach

                        <h2>Add a new message</h2>
                            <div class="col-md-6">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('messages.update', $thread) }}"
                              name="messages.update" enctype="multipart/form-data">
                            {{ method_field('PUT') }}
                            {{ csrf_field() }}

                        <div class="form-group">
                            <textarea id="message" class="form-control" name="message"></textarea>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                            <button type="Submit" class="btn btn-warning form-control">
                                <i class="fa fa-paper-plane-o" aria-hidden="true"></i> Send
                            </button>
                            </div>
                        </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection