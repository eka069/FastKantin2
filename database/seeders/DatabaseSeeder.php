<?php

namespace Database\Seeders;

use App\Models\FoodItem;
use App\Models\merchant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            MerchantSeeder::class,
            CategoriesSeeder::class,
            FoodItemSeeder::class,

        ]);
    }
}
