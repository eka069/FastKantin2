<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'FAST KANTIN - Seller')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    @include('layout.header')

    <main class="container mx-auto py-6 px-4">
        @yield('seller-content')
    </main>

    @include('layout.footer')

</body>
</html>
