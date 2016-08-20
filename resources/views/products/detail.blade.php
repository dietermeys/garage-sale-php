@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $product->title }}</div>

                    <div class="panel-body">
                        <ul>
                            <li>Title: {{ $product->title }}</li>
                            <li>Summary: {{ $product->summary }}</li>
                            <li>Seller: {{ $product->seller->name }}</li>
                            <li>Category: {{ $product->category->name }}</li>
                            <li>Date: {{ $product->created_at->format('d-m-Y H:i') }}</li>
                            <li>Price: € {{ money_format('%i', $product->price) }}</li>
                            <li>Images:</li>
                            @foreach($product->photos->chunk(4) as $chunk)
                                <div class="row">
                                    @foreach($chunk as $image)
                                        <div class="col-md-3">
                                            <img src="/images/products/{{$image->filename}}" alt="">
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </ul>
                        @if(Auth::user()->id == $product->user_id)
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('products.destroy', $product) }}"
                              name="products.store" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-btn fa-user"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </form>
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('products.edit', $product) }}"
                              name="products.store" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('GET') }}
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fa fa-btn fa-user"></i> Edit
                                    </button>
                                </div>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection