<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Role: user
        User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'phone' => '081111111111',
            'image' => null,
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Role: admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'phone' => '082222222222',
            'image' => null,
            'password' => Hash::make('password'),
            'role' => 'seller',
        ]);
    }
}
