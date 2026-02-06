<x-layouts::auth.simple :title="$title ?? null">
    <!-- Logo and Header -->
    <div class="flex justify-center">
        <!-- Logo with animation -->
        <div
            class="w-20 h-20 bg-primary rounded-2xl flex items-center justify-center shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-primary-content" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
    </div>

    <!-- Content Card -->
    <div class="w-full">
        <div class="card bg-base-100 shadow-2xl border border-base-300">
            <div class="card-body p-8">
                {{ $slot }}
            </div>
        </div>
    </div>
</x-layouts::auth.simple>
