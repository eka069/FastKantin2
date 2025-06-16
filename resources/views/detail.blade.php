@extends('layout.master')
@section('title', 'Beranda')
@section('content')
  <!-- Detail Page -->
  <div class="container mx-auto px-4">
    <div class="bg-white rounded-xl  p-6 grid grid-cols-1 md:grid-cols-2 gap-8">

      <!-- Kolom Kiri: Gambar -->
      <div class="w-full">
        <img src="https://picsum.photos/600/400?random=1"
             alt="Contoh Gambar Barang"
             class="rounded-lg shadow-sm object-cover w-full h-80 md:h-full">
          </div>

      <!-- Kolom Kanan: Info & Form -->
      <div>
        <h2 class="text-2xl font-bold mb-2 text-gray-900">Nasi Goreng Spesial</h2>
        <span class="block text-sm text-gray-600 mb-1">Makanan</span>
        <p class="text-sm text-gray-600 mb-4">Stok tersedia: <span class="font-semibold text-green-600">27</span></p>

        <p class="text-gray-700 mb-6">
          Nasi goreng spesial dengan campuran ayam, telur, sayur dan bumbu rahasia yang menggugah selera.
        </p>

        <!-- Form -->
        <form>
          <div class="mb-4">
            <label class="block text-gray-700 mb-1">Jumlah yang ingin dibeli</label>
            <input type="number" min="1" max="27" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan jumlah" />
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 mb-1">Catatan</label>
            <textarea class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: tanpa pedas atau tambahan kerupuk"></textarea>
          </div>

          <button type="submit" formaction="{{ route('order.success') }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg">
            Konfirmasi Pembelian
          </button>
        </form>
      </div>

    </div>
  </div>

@endsection
