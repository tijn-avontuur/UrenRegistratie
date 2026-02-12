@php
    $title = __('Mijn uren');
@endphp

<x-layouts::app :title="$title">
    <div class="p-4 md:p-8 bg-gray-50 min-h-screen">
        <div class="mb-6 flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $title }}</h1>
                <p class="text-gray-500 mt-1">Overzicht van je geregistreerde uren.</p>
            </div>
            <div class="text-right">
                @php
                    $total = $totalMinutes ?? 0;
                    $hours = intdiv($total, 60);
                    $minutes = $total % 60;
                @endphp
                <div class="text-sm text-gray-500">Totaal gewerkt: <span class="font-medium text-gray-800">{{ $hours }}h {{ sprintf('%02d', $minutes) }}m</span></div>
            </div>
        </div>

        <!-- Filters: date range + project -->
        <form method="GET" action="{{ route('time-entries.index') }}" class="mb-4 bg-white p-4 rounded-lg shadow-sm flex flex-col md:flex-row gap-3 items-end">
            <div class="flex gap-4 items-end flex-wrap">
                <div>
                    <label class="block text-xs text-gray-500">Start datum</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="mt-1 block w-44 border-gray-200 rounded-md shadow-sm text-sm">
                </div>
                <div>
                    <label class="block text-xs text-gray-500">Eind datum</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="mt-1 block w-44 border-gray-200 rounded-md shadow-sm text-sm">
                </div>

                <div>
                    <label class="block text-xs text-gray-500">Project</label>
                    <select name="project_id" class="mt-1 block w-56 border-gray-200 rounded-md shadow-sm text-sm">
                        <option value="">{{ __('All projects') }}</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" @if(request('project_id') == $project->id) selected @endif>{{ $project->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="ml-auto flex gap-2">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md text-sm">Filter</button>
                <a href="{{ route('time-entries.index') }}" class="inline-flex items-center px-4 py-2 border rounded-md text-sm text-gray-600">Reset</a>
            </div>
        </form>

        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y">
                    <thead class="bg-gray-50">
                        <tr class="text-sm text-gray-500">
                            <th class="px-6 py-4 text-left">Datum</th>
                            <th class="px-6 py-4 text-left">Project</th>
                            <th class="px-6 py-4 text-left">Omschrijving</th>
                            <th class="px-6 py-4 text-left">Tijd</th>
                            <th class="px-6 py-4"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                        @forelse($entries as $entry)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 align-middle text-sm text-gray-700">
                                    <div class="flex items-center gap-3">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>{{ $entry->date->locale('nl')->isoFormat('LL') }}</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 align-middle text-sm">
                                    <div class="inline-flex items-center gap-3">
                                        <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-sm font-medium">{{ optional($entry->project)->title ?? 'Onbekend' }}</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 align-middle text-sm text-gray-600">
                                    {{ Str::limit(optional($entry->project)->description ?? '-', 80) }}
                                </td>

                                <td class="px-6 py-4 align-middle text-sm text-gray-800 font-medium">
                                    {{ $entry->start_time ? $entry->start_time->format('H:i') : '-' }} — {{ $entry->end_time ? $entry->end_time->format('H:i') : '-' }}
                                </td>

                                <td class="px-6 py-4 align-middle text-right text-sm">
                                    <details class="relative inline-block">
                                        <summary class="list-none p-2 rounded-full hover:bg-gray-100 cursor-pointer inline-flex items-center">
                                            <svg class="w-5 h-5 text-gray-500" viewBox="0 0 24 24" fill="currentColor"> <circle cx="12" cy="5" r="1.8"/> <circle cx="12" cy="12" r="1.8"/> <circle cx="12" cy="19" r="1.8"/> </svg>
0                                        </summary>
                                        <div class="absolute right-0 mt-2 w-40 bg-white border rounded shadow-sm z-10">
                                            <ul class="p-2">
                                                <li class="text-sm text-gray-700 px-2 py-1">Actie 1 (later)</li>
                                                <li class="text-sm text-gray-700 px-2 py-1">Actie 2 (later)</li>
                                            </ul>
                                        </div>
                                    </details>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-6 text-center text-sm text-gray-500">Geen uren gevonden.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $entries->links() }}
        </div>
    </div>
</x-layouts::app>
