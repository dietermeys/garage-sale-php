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
        </ul>
        <form class="form-horizontal" role="form" method="POST" action="{{ route('products.show', $product) }}"
              name="products.store" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('GET') }}
            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-info">
                        <i class="fa fa-btn fa-user"></i> More >>>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>