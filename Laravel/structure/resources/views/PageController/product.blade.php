<main>
    <h1>Product Page</h1>
    @foreach ($products as $product)
        <li>{{ $product['id'] }}</li>
        <li>{{ $product['title'] }}</li>
        <li>{{ $product['price'] }}</li>
        <li>{{ $product['qty'] }}</li>
        <li>
            <img src="{{ $product['image'] }}" width="100px" alt="">
        </li>
        <li>{{ $product['description'] }}</li>
    @endforeach
    <a href="{{ route('home') }}">home</a>
</main>