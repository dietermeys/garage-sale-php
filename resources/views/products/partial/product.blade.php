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
    </div>
</div>