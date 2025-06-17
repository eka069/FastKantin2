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
        return view('cart');
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


}
