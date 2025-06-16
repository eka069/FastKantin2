@extends('layout.master')

@section('title', 'Beranda')

@section('content')
<div class="flex flex-col items-center justify-center py-8">
    <h1 class="text-3xl font-bold mb-2">FAST KANTIN</h1>
    <p class="text-lg text-gray-600">pesan makanan kantin dengan cepat dan mudah</p>
</div>

<div class="max-w-7xl mx-auto px-6 flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0 sm:space-x-4">
    {{-- Search Form --}}
    <form action="" method="GET" class="w-full sm:w-auto flex-grow">
        <label for="searchQuery" class="sr-only">Cari makanan...</label>
        <input
            id="searchQuery"
            type="text"
            name="query"
            placeholder="Cari makanan..."
            value="{{ $query }}"
            class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400"
        />
        @if ($categoryFilter)
            <input type="hidden" name="category" value="{{ $categoryFilter }}">
        @endif
    </form>

    {{-- Filter Form --}}
    <form action="" method="GET" class="w-full sm:w-auto">
        <label for="categoryFilter" class="sr-only">Filter by Kategori</label>
        <select
            id="categoryFilter"
            name="category"
            onchange="this.form.submit()"
            class="w-full px-4 py-2 rounded-md border border-gray-300 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-400"
        >
            <option value="all" {{ $categoryFilter == 'all' ? 'selected' : '' }}>Semua Kategori</option>
            @foreach ($categories as $category)
                <option value="{{ $category }}" {{ $categoryFilter == $category ? 'selected' : '' }}>
                    {{ $category }}
                </option>
            @endforeach
        </select>
        @if ($query)
            <input type="hidden" name="query" value="{{ $query }}">
        @endif
    </form>
</div>

<main class="max-w-7xl mx-auto px-6 py-10">
    @if ($foodItems->isEmpty())
        <p class="text-center text-gray-500 text-lg">Tidak ada makanan yang ditemukan.</p>
    @else
        <div id="foodList" class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @foreach ($foodItems as $item)
                <div class="bg-white p-4 rounded-xl shadow hover:shadow-md transition">
                    <img src="https://source.unsplash.com/featured/300x200?{{ urlencode($item->name) }},food"
                         class="rounded-md mb-3 w-full h-40 object-cover"
                         alt="{{ $item->name }}"/>
                    <h2 class="text-lg font-semibold">{{ $item->name }}</h2>
                    <p class="text-sm text-gray-500">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-400 mt-1">Kategori: {{ $item->category->name ?? 'Tidak ada' }}</p>
                    <a href="{{ route('home-menu.detail', ['id' => $item->id]) }}">
                        <button type="button"
                                class="mt-3 w-full bg-indigo-500 text-white py-2 rounded-md hover:bg-indigo-600 transition">
                            Beli Sekarang
                        </button>
                    </a>
                </div>
            @endforeach
        </div>

        {{-- Laravel Pagination --}}
        <div class="mt-10 flex justify-center">
            {{ $foodItems->links() }}
        </div>
    @endif
</main>
@endsection
