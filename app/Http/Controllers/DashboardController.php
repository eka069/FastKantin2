<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\FoodItem;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $menu = FoodItem::count();
        $category = category::count();
        return view('seller.dashbord.index', compact('menu', 'category'));
    }
}
