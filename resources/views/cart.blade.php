@extends('layout.master')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Keranjang Belanja</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Daftar Menu --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg border overflow-hidden">
                <div class="p-4 border-b bg-gray-50">
                    <h2 class="font-semibold">Daftar Menu</h2>
                </div>
                <ul class="divide-y">
                    @forelse ($cart as $item)
                        <li class="p-4" data-id="{{ $item->id }}" data-price="{{ $item->foodItem->price }}">
                            <div class="flex items-center">
                                {{-- Gambar makanan --}}
                                <div class="h-16 w-16 rounded-md overflow-hidden flex-shrink-0">
                                    <img src="{{ $item->foodItem->image ?? 'https://via.placeholder.com/100' }}" class="w-full h-full object-cover" alt="{{ $item->foodItem->name ?? 'Makanan' }}">
                                </div>

                                {{-- Informasi makanan --}}
                                <div class="ml-4 flex-grow">
                                    <h3 class="font-medium">{{ $item->foodItem->name ?? 'Nama Tidak Ditemukan' }}</h3>
                                    <p class="text-sm text-gray-600">Penjual: {{ $item->foodItem->seller_name ?? 'Tidak diketahui' }}</p>
                                    <p class="text-sm font-medium mt-1">Rp {{ number_format($item->foodItem->price, 0, ',', '.') }}</p>
                                </div>

                                {{-- Qty counter --}}
                                <div class="flex items-center ml-4 space-x-1">
                                    <button type="button" class="qty-btn px-2 bg-gray-200 rounded" data-action="minus">−</button>
                                    <input type="number" class="qty-input w-12 text-center border rounded" value="{{ $item->qty }}" min="1">
                                    <button type="button" class="qty-btn px-2 bg-gray-200 rounded" data-action="plus">+</button>
                                </div>

                                {{-- Total harga item --}}
                                <div class="ml-6 text-right">
                                    <p class="font-medium item-total">Rp {{ number_format($item->qty * $item->foodItem->price, 0, ',', '.') }}</p>
                                    <form action="{{ route('cart.delete', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus item ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:text-red-800 text-sm mt-1">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="p-4 text-gray-600">Keranjang kosong.</li>
                    @endforelse
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
                        <span class="font-medium" id="total-items">
                            {{ $cart->sum('qty') }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Harga:</span>
                        <span class="font-medium" id="total-price">
                            Rp {{ number_format($cart->sum(fn($c) => $c->qty * ($c->foodItem->price ?? 0)), 0, ',', '.') }}
                        </span>
                    </div>
                </div>
                <hr class="my-4">
                <a href="{{ route('order.payment') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-md transition-colors mb-2">
                    Lanjutkan ke Pembayaran
                </a>
                <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Kosongkan keranjang?')">
                    @csrf
                    @method('DELETE')
                    <button class="block w-full bg-gray-200 hover:bg-gray-300 text-gray-800 text-center py-2 px-4 rounded-md transition-colors">
                        Kosongkan Keranjang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Script untuk qty dinamis --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const formatRupiah = (value) => {
            return 'Rp ' + Number(value).toLocaleString('id-ID');
        };

        function updateSummary() {
            let totalItems = 0;
            let totalPrice = 0;

            document.querySelectorAll('li[data-id]').forEach(li => {
                const qty = parseInt(li.querySelector('.qty-input').value);
                const price = parseInt(li.getAttribute('data-price'));
                const total = qty * price;
                totalItems += qty;
                totalPrice += total;
                li.querySelector('.item-total').textContent = formatRupiah(total);
            });

            document.getElementById('total-items').textContent = totalItems;
            document.getElementById('total-price').textContent = formatRupiah(totalPrice);
        }

        document.querySelectorAll('.qty-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const input = this.parentElement.querySelector('.qty-input');
                let qty = parseInt(input.value);
                if (this.dataset.action === 'plus') {
                    qty++;
                } else if (this.dataset.action === 'minus' && qty > 1) {
                    qty--;
                }
                input.value = qty;
                updateSummary();
            });
        });

        document.querySelectorAll('.qty-input').forEach(input => {
            input.addEventListener('change', updateSummary);
        });
    });
</script>
@endsection
