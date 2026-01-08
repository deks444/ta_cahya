<!-- ========== HEADER ========== -->
<header class="bg-white border-b border-gray-200 flex flex-wrap md:justify-start md:flex-nowrap z-50 w-full">
    <nav
        class="relative max-w-[85rem] w-full md:flex md:items-center md:justify-between md:gap-3 mx-auto px-4 sm:px-6 lg:px-8 py-2">
        <!-- Logo w/ Collapse Button -->
        <div class="flex items-center justify-between">
            <a class="flex-none font-semibold text-xl text-black focus:outline-none focus:opacity-80"
                href="{{ route('main') }}" aria-label="Brand">
                <img class="h-[70px]" src="{{ asset('img/theme1_sf.png') }}" alt="">
            </a>

            <!-- Collapse Button -->
            <div class="md:hidden">
                <button type="button"
                    class="hs-collapse-toggle relative size-9 flex justify-center items-center text-sm font-semibold rounded-lg border border-gray-200 text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none"
                    id="hs-header-classic-collapse" aria-expanded="false" aria-controls="hs-header-classic"
                    aria-label="Toggle navigation" data-hs-collapse="#hs-header-classic">
                    <svg class="hs-collapse-open:hidden size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" x2="21" y1="6" y2="6" />
                        <line x1="3" x2="21" y1="12" y2="12" />
                        <line x1="3" x2="21" y1="18" y2="18" />
                    </svg>
                    <svg class="hs-collapse-open:block shrink-0 hidden size-4" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                    <span class="sr-only">Toggle navigation</span>
                </button>
            </div>
            <!-- End Collapse Button -->
        </div>
        <!-- End Logo w/ Collapse Button -->

        <!-- Collapse -->
        <div id="hs-header-classic"
            class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow md:block"
            aria-labelledby="hs-header-classic-collapse">
            <div
                class="overflow-hidden overflow-y-auto max-h-[75vh] [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300">
                <div class="py-2 md:py-0 flex flex-col md:flex-row md:items-center md:justify-end gap-0.5 md:gap-1">
                    <a class="p-2 flex items-center text-sm hover:text-blue-500 focus:outline-none focus:text-blue-600 {{ Route::is('main') ? "text-blue-600 font-bold" : "text-gray-800" }}"
                        href="{{ route('main') }}" aria-current="page">
                        <svg class="shrink-0 size-4 me-3 md:me-2 block md:hidden" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8" />
                            <path
                                d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        </svg>
                        Home
                    </a>

                    <a class="p-2 flex items-center text-sm  hover:text-blue-500 focus:outline-none focus:text-blue-500 {{ Route::is('peraturan') ? "text-blue-600 font-bold" : "text-gray-800" }}"
                        href="{{ route('peraturan') }}">
                        <svg class="shrink-0 size-4 me-3 md:me-2 block md:hidden" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        Peraturan
                    </a>

                    <!-- Dropdown -->
                    <div
                        class="hs-dropdown [--strategy:static] md:[--strategy:fixed] [--adaptive:none] [--is-collapse:true] md:[--is-collapse:false] ">
                        <button id="hs-header-classic-dropdown" type="button"
                            class="hs-dropdown-toggle w-full p-2 flex items-center hover:text-blue-500 focus:outline-none focus:text-blue-500 {{ Route::is('event*') ? "text-sm text-blue-600 font-bold" : "text-sm text-gray-800" }}"
                            aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                            <svg class="shrink-0 size-4 me-3 md:me-2 block md:hidden" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m3 10 2.5-2.5L3 5" />
                                <path d="m3 19 2.5-2.5L3 14" />
                                <path d="M10 6h11" />
                                <path d="M10 12h11" />
                                <path d="M10 18h11" />
                            </svg>
                            Event
                            <svg class="hs-dropdown-open:-rotate-180 md:hs-dropdown-open:rotate-0 duration-300 shrink-0 size-4 ms-auto md:ms-1"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="m6 9 6 6 6-6" />
                            </svg>
                        </button>

                        <div class="hs-dropdown-menu transition-[opacity,margin] duration-[0.1ms] md:duration-[150ms] hs-dropdown-open:opacity-100 opacity-0 relative w-full md:w-52 hidden z-10 top-full ps-7 md:ps-0 md:bg-white md:rounded-lg md:shadow-md before:absolute before:-top-4 before:start-0 before:w-full before:h-5 md:after:hidden after:absolute after:top-1 after:start-[18px] after:w-0.5 after:h-[calc(100%-0.25rem)] after:bg-gray-100"
                            role="menu" aria-orientation="vertical" aria-labelledby="hs-header-classic-dropdown">
                            <div class="py-1 md:px-1 space-y-0.5">
                                <a class="py-1.5 px-2 flex items-center text-sm text-gray-800 hover:text-blue-500 focus:outline-none focus:text-gray-500"
                                    href="{{ route('event.acara') }}">
                                    Berita Acara
                                </a>

                                <a class="py-1.5 px-2 flex items-center text-sm text-gray-800 hover:text-blue-500 focus:outline-none focus:text-gray-500"
                                    href="{{ route('event.sertifikat') }}">
                                    Sertifikat
                                </a>
                            </div>
                        </div>
                    </div>
                    <a class="p-2 flex items-center text-sm  hover:text-blue-500 focus:outline-none focus:text-blue-500 {{ Route::is('faq') ? "text-blue-600 font-bold" : "text-gray-800" }}"
                        href="{{ route('faq') }}">
                        <svg class="shrink-0 size-4 me-3 md:me-2 block md:hidden" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 12h.01" />
                            <path d="M16 6V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2" />
                            <path d="M22 13a18.15 18.15 0 0 1-20 0" />
                            <rect width="20" height="14" x="2" y="6" rx="2" />
                        </svg>
                        FAQ
                    </a>
                    <!-- End Dropdown -->

                    <!-- Button Group -->
                    <div
                        class="relative flex flex-wrap items-center gap-x-1.5 md:ps-2.5 mt-1 md:mt-0 md:ms-1.5 before:block before:absolute before:top-1/2 before:-start-px before:w-px before:h-4 before:bg-gray-300 before:-translate-y-1/2">

                        @guest
                            <a class="p-2 flex items-center text-sm hover:text-blue-500 focus:outline-none focus:text-blue-500 {{ Route::is('login') ? 'text-blue-600 font-bold' : 'text-gray-800' }}"
                                href="{{ route('login') }}">
                                <svg class="shrink-0 size-4 me-3 md:me-2" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                                Log in
                            </a>
                        @endguest

                        @auth
                            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'pelatih')
                                <a class="p-2 flex items-center text-sm font-medium text-gray-800 hover:text-blue-500 focus:outline-none focus:text-blue-500"
                                    href="{{ route('admin.dashboard') }}">
                                    <svg class="shrink-0 size-4 me-3 md:me-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect width="7" height="9" x="3" y="3" rx="1" />
                                        <rect width="7" height="5" x="14" y="3" rx="1" />
                                        <rect width="7" height="9" x="14" y="12" rx="1" />
                                        <rect width="7" height="5" x="3" y="16" rx="1" />
                                    </svg>
                                    Dashboard
                                </a>
                            @elseif(Auth::user()->role === 'atlit')
                                <a class="p-2 flex items-center text-sm font-medium text-gray-800 hover:text-blue-500 focus:outline-none focus:text-blue-500"
                                    href="{{ route('atlit.schedules.index') }}">
                                    <svg class="shrink-0 size-4 me-3 md:me-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    Jadwal Latihan
                                </a>
                            @endif

                            <!-- Profile Dropdown -->
                            <div class="hs-dropdown [--strategy:static] md:[--strategy:fixed] [--adaptive:none]">
                                <button id="hs-navbar-dropdown-profile" type="button"
                                    class="hs-dropdown-toggle p-2 flex items-center text-sm text-gray-800 hover:text-blue-500 focus:outline-none focus:text-blue-500">
                                    <svg class="shrink-0 size-4 me-3 md:me-2" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                        <circle cx="12" cy="7" r="4" />
                                    </svg>
                                    {{ Auth::user()->name }}
                                    <svg class="hs-dropdown-open:-rotate-180 md:hs-dropdown-open:rotate-0 duration-300 shrink-0 size-4 ms-auto md:ms-1"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="m6 9 6 6 6-6" />
                                    </svg>
                                </button>

                                <div class="hs-dropdown-menu transition-[opacity,margin] duration-[0.1ms] md:duration-[150ms] hs-dropdown-open:opacity-100 opacity-0 relative w-full md:w-52 hidden z-10 top-full ps-7 md:ps-0 md:bg-white md:rounded-lg md:shadow-md before:absolute before:-top-4 before:start-0 before:w-full before:h-5"
                                    role="menu" aria-orientation="vertical" aria-labelledby="hs-navbar-dropdown-profile">
                                    <div class="py-1 md:px-1 space-y-0.5">
                                        <a class="py-1.5 px-2 flex items-center text-sm text-gray-800 hover:text-blue-500 focus:outline-none focus:text-gray-500"
                                            href="{{ Auth::user()->role === 'atlit' ? route('atlit.profile') : route('admin.profile') }}">
                                            Profil Saya
                                        </a>
                                        <hr class="my-1 border-gray-200">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit"
                                                class="w-full py-1.5 px-2 flex items-center text-sm text-red-600 hover:text-red-700 focus:outline-none">
                                                Log out
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- End Profile Dropdown -->
                        @endauth

                    </div>
                    <!-- End Button Group -->
                </div>
            </div>
        </div>
        <!-- End Collapse -->
    </nav>
</header>
<!-- ========== END HEADER ========== -->