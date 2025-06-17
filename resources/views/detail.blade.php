@extends('layout.master')

@section('title', 'Beranda')

@section('content')
<div class="container mx-auto px-4 py-8">
  <div class="bg-white rounded-xl p-6 grid grid-cols-1 md:grid-cols-2 gap-10 items-start">

    <!-- Kolom Kiri: Gambar + Info -->
    <div>
      <img src="{{ $foodItem->image ? asset('storage/' . $foodItem->image) : 'https://picsum.photos/600/400?random=1' }}"
           alt="{{ $foodItem->name }}"
           class="rounded-xl shadow-lg object-cover w-full h-72 md:h-96 mb-6">

      <div class="space-y-2">
        <h2 class="text-2xl font-bold text-gray-900">{{ $foodItem->name }}</h2>
        <span class="text-sm text-gray-600">{{ $foodItem->category->name }}</span>
        <p class="text-sm text-gray-700">Stok tersedia: <span class="font-semibold text-green-600">{{ $foodItem->stock }}</span></p>
        <p class="text-gray-800 mt-4">
          {{ $foodItem->description ?: 'Tidak ada deskripsi tersedia.' }}
        </p>
      </div>
    </div>

    <!-- Kolom Kanan: Form -->
    <div class="bg-gray-50 p-6 rounded-lg shadow-md w-full">
      <form method="POST" action="{{ route('order.store') }}">
        @csrf
        @method('POST')

        <!-- hidden food_id -->
        <input type="hidden" name="food_id" value="{{ request()->route('id') }}">

        <!-- Input jumlah -->
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1">Jumlah</label>
          <input
            type="number"
            name="qty"
            id="qty"
            min="1"
            max="{{ $foodItem->stock }}"
            value="1"
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          />
        </div>

        <!-- Total harga -->
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1">Total Harga</label>
          <input
            type="text"
            id="totalPrice"
            class="w-full bg-gray-100 border border-gray-300 rounded-md px-3 py-2"
            value="Rp {{ number_format($foodItem->price, 0, ',', '.') }}"
            readonly
          />
        </div>

        <!-- Metode Pembayaran -->
        <div class="mb-4">
          <label for="payment_method" class="block text-gray-700 font-medium mb-1">Metode Pembayaran</label>
          <select id="payment_method" name="payment_method" class="w-full p-2 border rounded-md" required>
            <option value="">Pilih metode pembayaran</option>
            <option value="cash" selected>Tunai (Bayar di Tempat)</option>
            <option value="transfer">Transfer Bank</option>
            <option value="qris">QRIS</option>
          </select>
        </div>

        <!-- Catatan -->
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1">Catatan</label>
          <textarea
            name="note"
            rows="3"
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Contoh: tanpa pedas atau tambahan kerupuk"
          ></textarea>
        </div>

        <!-- Waktu Pengambilan -->
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1">Waktu Pengambilan</label>
          <input
            type="time"
            name="pickup_time"
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          />
        </div>

        <!-- Submit -->
        <button
          type="submit"
          class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-md transition"
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
