<?php

namespace Database\Seeders;

use App\Models\categories;
use App\Models\category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Categories = [
            [
                'name' => 'Makanan Berat',
            ],[
                'name' => 'Minuman',
            ],[
                'name' => 'Camilan',
            ],
        ];
        category::insert($Categories);
    }
}
