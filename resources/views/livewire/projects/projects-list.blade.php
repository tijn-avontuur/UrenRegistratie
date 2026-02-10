<div>
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Projecten</h1>
        <flux:button wire:click="openCreateModal" variant="primary" icon="plus">
            Nieuw Project
        </flux:button>
    </div>

    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
        @forelse($projects as $project)
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <div class="mb-4 flex items-start justify-between">
                    <div class="flex items-center gap-3">
                        @if($project->color)
                            <div class="h-12 w-12 rounded-lg border-2 border-gray-300 shadow-sm flex-shrink-0" style="background-color: {{ $project->color }}"></div>
                        @endif
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $project->title }}</h3>
                            @if($project->description)
                                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($project->description, 100) }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mb-4 flex items-center gap-4 text-sm text-gray-700 flex-wrap">
                    <div class="flex items-center gap-1">
                        <flux:icon name="clock" class="h-4 w-4 text-gray-500" />
                        <span class="font-medium">{{ $project->time_entries_count }} uren</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <flux:icon name="users" class="h-4 w-4 text-gray-500" />
                        <span class="font-medium">{{ $project->users->count() }} medewerkers</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                        </svg>
                        <span class="font-medium">{{ $project->projectAttachments->count() }} bijlagen</span>
                    </div>
                </div>

                <div class="flex gap-2 flex-wrap">
                    <a
                        href="/projecten/{{ $project->id }}"
                        wire:navigate
                        class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-[#422AD5] bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Details
                    </a>
                    <button
                        wire:click="openEditModal({{ $project->id }})"
                        class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Bewerken
                    </button>
                    <button
                        wire:click="deleteProject({{ $project->id }})"
                        wire:confirm="Weet je zeker dat je dit project wilt verwijderen?"
                        class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-red-700 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Verwijderen
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                </svg>
                <h3 class="mt-4 text-lg font-semibold text-gray-900">Geen projecten</h3>
                <p class="mt-2 text-sm text-gray-600">Begin met het aanmaken van je eerste project.</p>
                <flux:button wire:click="openCreateModal" variant="primary" class="mt-6" icon="plus">
                    Nieuw Project
                </flux:button>
            </div>
        @endforelse
    </div>

    <!-- Create Modal -->
    @if($showCreateModal)
        <livewire:projects.create-project :key="'create-project'" />
    @endif

    <!-- Edit Modal -->
    @if($showEditModal && $editingProject)
        <livewire:projects.edit-project :project="$editingProject" :key="'edit-project-'.$editingProject->id" />
    @endif
</div>
