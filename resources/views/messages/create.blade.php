@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-warning">
                    <div class="panel-heading">Create new message</div>
                    <div class="panel-body">
                        <div class="col-md-6 col-md-offset-3">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('messages.store') }}"
                              name="messages.store" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <input type="hidden" name="recipients[]" value="{{ $recipient->id }}">

                            <div class="form-group">
                                <label for="subject" class="control-label">Subject</label>
                                <input type="text" id="subject" class="form-control" name="subject">
                            </div>

                            <div class="form-group">
                                <label for="message" class="control-label">Message</label>
                                <textarea id="message" class="form-control" name="message"></textarea>
                                <p>Send to: {{ $recipient->name }}</p>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-warning">
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