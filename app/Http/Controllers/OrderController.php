<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\cart;
use App\Models\category;
use App\Models\order;
use App\Models\produk;
use App\Models\FoodItem;
use App\Models\order_item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{


public function index(Request $request)
{
    $query = $request->input('query');
    $categoryFilter = $request->input('category');
    $itemsPerPage = 8;

    // Query awal dengan relasi category (pastikan relasi 'category' ada di model FoodItem)
    $foodItemsQuery = FoodItem::with('category');

    if ($query) {
        $foodItemsQuery->where('name', 'like', "%{$query}%");
    }

    if ($categoryFilter && $categoryFilter !== 'all') {
        // Filter berdasarkan relasi kategori
        $foodItemsQuery->whereHas('category', function ($q) use ($categoryFilter) {
            $q->where('name', $categoryFilter);
        });
    }

    $foodItems = $foodItemsQuery->paginate($itemsPerPage)->appends($request->query());

    // Ambil semua kategori yang tersedia dari tabel categories
    $categories = \App\Models\Category::orderBy('name')->pluck('name');



    // Kalau sudah yakin muncul, return compact view
    return view('index', compact('foodItems', 'categories', 'categoryFilter', 'query'));
}

    public function show($id)
    {
        $foodItem = FoodItem::find($id);

        if (!$foodItem) {
            abort(404, 'Food item not found');
        }

        return view('detail', ['foodItem' => $foodItem]);
    }

    public function success()
    {
        return view('success');
    }

    public function payment()
    {
        return view('pembayaran');
    }

    public function history()
    {
        return view('riwayat-pesanan');
    }
}
