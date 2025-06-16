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
        ['name' => 'Nasi Goreng', 'category' => 'Nusantara', 'price' => 25000],
        ['name' => 'Mie Ayam', 'category' => 'Nusantara', 'price' => 20000],
        ['name' => 'Sate Ayam', 'category' => 'Nusantara', 'price' => 30000],
        ['name' => 'Bakso', 'category' => 'Nusantara', 'price' => 18000],
        ['name' => 'Rendang', 'category' => 'Nusantara', 'price' => 35000],
        ['name' => 'Soto Ayam', 'category' => 'Nusantara', 'price' => 22000],
        ['name' => 'Ayam Geprek', 'category' => 'Modern', 'price' => 28000],
        ['name' => 'Tahu Gejrot', 'category' => 'Camilan', 'price' => 15000],
        ['name' => 'Nasi Kuning', 'category' => 'Nusantara', 'price' => 23000],
        ['name' => 'Gudeg', 'category' => 'Nusantara', 'price' => 27000],
        ['name' => 'Pecel Lele', 'category' => 'Nusantara', 'price' => 24000],
        ['name' => 'Lontong Sayur', 'category' => 'Nusantara', 'price' => 19000],
        ['name' => 'Sop Buntut', 'category' => 'Nusantara', 'price' => 40000],
        ['name' => 'Rawon', 'category' => 'Nusantara', 'price' => 32000],
        ['name' => 'Gado-Gado', 'category' => 'Vegetarian', 'price' => 26000],
        ['name' => 'Ayam Bakar', 'category' => 'Nusantara', 'price' => 31000],
        ['name' => 'Pempek', 'category' => 'Camilan', 'price' => 20000],
        ['name' => 'Nasi Uduk', 'category' => 'Nusantara', 'price' => 21000],
        ['name' => 'Ikan Bakar', 'category' => 'Nusantara', 'price' => 38000],
        ['name' => 'Ketoprak', 'category' => 'Vegetarian', 'price' => 22000],
        ['name' => 'Seblak', 'category' => 'Camilan', 'price' => 17000],
        ['name' => 'Martabak', 'category' => 'Camilan', 'price' => 29000],
        ['name' => 'Siomay', 'category' => 'Camilan', 'price' => 16000],
        ['name' => 'Tongseng', 'category' => 'Nusantara', 'price' => 33000],
        ['name' => 'Coto Makassar', 'category' => 'Nusantara', 'price' => 29000],
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // lalu proses order dan hapus cart
        Cart::where('user_id', auth()->id())->delete();

        return redirect()->route('cart.index')->with('success', 'Pesanan berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(order $order)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(order $order)
    {
        //
    }
}
