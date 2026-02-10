<div>
    @if($show)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeModal"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit="save">
                        <div class="bg-white px-6 pt-6 pb-4">
                            <div class="mb-6">
                                <h3 class="text-xl font-semibold text-gray-900" id="modal-title">Nieuw Project</h3>
                                <p class="mt-1 text-sm text-gray-600">Maak een nieuw project aan.</p>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-900 mb-1">Project Naam</label>
                                    <input
                                        type="text"
                                        wire:model="title"
                                        placeholder="Bijv. Website Redesign"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#422AD5] focus:border-[#422AD5] transition-colors"
                                    />
                                    @error('title') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-900 mb-1">Beschrijving</label>
                                    <textarea
                                        wire:model="description"
                                        placeholder="Optionele beschrijving..."
                                        rows="3"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#422AD5] focus:border-[#422AD5] transition-colors"
                                    ></textarea>
                                    @error('description') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-900 mb-1">Kleur</label>
                                    <input
                                        type="color"
                                        wire:model="color"
                                        class="h-12 w-full cursor-pointer rounded-lg border-2 border-gray-300 shadow-sm hover:border-[#422AD5] transition-colors"
                                    />
                                    @error('color') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-900 mb-1">Startdatum (optioneel)</label>
                                        <input
                                            type="date"
                                            wire:model="start_date"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#422AD5] focus:border-[#422AD5] transition-colors"
                                        />
                                        @error('start_date') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-900 mb-1">Einddatum (optioneel)</label>
                                        <input
                                            type="date"
                                            wire:model="end_date"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#422AD5] focus:border-[#422AD5] transition-colors"
                                        />
                                        @error('end_date') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-900 mb-2">Bijlagen (optioneel)</label>
                                    <input
                                        type="file"
                                        wire:model="attachments"
                                        multiple
                                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#422AD5] focus:border-[#422AD5]"
                                    />
                                    <p class="mt-1 text-xs text-gray-500">Max 10MB per bestand</p>
                                    @error('attachments.*') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror

                                    <div wire:loading wire:target="attachments" class="mt-2">
                                        <p class="text-sm text-gray-600">Bestanden laden...</p>
                                    </div>

                                    @if(!empty($attachments))
                                        <div class="mt-3 space-y-2">
                                            @foreach($attachments as $index => $attachment)
                                                <div class="flex items-center justify-between p-2 bg-blue-50 rounded border border-blue-200">
                                                    <div class="flex items-center gap-2 flex-1 min-w-0">
                                                        <svg class="w-4 h-4 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                                        </svg>
                                                        <span class="text-sm text-blue-900 truncate">{{ $attachment->getClientOriginalName() }}</span>
                                                    </div>
                                                    <button
                                                        type="button"
                                                        wire:click="removeAttachment({{ $index }})"
                                                        class="text-red-600 hover:text-red-800 flex-shrink-0 ml-2">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-6 py-4 flex gap-3 justify-end">
                            <button
                                type="button"
                                wire:click="closeModal"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
                            >
                                Annuleren
                            </button>
                            <button
                                type="submit"
                                wire:loading.attr="disabled"
                                wire:target="save,attachments"
                                class="px-4 py-2 text-sm font-medium text-white bg-[#422AD5] rounded-lg hover:bg-[#3622a8] transition-colors disabled:opacity-50"
                            >
                                <span wire:loading.remove wire:target="save">Opslaan</span>
                                <span wire:loading wire:target="save">Opslaan...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
