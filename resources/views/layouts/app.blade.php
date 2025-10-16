<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Multi-Vendor App')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

    <nav class="bg-white shadow p-4">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <a href="{{ route('products.index') }}" class="text-xl font-bold">Multi-Vendor</a>
            <div class="space-x-4">
                @auth
                    @php
                        // Determine dashboard route based on user role
                        $dashboardRoute = match(auth()->user()->role) {
                            'admin' => route('dashboard.admin'),
                            'vendor' => route('dashboard.vendor'),
                            'customer' => route('dashboard.customer'),
                            default => route('products.index'),
                        };
                    @endphp

                    <a href="{{ $dashboardRoute }}" class="text-gray-700 hover:text-gray-900">Dashboard</a>
                @endauth

                

                {{-- Show Cart link only for customers --}}
                @auth
                    @if(auth()->user()->role === 'customer')
                        <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-gray-900">Products</a>
                        <a href="{{ route('cart.index') }}" class="text-gray-700 hover:text-gray-900">Cart</a>
                        
                    @endif
                @endauth

                @auth
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-gray-900">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900">Login</a>
                @endauth
            </div>

        </div>
    </nav>

    <main class="py-8">
        @yield('content')
    </main>

</body>
</html>
