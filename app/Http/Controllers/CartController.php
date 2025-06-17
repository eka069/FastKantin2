<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\FoodItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = cart::where('customer_id', Auth::id())
            ->with('foodItem', 'foodItem.category')
            ->get();
        return view('cart', compact('cart'));
    }

    public function addToChart($id)
    {
        $customerId = Auth::id();
        $qty = 1;

        $existing = cart::where([
            'customer_id' => $customerId,
            'food_id' => $id
        ])->first();

        if ($existing) {
            $existing->qty += $qty;
            $existing->updated_at = now();
            $existing->save();
        } else {
            cart::create([
                'customer_id' => $customerId,
                'food_id' => $id,
                'qty' => $qty,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return redirect()->route('cart')->with('success', 'Item added to cart successfully!');
    }

    public function destroy($id)
    {
        cart::where('id', $id)
            ->where('customer_id', Auth::id())
            ->delete();

        return back()->with('success', 'Item berhasil dihapus.');
    }

    public function clear()
    {
        cart::where('customer_id', Auth::id())
            ->delete();

        return back()->with('success', 'Keranjang dikosongkan.');
    }

        public function updateQty(Request $request, $id)
        {
            $cart = Cart::findOrFail($id);
            $cart->qty = $request->qty;
            $cart->save();

            return response()->json(['success' => true]);
        }


}
