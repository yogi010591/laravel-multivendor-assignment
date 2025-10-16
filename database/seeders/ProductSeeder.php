<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $vendors = Vendor::all();

        foreach ($vendors as $vendor) {
            for ($i = 1; $i <= 2; $i++) {
                Product::create([
                    'name' => "Product {$i} by {$vendor->business_name}",
                    'price' => rand(500, 2000),
                    'stock' => rand(5, 50),
                    'vendor_id' => $vendor->id,
                ]);
            }
        }
    }
}
