<main>
    @if($product)
        <ul>
            <li>{{ $product->id }}</li>
            <li>{{ $product->name }}</li>
            <li>{{ $product->price }}</li>
            <li>{{ $product->qty }}</li>
            <li>{{ $product->description }}</li>
        </ul>
    @else
        <p>Product not found.</p>
    @endif
</main> 