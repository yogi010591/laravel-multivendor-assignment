@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-10">
  <h2 class="text-2xl font-bold mb-5">Products</h2>

  <div class="grid grid-cols-3 gap-6">
    @foreach ($products as $product)
      <div class="border rounded-lg p-4 shadow">
        <h3 class="font-semibold text-lg">{{ $product->name }}</h3>
        <p class="text-gray-600">₹{{ $product->price }}</p>
        <p class="text-sm text-gray-500">Stock: {{ $product->stock }}</p>
        <p class="text-sm text-gray-500">Vendor: {{ $product->vendor->shop_name }}</p>

        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-2">
          @csrf
          <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="border p-1 w-16">
          <button class="bg-blue-600 text-white px-3 py-1 rounded">Add to Cart</button>
        </form>
      </div>
    @endforeach
  </div>

  <div class="mt-6">{{ $products->links() }}</div>
</div>
@endsection
