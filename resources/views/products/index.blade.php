@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Overview of products</div>

                    <div class="panel-body">
                        <ul>
                        @foreach($products as $product)
                            <li>{{ $product->title }}</li>
                        @endforeach
                        </ul>
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection