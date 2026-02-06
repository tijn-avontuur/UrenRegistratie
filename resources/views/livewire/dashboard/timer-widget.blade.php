<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <div class="flex flex-col items-center">
        @if($isRunning)
            <!-- Stop Button -->
            <div class="w-24 h-24 rounded-full bg-red-100 flex items-center justify-center mb-4">
                <div class="w-8 h-8 bg-red-600 rounded"></div>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Ingeklokt</h3>
        @else
            <!-- Play Button -->
            <div class="w-24 h-24 rounded-full bg-green-100 flex items-center justify-center mb-4">
                <svg class="w-12 h-12 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8 5v14l11-7z"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Klaar om te werken?</h3>
        @endif
        
        <div 
            class="text-4xl font-bold mb-6" 
            style="letter-spacing: 0.1em; color: #422AD5;"
            x-data="{ 
                elapsed: @entangle('elapsedTime').live,
                interval: null,
                isRunning: @entangle('isRunning').live
            }"
            x-init="
                $watch('isRunning', value => {
                    if (value && !interval) {
                        // Start counting from current elapsed time
                        interval = setInterval(() => {
                            elapsed = parseInt(elapsed) + 1;
                        }, 1000);
                    } else if (!value && interval) {
                        // Stop counting but DON'T reset elapsed
                        clearInterval(interval);
                        interval = null;
                    }
                });
                
                // Start interval if already running on mount
                if (isRunning && !interval) {
                    interval = setInterval(() => {
                        elapsed = parseInt(elapsed) + 1;
                    }, 1000);
                }
            "
            x-text="
                (() => {
                    const total = parseInt(Math.abs(elapsed)) || 0;
                    const hours = Math.floor(total / 3600);
                    const minutes = Math.floor((total % 3600) / 60);
                    const seconds = total % 60;
                    return String(hours).padStart(2, '0') + ':' + 
                           String(minutes).padStart(2, '0') + ':' + 
                           String(seconds).padStart(2, '0');
                })()
            "
        >
            00:00:00
        </div>

        @if(!$isRunning && count($projects) > 0)
            <!-- Project Selector -->
            <div class="w-full mb-4">
                <select 
                    wire:model="selectedProjectId" 
                    class="w-full px-4 py-2 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#422AD5] focus:border-transparent text-sm"
                >
                    @foreach($projects as $project)
                        <option value="{{ $project['id'] }}">{{ $project['title'] }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        @if(count($projects) === 0 && !$isRunning)
            <p class="text-sm text-gray-500 mb-4 text-center">Je bent niet toegewezen aan projecten</p>
        @endif

        @if(session()->has('error'))
            <div class="w-full mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-600">
                {{ session('error') }}
            </div>
        @endif
        
        <button 
            wire:click="toggleTimer"
            @if(count($projects) === 0 && !$isRunning) disabled @endif
            class="w-full font-semibold py-3 px-6 rounded-lg transition-colors {{ $isRunning ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} text-white disabled:bg-gray-300 disabled:cursor-not-allowed"
        >
            @if($isRunning)
                Uitklokken
            @else
                Inklokken
            @endif
        </button>
    </div>

    <!-- Stop Timer Modal -->
    @if($showStopModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showStopModal').live }" x-show="show" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div 
                    class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" 
                    @click="$wire.cancelStop()"
                    x-show="show"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                ></div>

                <!-- Center modal -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <!-- Modal panel -->
                <div 
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                    x-show="show"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                >
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-[#422AD5] bg-opacity-10 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-[#422AD5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-1">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                    Timer stoppen
                                </h3>
                                <div class="mt-4 space-y-3">
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <span class="text-sm font-medium text-gray-500">Project:</span>
                                        <span class="text-sm font-semibold text-gray-900">{{ $modalProjectName }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <span class="text-sm font-medium text-gray-500">Starttijd:</span>
                                        <span class="text-sm font-semibold text-gray-900">{{ $modalStartTime }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <span class="text-sm font-medium text-gray-500">Eindtijd:</span>
                                        <span class="text-sm font-semibold text-gray-900">{{ $modalEndTime }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 bg-[#422AD5] bg-opacity-5 rounded-lg px-3">
                                        <span class="text-sm font-medium text-gray-700">Totale duur:</span>
                                        <span class="text-base font-bold text-[#422AD5]">{{ $modalDuration }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button 
                            wire:click="confirmStop" 
                            type="button" 
                            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-[#422AD5] text-base font-medium text-white hover:bg-[#3622a8] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#422AD5] sm:ml-3 sm:w-auto sm:text-sm transition-colors"
                        >
                            Opslaan
                        </button>
                        <button 
                            wire:click="discardTimer" 
                            type="button" 
                            class="w-full inline-flex justify-center rounded-lg border border-red-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-red-600 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors"
                        >
                            Niet opslaan
                        </button>
                        <button 
                            wire:click="cancelStop" 
                            type="button" 
                            class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#422AD5] sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors"
                        >
                            Annuleren
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
