<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function showForm(Request $request) {
        $cartItems = getCartItems(); // Sesuaikan dengan model
        if (empty($cartItems)) {
            return redirect('/'); // redirect jika keranjang kosong
        }

        $cartTotal = getCartTotal();
        return view('checkout', compact('cartItems', 'cartTotal'));
    }

}
