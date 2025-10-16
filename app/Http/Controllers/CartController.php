<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // View Cart
    public function viewCart()
    {
        $cart = Session::get('cart', []);

        // Add current stock for each cart item
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            $cart[$id]['stock'] = $product ? $product->stock : 0;
        }

        return view('cart.index', compact('cart'));
    }


    // Add Product to Cart
    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $quantity = $request->input('quantity', 1);

        if ($quantity > $product->stock) {
            return redirect()->back()->with('error', 'Quantity exceeds available stock.');
        }

        $cart = session('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
            if ($cart[$id]['quantity'] > $product->stock) {
                $cart[$id]['quantity'] = $product->stock;
            }
        } else {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'vendor_id' => $product->vendor_id,   // ← Add this
                'vendor' => $product->vendor->shop_name,
                'stock' => $product->stock,           // Keep stock for front-end validation
            ];
        }

        session(['cart' => $cart]);

        return redirect()->back()->with('success', 'Product added to cart.');
    }


    // Update single product quantity
    public function updateQuantity(Request $request, $id)
    {
        $quantity = $request->input('quantity', 1);
        $cart = Session::get('cart', []);
        $product = Product::findOrFail($id);

        if ($quantity > $product->stock) {
            $quantity = $product->stock;
        }

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
            Session::put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Cart updated.');
    }

    // Update all quantities at once
    public function updateAll(Request $request)
    {
        $quantities = $request->input('quantities', []);
        $cart = Session::get('cart', []);

        foreach ($quantities as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product && isset($cart[$productId])) {
                // Ensure quantity does not exceed stock
                $cart[$productId]['quantity'] = min(max(1, (int)$quantity), $product->stock);
            }
        }

        Session::put('cart', $cart);

        return redirect()->back()->with('success', 'Cart updated successfully.');
    }

    public function checkout(Request $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Cart is empty.');
        }

        $user = auth()->user();

        // Group items by vendor
        $vendors = [];
        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            if (!$product) continue;

            // Validate stock
            if ($item['quantity'] > $product->stock) {
                return redirect()->back()->with('error', "Quantity for {$product->name} exceeds stock.");
            }

            $vendors[$item['vendor_id']][] = [
                'product' => $product,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ];
        }

        foreach ($vendors as $vendorId => $items) {
            $total = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $items));

            $order = \App\Models\Order::create([
                'user_id' => $user->id,
                'vendor_id' => $vendorId,
                'total' => $total,
                'status' => 'pending',
            ]);

            foreach ($items as $i) {
                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $i['product']->id,
                    'quantity' => $i['quantity'],
                    'price' => $i['price'],
                ]);

                // Deduct stock
                $i['product']->decrement('stock', $i['quantity']);
            }

            // Create payment
            \App\Models\Payment::create([
                'order_id' => $order->id,
                'status' => 'paid',
                'transaction_id' => 'TXN' . time(),
            ]);
        }

        // Clear cart
        session()->forget('cart');

        return redirect()->route('products.index')->with('success', 'Order placed successfully!');
    }

}
