<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Fast Kantin')</title>
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Import font Poppins dari Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

    {{-- Navbar --}}
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-black">Fast Kantin</h1>
            <div class="flex items-center space-x-6 text-sm">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-indigo-600">Home</a>
                <a href="{{ route('cart') }}" class="text-gray-600 hover:text-indigo-600">Cart</a>
                <a href="{{ route('riwayat') }}" class="text-gray-600 hover:text-indigo-600">Riwayat</a>

                {{-- Dropdown Profil --}}
                <div class="relative">
                    <button id="profile-button" class="flex items-center focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12 2a10 10 0 100 20
        10 10 0 000-20zm0 4a3 3 0 110 6 3 3 0 010-6zm0
        14a8 8 0 01-6.32-3.16c.03-2.11 4.21-3.26
        6.32-3.26s6.29 1.15 6.32 3.26A8 8 0 0112 20z" clip-rule="evenodd" />
                        </svg>

                    </button>

                    <div id="profile-dropdown"
                        class="absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg border hidden z-50">

                        <a href="{{ route('profile.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Profile
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                Logout
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </nav>

    {{-- Content --}}
    <div>
        @yield('content')
    </div>

    {{-- Script untuk Dropdown --}}
    <script>
        const profileBtn = document.getElementById('profile-button');
        const dropdown = document.getElementById('profile-dropdown');

        document.addEventListener('click', function(e) {
            if (profileBtn.contains(e.target)) {
                dropdown.classList.toggle('hidden');
            } else if (!dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>

    @yield('scripts')
</body>

</html>
