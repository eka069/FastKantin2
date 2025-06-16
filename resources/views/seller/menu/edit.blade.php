@extends('layout.main')

@section('title', 'Beranda')

@section('content')

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


      <form action="{{ route('menu.update', $menu->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="space-y-2">
          <label for="name" class="block font-medium">Nama Menu</label>
          <input type="text" id="name" name="name"
            class="w-full p-2 border rounded-md" required
            value="<?= htmlspecialchars($_POST['name'] ?? $menu['name']) ?>">
        </div>

        <div class="space-y-2">
          <label for="category_id" class="block font-medium">Kategori</label>
          <select id="category_id" name="category_id" class="w-full p-2 border rounded-md" required>
            <option value="">Pilih kategori</option>
            <?php foreach ($category as $c): ?>
              <option value="<?= $c['id'] ?>" <?= (($_POST['category_id'] ?? $menu['category_id']) == $c['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($c['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="space-y-2">
          <label for="price" class="block font-medium">Harga (Rp)</label>
          <input type="number" id="price" name="price" min="0"
            class="w-full p-2 border rounded-md" required
            value="<?= htmlspecialchars($_POST['price'] ?? $menu['price']) ?>">
        </div>

        <div class="space-y-2">
          <label for="stock" class="block font-medium">Stok</label>
          <input type="number" id="stock" name="stock" min="0"
            class="w-full p-2 border rounded-md" required
            value="<?= htmlspecialchars($_POST['stock'] ?? $menu['stock']) ?>">
        </div>

        <div class="space-y-2">
          <label for="description" class="block font-medium">Deskripsi</label>
          <textarea id="description" name="description"
            rows="4" class="w-full p-2 border rounded-md" required><?= htmlspecialchars($_POST['description'] ?? $menu['description']) ?></textarea>
        </div>

        <?php if ($menu['image']): ?>
          <div class="space-y-2">
            <label class="block font-medium">Gambar Saat Ini</label>
            <div class="w-32 h-32 rounded-md overflow-hidden">
              <img src="<?= htmlspecialchars('../' . $menu['image']) ?>" alt="<?= htmlspecialchars($menu['name']) ?>" class="w-full h-full object-cover">
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
          <a href="{{ route('menu.index') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded-md text-center transition-colors">
            Batal
        </a>
        </div>
      </form>
    </div>
  </div>

  @endsection
