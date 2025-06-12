<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FoodItem;

class category extends Model
{
    use HasFactory;
    public function FoodItem()
    {
        return $this->hasMany(FoodItem::class);$category = Category::all();
        $foodItems = FoodItem::all(); // sesuaikan jika pakai
        $category = Category::all();

    return view('index', compact('category', 'foodItems'));

    }

}
