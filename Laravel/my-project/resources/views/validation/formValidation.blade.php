<main>
    @if (session('success'))
        <p style="color: greenyellow">{{ session('success') }}</p>
    @endif

    <form action="{{ route('validation') }}" method="post">
        @csrf
        <h1>validation form</h1>
        <input type="text" name="title" value="{{ old('title') ?? '' }}" placeholder="title"><br>
        @error('title')
            <p style="color: red">{{ $message }}</p>
        @enderror
        <input type="number" name="price" value="{{ old('price') ?? '' }}" placeholder="price"><br>
        @error('price')
            <p style="color: red">{{ $message }}</p>
        @enderror
        <input type="number" name="qty" value="{{ old('qty') ?? '' }}" placeholder="qty"><br>
        @error('qty')
            <p style="color: red">{{ $message }}</p>
        @enderror
        <textarea name="description" placeholder="description">{{ old('description') }}</textarea><br><br>

        <button type="submit">submit</button>
    </form>
    <hr>

    @if (session('product'))
        <ul>
            <li>Title: {{ session('product')['title'] }}</li>
            <li>Price: {{ session('product')['price'] }}</li>
            <li>Quantity: {{ session('product')['qty'] }}</li>
            <li>Description: {{ session('product')['description'] }}</li>
        </ul>
    @endif
</main>
