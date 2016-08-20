@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Overview of products</div>

                    <div class="panel-body">

                        <form class="form-inline" role="form" method="GET" action="{{ route('products.index') }}">
                            <div class="form-group">
                                <label class="sr-only" for="search">Search</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                    </div>
                                    <input type="text" class="form-control" id="search" placeholder="Search"
                                           value="{{ \Request::get('search') }}"
                                           name="search"
                                    >
                                </div>
                            </div>
                            <button type="submit" class="btn btn-default">Search</button>
                        </form>

                        @foreach($products->chunk(2) as $chunk)
                            <div class="row">
                                @foreach($chunk as $product)
                                    <div class="col-md-6">
                                        @include('products.partial.product', compact('product'))
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                        {{ $products->appends(\Request::only('search'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/js/favorite.js"></script>
@endsection