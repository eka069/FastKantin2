@extends('layout.seller')

@section('title', 'Tambah Menu')

@section('seller-content')
    <h1 class="text-2xl font-bold mb-4">Tambah Menu Baru</h1>
    <!-- Form tambah menu -->
@endsection

<!-- Konten Utama -->
<div class="container max-w-2xl mx-auto px-4 py-8">
    <a href="index.php" class="flex items-center text-gray-600 mb-6 hover:text-gray-900 transition-colors">
      <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
      </svg>
      Kembali ke Dashboard
    </a>

    <div class="bg-white rounded-lg border p-6">
      <h1 class="text-2xl font-bold mb-2">Tambah Menu Baru</h1>
      <p class="text-gray-600 mb-6">Isi detail menu yang ingin ditambahkan</p>

      <form method="POST" action="{{route('menu.store')}}" class="space-y-6" id="menu-form">
        @method('post')
        @csrf

          <div class="space-y-2">
            <label for="name" class="block font-medium">Nama Menu</label>
            <input type="text" id="name" name="name" placeholder="Masukkan nama menu"
              class="w-full p-2 border rounded-md" required
              value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
          </div>

          <div class="space-y-2">
            <label for="category_id" class="block font-medium">Kategori</label>
            <select id="category_id" name="category_id" class="w-full p-2 border rounded-md" required>
                @foreach ($category as $c )
                    <option value="">{{$c->name}}</option>
                @endforeach

            </select>
          </div>

          <div class="space-y-2">
            <label for="price" class="block font-medium">Harga (Rp)</label>
            <input type="number" id="price" name="price" min="0" placeholder="Masukkan harga"
              class="w-full p-2 border rounded-md" required
              value="<?= htmlspecialchars($_POST['price'] ?? '') ?>">
          </div>

          <div class="space-y-2">
            <label for="stock" class="block font-medium">Stok</label>
            <input type="number" id="stock" name="stock" min="0" placeholder="Masukkan jumlah stok"
              class="w-full p-2 border rounded-md" required
              value="<?= htmlspecialchars($_POST['stock'] ?? '') ?>">
          </div>

          <div class="space-y-2">
            <label for="description" class="block font-medium">Deskripsi</label>
            <textarea id="description" name="description" placeholder="Masukkan deskripsi menu"
              rows="4" class="w-full p-2 border rounded-md" required><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
          </div>

          <div class="space-y-2">
            <label for="image" class="block font-medium">Gambar</label>
            <input type="file" id="image" name="image" accept="image/*" class="w-full p-2 border rounded-md">
            <p class="text-xs text-gray-500 mt-1">Format yang didukung: JPG, PNG, GIF. Ukuran maksimal: 2MB</p>
          </div>

          <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition-colors">
              Simpan Menu
            </button>
            <a href="index.php" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded-md text-center transition-colors">
              Batal
            </a>
          </div>
        </form>
    </div>
  </div>

