@extends('layout.main')

@section('title', 'Dashboard Seller')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Category</h1>
        <a href="{{ route('category.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md flex items-center transition-colors">
            Tambah Category
        </a>

    </div>

    <!-- Menu tab -->
    <div id="menu-tab" class="tab-content">
        <table class="min-w-full bg-white border rounded-lg">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-sm">
                    <th class="py-3 px-4 text-left">ID</th>
                    <th class="py-3 px-4 text-left">Kategori</th>
                    <th class="py-3 px-4 text-left">aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Contoh data menu -->
                @foreach ( $category as $c )



                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3 px-4">{{$c->id}}</td>
                    <td class="py-3 px-4">{{$c->name}}</td>
                    <td class="py-3 px-4"> <a href="{{ route('category.edit',{{$c->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md flex items-center transition-colors">
                       Edit Kategori
                    </a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
