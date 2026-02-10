<?php

use App\Concerns\PasswordValidationRules;
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component {
    use PasswordValidationRules;

    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => $this->currentPasswordRules(),
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="mt-8 pt-6 border-t border-gray-200">
    <div class="mb-4">
        <h3 class="text-base font-semibold text-red-600">{{ __('Danger zone') }}</h3>
        <p class="text-sm text-gray-500 mt-0.5">{{ __('Delete your account and all of its resources permanently.') }}</p>
    </div>

    <flux:modal.trigger name="confirm-user-deletion">
        <button type="button"
            class="inline-flex items-center gap-2 px-4 py-2 border border-red-300 text-red-600 text-sm font-medium rounded-md hover:bg-red-50 transition-colors"
            data-test="delete-user-button">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            {{ __('Delete account') }}
        </button>
    </flux:modal.trigger>

    <flux:modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable class="max-w-lg">
        <form method="POST" wire:submit="deleteUser" class="space-y-5">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">
                    {{ __('Are you sure you want to delete your account?') }}</h3>
                <p class="text-sm text-gray-500 mt-2">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>
            </div>

            <div>
                <label for="delete-password"
                    class="block text-sm font-medium text-gray-700 mb-1">{{ __('Password') }}</label>
                <input wire:model="password" id="delete-password" type="password"
                    class="block w-full rounded-md border-gray-200 shadow-sm text-sm focus:border-[#422AD5] focus:ring-[#422AD5]" />
                @error('password')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <flux:modal.close>
                    <button type="button"
                        class="inline-flex items-center px-4 py-2 border border-gray-200 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50 transition-colors">
                        {{ __('Cancel') }}
                    </button>
                </flux:modal.close>

                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 transition-colors"
                    data-test="confirm-delete-user-button">
                    {{ __('Delete account') }}
                </button>
            </div>
        </form>
    </flux:modal>
</section>
