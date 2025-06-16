@extends('layout.master')

@section('title', 'Pembayaran')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Pembayaran</h1>



    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Pembayaran -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg border p-6">
                <h2 class="text-xl font-semibold mb-4">Informasi Pesanan</h2>



                <form class="space-y-6">
                    <div class="space-y-2">
                        <label for="customer_name" class="block font-medium">Nama Pemesan</label>
                        <input type="text" id="customer_name" name="customer_name"
                            class="w-full p-2 border rounded-md" required value="Nama Contoh">
                    </div>

                    <div class="space-y-2">
                        <label for="phone" class="block font-medium">Nomor Telepon</label>
                        <input type="tel" id="phone" name="phone"
                            class="w-full p-2 border rounded-md" value="08123456789">
                    </div>

                    <div class="space-y-2">
                        <label for="pickup_time" class="block font-medium">Waktu Pengambilan</label>
                        <select id="pickup_time" name="pickup_time" class="w-full p-2 border rounded-md" required>
                            <option value="">Pilih waktu pengambilan</option>
                            <option value="08:00" selected>08:00 WIB</option>
                            <option value="08:30">08:30 WIB</option>
                            <option value="09:00">09:00 WIB</option>
                        </select>
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

                    <div class="space-y-2">
                        <label for="notes" class="block font-medium">Catatan (Opsional)</label>
                        <textarea id="notes" name="notes" rows="3"
                            class="w-full p-2 border rounded-md">Contoh catatan</textarea>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-md transition-colors">
                            Konfirmasi Pesanan
                        </button>
                        <a href="#" class="w-full block text-center mt-2 text-blue-600 hover:underline">
                            Kembali ke Keranjang
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Ringkasan Pesanan -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg border p-4 sticky top-4">
                <h2 class="font-semibold mb-4">Ringkasan Pesanan</h2>

                <div class="space-y-4 mb-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium">Nasi Goreng</p>
                            <p class="text-sm text-gray-600">2 x Rp 15.000</p>
                        </div>
                        <p class="font-medium">Rp 30.000</p>
                    </div>

                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium">Es Teh</p>
                            <p class="text-sm text-gray-600">1 x Rp 5.000</p>
                        </div>
                        <p class="font-medium">Rp 5.000</p>
                    </div>
                </div>

                <hr class="my-4">

                <div class="flex justify-between font-bold">
                    <span>Total</span>
                    <span>Rp 35.000</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
