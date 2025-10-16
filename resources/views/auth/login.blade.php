<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-center mb-6">Login</h2>

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Email</label>
                <input type="email" name="email" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-indigo-200" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-1">Password</label>
                <input type="password" name="password" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-indigo-200" required>
            </div>
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">Login</button>
        </form>
    </div>

</body>
</html>
