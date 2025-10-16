@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4">All Orders</h2>

<form method="GET" class="mb-4 flex gap-2">
    <select name="vendor_id" class="border p-1">
        <option value="">All Vendors</option>
        @foreach($vendors as $vendor)
            <option value="{{ $vendor->id }}" {{ request('vendor_id')==$vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
        @endforeach
    </select>

    <select name="customer_id" class="border p-1">
        <option value="">All Customers</option>
        @foreach($customers as $customer)
            <option value="{{ $customer->id }}" {{ request('customer_id')==$customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
        @endforeach
    </select>

    <select name="status" class="border p-1">
        <option value="">All Status</option>
        <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
        <option value="completed" {{ request('status')=='completed' ? 'selected' : '' }}>Completed</option>
        <option value="cancelled" {{ request('status')=='cancelled' ? 'selected' : '' }}>Cancelled</option>
    </select>

    <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded">Filter</button>
</form>

<table class="w-full border">
    <thead>
        <tr>
            <th class="border px-2 py-1">Order ID</th>
            <th class="border px-2 py-1">Customer</th>
            <th class="border px-2 py-1">Vendor</th>
            <th class="border px-2 py-1">Total</th>
            <th class="border px-2 py-1">Status</th>
            <th class="border px-2 py-1">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
            <tr>
                <td class="border px-2 py-1">{{ $order->id }}</td>
                <td class="border px-2 py-1">{{ $order->user->name }}</td>
                <td class="border px-2 py-1">{{ $order->vendor->name }}</td>
                <td class="border px-2 py-1">₹{{ $order->total }}</td>
                <td class="border px-2 py-1">{{ ucfirst($order->status) }}</td>
                <td class="border px-2 py-1">
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-600">View</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $orders->withQueryString()->links() }}
@endsection
