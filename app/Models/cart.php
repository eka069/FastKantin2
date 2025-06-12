<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    use HasFactory;
    protected $table = 'cart'; // nama table lama
    protected $guarded = [];

    // Relasi ke food item (biar bisa ambil nama makanan)
    public function foodItem()
    {
        return $this->belongsTo(Category::class, 'kategori_id');    }
}
