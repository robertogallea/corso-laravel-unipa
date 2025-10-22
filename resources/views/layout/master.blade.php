<!doctype html>
<html lang="it">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1"/>
    <title>Vista minimale — Header + Sidebar</title>
    <!-- Tailwind utilities via CDN (no custom JavaScript in the page) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-50 text-gray-800">
<div class="flex flex-col md:flex-row min-h-screen">
    <!-- Sidebar -->
    <aside class="w-full md:w-64 bg-white border-r border-gray-200">
        <div class="p-4 border-b border-gray-100">
            <h1 class="text-lg font-semibold">{{ config('app.name') }}</h1>
        </div>
        <nav class="p-4 space-y-1">
            <a href="#" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-100">🏠 Home</a>
            <a href="{{ route('products.index') }}"
               class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-100">📁 Prodotti</a>
            <a href="{{ route('movements.index') }}"
               class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-100">📁 Movimenti</a>
            <a href="#" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-100">⚙️ Impostazioni</a>
        </nav>
    </aside>

    <!-- Main area -->
    <div class="flex-1 flex flex-col">
        <!-- Header -->
        <header class="w-full bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button aria-hidden="true" class="md:hidden p-2 rounded-md">☰</button>
                    <h2 class="text-xl font-semibold">@yield('page-title')</h2>
                </div>
                @auth
                    <div class="flex flex-col">
                        <div class="text-sm text-gray-600">Utente · <span
                                class="font-medium">{{ auth()->user()->name }}</span></div>
                        <form class="inline" method="post" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                    </div>
                @endauth
                @guest
                    <div class="text-sm text-gray-600"><a href="{{ route('login') }}"><span
                                class="font-medium">Login</span></a></div>
                @endguest
            </div>
        </header>

        <!-- Content -->
        <main class="p-6 flex-1 bg-gray-50">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
