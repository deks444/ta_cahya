<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Sharefit</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app-simple.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* FORCE SIDEBAR VISIBLE ON DESKTOP */
        @media (min-width: 1024px) {
            #admin-sidebar {
                transform: translateX(0) !important;
            }

            #main-content {
                margin-left: 16rem !important;
            }
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800" x-data="{ sidebarOpen: false }">

    <!-- OVERLAY SIDEBAR (MOBILE ONLY) -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
        x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 lg:hidden" style="display: none;"></div>

    <!-- SIDEBAR -->
    <aside id="admin-sidebar"
        class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transition-transform duration-300 ease-in-out flex flex-col"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

        <!-- Brand Logo -->
        <div
            class="h-16 flex items-center px-6 border-b border-gray-100 flex-shrink-0 justify-between lg:justify-start">
            <span class="text-xl font-bold text-gray-800 tracking-tight">Admin Panel</span>
            <!-- Close Button (Mobile Only) -->
            <button @click="sidebarOpen = false" class="lg:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Menu Navigasi -->
        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition {{ Request::is('admin/dashboard') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                    </path>
                </svg>
                Dashboard
            </a>

            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition {{ Request::is('admin/users*') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Daftar User
                </a>

                <a href="{{ route('admin.achievements.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition {{ Request::is('admin/achievements*') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Data Prestasi
                </a>

                <a href="{{ route('admin.activities.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition {{ Request::is('admin/activities*') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Kelola Kegiatan
                </a>
            @endif

            <a href="{{ route('admin.schedules.index') }}"
                class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition {{ Request::is('admin/schedules*') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
                Jadwal Latihan
            </a>

            <a href="{{ route('admin.attendance.index') }}"
                class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition {{ Request::is('admin/attendance*') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                    </path>
                </svg>
                Presensi
            </a>
        </nav>
    </aside>

    <!-- MAIN CONTENT WRAPPER -->
    <!-- Tidak menggunakan Flexbox untuk fixed layout + margin -->
    <div id="main-content" class="relative flex flex-col min-h-screen transition-all duration-300">
        <!-- Header -->
        <header
            class="h-16 bg-white border-b border-gray-200 sticky top-0 z-40 flex items-center justify-between px-4 lg:px-8 flex-shrink-0">
            <div class="flex items-center gap-4">
                <!-- Hamburger Button (Mobile Only) -->
                <button @click="sidebarOpen = true"
                    class="text-gray-500 hover:text-gray-700 focus:outline-none lg:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <h1 class="text-lg font-semibold text-gray-700">@yield('page-title', 'Dashboard')</h1>
            </div>

            <!-- Right Side Actions -->
            <div class="flex items-center gap-2">
                <!-- User Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center gap-2 focus:outline-none hover:bg-gray-50 p-2 rounded-lg transition">
                        <div
                            class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold overflow-hidden">
                            @if (Auth::user()->avatar)
                                <img src="{{ asset(Auth::user()->avatar) }}" alt="Avatar"
                                    class="w-full h-full object-cover">
                            @else
                                {{ substr(Auth::user()->name, 0, 1) }}
                            @endif
                        </div>
                        <!-- Hide Name on very small screens if needed -->
                        <span class="text-sm font-medium text-gray-700 hidden sm:block">{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4 text-gray-400 transition-transform" :class="{'rotate-180': open}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                        <div class="px-4 py-2 border-b border-gray-100 mb-1">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                            @if(Auth::user()->email)
                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            @endif
                        </div>
                        <a href="{{ route('admin.profile') }}"
                            class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition text-left">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 p-4 lg:p-8">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="h-12 bg-white border-t border-gray-200 flex items-center justify-center px-8 flex-shrink-0">
            <p class="text-sm text-gray-500">© Sharefit 2026</p>
        </footer>
    </div>

    @stack('scripts')
</body>

</html>