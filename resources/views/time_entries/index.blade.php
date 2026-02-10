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
        </div>

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
                                            <svg class="w-5 h-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zm9-2a2 2 0 100 4 2 2 0 000-4zm3 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </summary>
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
