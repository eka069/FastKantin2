@extends('layout.master')

@section('title', 'Beranda')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Keranjang Belanja</h1>

    {{-- Jika keranjang kosong, hapus bagian ini dan tampilkan yang di bawah --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Daftar Menu --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg border overflow-hidden">
                <div class="p-4 border-b bg-gray-50">
                    <h2 class="font-semibold">Daftar Menu</h2>
                </div>
                <ul class="divide-y">
                    @foreach ([1,2] as $i)
                        <li class="p-4">
                            <div class="flex items-center">
                                <div class="h-16 w-16 rounded-md overflow-hidden flex-shrink-0">
                                    <img src="https://picsum.photos/100?random={{ $i }}" class="w-full h-full object-cover" alt="Menu {{ $i }}">
                                </div>
                                <div class="ml-4 flex-grow">
                                    <h3 class="font-medium">Menu Makanan {{ $i }}</h3>
                                    <p class="text-sm text-gray-600">Penjual: Penjual {{ $i }}</p>
                                    <p class="text-sm font-medium mt-1">Rp {{ number_format(15000 * $i, 0, ',', '.') }}</p>
                                </div>
                                <div class="flex items-center ml-4">
                                    <button class="p-1 rounded-full hover:bg-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                        </svg>
                                    </button>
                                    <input type="number" class="w-12 mx-2 text-center border rounded-md" value="1" min="1">
                                    <button class="p-1 rounded-full hover:bg-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="ml-6 text-right">
                                    <p class="font-medium">Rp {{ number_format(15000 * $i, 0, ',', '.') }}</p>
                                    <button class="text-red-600 hover:text-red-800 text-sm mt-1">Hapus</button>
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
                        <span class="font-medium">2</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Harga:</span>
                        <span class="font-medium">Rp {{ number_format(15000 + 30000, 0, ',', '.') }}</span>
                    </div>
                </div>
                <hr class="my-4">
                <a href="{{route('order.payment')}}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-md transition-colors mb-2">
                    Lanjutkan ke Pembayaran
                </a>
                <button class="block w-full bg-gray-200 hover:bg-gray-300 text-gray-800 text-center py-2 px-4 rounded-md transition-colors">
                    Kosongkan Keranjang
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
