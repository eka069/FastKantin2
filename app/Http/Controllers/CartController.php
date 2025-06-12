<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\FoodItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = Cart::with('food')->where('user_id', auth()->id())->get();

        $cart_total = $cart->sum(function($item) {
            return $item->quantity * $item->food->price;
        });

        return view('keranjang', compact('cart', 'cart_total'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = FoodItem::findOrFail($request->product_id);

        $existing = Cart::where('user_id', auth()->id())
            ->where('food_id', $product->id)
            ->first();

        if ($existing) {
            $existing->increment('quantity');
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'food_id' => $product->id,
                'food_name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'total' => $product->total,
            ]);
        }

        return redirect()->route('keranjang')->with('success', 'Produk ditambahkan ke keranjang!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cart = Cart::with('food')->where('user_id', auth()->id())->get();
        return view('keranjang', compact('cart'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $newQty = $request->input('quantity');

        Cart::where('user_id', auth()->id())
            ->where('food_id', $id)
            ->update(['quantity' => $newQty]);

        return redirect()->route('keranjang')->with('success', 'Jumlah produk diperbarui.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Cart::where('user_id', auth()->id())
        ->where('food_id', $id)
        ->delete();

    return redirect()->route('keranjang')->with('success', 'Produk dihapus dari keranjang.');
    }
}
