<div>
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-xl font-semibold text-gray-900">Tijdsregistraties</h2>
        <flux:button wire:click="openCreateModal" variant="primary" icon="plus" size="sm">
            Nieuwe Registratie
        </flux:button>
    </div>

    <div class="space-y-3">
        @forelse($timeEntries as $entry)
            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm hover:border-blue-300 transition-colors">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex px-2.5 py-1 text-xs font-semibold text-blue-800 bg-blue-100 border border-blue-300 rounded-lg">
                                {{ $entry->date->format('d-m-Y') }}
                            </span>
                            <span class="font-semibold text-gray-900">{{ $entry->project->title }}</span>
                        </div>
                        <div class="mt-2 flex items-center gap-4 text-sm text-gray-700">
                            <span class="font-medium">{{ $entry->start_time->format('H:i') }} - {{ $entry->end_time?->format('H:i') ?? 'Lopend' }}</span>
                            @if($entry->duration_minutes)
                                @php($duration = max(0, (int) round($entry->duration_minutes)))
                                <span class="font-semibold text-blue-600">{{ intdiv($duration, 60) }}u {{ $duration % 60 }}m</span>
                            @endif
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button
                            wire:click="openEditModal({{ $entry->id }})"
                            class="inline-flex items-center justify-center w-8 h-8 text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                        <button
                            wire:click="deleteTimeEntry({{ $entry->id }})"
                            wire:confirm="Weet je zeker dat je deze registratie wilt verwijderen?"
                            class="inline-flex items-center justify-center w-8 h-8 text-red-700 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="rounded-lg border-2 border-dashed border-gray-300 p-8 text-center">
                <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="mt-2 text-sm text-gray-600">Nog geen tijdsregistraties</p>
                <flux:button wire:click="openCreateModal" variant="primary" class="mt-4" size="sm" icon="plus">
                    Nieuwe Registratie
                </flux:button>
            </div>
        @endforelse
    </div>

    <!-- Create Modal -->
    @if($showCreateModal)
        <livewire:projects.create-time-entry :projectId="$projectId" @close="showCreateModal = false" />
    @endif

    <!-- Edit Modal -->
    @if($showEditModal && $editingTimeEntry)
        <livewire:projects.edit-time-entry :timeEntry="$editingTimeEntry" @close="showEditModal = false" />
    @endif
</div>
