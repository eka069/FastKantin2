@extends('layout.seller')

@section('title', 'Dashboard Seller')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Dashboard Seller</h1>
        <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md flex items-center transition-colors">
            Tambah Menu Baru
        </a>
    </div>

    <!-- Tabs -->
    <div class="mb-8">
        <div class="border-b">
            <ul class="flex flex-wrap -mb-px">
                <li class="mr-2">
                    <a href="#" class="inline-block p-4 border-b-2 border-blue-600 text-blue-600 font-medium tab-link active" data-tab="menu">
                        Menu Makanan
                    </a>
                </li>
                <li class="mr-2">
                    <a href="#" class="inline-block p-4 border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 font-medium tab-link" data-tab="orders">
                        Pesanan Masuk
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Menu tab -->
    <div id="menu-tab" class="tab-content">
        <table class="min-w-full bg-white border rounded-lg">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-sm">
                    <th class="py-3 px-4 text-left">Menu</th>
                    <th class="py-3 px-4 text-left">Kategori</th>
                    <th class="py-3 px-4 text-left">Harga</th>
                    <th class="py-3 px-4 text-left">Stok</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($foodItems as $item)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-md overflow-hidden">
                                <img src="{{ $item->image ? asset($item->image) : 'https://via.placeholder.com/100' }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                            </div>
                            <span class="font-medium">{{ $item->name }}</span>
                        </div>
                    </td>
                    <td class="py-3 px-4">{{ $item->category_name }}</td>
                    <td class="py-3 px-4">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="py-3 px-4">{{ $item->stock }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Orders tab -->
    <div id="orders-tab" class="tab-content hidden">
        <table class="min-w-full bg-white border rounded-lg">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-sm">
                    <th class="py-3 px-4 text-left">ID Pesanan</th>
                    <th class="py-3 px-4 text-left">Nama Pemesan</th>
                    <th class="py-3 px-4 text-left">Menu</th>
                    <th class="py-3 px-4 text-left">Jumlah</th>
                    <th class="py-3 px-4 text-left">Waktu Ambil</th>
                    <th class="py-3 px-4 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3 px-4 font-medium">#{{ $order->id }}</td>
                    <td class="py-3 px-4">{{ $order->customer_name }}</td>
                    <td class="py-3 px-4">{{ $order->foodItem->name ?? '-' }}</td>
                    <td class="py-3 px-4">{{ $order->quantity }}</td>
                    <td class="py-3 px-4">{{ $order->pickup_time }} WIB</td>
                    <td class="py-3 px-4">
                        <span class="@php echo getStatusBadgeClass($order->status); @endphp">
                            {{ getStatusLabel($order->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Tab JS -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabLinks = document.querySelectorAll('.tab-link');
        const tabContents = document.querySelectorAll('.tab-content');

        tabLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                tabLinks.forEach(tab => {
                    tab.classList.remove('active', 'border-blue-600', 'text-blue-600');
                    tab.classList.add('border-transparent');
                });
                this.classList.add('active', 'border-blue-600', 'text-blue-600');
                this.classList.remove('border-transparent');
                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });
                const tabId = this.getAttribute('data-tab');
                document.getElementById(tabId + '-tab').classList.remove('hidden');
            });
        });
    });
</script>
@endsection
