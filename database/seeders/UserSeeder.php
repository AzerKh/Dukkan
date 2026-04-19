<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
    'name' => 'Admin',
    'email' => 'admin@ecommerce.com',
    'password' => Hash::make('password'),
    'email_verified_at' => now(),
    'role' => 'admin',
]);

        // Vendeur 1
        User::create([
            'name' => 'Jean Dupont',
            'email' => 'jean@ecommerce.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Vendeur 2
        User::create([
            'name' => 'Marie Martin',
            'email' => 'marie@ecommerce.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Client
        User::create([
            'name' => 'Client Test',
            'email' => 'client@ecommerce.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }
}