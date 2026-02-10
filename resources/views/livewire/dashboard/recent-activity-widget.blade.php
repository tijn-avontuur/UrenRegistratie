<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Recente Activiteit</h3>
        <a href="{{ route('projecten') }}" class="text-sm text-[#422AD5] hover:text-[#3622a8] font-medium" wire:navigate>Bekijk alles</a>
    </div>

    <div class="space-y-4">
        @forelse($activities as $activity)
            <!-- Activity Item -->
            <div class="border-l-2 border-gray-200 pl-4 hover:border-[#422AD5] transition-colors">
                <div class="flex items-start justify-between gap-2">
                    <div class="flex-1 min-w-0">
                        <h4 class="font-medium text-gray-900 text-sm">{{ $activity['title'] }}</h4>
                        <div class="flex items-center gap-2 mt-1 text-xs text-gray-500">
                            <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="whitespace-nowrap">{{ $activity['start_time'] }} - {{ $activity['end_time'] }}</span>
                            <span class="text-[#422AD5] font-medium truncate">{{ $activity['project_name'] }}</span>
                        </div>
                    </div>
                    <span class="text-xs text-gray-400 whitespace-nowrap">{{ $activity['date_short'] }} {{ $activity['month_short'] }}.</span>
                </div>
            </div>
        @empty
            <div class="text-center py-8">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-gray-500 text-sm">Nog geen activiteiten</p>
                <p class="text-gray-400 text-xs mt-1">Start de timer om tijd bij te houden</p>
            </div>
        @endforelse
    </div>
</div>
