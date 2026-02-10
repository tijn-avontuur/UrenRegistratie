<div>
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold text-gray-900">Teamleden</h3>
        <flux:button wire:click="openAddModal" variant="primary">
            Medewerker toevoegen
        </flux:button>
    </div>

    @if($project->users->isEmpty())
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Geen teamleden</h3>
            <p class="mt-1 text-sm text-gray-500">Begin met het toevoegen van medewerkers aan dit project.</p>
        </div>
    @else
        <div class="overflow-hidden">
            <ul role="list" class="divide-y divide-gray-200">
                @foreach($project->users as $user)
                    <li class="flex items-center justify-between py-4">
                        <div class="flex items-center min-w-0 gap-x-4">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-[#422AD5] flex items-center justify-center text-white font-semibold">
                                    {{ $user->initials() }}
                                </div>
                            </div>
                            <div class="min-w-0 flex-auto">
                                <p class="text-sm font-semibold leading-6 text-gray-900">{{ $user->name }}</p>
                                <p class="text-xs leading-5 text-gray-500">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <flux:button
                                wire:click="removeEmployee({{ $user->id }})"
                                variant="danger"
                                size="sm"
                                wire:confirm="Weet je zeker dat je {{ $user->name }} wilt verwijderen van dit project?"
                            >
                                Verwijderen
                            </flux:button>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Add Employee Modal -->
    @if($showAddModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="$set('showAddModal', false)"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit.prevent="addEmployee">
                        <div class="bg-white px-6 pt-6 pb-4">
                            <div class="mb-6">
                                <h3 class="text-xl font-semibold text-gray-900" id="modal-title">Medewerker toevoegen</h3>
                            </div>

                            <div class="space-y-6">
                                @if($availableUsers->isEmpty())
                                    <div class="rounded-md bg-yellow-50 p-4">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-yellow-800">Geen beschikbare medewerkers</h3>
                                                <p class="mt-2 text-sm text-yellow-700">Alle medewerkers zijn al gekoppeld aan dit project.</p>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div>
                                        <label class="block text-sm font-medium text-gray-900 mb-1">Selecteer medewerker</label>
                                        <select wire:model="selectedUserId" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#422AD5] focus:border-[#422AD5] transition-colors">
                                            <option value="">-- Kies een medewerker --</option>
                                            @foreach($availableUsers as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                            @endforeach
                                        </select>
                                        @error('selectedUserId') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3">
                            @if($availableUsers->isNotEmpty())
                                <button
                                    type="submit"
                                    class="inline-flex justify-center rounded-lg border border-transparent bg-[#422AD5] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#3821B0] focus:outline-none focus:ring-2 focus:ring-[#422AD5] focus:ring-offset-2 transition-all">
                                    Toevoegen
                                </button>
                            @endif
                            <button
                                type="button"
                                wire:click="$set('showAddModal', false)"
                                class="inline-flex justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#422AD5] focus:ring-offset-2 transition-all">
                                Annuleren
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
