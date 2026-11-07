<main>

    <form action="{{ route('upload') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="text" name="title" placeholder="title"><br>
        @error('title')
            <p>{{ $message }}</p>
        @enderror
        <input type="file" name="image"><br>
        @error('image')
            <p>{{ $message }}</p>
        @enderror
        <button type="submit">submit</button>
    </form>
    <hr>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif
    @if (session('data'))
        <p>{{ session('data')['title'] }}</p>

        <img src="{{ asset('storage/' . session('data')['image']) }}" alt="Product Image" width="200">
    @endif
</main>
