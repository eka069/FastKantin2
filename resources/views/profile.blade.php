@extends('layout.master')

@section('title', 'Profil Saya')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Profil Saya</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Sidebar -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-lg border p-4">
                <div class="flex items-center mb-4">
                    @if($user->image)
                        <img src="{{ asset('storage/' . $user->image) }}" alt="Foto Profil" class="w-16 h-16 rounded-full object-cover">
                    @else
                        <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="ml-4">
                        <h2 class="font-semibold">{{$user->name}}</h2>
                        <p class="text-sm text-gray-600">{{$user->email}}</p>
                    </div>
                </div>

                <hr class="my-4">

                <nav>
                    <ul class="space-y-2">
                        <li>
                            <a href="#" class="flex items-center py-2 px-3 rounded-md bg-blue-50 text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24" stroke="currentColor" fill="none">
                                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Profil Saya
                            </a>
                        </li>



                    </ul>
                </nav>
            </div>
        </div>

        <!-- Konten Profil -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg border p-6">
                <h2 class="text-xl font-semibold mb-4">Informasi Profil</h2>


                <form method="POST" action="#" class="space-y-4">
                    <div>
                        <label for="name" class="block font-medium mb-1">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{$user->name}}"
                            class="w-full p-2 border rounded-md" required>
                    </div>

                    <div>
                        <label for="email" class="block font-medium mb-1">Email</label>
                        <input type="email" id="email" value="{{ $user->email }}"
                            class="w-full p-2 border rounded-md bg-gray-50" readonly>
                        <p class="text-xs text-gray-500 mt-1">Email tidak dapat diubah</p>
                    </div>

                    <div>
                        <label for="phone" class="block font-medium mb-1">Nomor Telepon</label>
                        <input type="tel" id="phone" name="phone" value="{{ $user->phone }}"
                            class="w-full p-2 border rounded-md">
                    </div>

                    <div>
                        <label for="created_at" class="block font-medium mb-1">Tanggal Bergabung</label>
                        <input type="text" id="created_at" value="{{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('d F Y') }}"
                            class="w-full p-2 border rounded-md bg-gray-50" readonly>
                    </div>

                    <div class="pt-4">
                        <a href="{{ route('profile.edit', $user->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition-colors inline-block text-center">
                            Edit
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
