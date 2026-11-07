<main>
    <form action="{{ route('store') }}" method="post">
        @csrf
        <h1>Form Submit</h1>
        <input type="text" id="name" name="name"> <br>
        <input type="text" id="email" name="email"> <br>
        <input type="password" id="password" name="password" required><br>
        <button type="submit">Submit</button>
        </form>
</main>