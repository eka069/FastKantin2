<?php

namespace App\Http\Controllers;

use App\Models\order;
use Illuminate\Http\Request;

class IncomingOrderController extends Controller
{
    public function index()
    {
        $orders = order::with(['orderItems.foodItem', 'orderItems.foodItem.category', 'customer'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('seller.incoming-orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = order::with(['orderItems.foodItem', 'orderItems.foodItem.category', 'customer'])
            ->findOrFail($id);

        return view('seller.incoming-orders.show', compact('order'));
    }

        public function update(Request $request, $id)
        {
            $order = Order::findOrFail($id);

            if ($request->has('status')) {
                $order->status = $request->status;
                $order->save();

                return response()->json(['message' => 'Status diperbarui.']);
            }

            return response()->json(['message' => 'Tidak ada status diberikan.'], 400);
        }
}
