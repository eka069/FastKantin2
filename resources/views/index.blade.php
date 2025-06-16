@extends('layout.main')

@section('title', 'Beranda')

@section('content')

<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <header class="mb-8 text-center">
        <h1 class="text-3xl font-bold mb-2">FAST KANTIN</h1>
        <p class="text-gray-600">Pesan makanan kantin dengan cepat dan mudah</p>
    </header>

    <!-- Daftar Menu Makanan -->
    <div id="food-items-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($foodItems as $item)
        <div class="food-item border rounded-lg overflow-hidden" data-category="{{ $item->category->name ?? 'Tanpa Kategori' }}">
            <!-- Gambar dan Kategori -->
            <div class="relative h-48 w-full">
                <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-40 object-cover rounded-md" alt="{{ $item->name }}">
                <span class="absolute top-2 right-2 bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full">
                    {{ $item->category->name ?? 'Tanpa Kategori' }}
                </span>
            </div>

            <!-- Info Produk -->
            <div class="p-4">
                <h3 class="font-semibold text-lg mb-1">{{ $item->name}}</h3>
                <p class="text-gray-600 text-sm mb-2">{{ $item->deskripsi }}</p>
                <p class="font-bold text-lg">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                <p class="text-sm text-gray-500 mt-1">Tersedia</p>
            </div>

            <!-- Tombol Aksi -->
            <div class="p-4 pt-0 flex gap-2">
                <a href="{{ route('detail', $item->id) }}" class="detail-link flex-1 block bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-md transition-colors">Detail</a>

                <form method="POST" action="{{ route('cart.store') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $item->id }}">
                    <button type="submit" class="add-to-cart bg-green-600 hover:bg-green-700 text-white py-2 px-2 rounded-md transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
