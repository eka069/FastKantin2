@extends('layout.master')

@section('title', 'Beranda')

@section('content')
  <!-- Detail Page -->
  <div class="container mx-auto px-4">
    <div class="bg-white rounded-xl p-6 grid grid-cols-1 md:grid-cols-2 gap-8">

      <!-- Kolom Kiri: Gambar -->
      <div class="w-full">
        <img src="https://picsum.photos/600/400?random=1"
             alt="Contoh Gambar Barang"
             class="rounded-lg shadow-sm object-cover w-full h-80 md:h-full">
      </div>

      <!-- Kolom Kanan: Info & Form -->
      <div>
        <h2 class="text-2xl font-bold mb-2 text-gray-900">{{$foodItem ->name}}</h2>
        <span class="block text-sm text-gray-600 mb-1">{{$foodItem->category->name}}</span>
        <p class="text-sm text-gray-600 mb-4">Stok tersedia: <span class="font-semibold text-green-600">{{$foodItem->stock}}</span></p>

        <p class="text-gray-700 mb-6">
         {{ $foodItem->description ?: 'Tidak ada deskripsi tersedia.' }}
        </p>

        <!-- Form -->
        <form method="POST" action="{{ route('order.store') }}">
          @csrf
            @method('POST')
          {{-- input nama makanan --}}
          <input type="hidden" name="food_id" value="{{ request()->route('id') }}">

          <!-- Input jumlah -->
          <div class="mb-4">
            <label class="block text-gray-700 mb-1">Jumlah yang ingin dibeli</label>
            <input
              type="number"
              name="qty"
              id="qty"
              min="1"
              max="27"
              value="1"
              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
              required
            />
          </div>

          <!-- Total harga -->
          <div class="mb-4">
            <label class="block text-gray-700 mb-1">Total Harga</label>
            <input
              type="text"
              id="totalPrice"
              class="w-full bg-gray-100 border border-gray-300 rounded-lg px-3 py-2"
              value="Rp {{ number_format($foodItem->price, 0, ',', '.') }}"
              readonly
            />
          </div>

           <div class="space-y-2">
                        <label for="payment_method" class="block font-medium">Metode Pembayaran</label>
                        <select id="payment_method" name="payment_method" class="w-full p-2 border rounded-md" required>
                            <option value="">Pilih metode pembayaran</option>
                            <option value="cash" selected>Tunai (Bayar di Tempat)</option>
                            <option value="transfer">Transfer Bank</option>
                            <option value="qris">QRIS</option>
                        </select>
                    </div>

          <!-- Catatan -->
          <div class="mb-4">
            <label class="block text-gray-700 mb-1">Catatan</label>
            <textarea
              name="note"
              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Contoh: tanpa pedas atau tambahan kerupuk"
            ></textarea>
          </div>

          <!-- Waktu Pengambilan -->
          <div class="mb-4">
            <label class="block text-gray-700 mb-1">Waktu Pengambilan</label>
            <input
              type="time"
              name="pickup_time"
              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
              required
            />
          </div>

          <!-- Submit -->
          <button
            type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg"
          >
            Konfirmasi Pembelian
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Script untuk update total harga -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const qtyInput = document.getElementById('qty');
      const totalPriceInput = document.getElementById('totalPrice');
    // Ambil harga satuan dari value awal input totalPrice
    const hargaPerItem = parseInt(
      totalPriceInput.value.replace(/[^\d]/g, '')
    ) || 0;

      qtyInput.addEventListener('input', function () {
        const qty = parseInt(qtyInput.value) || 1;
        const total = qty * hargaPerItem;
        totalPriceInput.value = 'Rp ' + total.toLocaleString('id-ID');
      });
    });
  </script>
@endsection
