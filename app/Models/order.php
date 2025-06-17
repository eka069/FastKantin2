<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
   protected $table = 'orders';

    protected $fillable = [
        'customer_id',
        'pickup_time',
        'status',
        'payment_method',
        'note',
        'total_price',
    ];

    public function orderItems()
    {
        return $this->hasMany(order_item::class, 'order_id');
    }

    public function foodItems()
    {
        return $this->hasManyThrough(FoodItem::class, order_item::class, 'order_id', 'id', 'id', 'item_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
