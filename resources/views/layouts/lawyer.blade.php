<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Divorce Lawyer Portal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background: #0f172a; color: white; min-height: 100vh; display: flex;">

    {{-- SIDEBAR --}}
    <aside style="width: 260px; background: #1e293b; min-height: 100vh; display: flex; flex-direction: column;">

        {{-- Logo --}}
        <div style="padding: 1.5rem; border-bottom: 1px solid #334155;">
            <h1 style="font-size: 1.25rem; font-weight: 700;">⚖️ E-Divorce</h1>
            <p style="font-size: 0.75rem; color: #6ee7b7; margin-top: 0.25rem;">Lawyer Portal</p>
        </div>

        {{-- Nav --}}
        <nav style="flex: 1; padding: 1rem;">
            <a href="/lawyer/dashboard"
               style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 0.5rem; background: #064e3b; color: white; text-decoration: none; margin-bottom: 0.5rem;">
                🏠 Dashboard
            </a>
            <a href="/lawyer/cases"
               style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 0.5rem; color: #94a3b8; text-decoration: none; margin-bottom: 0.5rem;"
               onmouseover="this.style.background='#064e3b';this.style.color='white'"
               onmouseout="this.style.background='transparent';this.style.color='#94a3b8'">
                📁 All Cases
            </a>
        </nav>

        {{-- Logout --}}
        <div style="padding: 1rem; border-top: 1px solid #334155;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        style="width: 100%; display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 0.5rem; background: none; border: none; color: #94a3b8; cursor: pointer; text-align: left;"
                        onmouseover="this.style.background='#dc2626';this.style.color='white'"
                        onmouseout="this.style.background='transparent';this.style.color='#94a3b8'">
                    🚪 Log Out
                </button>
            </form>
        </div>

    </aside>

    {{-- MAIN --}}
    <div style="flex: 1; display: flex; flex-direction: column;">

        {{-- Top Bar --}}
        <header style="background: #1e293b; border-bottom: 1px solid #334155; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 1.125rem; font-weight: 600;">@yield('title', 'Dashboard')</h2>
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <div style="width: 2rem; height: 2rem; border-radius: 9999px; background: #064e3b; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.875rem; color: #6ee7b7;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <span style="color: #94a3b8; font-size: 0.875rem;">{{ auth()->user()->name }}</span>
            </div>
        </header>

        {{-- Content --}}
        <main style="flex: 1; padding: 2rem;">
            @yield('content')
        </main>

    </div>

</body>
</html>