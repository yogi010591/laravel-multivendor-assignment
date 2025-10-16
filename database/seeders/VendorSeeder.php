<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    public function run(): void
    {
        $vendorUsers = User::where('role', 'vendor')->get();

        $count = 1;
        foreach ($vendorUsers as $user) {
            Vendor::create([
                'user_id' => $user->id,
                'business_name' => "Business {$count} - {$user->name}",
                'contact_number' => '98765' . rand(10000, 99999),
            ]);
            $count++;
        }
    }
}
