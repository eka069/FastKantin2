<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_item extends Model
{
    use HasFactory;
    protected $table = 'order_items';
    protected $fillable = [
        'order_id',
        'item_id',
        'quantity',
        'price_per_item',
        'subtotal',
    ];

    public function foodItem()
    {
        return $this->belongsTo(FoodItem::class, 'item_id');
    }
}
