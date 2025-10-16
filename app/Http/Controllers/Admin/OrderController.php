<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'vendor', 'items.product']);

        // Filter by vendor
        if ($request->vendor_id) {
            $query->where('vendor_id', $request->vendor_id);
        }

        // Filter by customer
        if ($request->customer_id) {
            $query->where('user_id', $request->customer_id);
        }

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15);

        $vendors = User::where('role', 'vendor')->get();
        $customers = User::where('role', 'customer')->get();

        return view('admin.orders.index', compact('orders', 'vendors', 'customers'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'vendor', 'items.product', 'payment']);
        return view('admin.orders.show', compact('order'));
    }
}
