@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @foreach($products->chunk(2) as $chunk)
                        <div class="col-md-6">
                            @each('products.partial.product', $chunk, 'product')
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
