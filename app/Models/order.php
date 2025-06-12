<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
    protected $table = 'orders'; // nama table lama
    protected $guarded = [];

    // Relasi ke food item (biar bisa ambil nama makanan)
    public function foodItem()
    {
        return $this->belongsTo(FoodItem::class, 'food_id');
    }
}
