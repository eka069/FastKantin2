@extends('layout.master')

@section('title', 'Edit Profil')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6 text-center">Edit Profil</h1>

    <div class="max-w-xl mx-auto p-6 ">
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update', $user->id) }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Preview Gambar -->
            <div class="text-center">
                <img id="imagePreview"
                     src="{{ $user->image ? asset('storage/'.$user->image) : asset('assets/images/avatars/Default_pfp.jpg') }}"
                     class="w-24 h-24 rounded-full object-cover mx-auto mb-4 border"
                     alt="Foto Profil">
            </div>

            <!-- Upload Gambar -->
            <div>
                <label for="image" class="block font-medium mb-1">Foto Profil</label>
                <input type="file" id="image" name="image"
                       class="w-full p-2 border rounded-md" accept="image/*">
                @error('image')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama -->
            <div>
                <label for="name" class="block font-medium mb-1">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                       class="w-full p-2 border rounded-md" required>
                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nomor Telepon -->
            <div>
                <label for="phone" class="block font-medium mb-1">Nomor Telepon</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                       class="w-full p-2 border rounded-md">
                @error('phone')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 flex justify-between items-center">
                <a href="{{ route('profile.index') }}" class="text-gray-600 hover:underline">← Kembali</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- jQuery Preview Gambar --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $('#image').on('change', function () {
        const [file] = this.files;
        if (file) {
            $('#imagePreview').attr('src', URL.createObjectURL(file));
        }
    });
</script>
@endsection
