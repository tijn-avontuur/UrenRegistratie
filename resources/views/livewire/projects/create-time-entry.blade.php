<flux:modal wire:model="show" class="md:w-96">
    <form wire:submit="save">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg" class="text-gray-900">Nieuwe Tijdsregistratie</flux:heading>
                <flux:text class="text-gray-700">Vul de gewerkte uren in.</flux:text>
            </div>

            @if(!$projectId)
                <flux:field>
                    <flux:label class="text-gray-900 font-medium">Project</flux:label>
                    <flux:select wire:model="project_id">
                        <option value="">Selecteer een project</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->title }}</option>
                        @endforeach
                    </flux:select>
                    <flux:error name="project_id" />
                </flux:field>
            @endif

            <flux:field>
                <flux:label class="text-gray-900 font-medium">Datum</flux:label>
                <flux:input type="date" wire:model="date" />
                <flux:error name="date" />
            </flux:field>

            <div class="grid grid-cols-2 gap-4">
                <flux:field>
                    <flux:label class="text-gray-900 font-medium">Begintijd</flux:label>
                    <flux:input type="time" wire:model="start_time" />
                    <flux:error name="start_time" />
                </flux:field>

                <flux:field>
                    <flux:label class="text-gray-900 font-medium">Eindtijd</flux:label>
                    <flux:input type="time" wire:model="end_time" />
                    <flux:error name="end_time" />
                </flux:field>
            </div>

            <div class="flex gap-2">
                <flux:button type="submit" variant="primary">Opslaan</flux:button>
                <flux:button type="button" variant="ghost" wire:click="$dispatch('close')">Annuleren</flux:button>
            </div>
        </div>
    </form>
</flux:modal>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('close', () => {
            @this.set('show', false);
        });
    });
</script>
