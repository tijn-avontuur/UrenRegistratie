<div class="p-4 md:p-8 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center gap-3 mb-2">
                <a href="/projecten" wire:navigate class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                @if($project->color)
                    <div class="h-12 w-12 rounded-lg border-2 border-gray-300 shadow-sm" style="background-color: {{ $project->color }}"></div>
                @endif
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $project->title }}</h1>
                    @if($project->description)
                        <p class="text-sm text-gray-600 mt-1">{{ $project->description }}</p>
                    @endif
                </div>
            </div>
        </div>

    <!-- Tabs -->
    <div class="mb-6 border-b border-gray-200">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <button
                wire:click="setActiveTab('info')"
                class="@if($activeTab === 'info') border-[#422AD5] text-[#422AD5] @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                Informatie
            </button>
            <button
                wire:click="setActiveTab('time-entries')"
                class="@if($activeTab === 'time-entries') border-[#422AD5] text-[#422AD5] @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                Uren ({{ $project->timeEntries->count() }})
            </button>
            <button
                wire:click="setActiveTab('attachments')"
                class="@if($activeTab === 'attachments') border-[#422AD5] text-[#422AD5] @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                Bijlagen ({{ $project->projectAttachments->count() }})
            </button>
        </nav>
    </div>

    <!-- Tab Content -->
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
        @if($activeTab === 'info')
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Project Details</h3>
                    <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Titel</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $project->title }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Kleur</dt>
                            <dd class="mt-1">
                                <div class="h-8 w-20 rounded border-2 border-gray-300" style="background-color: {{ $project->color }}"></div>
                            </dd>
                        </div>
                        @if($project->description)
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Beschrijving</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $project->description }}</dd>
                            </div>
                        @endif
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Startdatum</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $project->start_date ? $project->start_date->format('d-m-Y') : 'Niet ingesteld' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Einddatum</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $project->end_date ? $project->end_date->format('d-m-Y') : 'Niet ingesteld' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Totaal uren</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $project->timeEntries->count() }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Medewerkers</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $project->users->count() }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Aangemaakt op</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $project->created_at->format('d-m-Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Laatst bijgewerkt</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $project->updated_at->format('d-m-Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        @endif

        @if($activeTab === 'time-entries')
            <livewire:projects.time-entries-list :project="$project" :key="'time-entries-'.$project->id" />
        @endif

        @if($activeTab === 'attachments')
            <livewire:projects.project-attachments :project="$project" :key="'attachments-'.$project->id" />
        @endif
    </div>
    </div>
</div>
