<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\FoodItem;
use App\Models\order;
use Illuminate\Http\Request;

class ProdukController extends Controller
{ /**
    * Display a listing of the resource.
    */
   public function index()
   {
    $FoodItem = FoodItem::all();
    $category = category::all();
    return view('index', compact('foodItems', 'category'));

   }

   /**
    * Show the form for creating a new resource.
    */
   public function create()
   {
    return view('seller.tambah');
   }

   /**
    * Store a newly created resource in storage.
    */
   public function store(Request $request)
   {
    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'image' => 'nullable|image|max:2048',
    ]);

    $path = $request->file('image')?->store('produk', 'public');

    FoodItem::create([
        'name' => $request->name,
        'price' => $request->price,
        'image' => $path,
    ]);

    return redirect()->route('seller.index')->with('success', 'Produk berhasil ditambahkan.');
   }

   /**
    * Display the specified resource.
    */
   public function show(order $order)
   {
    return view('seller.index', compact('produk'));   }

   /**
    * Show the form for editing the specified resource.
    */
   public function edit(order $order)
   {
    return view('seller.edit', compact('produk'));
   }

   /**
    * Update the specified resource in storage.
    */
   public function update(Request $request, order $order)
   {
    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'image' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('produk', 'public');
        $products->image = $path;
    }

    $produk->name = $request->name;
    $produk->price = $request->price;
    $produk->save();

    return redirect()->route('seller.tambah')->with('success', 'Produk berhasil diperbarui.');
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy(order $order)
   {
    $produk->delete();
    return redirect()->route('seller.index')->with('success', 'Produk berhasil dihapus.');
   }

}
