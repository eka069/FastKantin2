<?php

namespace Database\Seeders;

use App\Models\FoodItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $FoodItem = [
            [
                'name' => 'Nasi',
                'category_id' => '1',
                'merchant_id'=>'1',
                'price' => '10000',
                'stock' => '5',
            ]
        ];
        FoodItem::insert($FoodItem);
    }
}
