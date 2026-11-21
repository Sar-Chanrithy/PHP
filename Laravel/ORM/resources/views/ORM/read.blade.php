<main>
    <table border="1" >
        <thead>
            <tr>
                th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->qty }}</td>
                <td>{{ $product->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</main>