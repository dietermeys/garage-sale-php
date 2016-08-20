@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Overview of products</div>

                    <div class="panel-body">

                        <form class="form-inline" role="form" method="GET">
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
                            <div class="form-group">
                                <label class="sr-only" for="price_start">Price start</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                    </div>
                                    <input type="text" class="form-control" id="price_start" placeholder="5.00"
                                           value="{{ \Request::get('price_start') }}"
                                           name="price_start"
                                    >
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="sr-only" for="price_end">Price end</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                    </div>
                                    <input type="text" class="form-control" id="price_end" placeholder="10.00"
                                           value="{{ \Request::get('price_end') }}"
                                           name="price_end"
                                    >
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="sr-only" for="category_id">Category</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                    </div>

                                    <select id="category_id" class="form-control" name="category_id"
                                            value="{{ \Request::get('category_id') }}">
                                        <option value="">-- Choose --</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}"
                                                    @if ($category->id == old('category_id'))
                                                    selected
                                                    @endif
                                            >{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="sr-only" for="distance">Distance</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                    </div>
                                    <input type="text" class="form-control" id="distance" placeholder="15"
                                           value="{{ \Request::get('distance') }}"
                                           name="distance"
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
                        {{ $products->appends(\Request::only([
                                'search', 'price_start', 'price_end', 'category_id', 'distance'
                            ]))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection