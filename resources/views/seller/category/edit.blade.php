@extends('layout.main')

@section('title', 'Edit Kategori')

@section('content')

<!-- Konten Utama -->
<div class="container max-w-2xl mx-auto px-4 py-8">
    <a href="{{ route('category.index') }}" class="flex items-center text-gray-600 mb-6 hover:text-gray-900 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Dashboard
    </a>

    <div class="bg-white rounded-lg border p-6">
        <h1 class="text-2xl font-bold mb-2">Edit Kategori</h1>
        <p class="text-gray-600 mb-6">Perbarui detail kategori</p>

        <form action="{{ route('category.update', $category->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="space-y-2 mb-6">
                <label for="name" class="block font-medium">Nama Kategori</label>
                <input type="text" id="name" name="name" placeholder="Masukkan nama kategori"
                    class="w-full p-2 border rounded-md" required
                    value="{{ old('name', $category->name) }}">
            </div>

            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition-colors">
                    Simpan Perubahan
                </button>
                <a href="{{ route('category.index') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded-md text-center transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
