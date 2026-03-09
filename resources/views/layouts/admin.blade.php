<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Divorce Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-white min-h-screen flex">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-gray-800 min-h-screen flex flex-col">

        {{-- Logo --}}
        <div class="p-6 border-b border-gray-700">
            <h1 class="text-xl font-bold text-white">⚖️ E-Divorce</h1>
            <p class="text-xs text-gray-400 mt-1">Admin Panel</p>
        </div>

        {{-- Nav Links --}}
        <nav class="flex-1 p-4 space-y-2">
            <a href="/admin/dashboard"
               class="flex items-center gap-3 px-4 py-3 rounded-lg bg-gray-700 text-white font-medium hover:bg-indigo-600 transition">
                🏠 Dashboard
            </a>
            <a href="/admin/users"
               class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-indigo-600 hover:text-white transition">
                👥 Manage Users
            </a>
            <a href="/admin/cases"
               class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-indigo-600 hover:text-white transition">
                📁 Manage Cases
            </a>
            <a href="/admin/judges"
               class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-indigo-600 hover:text-white transition">
                👨‍⚖️ Manage Judges
            </a>
            <a href="/admin/lawyers"
               class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-indigo-600 hover:text-white transition">
                💼 Manage Lawyers
            </a>
        </nav>

        {{-- Logout --}}
        <div class="p-4 border-t border-gray-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-red-600 hover:text-white transition">
                    🚪 Log Out
                </button>
            </form>
        </div>

    </aside>

    {{-- MAIN CONTENT --}}
    <div class="flex-1 flex flex-col">

        {{-- Top Bar --}}
        <header class="bg-gray-800 border-b border-gray-700 px-8 py-4 flex justify-between items-center">
            <h2 class="text-lg font-semibold">@yield('title', 'Dashboard')</h2>
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-sm font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <span class="text-gray-300 text-sm">{{ auth()->user()->name }}</span>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 p-8">
            @yield('content')
        </main>

    </div>

</body>
</html>