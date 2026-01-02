<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - DPM PM STIKOM</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100">

    <div class="flex min-h-screen overflow-hidden">
        
        <!-- SIDEBAR (FULL KIRI) -->
        <aside class="w-64 bg-white border-e border-gray-200 flex flex-col flex-shrink-0">
            <!-- Brand Logo -->
            <div class="h-16 flex items-center px-6 border-b border-gray-100">
                <span class="text-xl font-bold text-gray-800 tracking-tight">Admin Panel</span>
            </div>

            <!-- Menu Navigasi -->
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition {{ Request::is('admin/dashboard') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition {{ Request::is('admin/users*') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Daftar User
                </a>

                <!-- Nama Admin (Non-clickable menu) -->
                <div class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-gray-700 bg-gray-50 rounded-xl mt-4">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    {{ Auth::user()->name }}
                </div>

                <!-- Logout Menu -->
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm font-semibold text-red-600 hover:bg-red-50 rounded-xl transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout
                    </button>
                </form>
            </nav>
        </aside>

        <!-- AREA KONTEN (TENAH) -->
        <main class="flex-1 flex flex-col overflow-hidden bg-gray-50">
            <!-- Header Atas (Opsional) -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center px-8 flex-shrink-0">
                <h1 class="text-lg font-semibold text-gray-700">@yield('page-title', 'Dashboard')</h1>
            </header>

            <!-- Isi Content yang akan diupdate bareng -->
            <div class="flex-1 overflow-y-auto p-8">
                @yield('content')
            </div>

            <!-- FOOTER -->
            <footer class="h-12 bg-white border-t border-gray-200 flex items-center justify-center px-8 flex-shrink-0">
                <p class="text-sm text-gray-500">© Sharefit 2026</p>
            </footer>
        </main>

    </div>

</body>
</html>