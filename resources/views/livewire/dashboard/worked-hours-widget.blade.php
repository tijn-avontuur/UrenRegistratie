<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Gewerkte Uren</h3>
        <svg class="w-5 h-5 text-[#422AD5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
        </svg>
    </div>

    <!-- Deze week -->
    <div class="mb-6">
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm text-gray-600">Deze week</span>
            <span class="text-sm font-semibold text-gray-900">{{ number_format($weekHours, 0) }}u / {{ $weekTarget }}u</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-[#422AD5] h-2 rounded-full transition-all duration-500" style="width: {{ $weekPercentage }}%"></div>
        </div>
    </div>

    <!-- Deze maand -->
    <div>
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm text-gray-600">Deze maand</span>
            <span class="text-sm font-semibold text-gray-900">{{ number_format($monthHours, 0) }}u</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-[#422AD5] h-2 rounded-full transition-all duration-500" style="width: {{ min(100, ($monthHours / 160) * 100) }}%"></div>
        </div>
    </div>
</div>
