<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Beli Makanan</title>
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Import font Poppins dari Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-black">Fast Kantin</h1>

            <div class="flex items-center space-x-6 text-sm">
                <a href="#" class="text-gray-600 hover:text-indigo-600">Profile</a>
                <a href="#" class="text-gray-600 hover:text-indigo-600">Cart</a>
                <a href="#" class="text-gray-600 hover:text-indigo-600">Riwayat</a>
                <a href="#" class="text-red-500 hover:text-red-700">Logout</a>
            </div>
        </div>
    </nav>

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
                value="{{ $searchQuery }}"
                class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400"
            />
            @if ($selectedCategory)
                <input type="hidden" name="category" value="{{ $selectedCategory }}">
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
                <option value="all">Semua Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category }}" {{ $selectedCategory == $category ? 'selected' : '' }}>
                        {{ $category }}
                    </option>
                @endforeach
            </select>
            @if ($searchQuery)
                <input type="hidden" name="query" value="{{ $searchQuery }}">
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
                        <img src="https://source.unsplash.com/featured/300x200?{{ urlencode($item['name']) }},food" class="rounded-md mb-3 w-full h-40 object-cover" alt="{{ $item['name'] }}"/>
                        <h2 class="text-lg font-semibold">{{ $item['name'] }}</h2>
                        <p class="text-sm text-gray-500">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-400 mt-1">Kategori: {{ $item['category'] }}</p>
                        <button class="mt-3 w-full bg-indigo-500 text-white py-2 rounded-md hover:bg-indigo-600 transition">Beli Sekarang</button>
                    </div>
                @endforeach
            </div>
        @endif
    </main>
</body>
</html>
