<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="hidden lg:flex flex-col w-64 bg-white border-r border-gray-200">
            <!-- Logo -->
            <div class="p-6 border-b border-gray-200">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2" wire:navigate>
                    <svg class="w-8 h-8 text-[#422AD5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke-width="2" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2" />
                    </svg>
                    <span class="text-xl font-bold text-gray-800">UrenApp</span>
                </a>
            </div>

            <!-- Navigation Menu -->
            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-[#422AD5] text-white' : 'text-gray-700 hover:bg-gray-100' }} transition-colors"
                    wire:navigate>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="#"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="font-medium">Kalender</span>
                </a>

                <a href="#"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium">Urenregistratie</span>
                </a>

                <a href="#"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="font-medium">Projecten</span>
                </a>
            </nav>

            <!-- User Profile Section -->
            <div class="p-4 border-t border-gray-200">
                <div class="flex items-center gap-3 mb-3">
                    <div class="avatar placeholder">
                        <div class="bg-[#422AD5] text-white rounded-full w-10 h-10 flex items-center justify-center">
                            <span class="text-sm font-semibold">{{ auth()->user()->initials() }}</span>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="font-semibold text-gray-800 text-sm">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-gray-500">Employee</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Uitloggen
                    </button>
                </form>
            </div>
        </div>

        <!-- Mobile Header -->
        <div class="lg:hidden fixed top-0 left-0 right-0 bg-white border-b border-gray-200 z-50">
            <div class="flex items-center justify-between p-4">
                <label for="mobile-menu-toggle" class="btn btn-ghost btn-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </label>
                <span class="text-lg font-bold">UrenApp</span>
                <div class="w-10"></div>
            </div>
        </div>

        <!-- Mobile Menu Drawer -->
        <input type="checkbox" id="mobile-menu-toggle" class="drawer-toggle hidden" />
        <div class="drawer-side lg:hidden fixed inset-0 z-40">
            <label for="mobile-menu-toggle" class="drawer-overlay absolute inset-0 bg-black bg-opacity-50"></label>
            <div class="flex flex-col w-64 h-full bg-white">
                <!-- Logo -->
                <div class="p-6 border-b border-gray-200">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2" wire:navigate>
                        <svg class="w-8 h-8 text-[#422AD5]" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" stroke-width="2" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2" />
                        </svg>
                        <span class="text-xl font-bold text-gray-800">UrenApp</span>
                    </a>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex-1 p-4 space-y-1">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-[#422AD5] text-white' : 'text-gray-700 hover:bg-gray-100' }} transition-colors"
                        wire:navigate>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="font-medium">Dashboard</span>
                    </a>

                    <a href="#"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="font-medium">Kalender</span>
                    </a>

                    <a href="#"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium">Urenregistratie</span>
                    </a>

                    <a href="#"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="font-medium">Projecten</span>
                    </a>
                </nav>

                <!-- User Profile Section -->
                <div class="p-4 border-t border-gray-200">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="avatar placeholder">
                            <div
                                class="bg-[#422AD5] text-white rounded-full w-10 h-10 flex items-center justify-center">
                                <span class="text-sm font-semibold">{{ auth()->user()->initials() }}</span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-gray-800 text-sm">{{ auth()->user()->name }}</div>
                            <div class="text-xs text-gray-500">Employee</div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Uitloggen
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 mt-16 lg:mt-0">
                {{ $slot }}
            </main>
        </div>
    </div>

    @fluxScripts
</body>

</html>
