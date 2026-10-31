<main>
    <table border="1">
            <thead>
                <tr>
                    <th>id</th>
                    <th>title</th>
                    <th>price</th>
                    <th>qty</th>
                    <th>image</th>
                    <th>description</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product['id'] }}</td>
                        <td>{{ $product['title'] }}</td>
                        <td>{{ $product['price'] }}</td>
                        <td>{{ $product['qty'] }}</td>
                        <td><img src="{{ $product['image'] }}" width="100" alt="{{ $product['title'] }}"></td>
                        <td>{{ $product['description'] }}</td>
                    </tr>
                @endforeach
            </tbody>
    </table>
</main>