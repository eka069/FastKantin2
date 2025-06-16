<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\FoodItem;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(){
        $menu = FoodItem::all();
        return view('seller.menu.index' , compact('menu'));
    }

    public function create(){
        $category = category::all();
        return view('seller.menu.tambah',compact('category'));
    }

    public function edit($id){
        $menu = FoodItem::find($id);
        $category = category::all();
        return view('seller.menu.edit', compact('menu','category'));

    }

    public function store(Request $request)
{
    $data = $request->validate([
        'name' => 'required',
        'category_id' => 'required',
        'merchant_id' => 'required',
        'price' => 'required',
        'stock' => 'required',
    ]);

    try {
        FoodItem::create($data);
        return redirect()->route('menu.index')->with('success', 'Product created!');
    } catch (\Exception $e) {
        // Menampilkan error ke browser
        return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
    }
}


    public function update(Request $request, FoodItem $foodItem)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'merchant_id' => 'required|exists:merchants,id',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
    ]);

    $foodItem->update($validated);

    return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui.');
}




}
