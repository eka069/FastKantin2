@extends('layout.main')

@section('title', 'Dashboard Seller')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Dashboard Seller</h1>
        <a href="{{ route('menu.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md flex items-center transition-colors">
            Tambah Menu Baru
        </a>

    </div>
    @if(session('error'))
    <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

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
                    <th class="py-3 px-4 text-left">Descriiption</th>
                    <th class="py-3 px-4 text-left">aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($menu as $m)
                         <!-- Contoh data menu -->
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3 px-4">{{$m -> name}}</td>
                    <td class="py-3 px-4">{{$m -> category ->name}}</td>
                    <td class="py-3 px-4">{{$m -> price}}</td>
                    <td class="py-3 px-4">{{$m -> stock}}</td>
                    <td class="py-3 px-4">{{$m -> description}}</td>
                    <td class="py-3 px-4"> <a href="{{ route('menu.edit',1) }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md flex items-center transition-colors">
                       Edit Menu
                    </a></td>
                </tr>
                @endforeach


            </tbody>
        </table>
    </div>

</div>
@endsection
