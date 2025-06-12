<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodItem extends Model
{
    use HasFactory;
    protected $table = 'food_items'; // nama table lama
    protected $guarded = []; // supaya mass-assignment bisa semua kolom

    public function category()
    {
     return $this->belongsTo(FoodItem::class, 'food_id');

    }
}
