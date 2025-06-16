@extends('layout.main')

@section('title', 'cart')

@section('content')

<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Keranjang Belanja</h1>

    {{-- Pesan error jika ada --}}
    @if (!empty($error))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            @if ($error === 'empty')
                <p>Keranjang Anda kosong. Silakan tambahkan menu terlebih dahulu.</p>
            @else
                <p>Terjadi kesalahan. Silakan coba lagi.</p>
            @endif
        </div>
    @endif

    {{-- Keranjang Kosong --}}
    @if (empty($cart))
        <div class="bg-white rounded-lg border p-8 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            <h2 class="text-xl font-semibold mb-2">Keranjang Anda Kosong</h2>
            <p class="text-gray-600 mb-6">Anda belum menambahkan menu apapun ke keranjang.</p>
            <a href="{{ url('Order') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition-colors inline-block">
                Lihat Menu
            </a>
        </div>
    @else
        {{-- Keranjang Berisi Item --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Daftar Menu --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg border overflow-hidden">
                    <div class="p-4 border-b bg-gray-50">
                        <h2 class="font-semibold">Daftar Menu</h2>
                    </div>
                    <ul class="divide-y" id="cart-items-list">
                        @foreach ($cart as $item)
                            <li class="p-4 cart-item" data-id="{{ $item['id'] }}">
                                <div class="flex items-center">
                                    <div class="h-16 w-16 rounded-md overflow-hidden flex-shrink-0">
                                        <img src="{{ $item['image'] ? e($item['image']) : e(getPlaceholderUrl(100, 100)) }}"
                                             alt="{{ e($item['name']) }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="ml-4 flex-grow">
                                        <h3 class="font-medium">{{ e($item['name']) }}</h3>
                                        <p class="text-sm text-gray-600">Penjual: {{ e($item['seller_name']) }}</p>
                                        <p class="text-sm font-medium mt-1">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                    </div>
                                    <div class="flex items-center ml-4">
                                        <button class="decrease-quantity p-1 rounded-full hover:bg-gray-100"
                                                data-id="{{ $item['id'] }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      stroke-width="2" d="M20 12H4"/>
                                            </svg>
                                        </button>
                                        <input type="number" class="item-quantity w-12 mx-2 text-center border rounded-md"
                                               value="{{ $item['quantity'] }}" min="1" max="{{ $item['stock'] }}"
                                               data-id="{{ $item['id'] }}" data-stock="{{ $item['stock'] }}">
                                        <button class="increase-quantity p-1 rounded-full hover:bg-gray-100"
                                                data-id="{{ $item['id'] }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="ml-6 text-right">
                                        <p class="font-medium item-subtotal">
                                            Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                        </p>
                                        <button class="remove-item text-red-600 hover:text-red-800 text-sm mt-1"
                                                data-id="{{ $item['id'] }}">
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Ringkasan Pesanan --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg border p-4 sticky top-4">
                    <h2 class="font-semibold mb-4">Ringkasan Pesanan</h2>
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Item:</span>
                            <span class="font-medium" id="cart-count">{{ getCartCount() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Harga:</span>
                            <span class="font-medium" id="cart-total">Rp {{ number_format($cart_total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <hr class="my-4">
                    <a href="pembayaran.php"
                       class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-md transition-colors mb-2">
                        Lanjutkan ke Pembayaran
                    </a>
                    <button id="clear-cart"
                            class="block w-full bg-gray-200 hover:bg-gray-300 text-gray-800 text-center py-2 px-4 rounded-md transition-colors">
                        Kosongkan Keranjang
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

{{-- Tambahkan script keranjang di sini jika belum --}}
<script>
    // JavaScript keranjang tetap sama seperti sebelumnya
</script>

@endsection
