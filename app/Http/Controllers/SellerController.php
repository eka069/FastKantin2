<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FoodItem;
use App\Models\Order;

class SellerController extends Controller
{
    public function index()
    {
        $foodItems = FoodItem::all();
        $orders = Order::with('foodItem')->orderBy('created_at', 'desc')->get();

        return view('seller.index', compact('foodItems', 'orders'));
    }
}
