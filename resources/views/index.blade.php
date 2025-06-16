<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Beli Makanan</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- Navbar -->
  <nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
      <h1 class="text-2xl font-bold text-indigo-600">FoodMart</h1>

      <!-- Search input -->
      <input
        id="searchInput"
        type="text"
        placeholder="Cari makanan..."
        class="hidden sm:block w-72 px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400"
      />

      <!-- Menu -->
      <div class="flex items-center space-x-6 text-sm">
        <a href="#" class="text-gray-600 hover:text-indigo-600">Profile</a>
        <a href="#" class="text-gray-600 hover:text-indigo-600">Cart</a>
        <a href="#" class="text-gray-600 hover:text-indigo-600">Riwayat</a>
        <a href="#" class="text-red-500 hover:text-red-700">Logout</a>
      </div>
    </div>

    <!-- Search input mobile -->
    <div class="sm:hidden px-6 pb-4">
      <input
        id="searchInputMobile"
        type="text"
        placeholder="Cari makanan..."
        class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400"
      />
    </div>
  </nav>

  <!-- Main -->
  <main class="max-w-7xl mx-auto px-6 py-10">
    <div id="foodList" class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"></div>

    <!-- Pagination -->
    <div class="flex justify-center mt-10 space-x-2" id="pagination"></div>
  </main>

  <script>
    const foodItems = [
      "Nasi Goreng", "Mie Ayam", "Sate Ayam", "Bakso", "Rendang", "Soto Ayam", "Ayam Geprek", "Tahu Gejrot",
      "Nasi Kuning", "Gudeg", "Pecel Lele", "Lontong Sayur", "Sop Buntut", "Rawon", "Gado-Gado", "Ayam Bakar",
      "Pempek", "Nasi Uduk", "Ikan Bakar", "Ketoprak", "Seblak", "Martabak", "Siomay", "Tongseng", "Coto Makassar"
    ];

    const itemsPerPage = 8;
    let currentPage = 1;

    function renderFoodList() {
      const queryDesktop = document.getElementById("searchInput").value.toLowerCase();
      const queryMobile = document.getElementById("searchInputMobile").value.toLowerCase();
      const query = queryDesktop || queryMobile;

      const filteredItems = foodItems.filter(item => item.toLowerCase().includes(query));
      const totalPages = Math.ceil(filteredItems.length / itemsPerPage);
      const start = (currentPage - 1) * itemsPerPage;
      const itemsToShow = filteredItems.slice(start, start + itemsPerPage);

      const listEl = document.getElementById("foodList");
      listEl.innerHTML = itemsToShow.map(item => `
        <div class="bg-white p-4 rounded-xl shadow hover:shadow-md transition">
          <img src="https://source.unsplash.com/featured/300x200?${encodeURIComponent(item)},food" class="rounded-md mb-3 w-full h-40 object-cover" alt="${item}"/>
          <h2 class="text-lg font-semibold">${item}</h2>
          <p class="text-sm text-gray-500">Rp ${Math.floor(Math.random() * 20000 + 10000).toLocaleString()}</p>
          <button class="mt-3 w-full bg-indigo-500 text-white py-2 rounded-md hover:bg-indigo-600 transition">Beli Sekarang</button>
        </div>
      `).join("");

      renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
      const paginationEl = document.getElementById("pagination");
      paginationEl.innerHTML = "";

      for (let i = 1; i <= totalPages; i++) {
        const btn = document.createElement("button");
        btn.textContent = i;
        btn.className = `px-4 py-2 rounded-md border ${i === currentPage ? 'bg-indigo-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-100'}`;
        btn.onclick = () => {
          currentPage = i;
          renderFoodList();
        };
        paginationEl.appendChild(btn);
      }
    }

    document.getElementById("searchInput").addEventListener("input", () => {
      currentPage = 1;
      renderFoodList();
    });

    document.getElementById("searchInputMobile").addEventListener("input", () => {
      currentPage = 1;
      renderFoodList();
    });

    renderFoodList();
  </script>
</body>
</html>
