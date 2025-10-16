@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4">Order #{{ $order->id }}</h2>

<p><strong>Customer:</strong> {{ $order->user->name }} | <strong>Vendor:</strong> {{ $order->vendor->name }}</p>
<p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
<p><strong>Total:</strong> ₹{{ $order->total }}</p>
<p><strong>Payment Status:</strong> {{ $order->payment->status ?? 'N/A' }}</p>

<h3 class="mt-4 font-bold">Items</h3>
<table class="w-full border">
    <thead>
        <tr>
            <th class="border px-2 py-1">Product</th>
            <th class="border px-2 py-1">Quantity</th>
            <th class="border px-2 py-1">Price</th>
            <th class="border px-2 py-1">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->items as $item)
            <tr>
                <td class="border px-2 py-1">{{ $item->product->name }}</td>
                <td class="border px-2 py-1">{{ $item->quantity }}</td>
                <td class="border px-2 py-1">₹{{ $item->price }}</td>
                <td class="border px-2 py-1">₹{{ $item->quantity * $item->price }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
