<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FoodItem;

class category extends Model
{
    use HasFactory;
    protected $table = 'categories'; // nama table lama
    protected $fillable = ['id','name'];

}
