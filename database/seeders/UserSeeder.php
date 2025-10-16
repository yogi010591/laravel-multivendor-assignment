<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create multiple Vendors
        for ($i = 1; $i <= 3; $i++) {
            User::create([
                'name' => "Vendor $i",
                'email' => "vendor{$i}@example.com",
                'password' => Hash::make('password'),
                'role' => 'vendor',
            ]);
        }

        // Create multiple Customers
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => "Customer $i",
                'email' => "customer{$i}@example.com",
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]);
        }
    }
}
