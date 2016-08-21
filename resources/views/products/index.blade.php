@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                <div class="panel panel-info">
                    <div class="panel-heading"><h3>Overview of products</h3></div>
                    <div class="search">
                        @include('products.partial.search', compact('search'))
                    </div>
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
                            {{ $products->appends(\Request::only([
                                    'search', 'price_start', 'price_end', 'category_id', 'distance'
                                ]))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection