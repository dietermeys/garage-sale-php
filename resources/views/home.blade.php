@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Show nearby products. Distance range is 15km.</h3></div>

                <div class="panel-body">
                    @foreach($products->chunk(2) as $chunk)
                        <div class="row">
                            @foreach($chunk as $product)
                                <div class="col-md-6">
                                    @include('products.partial.product', compact('product'))
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
