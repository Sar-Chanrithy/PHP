<main>
    <h2>User Created Successfully in Database!</h2>
    <ul>
        <li><strong>ID:</strong> {{ $user->id }}</li>
        <li><strong>Name:</strong> {{ $user->name }}</li>
        <li><strong>Email:</strong> {{ $user->email }}</li>
        <li><strong>Created At:</strong> {{ $user->created_at }}</li>
    </ul>
    <a href="{{ route('create') }}">Back to Form</a>
</main>