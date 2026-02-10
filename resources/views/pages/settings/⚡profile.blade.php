<?php

use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    use ProfileValidationRules;

    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $position = '';
    public string $bio = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->position = $user->position ?? '';
        $this->bio = $user->bio ?? '';
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate($this->profileRules($user->id));

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    #[Computed]
    public function hasUnverifiedEmail(): bool
    {
        return Auth::user() instanceof MustVerifyEmail && !Auth::user()->hasVerifiedEmail();
    }

    #[Computed]
    public function showDeleteUser(): bool
    {
        return !Auth::user() instanceof MustVerifyEmail || (Auth::user() instanceof MustVerifyEmail && Auth::user()->hasVerifiedEmail());
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-pages::settings.layout :heading="__('Profile')" :subheading="__('Update your personal information and profile details')">
        <form wire:submit="updateProfileInformation" class="space-y-6">
            {{-- Avatar & Name Header --}}
            <div class="flex items-center gap-4 pb-6 border-b border-gray-200">
                <div class="bg-[#422AD5] text-white rounded-full w-16 h-16 flex items-center justify-center shrink-0">
                    <span class="text-xl font-semibold">{{ auth()->user()->initials() }}</span>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ auth()->user()->name }}</h3>
                    <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                </div>
            </div>

            {{-- Personal Information --}}
            <div class="space-y-4">
                <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">{{ __('Personal Information') }}
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Name') }}
                            <span class="text-red-500">*</span></label>
                        <input wire:model="name" id="name" type="text" required autofocus autocomplete="name"
                            class="block w-full rounded-md border-gray-200 shadow-sm text-sm focus:border-[#422AD5] focus:ring-[#422AD5] @error('name') border-red-300 @enderror" />
                        @error('name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone"
                            class="block text-sm font-medium text-gray-700 mb-1">{{ __('Phone') }}</label>
                        <input wire:model="phone" id="phone" type="tel" autocomplete="tel"
                            class="block w-full rounded-md border-gray-200 shadow-sm text-sm focus:border-[#422AD5] focus:ring-[#422AD5] @error('phone') border-red-300 @enderror"
                            placeholder="+31 6 12345678" />
                        @error('phone')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Email') }} <span
                            class="text-red-500">*</span></label>
                    <input wire:model="email" id="email" type="email" required autocomplete="email"
                        class="block w-full rounded-md border-gray-200 shadow-sm text-sm focus:border-[#422AD5] focus:ring-[#422AD5] @error('email') border-red-300 @enderror" />
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror

                    @if ($this->hasUnverifiedEmail)
                        <div class="mt-2 flex items-center gap-2 text-sm text-amber-600">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                            <span>{{ __('Your email address is unverified.') }}
                                <button type="button" wire:click.prevent="resendVerificationNotification"
                                    class="underline hover:text-amber-700 font-medium">
                                    {{ __('Resend verification email') }}
                                </button>
                            </span>
                        </div>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 text-sm font-medium text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    @endif
                </div>

                <div>
                    <label for="position"
                        class="block text-sm font-medium text-gray-700 mb-1">{{ __('Position') }}</label>
                    <input wire:model="position" id="position" type="text"
                        class="block w-full rounded-md border-gray-200 shadow-sm text-sm focus:border-[#422AD5] focus:ring-[#422AD5] @error('position') border-red-300 @enderror"
                        placeholder="{{ __('e.g. Software Developer') }}" />
                    @error('position')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="bio"
                        class="block text-sm font-medium text-gray-700 mb-1">{{ __('Bio') }}</label>
                    <textarea wire:model="bio" id="bio" rows="3"
                        class="block w-full rounded-md border-gray-200 shadow-sm text-sm focus:border-[#422AD5] focus:ring-[#422AD5] @error('bio') border-red-300 @enderror"
                        placeholder="{{ __('Tell us a little about yourself...') }}"></textarea>
                    <p class="mt-1 text-xs text-gray-400">{{ __('Max 1000 characters') }}</p>
                    @error('bio')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Save --}}
            <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-[#422AD5] text-white text-sm font-medium rounded-md hover:bg-[#3622b0] transition-colors shadow-sm"
                    data-test="update-profile-button">
                    {{ __('Save changes') }}
                </button>

                <x-action-message class="text-sm text-green-600 font-medium" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

        @if ($this->showDeleteUser)
            <livewire:pages::settings.delete-user-form />
        @endif
    </x-pages::settings.layout>
</section>
