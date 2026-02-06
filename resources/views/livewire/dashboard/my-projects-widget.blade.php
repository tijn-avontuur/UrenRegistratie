<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-semibold text-gray-900">Mijn Projecten</h3>
        <a href="#" class="text-sm text-[#422AD5] hover:text-[#3622a8] font-medium flex items-center gap-1">
            Alle projecten
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($projects as $project)
            <!-- Project Card -->
            <a href="#" class="block border border-gray-200 rounded-lg p-4 hover:border-[#422AD5] transition-colors group">
                <div class="flex items-start gap-3">
                    <div 
                        class="w-12 h-12 rounded-lg flex-shrink-0 transition-transform group-hover:scale-105" 
                        style="background: {{ $project['color'] ?? '#422AD5' }};"
                    ></div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-2 mb-1">
                            <h4 class="font-semibold text-gray-900 text-sm">{{ $project['title'] }}</h4>
                            <span class="w-2 h-2 rounded-full {{ $project['status_color'] }} flex-shrink-0 mt-1.5"></span>
                        </div>
                        <p class="text-xs text-gray-500 line-clamp-2">{{ Str::limit($project['description'], 60) }}</p>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full text-center py-8 text-gray-500 text-sm">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p>Je bent nog niet toegewezen aan projecten</p>
            </div>
        @endforelse
    </div>
</div>
