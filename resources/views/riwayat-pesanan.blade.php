@extends('layout.master')

@section('title', 'Riwayat Pesanan')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-3xl">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Riwayat Pesanan</h1>

        @forelse ($history as $order)
            <div class="rounded-lg border overflow-hidden shadow-md mb-6">
                <div class="p-4 border-b bg-gray-50">
                    <h2 class="font-semibold text-gray-700">Pesanan #{{ $order->id }}</h2>
                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($order->created_at)->format('d F Y, H:i') }}
                        WIB</p>
                </div>

                <div class="p-6">
                    @foreach ($order->orderItems as $item)
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex items-start gap-4">
                                <img src="{{ Storage::url($item->foodItem->image) }}" alt="Menu"
                                    class="w-20 h-20 rounded-md object-cover">
                                <div>
                                    <h4 class="font-medium text-gray-800">
                                        {{ $item->foodItem->name ?? 'Menu tidak ditemukan' }}
                                    </h4>
                                    <p class="text-sm text-gray-600">
                                        Jumlah: {{ $item->quantity }} × Rp
                                        {{ number_format($item->price_per_item, 0, ',', '.') }}
                                    </p>
                                    <p class="text-sm font-semibold mt-1">
                                        Total: Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </p>

                                    {{-- Status pesanan --}}
                                    <p class="text-sm mt-1">
                                        <strong>Status:</strong>
                                        @if ($order->status == 'pending')
                                            <span class="inline-block px-2 py-1 rounded text-xs font-semibold bg-yellow-200 text-yellow-800">Pending</span>
                                        @elseif ($order->status == 'success')
                                            <span class="inline-block px-2 py-1 rounded text-xs font-semibold bg-green-200 text-green-800">Sukses</span>
                                        @elseif ($order->status == 'failed')
                                            <span class="inline-block px-2 py-1 rounded text-xs font-semibold bg-red-200 text-red-800">Gagal</span>
                                        @else
                                            <span class="inline-block px-2 py-1 rounded text-xs font-semibold bg-gray-200 text-gray-800">{{ ucfirst($order->status) }}</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-4 pt-3 border-t text-sm text-gray-700">
                        <p><span class="font-semibold">Waktu Pengambilan:</span> {{ $order->pickup_time }}</p>
                        <p class="mt-1">
                            <span class="font-semibold">Catatan:</span>
                            {{ $order->note ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500">Belum ada riwayat pesanan.</p>
        @endforelse
    </div>
@endsection
