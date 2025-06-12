@extends('layout.main')

@section('title', 'Beranda')

@section('content')

@endsection

<main class="pt-20"> {{-- Sesuaikan dengan tinggi header --}}
    @yield('content')
</main>
<!-- Konten Utama -->
<div class="container max-w-2xl mx-auto px-4 py-8">
    <a href="index.php" class="flex items-center text-gray-600 mb-6 hover:text-gray-900 transition-colors">
      <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
      </svg>
      Kembali ke Dashboard
    </a>

    <div class="bg-white rounded-lg border p-6">
      <h1 class="text-2x1 font-bold mb-2">Edit Menu</h1>
      <p class="text-gray-600 mb-6">Perbarui detail menu</p>

      <?php if ($success): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
          <p>Menu berhasil diperbarui!</p>
        </div>
      <?php endif; ?>

      <?php if (!empty($errors)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
          <ul class="list-disc pl-5">
            <?php foreach ($errors as $error): ?>
              <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form method="POST" action="" enctype="multipart/form-data" class="space-y-6" id="menu-form">
        <div class="space-y-2">
          <label for="name" class="block font-medium">Nama Menu</label>
          <input type="text" id="name" name="name"
            class="w-full p-2 border rounded-md" required
            value="<?= htmlspecialchars($_POST['name'] ?? $foodItem['name']) ?>">
        </div>

        <div class="space-y-2">
          <label for="category_id" class="block font-medium">Kategori</label>
          <select id="category_id" name="category_id" class="w-full p-2 border rounded-md" required>
            <option value="">Pilih kategori</option>
            <?php foreach ($categories as $category): ?>
              <option value="<?= $category['id'] ?>" <?= (($_POST['category_id'] ?? $foodItem['category_id']) == $category['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($category['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="space-y-2">
          <label for="price" class="block font-medium">Harga (Rp)</label>
          <input type="number" id="price" name="price" min="0"
            class="w-full p-2 border rounded-md" required
            value="<?= htmlspecialchars($_POST['price'] ?? $foodItem['price']) ?>">
        </div>

        <div class="space-y-2">
          <label for="stock" class="block font-medium">Stok</label>
          <input type="number" id="stock" name="stock" min="0"
            class="w-full p-2 border rounded-md" required
            value="<?= htmlspecialchars($_POST['stock'] ?? $foodItem['stock']) ?>">
        </div>

        <div class="space-y-2">
          <label for="description" class="block font-medium">Deskripsi</label>
          <textarea id="description" name="description"
            rows="4" class="w-full p-2 border rounded-md" required><?= htmlspecialchars($_POST['description'] ?? $foodItem['description']) ?></textarea>
        </div>

        <?php if ($foodItem['image']): ?>
          <div class="space-y-2">
            <label class="block font-medium">Gambar Saat Ini</label>
            <div class="w-32 h-32 rounded-md overflow-hidden">
              <img src="<?= htmlspecialchars('../' . $foodItem['image']) ?>" alt="<?= htmlspecialchars($foodItem['name']) ?>" class="w-full h-full object-cover">
            </div>
          </div>
        <?php endif; ?>

        <div class="space-y-2">
          <label for="image" class="block font-medium">Gambar Baru (Opsional)</label>
          <input type="file" id="image" name="image" accept="image/*" class="w-full p-2 border rounded-md">
          <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar</p>
        </div>

        <div class="flex gap-4">
          <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition-colors">
            Simpan Perubahan
          </button>
          <a href="index.php" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded-md text-center transition-colors">
            Batal
          </a>
        </div>
      </form>
    </div>
  </div>

  <!-- JavaScript untuk validasi form -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.getElementById('menu-form');
      if (form) {
        form.addEventListener('submit', function(event) {
          const name = document.getElementById('name').value.trim();
          const category = document.getElementById('category_id').value;
          const price = parseInt(document.getElementById('price').value);
          const stock = parseInt(document.getElementById('stock').value);
          const description = document.getElementById('description').value.trim();

          let isValid = true;
          let errorMessage = '';

          if (!name) {
            errorMessage += 'Nama menu harus diisi\n';
            isValid = false;
          }

          if (!category) {
            errorMessage += 'Kategori harus dipilih\n';
            isValid = false;
          }

          if (isNaN(price) || price <= 0) {
            errorMessage += 'Harga harus lebih dari 0\n';
            isValid = false;
          }

          if (isNaN(stock) || stock < 0) {
            errorMessage += 'Stok tidak boleh negatif\n';
            isValid = false;
          }

          if (!description) {
            errorMessage += 'Deskripsi harus diisi\n';
            isValid = false;
          }

          if (!isValid) {
            alert(errorMessage);
            event.preventDefault();
          }
        });
      }
    });
  </script>
