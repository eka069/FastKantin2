<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    use HasFactory;
    protected $table = 'cart';
    protected $guarded = [];

    public function foodItem()
    {
        return $this->belongsTo(Category::class, 'kategori_id');    }
}
