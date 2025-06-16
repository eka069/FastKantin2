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
                <a href="#" class="text-gray-600 hover:text-indigo-600">Profile</a>
                <a href="{{ route('cart') }}" class="text-gray-600 hover:text-indigo-600">Cart</a>
                <a href="{{ route('riwayat') }}" class="text-gray-600 hover:text-indigo-600">Riwayat</a>
                <a href="#" class="text-red-500 hover:text-red-700"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>

            </div>
        </div>
    </nav>

    {{-- Content --}}
    <div class="">
        @yield('content')
    </div>

</body>
@yield('scripts')
</html>
