<div>
    <div class="mb-4 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900">Bijlagen ({{ $attachments->count() }})</h3>
        <button
            wire:click="openUploadModal"
            class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-white bg-[#422AD5] rounded-lg hover:bg-[#3622a8] transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Upload Bijlage
        </button>
    </div>

    @if($attachments->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($attachments as $attachment)
                <div class="bg-gray-50 rounded-lg border border-gray-200 overflow-hidden hover:border-[#422AD5] transition-colors">
                    @if($attachment['is_image'])
                        <!-- Image Preview -->
                        <div class="aspect-video bg-gray-100 relative group">
                            <img
                                src="{{ $attachment['url'] }}"
                                alt="{{ $attachment['filename'] }}"
                                class="w-full h-full object-cover"
                            />
                            <!-- Overlay on hover -->
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all flex items-center justify-center">
                                <a
                                    href="{{ $attachment['url'] }}"
                                    target="_blank"
                                    class="opacity-0 group-hover:opacity-100 transition-opacity inline-flex items-center gap-1 px-3 py-2 text-xs font-medium text-white bg-[#422AD5] rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Bekijk
                                </a>
                            </div>
                        </div>
                    @else
                        <!-- File Icon for non-images -->
                        <div class="aspect-video bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif

                    <!-- File Info -->
                    <div class="p-3">
                        <div class="flex items-start gap-2 mb-2">
                            <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $attachment['filename'] }}</p>
                                <p class="text-xs text-gray-500">{{ $attachment['uploaded_at']->format('d-m-Y H:i') }}</p>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-2">
                            <button
                                wire:click="download({{ $attachment['id'] }})"
                                class="flex-1 inline-flex items-center justify-center gap-1 px-2 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 rounded transition-colors">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download
                            </button>
                            <button
                                wire:click="delete({{ $attachment['id'] }})"
                                wire:confirm="Weet je zeker dat je deze bijlage wilt verwijderen?"
                                class="flex-1 inline-flex items-center justify-center gap-1 px-2 py-1.5 text-xs font-medium text-red-700 bg-red-50 hover:bg-red-100 rounded transition-colors">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Verwijder
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
            <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
            </svg>
            <p class="mt-2 text-sm text-gray-600">Geen bijlagen toegevoegd</p>
        </div>
    @endif

    <!-- Upload Modal -->
    @if($showUploadModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeUploadModal"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit="upload">
                        <div class="bg-white px-6 pt-6 pb-4">
                            <div class="mb-6">
                                <h3 class="text-xl font-semibold text-gray-900" id="modal-title">Bijlage Uploaden</h3>
                                <p class="mt-1 text-sm text-gray-600">Upload een bestand voor dit project (max 10MB).</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-2">Bestand</label>
                                <input
                                    type="file"
                                    wire:model="attachment"
                                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#422AD5] focus:border-[#422AD5]"
                                />
                                @error('attachment')
                                    <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                                @enderror

                                @if($attachment)
                                    <div class="mt-3 p-3 bg-blue-50 rounded-lg border border-blue-200">
                                        <p class="text-sm text-blue-900">
                                            <span class="font-medium">Geselecteerd:</span> {{ $attachment->getClientOriginalName() }}
                                        </p>
                                    </div>
                                @endif

                                <div wire:loading wire:target="attachment" class="mt-2">
                                    <p class="text-sm text-gray-600">Bestand laden...</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-6 py-4 flex gap-3 justify-end">
                            <button
                                type="button"
                                wire:click="closeUploadModal"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
                            >
                                Annuleren
                            </button>
                            <button
                                type="submit"
                                wire:loading.attr="disabled"
                                wire:target="upload"
                                class="px-4 py-2 text-sm font-medium text-white bg-[#422AD5] rounded-lg hover:bg-[#3622a8] transition-colors disabled:opacity-50"
                            >
                                <span wire:loading.remove wire:target="upload">Uploaden</span>
                                <span wire:loading wire:target="upload">Uploaden...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
