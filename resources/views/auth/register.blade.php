@extends('layout.main')

@section('title', 'Daftar Akun')

@section('content')
<div class="container max-w-md mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold">Daftar Akun Baru</h1>
        <p class="text-gray-600 mt-2">Isi form di bawah untuk membuat akun baru</p>
    </div>

    <div class="bg-white rounded-lg border p-6">
        {{-- Tampilkan Error --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Tampilkan pesan sukses --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Form Registrasi --}}
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block font-medium mb-1">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="w-full p-2 border rounded-md" required>
            </div>

            <div>
                <label for="email" class="block font-medium mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="w-full p-2 border rounded-md" required>
            </div>

            <div>
                <label for="phone" class="block font-medium mb-1">Nomor Telepon (Opsional)</label>
                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                    class="w-full p-2 border rounded-md">
            </div>

            <div>
                <label for="password" class="block font-medium mb-1">Password</label>
                <input type="password" name="password" id="password"
                    class="w-full p-2 border rounded-md" required>
                <p class="text-xs text-gray-500 mt-1">Minimal 6 karakter</p>
            </div>

            <div>
                <label for="password_confirmation" class="block font-medium mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="w-full p-2 border rounded-md" required>
            </div>

            <div>
                <label for="role" class="block font-medium mb-1">Role</label>
                <select name="role" id="role" class="w-full p-2 border rounded-md" required>
                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih role</option>
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Pengguna</option>
                    <option value="seller" {{ old('role') == 'seller' ? 'selected' : '' }}>Penjual</option>
                </select>
            </div>

            <div class="pt-4">
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition-colors">
                    Daftar
                </button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Masuk</a>
            </p>
        </div>
    </div>
</div>
@endsection
