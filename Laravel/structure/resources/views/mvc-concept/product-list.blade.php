<main>
    <h1>Product page</h1>
    @foreach ($products as $products)
        <li>{{ $products['id'] }}</li>
        <li>{{ $products['title'] }}</li>
        <li>{{ $products['price'] }}</li>
        <li>{{ $products['qty'] }}</li>
        <li>
            <img src="{{ $products['image'] }}" width="100px" alt="">
        </li>
        <li>{{ $products['description'] }}</li> 
    
    @endforeach
</main>