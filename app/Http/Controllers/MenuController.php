<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\FoodItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        $menu = FoodItem::with('category')->get();
        return view('seller.menu.index', compact('menu'));
    }

    public function create()
    {
        $category = category::all();
        return view('seller.menu.tambah', compact('category'));
    }

    public function show($id)
    {
        $menu = FoodItem::find($id);
        $category = category::all();
        return view('seller.menu.show', compact('menu', 'category'));
    }

    public function edit($id)
    {
        $menu = FoodItem::find($id);
        $category = category::all();
        return view('seller.menu.edit', compact('menu', 'category'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('food_images', 'public');
                $validated['image'] = $imagePath;
            }

            FoodItem::create($validated);

            return redirect()->route('menu.index')->with('success', 'Product created!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $foodItem = FoodItem::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($foodItem->image && Storage::disk('public')->exists($foodItem->image)) {
                Storage::disk('public')->delete($foodItem->image);
            }

            $imagePath = $request->file('image')->store('food_images', 'public');
            $validated['image'] = $imagePath;
        }

        $foodItem->update($validated);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $foodItem = FoodItem::findOrFail($id);

        if ($foodItem->image && Storage::disk('public')->exists($foodItem->image)) {
            Storage::disk('public')->delete($foodItem->image);
        }

        $foodItem->delete();

        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus.');
    }
}
