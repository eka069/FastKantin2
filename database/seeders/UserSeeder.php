<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                'name'=>'eka',
                'email'=>'ekaeka@gmail.com',
                'phone'=>'0987654321',
                'password'=>'eka123'
            ]
        ];

        User::insert($user);
    }
}
