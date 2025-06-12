@php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!function_exists('getCartCount')) {
        require_once base_path('functions/cart_functions.php');
    }

    $cart_count = function_exists('getCartCount') ? getCartCount() : 0;
    $baseUrl = url('/');
@endphp

<header class="border-b bg-white shadow-md fixed top-0 left-0 w-full z-50">
    <div class="container mx-auto px-4 py-3 flex items-center justify-between">
        <a href="{{ url('index') }}" class="font-bold text-xl">FAST KANTIN</a>

        <nav class="flex items-center gap-4 w-1/2 justify-end">
            @if (auth()->check() && auth()->user()->role === 'user')
                <a href="{{ url('user') }}" class="text-sm font-medium text-blue-600 hover:text-blue-600 transition-colors">Menu</a>
            @endif
            @if (auth()->check() && auth()->user()->role === 'seller')
                <a href="{{ url('seller/index') }}" class="text-sm font-medium hover:text-blue-600">Penjual</a>
            @endif

            <div class="flex items-center gap-2">
                {{-- @if (auth()->check() && auth()->user()->role === 'user') --}}
                <a href="{{route('keranjang') }}" class="p-2 hover:bg-gray-100 rounded-full relative">
                        <!-- Icon keranjang -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span class="sr-only">Keranjang</span>
                    </a>
                {{-- @endif --}}

                <!-- Profil -->
                <div class="relative">
                    <button id="profile-button" class="p-2 hover:bg-gray-100 rounded-full flex items-center gap-2">
                        <!-- Icon profil -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="sr-only">Profil</span>
                        @if (auth()->check())
                            <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                        @endif
                    </button>
                    <div id="profile-dropdown"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden">
                        @if (!auth()->check())
                            <a href="{{ url('login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Masuk</a>
                            <a href="{{ url('register') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Daftar</a>
                        @else
                            <a href="{{ url('profil') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Saya</a>
                            @if (auth()->user()->role === 'user')
                                <a href="{{ url('riwayat-pesanan') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Riwayat Pesanan</a>
                            @endif
                            <a href="{{ url('pengaturan') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pengaturan</a>
                            <hr class="my-1">
                            <a href="{{ url('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
                            <form id="logout-form" action="{{ url('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const profileButton = document.getElementById('profile-button');
        const profileDropdown = document.getElementById('profile-dropdown');

        if (profileButton && profileDropdown) {
            profileButton.addEventListener('click', function (e) {
                e.stopPropagation();
                profileDropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', function (event) {
                if (!profileButton.contains(event.target) && !profileDropdown.contains(event.target)) {
                    profileDropdown.classList.add('hidden');
                }
            });
        }
    });
</script>
@endpush
