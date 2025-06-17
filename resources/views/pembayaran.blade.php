@extends('layout.master')

@section('title', 'Pembayaran')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Pembayaran</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg border p-6">
                <h2 class="text-xl font-semibold mb-4">Informasi Pesanan</h2>
                <form action="{{ route('order.checkout') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('POST')
                    <div class="space-y-2">
                        <label class="block font-medium">Nama Pemesan</label>
                        <input type="text" disabled name="name" class="w-full p-2 border rounded-md" required value="{{ auth()->user()->name }}">
                    </div>

                    <div class="space-y-2">
                        <label class="block font-medium">Nomor Telepon</label>
                        <input type="tel" name="phone" class="w-full p-2 border rounded-md" required value="{{auth()->user()->phone}}">
                    </div>

                    <div class="space-y-2">
                        <label class="block font-medium">Waktu Pengambilan</label>
                        <select name="pickup_time" class="w-full p-2 border rounded-md" required>
                            <option disabled selected>-- Pilih waktu --</option>
                            <option value="08:00" {{ old('pickup_time') == '08:00' ? 'selected' : '' }}>08:00 WIB</option>
                            <option value="08:30" {{ old('pickup_time') == '08:30' ? 'selected' : '' }}>08:30 WIB</option>
                            <option value="09:00" {{ old('pickup_time') == '09:00' ? 'selected' : '' }}>09:00 WIB</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block font-medium">Metode Pembayaran</label>
                        <select name="payment_method" class="w-full p-2 border rounded-md" required>
                            <option disabled selected>-- Pilih metode --</option>
                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Tunai</option>
                            <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                            <option value="qris" {{ old('payment_method') == 'qris' ? 'selected' : '' }}>QRIS</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block font-medium">Catatan</label>
                        <textarea name="note" rows="3" class="w-full p-2 border rounded-md">{{ old('note') }}</textarea>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-3 px-4 rounded-md">Konfirmasi Pesanan</button>
                </form>
            </div>
        </div>

        <!-- Ringkasan -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg border p-4 sticky top-4">
                <h2 class="font-semibold mb-4">Ringkasan Pesanan</h2>
                <div class="space-y-4 mb-4">
                    @php $total = 0; @endphp
                    @foreach ($cart as $item)
                        @php
                            $subtotal = $item->qty * $item->foodItem->price;
                            $total += $subtotal;
                        @endphp
                        <div class="flex justify-between">
                            <div>
                                <p class="font-medium">{{ $item->foodItem->name }}</p>
                                <p class="text-sm text-gray-600">{{ $item->qty }} x Rp {{ number_format($item->foodItem->price, 0, ',', '.') }}</p>
                            </div>
                            <p class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>
                <hr class="my-4">
                <div class="flex justify-between font-bold">
                    <span>Total</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
