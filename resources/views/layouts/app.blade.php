<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>News Frontier House</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans antialiased">

    <nav class="bg-white shadow py-2">
        <div class="container mx-auto px-4 flex justify-between items-center">

            <!-- Left section: Logo + Text -->
            <a class="flex items-center" href="/">
                <img src="/company_logo.png" alt="Logo" class="w-15 mr-2">
                <span class="ml-2 font-bold text-2xl text-green-600">News Frontier House</span>
            </a>

            <!-- Toggler for mobile -->
            <button class="block lg:hidden px-2 text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M4 5h16a1 1 0 010 2H4a1 1 0 110-2zm0 6h16a1 1 0 010 2H4a1 1 0 010-2zm0 6h16a1 1 0 010 2H4a1 1 0 010-2z" clip-rule="evenodd"></path>
                </svg>
            </button>

            <!-- Right section: Menu -->
            <div class="hidden lg:flex lg:items-center lg:w-auto" id="navbarNav">
                <ul class="lg:flex items-center">
                    <li class="nav-item">
                        <a class="block mt-4 lg:inline-block lg:mt-0 text-gray-700 hover:text-gray-900 mr-4" href="#">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="block mt-4 lg:inline-block lg:mt-0 text-gray-700 hover:text-gray-900 mr-4" href="#">Partner</a>
                    </li>
                    <li class="nav-item">
                        <a class="block mt-4 lg:inline-block lg:mt-0 text-gray-700 hover:text-gray-900 mr-4" href="#">Lamar Pekerjaan</a>
                    </li>
                    <li class="nav-item">
                        <a class="block mt-4 lg:inline-block lg:mt-0 text-gray-700 hover:text-gray-900" href="/admin">Admin</a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <!-- For mobile menu toggling, you might need Alpine.js or a small script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const button = document.querySelector('[data-bs-toggle="collapse"]');
            const nav = document.getElementById('navbarNav');
            if (button && nav) {
                button.addEventListener('click', () => {
                    nav.classList.toggle('hidden');
                    nav.classList.toggle('block'); // For mobile, show as block
                    nav.classList.toggle('lg:flex'); // Maintain lg:flex for larger screens
                });
            }
        });
    </script>
</body>

</html>
