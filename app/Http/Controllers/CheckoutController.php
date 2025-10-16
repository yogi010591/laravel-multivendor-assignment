<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        // Validate stock for each item
        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            if (!$product) {
                return redirect()->back()->with('error', "Product {$item['name']} not found.");
            }
            if ($item['quantity'] > $product->stock) {
                return redirect()->back()->with('error', "Quantity for {$product->name} exceeds available stock.");
            }
        }

        // Split cart by vendor
        $vendorGroups = [];
        foreach ($cart as $item) {
            $vendorGroups[$item['vendor']][] = $item;
        }

        foreach ($vendorGroups as $vendorName => $items) {
            // Assume first item has vendor_id
            $firstItem = Product::find($items[0]['id']);
            $vendorId = $firstItem->vendor_id;

            // Calculate total for this vendor
            $total = 0;
            foreach ($items as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            // Create Order
            $order = Order::create([
                'user_id' => Auth::id(),
                'vendor_id' => $vendorId,
                'total' => $total,
                'status' => 'processing',
            ]);

            // Create OrderItems and deduct stock
            foreach ($items as $item) {
                $product = Product::find($item['id']);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);

                // Deduct stock
                $product->stock -= $item['quantity'];
                $product->save();
            }

            // Create Payment
            Payment::create([
                'order_id' => $order->id,
                'status' => 'paid',
                'transaction_id' => 'TXN' . time() . rand(1000, 9999),
            ]);
        }

        // Clear cart
        Session::forget('cart');

        return redirect()->route('products.index')->with('success', 'Checkout successful! Orders created for each vendor.');
    }
}
