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
    private $foodItems = [
        ['id' => 1, 'name' => 'Nasi Goreng', 'category' => 'Nusantara', 'price' => 25000],
        ['id' => 2, 'name' => 'Mie Ayam', 'category' => 'Nusantara', 'price' => 20000],
        ['id' => 3, 'name' => 'Sate Ayam', 'category' => 'Nusantara', 'price' => 30000],
        ['id' => 4, 'name' => 'Bakso', 'category' => 'Nusantara', 'price' => 18000],
        ['id' => 5, 'name' => 'Rendang', 'category' => 'Nusantara', 'price' => 35000],
        ['id' => 6, 'name' => 'Soto Ayam', 'category' => 'Nusantara', 'price' => 22000],
        ['id' => 7, 'name' => 'Ayam Geprek', 'category' => 'Modern', 'price' => 28000],
        ['id' => 8, 'name' => 'Tahu Gejrot', 'category' => 'Camilan', 'price' => 15000],
        ['id' => 9, 'name' => 'Nasi Kuning', 'category' => 'Nusantara', 'price' => 23000],
        ['id' => 10, 'name' => 'Gudeg', 'category' => 'Nusantara', 'price' => 27000],
        ['id' => 11, 'name' => 'Pecel Lele', 'category' => 'Nusantara', 'price' => 24000],
        ['id' => 12, 'name' => 'Lontong Sayur', 'category' => 'Nusantara', 'price' => 19000],
        ['id' => 13, 'name' => 'Sop Buntut', 'category' => 'Nusantara', 'price' => 40000],
        ['id' => 14, 'name' => 'Rawon', 'category' => 'Nusantara', 'price' => 32000],
        ['id' => 15, 'name' => 'Gado-Gado', 'category' => 'Vegetarian', 'price' => 26000],
        ['id' => 16, 'name' => 'Ayam Bakar', 'category' => 'Nusantara', 'price' => 31000],
        ['id' => 17, 'name' => 'Pempek', 'category' => 'Camilan', 'price' => 20000],
        ['id' => 18, 'name' => 'Nasi Uduk', 'category' => 'Nusantara', 'price' => 21000],
        ['id' => 19, 'name' => 'Ikan Bakar', 'category' => 'Nusantara', 'price' => 38000],
        ['id' => 20, 'name' => 'Ketoprak', 'category' => 'Vegetarian', 'price' => 22000],
        ['id' => 21, 'name' => 'Seblak', 'category' => 'Camilan', 'price' => 17000],
        ['id' => 22, 'name' => 'Martabak', 'category' => 'Camilan', 'price' => 29000],
        ['id' => 23, 'name' => 'Siomay', 'category' => 'Camilan', 'price' => 16000],
        ['id' => 24, 'name' => 'Tongseng', 'category' => 'Nusantara', 'price' => 33000],
        ['id' => 25, 'name' => 'Coto Makassar', 'category' => 'Nusantara', 'price' => 29000],
    ];


    public function index(Request $request)
    {

        $query = $request->input('query');
        $categoryFilter = $request->input('category');
        $itemsPerPage = 8;

        $filteredItems = collect($this->foodItems)->filter(function ($item) use ($query, $categoryFilter) {
            $matchQuery = true;
            $matchCategory = true;

            if ($query) {
                $matchQuery = stripos($item['name'], $query) !== false;
            }

            if ($categoryFilter && $categoryFilter !== 'all') {
                $matchCategory = $item['category'] === $categoryFilter;
            }

            return $matchQuery && $matchCategory;
        });

        // Manually paginate the collection
        $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $filteredItems->slice(($currentPage - 1) * $itemsPerPage, $itemsPerPage)->values();

        $foodItems = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentItems,
            $filteredItems->count(),
            $itemsPerPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $categories = collect($this->foodItems)->pluck('category')->unique()->sort()->values()->all();

        return view('index', [
            'foodItems' => $foodItems,
            'categories' => $categories,
            'selectedCategory' => $categoryFilter,
            'searchQuery' => $query
        ]);

    }

    public function show($id)
    {
        $foodItem = collect($this->foodItems)->firstWhere('id', $id);

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
