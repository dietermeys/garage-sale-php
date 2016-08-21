<?php
 $favoriteClass = $product->isFavorited ? 'fa-star' : 'fa-star-o';
 $favoriteClassButton = $product->isFavorited ? 'favorite' : 'notfavorite';
?>
<div class="panel panel-success panel-success1 product" data-id="{{ $product->id }}">
    <div class="panel-heading" style="height: 50px;">{{ $product->title }}

        <button type="button" class="btn btn-default btn-sm pull-right favorite_toggle {{ $favoriteClassButton }}" aria-label="Left Align">
            <i class="fa {{ $favoriteClass }}" aria-hidden="true"></i>
        </button>
    </div>

    <div class="panel-body">
        <ul>
            <li><strong>Summary:</strong></li>
            <li>{{ str_limit($product->summary, 100) }}</li>
            <li><strong>Category:</strong></li>
            <li>{{ $product->category->name }}</li>
            <li><strong>Price:</strong></li>
            <li>{{ money_format('%i', $product->price) }} €</li>
            <li><strong>Distance:</strong></li>
            <li>{{ number_format($product->distance / 1000, 2) }}km</li>
            <li><strong>Images:</strong></li>
            @foreach($product->photos->take(4)->chunk(4) as $chunk)
                <div class="row">
                    @foreach($chunk as $image)
                        <div class="col-md-3" style="max-height: 100px;">
                            <img src="/images/products/{{$image->filename}}" alt="{{$image->filename}}" class="imgkl">
                        </div>
                    @endforeach
                </div>
            @endforeach
        </ul>
        <form class="form-horizontal" role="form" method="POST" action="{{ route('products.show', $product) }}"
              name="products.store" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('GET') }}
            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-info">
                        More >>>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>