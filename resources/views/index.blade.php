<!-- Konten Utama -->
<div class="container mx-auto px-4 py-8">
    <header class="mb-8">
        <h1 class="text-3xl font-bold text-center mb-2">FAST KANTIN</h1>
        <p class="text-center text-gray-600">Pesan makanan kantin dengan cepat dan mudah</p>
    </header>

    <!-- Filter dan Pencarian -->
    <div class="flex flex-col md:flex-row gap-4 mb-8">
        <div class="relative flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" id="search-input" placeholder="Cari makanan..." class="pl-10 w-full p-2 border rounded-md">
        </div>

        <div class="flex gap-2">
            <select id="category-filter" class="p-2 border rounded-md w-[180px]">
                <option value="all">Semua Kategori</option>
                <!-- Kategori akan diisi dari API -->
            </select>

            <button id="filter-button" class="p-2 border rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Daftar Menu Makanan -->
    <div id="food-items-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <div class="loading">
            <div class="loading-spinner"></div>
        </div>
    </div>
</div>

<!-- Template untuk item makanan -->
<template id="food-item-template">
    <div class="food-item border rounded-lg overflow-hidden" data-category="">
        <div class="relative h-48 w-full">
            <img src="/placeholder.svg" alt="" class="w-full h-full object-cover">
            <span class="absolute top-2 right-2 bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full"></span>
        </div>
        <div class="p-4">
            <h3 class="font-semibold text-lg mb-1"></h3>
            <p class="text-gray-600 text-sm mb-2"></p>
            <p class="font-bold text-lg"></p>
            <p class="text-sm text-gray-500 mt-1"></p>
        </div>
        <div class="p-4 pt-0 flex gap-2">
            <a href="" class="detail-link flex-1 block bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-md transition-colors">Detail</a>
            <button class="add-to-cart bg-green-600 hover:bg-green-700 text-white py-2 px-2 rounded-md transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </button>
        </div>
    </div>
</template>

<!-- JavaScript untuk filter dan pencarian -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        const categoryFilter = document.getElementById('category-filter');
        const foodItems = document.querySelectorAll('.food-item');

        function filterItems() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedCategory = categoryFilter.value;

            foodItems.forEach(item => {
                const name = item.querySelector('h3').textContent.toLowerCase();
                const category = item.dataset.category;
                const matchesSearch = name.includes(searchTerm);
                const matchesCategory = selectedCategory === 'all' || category === selectedCategory;

                if (matchesSearch && matchesCategory) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        searchInput.addEventListener('input', filterItems);
        categoryFilter.addEventListener('change', filterItems);
        document.getElementById('filter-button').addEventListener('click', filterItems);

        // Cek keranjang
        fetch('api/cart_actions.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=get_cart'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Update header cart count
                    const headerCartCount = document.getElementById('header-cart-count');
                    if (headerCartCount) {
                        headerCartCount.textContent = data.cart_count;
                        headerCartCount.style.display = data.cart_count > 0 ? 'flex' : 'none';
                    }
                }
            })
            .catch(error => {
                console.error('Error checking cart:', error);
            });
    });
</script>
<!-- Tambahkan console untuk debugging -->
<script>
    console.log("Halaman beranda dimuat. Versi: 1.0.3");
</script>

<!-- Gunakan file JavaScript terpisah -->
<script src="js/main.js"></script>