@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $product->title }}</div>

                    <div class="panel-body">
                        <ul>

                                <li>{{ $product->summary }}</li>
                                <li>{{ $product->price }}</li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection