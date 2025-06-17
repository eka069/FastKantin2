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


    public function index(Request $request)
    {
        $query = $request->input('query');
        $categoryFilter = $request->input('category');
        $itemsPerPage = 8;

        // Query awal dengan relasi category (pastikan relasi 'category' ada di model FoodItem)
        $foodItemsQuery = FoodItem::with('category');

        if ($query) {
            $foodItemsQuery->where('name', 'like', "%{$query}%");
        }

        if ($categoryFilter && $categoryFilter !== 'all') {
            // Filter berdasarkan relasi kategori
            $foodItemsQuery->whereHas('category', function ($q) use ($categoryFilter) {
                $q->where('name', $categoryFilter);
            });
        }

        $foodItems = $foodItemsQuery->paginate($itemsPerPage)->appends($request->query());

        // Ambil semua kategori yang tersedia dari tabel categories
        $categories = \App\Models\Category::orderBy('name')->pluck('name');



        // Kalau sudah yakin muncul, return compact view
        return view('index', compact('foodItems', 'categories', 'categoryFilter', 'query'));
    }

    public function show($id)
    {
        $foodItem = FoodItem::with('category')->find($id);

        if (!$foodItem) {
            abort(404, 'Food item not found');
        }

        return view('detail', compact('foodItem'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'qty' => 'required|integer|min:1',
            'note' => 'nullable|string',
            'pickup_time' => 'required',
        ]);

        $itemId = FoodItem::findOrFail($request->food_id);
        $itemPrice = $itemId->price;

        $qty = $request->qty;
        $subtotal = $itemPrice * $qty;

        $order = Order::create([
            'customer_id' => Auth::id(),
            'note' => $request->note,
            'pickup_time' => $request->pickup_time,
            'status' => 'pending',
            'payment_method' => $request->payment_method ?? 'cash',
            'total_price' => $subtotal,
        ]);

        order_item::create([
            'order_id' => $order->id,
            'item_id' => $itemId->id,
            'quantity' => $qty,
            'price_per_item' => $itemPrice,
            'subtotal' => $subtotal,
        ]);

        return redirect()->route('order.success')->with('success', 'Pesanan berhasil disimpan!');
    }

    public function checkoutFromCart(Request $request)
    {
        $request->validate([
            'pickup_time' => 'required',
            'payment_method' => 'required',
            'note' => 'nullable|string',
        ]);

        // Ambil cart user dari database
        $cartItems = Cart::where('customer_id', Auth::id())->with('foodItem')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Keranjang belanja kosong.');
        }

        // Hitung total
        $total = $cartItems->sum(function ($item) {
            return $item->foodItem->price * $item->qty;
        });

        // Buat order
        $order = Order::create([
            'customer_id' => Auth::id(),
            'note' => $request->note,
            'pickup_time' => $request->pickup_time,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'total_price' => $total,
        ]);

        // Simpan item satu per satu ke order_items
        foreach ($cartItems as $item) {
            order_item::create([
                'order_id' => $order->id,
                'item_id' => $item->foodItem->id,
                'quantity' => $item->qty,
                'price_per_item' => $item->foodItem->price,
                'subtotal' => $item->qty * $item->foodItem->price,
            ]);
        }

        // Kosongkan cart setelah checkout
        Cart::where('customer_id', Auth::id())->delete();

        return redirect()->route('order.success')->with('success', 'Pesanan berhasil disimpan!');
    }


    public function success()
    {
        return view('success');
    }

    public function payment(Request $request)
    {
        $cart = cart::where('customer_id', Auth::id())
            ->with('foodItem')
            ->get();

        if ($request->has('items')) {
            $items = collect(json_decode($request->items, true));
            foreach ($cart as $item) {
                $match = $items->firstWhere('id', $item->id);
                if ($match) {
                    $item->qty = $match['qty'];
                }
            }
        }

        return view('pembayaran', compact('cart'));
    }


    public function history()
    {
        $history = order::with(['orderItems', 'foodItems']) // eager load relasi
            ->where('customer_id', Auth::id())
            ->latest()
            ->get();

        return view('riwayat-pesanan', compact('history'));
    }
}
