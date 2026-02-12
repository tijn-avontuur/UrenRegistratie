<div class="p-4 md:p-8 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Medewerkers</h1>
            <p class="text-sm text-gray-600 mt-1">Beheer medewerkers en bekijk hun gewerkte uren</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Totaal Uren</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($this->totalHours, 1) }}</p>
                    </div>
                    <div class="h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Totaal Registraties</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($this->totalEntries) }}</p>
                    </div>
                    <div class="h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Gemiddeld per Medewerker</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($this->averageHoursPerEmployee, 1) }}</p>
                    </div>
                    <div class="h-12 w-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 mb-6">
            <div class="flex flex-col lg:flex-row gap-4">
                <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-1">Startdatum</label>
                        <input
                            type="date"
                            wire:model.live="startDate"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#422AD5] focus:border-[#422AD5] transition-colors"
                        />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-1">Einddatum</label>
                        <input
                            type="date"
                            wire:model.live="endDate"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#422AD5] focus:border-[#422AD5] transition-colors"
                        />
                    </div>
                </div>

                <div class="flex gap-2">
                    <button
                        type="button"
                        wire:click="setThisMonth"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#422AD5] transition-colors">
                        Deze maand
                    </button>
                    <button
                        type="button"
                        wire:click="setLastMonth"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#422AD5] transition-colors">
                        Vorige maand
                    </button>
                    <button
                        type="button"
                        wire:click="setThisYear"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#422AD5] transition-colors">
                        Dit jaar
                    </button>
                    <button
                        type="button"
                        wire:click="resetFilters"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#422AD5] transition-colors">
                        Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- Employees Table -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left">
                                <button wire:click="sortBy('name')" class="flex items-center gap-2 text-xs font-medium text-gray-500 uppercase tracking-wider hover:text-gray-700">
                                    Medewerker
                                    @if($sortBy === 'name')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            @if($sortDirection === 'asc')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            @endif
                                        </svg>
                                    @endif
                                </button>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left">
                                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Email</span>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left">
                                <button wire:click="sortBy('entries')" class="flex items-center gap-2 text-xs font-medium text-gray-500 uppercase tracking-wider hover:text-gray-700">
                                    Registraties
                                    @if($sortBy === 'entries')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            @if($sortDirection === 'asc')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            @endif
                                        </svg>
                                    @endif
                                </button>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left">
                                <button wire:click="sortBy('hours')" class="flex items-center gap-2 text-xs font-medium text-gray-500 uppercase tracking-wider hover:text-gray-700">
                                    Totaal Uren
                                    @if($sortBy === 'hours')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            @if($sortDirection === 'asc')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            @endif
                                        </svg>
                                    @endif
                                </button>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($this->employeeStats as $stat)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-[#422AD5] flex items-center justify-center text-white font-semibold flex-shrink-0">
                                            {{ $stat['user']->initials() }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $stat['user']->name }}</div>
                                            <div class="text-sm text-gray-500">{{ ucfirst($stat['user']->role) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $stat['user']->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $stat['entry_count'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900">{{ number_format($stat['total_hours'], 2) }} uur</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12">
                                    <div class="text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">Geen medewerkers gevonden</h3>
                                        <p class="mt-1 text-sm text-gray-500">Er zijn geen medewerkers in het systeem.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Period Info -->
        @if($startDate || $endDate)
            <div class="mt-4 text-sm text-gray-600 text-center">
                Periode:
                @if($startDate)
                    {{ \Carbon\Carbon::parse($startDate)->format('d-m-Y') }}
                @else
                    Begin
                @endif
                t/m
                @if($endDate)
                    {{ \Carbon\Carbon::parse($endDate)->format('d-m-Y') }}
                @else
                    Eind
                @endif
            </div>
        @endif
    </div>
</div>
