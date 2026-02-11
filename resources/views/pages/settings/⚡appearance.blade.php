<?php

use Livewire\Component;

new class extends Component {
    //
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-pages::settings.layout :heading="__('Appearance')" :subheading="__('Update the appearance settings for your account')">
        <div x-data="{ appearance: $flux.appearance }">
            <p class="text-sm text-gray-500 mb-4">{{ __('Choose how UrenApp looks for you. Select a theme below.') }}</p>

            <div class="grid grid-cols-3 gap-3">
                {{-- Light --}}
                <button type="button" @click="$flux.appearance = 'light'"
                    :class="$flux.appearance === 'light' ? 'ring-2 ring-[#422AD5] border-[#422AD5]' :
                        'border-gray-200 hover:border-gray-300'"
                    class="flex flex-col items-center gap-2 p-4 bg-white rounded-lg border transition-all cursor-pointer">
                    <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="text-sm font-medium text-gray-700">{{ __('Light') }}</span>
                </button>

                {{-- Dark --}}
                <button type="button" @click="$flux.appearance = 'dark'"
                    :class="$flux.appearance === 'dark' ? 'ring-2 ring-[#422AD5] border-[#422AD5]' :
                        'border-gray-200 hover:border-gray-300'"
                    class="flex flex-col items-center gap-2 p-4 bg-white rounded-lg border transition-all cursor-pointer">
                    <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <span class="text-sm font-medium text-gray-700">{{ __('Dark') }}</span>
                </button>

                {{-- System --}}
                <button type="button" @click="$flux.appearance = 'system'"
                    :class="$flux.appearance === 'system' ? 'ring-2 ring-[#422AD5] border-[#422AD5]' :
                        'border-gray-200 hover:border-gray-300'"
                    class="flex flex-col items-center gap-2 p-4 bg-white rounded-lg border transition-all cursor-pointer">
                    <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span class="text-sm font-medium text-gray-700">{{ __('System') }}</span>
                </button>
            </div>
        </div>
    </x-pages::settings.layout>
</section>
