@extends('layout.master')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Riwayat Pesanan</h1>

    <div class="bg-white rounded-lg border overflow-hidden shadow-md">
        <div class="p-4 border-b bg-gray-50">
            <h2 class="font-semibold text-gray-700">Daftar Pesanan</h2>
        </div>

        {{-- Jika tidak ada pesanan --}}
        {{--
        <div class="p-8 text-center">
            <svg class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2..." />
            </svg>
            <h3 class="text-lg font-medium mb-2">Belum Ada Pesanan</h3>
            <p class="text-gray-600 mb-4">Anda belum memiliki riwayat pesanan</p>
            <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition">Lihat Menu</a>
        </div>
        --}}

        {{-- Jika ada pesanan --}}
        <div class="divide-y">
            <div class="p-6">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="font-semibold text-lg">Pesanan #1234</h3>
                        <p class="text-sm text-gray-500">12 Juni 2025, 10:30 WIB</p>
                    </div>
                    <span class="bg-green-100 text-green-700 text-xs font-medium px-3 py-1 rounded-full">Selesai</span>
                </div>

                <div class="flex items-start gap-4 mt-2">
                    <img src="https://via.placeholder.com/100" alt="Nasi Goreng" class="w-20 h-20 rounded-md object-cover">
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-800">Nasi Goreng Spesial</h4>
                        <p class="text-sm text-gray-600">Jumlah: 2 × Rp 15.000</p>
                        <p class="text-sm font-semibold mt-1">Total: Rp 30.000</p>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t text-sm text-gray-700">
                    <p><span class="font-semibold">Waktu Pengambilan:</span> 11:00 WIB</p>
                    <p class="mt-1"><span class="font-semibold">Catatan:</span> Tanpa sambal</p>
                </div>
            </div>

            {{-- Tambahkan pesanan lain di bawah ini jika perlu --}}
        </div>
    </div>
</div>
@endsection
