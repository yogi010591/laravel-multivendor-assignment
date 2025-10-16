@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4">
    {{-- Dashboard Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Vendor Dashboard</h1>
            <p class="text-gray-600">Welcome, {{ Auth::user()->name }} 👋</p>
        </div>
    </div>

    {{-- Products Table --}}
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Your Products</h2>

        @if($products->count())
            <table class="w-full table-auto border border-gray-200">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">Name</th>
                        <th class="px-4 py-2 border">Price</th>
                        <th class="px-4 py-2 border">Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 border">{{ $product->name }}</td>
                            <td class="px-4 py-2 border">{{ number_format($product->price, 2) }}</td>
                            <td class="px-4 py-2 border">{{ $product->stock }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-600">You have no products yet.</p>
        @endif
    </div>
</div>
@endsection
