<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodItem extends Model
{
    use HasFactory;
    protected $table = 'food_items'; // nama table lama
    protected $fillable = ['id','name','category_id','price','stock','image', 'description'];

    public function category()
    {
        return $this->belongsTo(category::class, 'category_id');
    }
}
