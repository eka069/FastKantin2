@extends('layout.main')

@section('content')
<div class="container max-w-md mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold">Masuk ke Akun</h1>
        <p class="text-gray-600 mt-2">Masukkan nama dan password Anda untuk melanjutkan</p>
    </div>

    <div class="bg-white rounded-lg border p-6">
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div>
                <label for="Name" class="block font-medium mb-1">Name</label>
                <input type="name" id="name" name="name" value="{{ old('name') }}"
                    class="w-full p-2 border rounded-md" required>
            </div>

            <div>
                <label for="password" class="block font-medium mb-1">Password</label>
                <input type="password" id="password" name="password"
                    class="w-full p-2 border rounded-md" required>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-700">Ingat saya</label>
                </div>

                <a href="#" class="text-sm text-blue-600 hover:underline">Lupa password?</a>
            </div>

            <div>
                <label for="role" class="block font-medium mb-1">Role</label>
                <select id="role" name="role" class="w-full p-2 border rounded-md" required>
                    <option value="" selected disabled>Pilih role</option>
                    <option value="user">User</option>
                    <option value="seller">Seller</option>
                </select>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition-colors">
                    Masuk
                </button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Daftar sekarang</a>
            </p>
        </div>
    </div>
</div>
@endsection
