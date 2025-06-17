<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    use HasFactory;
    protected $table = 'cart';
    protected $fillable = [
        'customer_id',
        'food_id',
        'qty',
    ];

    public function foodItem()
    {
        return $this->belongsTo(FoodItem::class, 'food_id');
    }
}
