@extends('layouts.app')

@section('content')
<?php
$favoriteClass = $product->isFavorited ? 'fa-star' : 'fa-star-o';
$favoriteClassButton = $product->isFavorited ? 'favorite' : 'notfavorite';
?>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-success product" data-id="{{ $product->id }}">
                    <div class="panel-heading" style="height: 75px;">
                        <h3 class="pull-left">{{ $product->title }}</h3>

                        <button type="button" class="btn btn-default btn-lg pull-right favorite_toggle pull-right {{ $favoriteClassButton }}" aria-label="Left Align">
                            <i class="fa {{ $favoriteClass }}" aria-hidden="true"></i>
                        </button>
                    </div>

                    <div class="panel-body">
                        <div class="col-md-6">
                        <ul>
                            <li><strong>Summary:</strong></li>
                            <li>{{ $product->summary }}</li><br />
                            <li><strong>Category:</strong></li>
                            <li>{{ $product->category->name }}</li><br />
                            <li><strong>Price:</strong></li>
                            <li>{{ money_format('%i', $product->price) }} €</li><br />
                            <li><strong>Date added:</strong></li>
                            <li>{{ $product->created_at->format('d-m-Y') }}</li><br />
                            <li><strong>Seller:</strong></li>
                            <li>{{ $product->seller->name }}</li><br />
                            <li><strong>Distance:</strong></li>
                            <li>{{ number_format($product->distance / 1000, 2) }}km</li><br />
                        </ul>
                        </div>
                        <div class="col-md-6">
                            <ul>
                            <li><strong>Images:</strong></li><br />
                            @foreach($product->photos->chunk(2) as $chunk)
                                <div class="row">
                                    @foreach($chunk as $image)
                                        <div class="col-md-6">
                                            <a href="#" class="pop">
                                                <img src="/images/products/{{$image->filename}}" alt=""><br /><br />
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                            </ul>
                            <!-- Creates the bootstrap modal where the image will appear -->

                            <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <img src="" class="imagepreview" style="width: 100%;" >
                                        </div>
                                    </div>
                                </div>
                        </div>
                        @if(Auth::user()->id == $product->user_id)
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('products.destroy', $product) }}"
                              name="products.store" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <div class="form-group">
                                <div class="col-md-6">
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
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fa fa-btn fa-user"></i> Edit
                                    </button>
                                </div>
                            </div>
                        </form>
                        @else
                            <form class="form-horizontal" role="form" method="POST" action="{{ route('messages.create', $product->seller) }}"
                                  name="products.store" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('GET') }}
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fa fa-btn fa-user"></i> Send message
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
</div>
<script src="/js/products/imagepreview.js"></script>
@endsection