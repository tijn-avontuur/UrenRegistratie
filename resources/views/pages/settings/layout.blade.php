<div class="flex flex-col md:flex-row gap-8">
    <!-- Settings Navigation -->
    <div class="w-full md:w-56 shrink-0">
        <nav class="space-y-1">
            <a href="{{ route('profile.edit') }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('profile.*') ? 'bg-[#422AD5] text-white' : 'text-gray-700 hover:bg-gray-100' }}"
                wire:navigate>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                {{ __('Profile') }}
            </a>
            <a href="{{ route('user-password.edit') }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('user-password.*') ? 'bg-[#422AD5] text-white' : 'text-gray-700 hover:bg-gray-100' }}"
                wire:navigate>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                {{ __('Password') }}
            </a>

        </nav>
    </div>

    <div class="border-l border-gray-200 hidden md:block"></div>

    <!-- Settings Content -->
    <div class="flex-1 min-w-0">
        <div class="mb-4">
            <h2 class="text-lg font-semibold text-gray-900">{{ $heading ?? '' }}</h2>
            <p class="text-sm text-gray-500 mt-0.5">{{ $subheading ?? '' }}</p>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
            {{ $slot }}
        </div>
    </div>
</div>
