<?php

namespace Database\Seeders;

use App\Models\merchant;
use App\Models\seller;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $merchant = [
            [
                'name'=>'andini',
                'phone'=>'1234567890',
            ]
        ];

        merchant::insert($merchant);
    }
}
