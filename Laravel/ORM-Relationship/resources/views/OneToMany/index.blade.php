<main>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Category</th>
                <th>Product Info</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>
                    @foreach($category->products as $product)
                        {{ $product->title }}<br>
                        {{ $product->price }}<br>
                        {{ $product->qty }}<br>
                    @endforeach
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</main>