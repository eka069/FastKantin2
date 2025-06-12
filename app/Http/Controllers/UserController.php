<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\FoodItem;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
{
    // semuabackend di setor disini

        // Ambil semua menu makanan
        // $foodItems = FoodItem::all();
        $foodItems = FoodItem::with('category')->get();
        // $foodItems = getAllFoodItems();

        // Ambil kategori untuk filter
         $category = category::with('FoodItem')->get();
        // $category = category::all();
        // $categories = getAllCategories();

        if (isset($_SESSION['user']) && $_SESSION['user'] && $_SESSION['user']['role'] === 'seller') {
            header("Location: {$baseUrl}seller/index.php");
            exit;
        }
        // return $category;
        //return $foodItems;
        return view('index', compact('foodItems', 'category'));
}
}
