<?php

use App\Concerns\PasswordValidationRules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

new class extends Component {
    use PasswordValidationRules;

    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => $this->currentPasswordRules(),
                'password' => $this->passwordRules(),
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => $validated['password'],
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-pages::settings.layout :heading="__('Wachtwoord wijzigen')" :subheading="__('Gebruik een lang en uniek wachtwoord om je account te beveiligen')">
        <form method="POST" wire:submit="updatePassword" class="space-y-5">
            <div>
                <label for="current_password"
                    class="block text-sm font-medium text-gray-700 mb-1">{{ __('Huidig wachtwoord') }} <span
                        class="text-red-500">*</span></label>
                <input wire:model="current_password" id="current_password" type="password" required
                    autocomplete="current-password"
                    class="block w-full h-11 rounded-md border-gray-200 bg-white shadow-sm text-sm focus:border-[#422AD5] focus:ring-[#422AD5]" />
                @error('current_password')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Nieuw wachtwoord') }}
                    <span class="text-red-500">*</span></label>
                <input wire:model="password" id="password" type="password" required autocomplete="new-password"
                    class="block w-full h-11 rounded-md border-gray-200 bg-white shadow-sm text-sm focus:border-[#422AD5] focus:ring-[#422AD5]" />
                @error('password')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation"
                    class="block text-sm font-medium text-gray-700 mb-1">{{ __('Bevestig wachtwoord') }} <span
                        class="text-red-500">*</span></label>
                <input wire:model="password_confirmation" id="password_confirmation" type="password" required
                    autocomplete="new-password"
                    class="block w-full h-11 rounded-md border-gray-200 bg-white shadow-sm text-sm focus:border-[#422AD5] focus:ring-[#422AD5]" />
                @error('password_confirmation')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-[#422AD5] text-white text-sm font-medium rounded-md hover:bg-[#3622b0] transition-colors shadow-sm"
                    data-test="update-password-button">
                    {{ __('Wachtwoord bijwerken') }}
                </button>

                <x-action-message class="text-sm text-green-600 font-medium" on="password-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>
    </x-pages::settings.layout>
</section>
