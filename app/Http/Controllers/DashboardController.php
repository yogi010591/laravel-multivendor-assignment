<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function admin()
    {
        return view('dashboard.admin');
    }

    public function vendor()
    {
        $vendorId = Auth::id(); // Assuming users with role 'vendor' have products linked to their user_id
        $products = Product::where('vendor_id', $vendorId)->get();

        return view('dashboard.vendor', compact('products'));
    }

    public function customer()
    {
        return view('dashboard.customer');
    }
}
