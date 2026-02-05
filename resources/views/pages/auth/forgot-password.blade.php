<x-layouts::auth>
    <div class="space-y-6">
        <!-- Title -->
        <div class="text-center space-y-2">
            <h1 class="text-3xl font-bold text-base-content">
                {{ __('Wachtwoord vergeten') }}
            </h1>
            <p class="text-sm text-base-content/60">
                {{ __('Vul je email in om een wachtwoord reset link te ontvangen') }}
            </p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <!-- Email Address -->
            <div class="form-control">
                <label class="label pt-1" for="email">
                    <span class="label-text font-medium">{{ __('Email adres') }}</span>
                </label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    autocomplete="email"
                    required
                    autofocus
                    placeholder="naam@bedrijf.nl"
                    class="input input-bordered w-full {{ $errors->has('email') ? 'input-error' : '' }}"
                />
                @error('email')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>

            <div class="form-control mt-6">
                <button
                    type="submit"
                    class="btn btn-primary btn-lg w-full"
                    data-test="email-password-reset-link-button"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    {{ __('Stuur reset link') }}
                </button>
            </div>
        </form>

        <div class="divider">OF</div>

        <div class="text-center">
            <a href="{{ route('login') }}" class="btn btn-ghost btn-sm gap-2" wire:navigate>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Terug naar inloggen') }}
            </a>
        </div>
    </div>
</x-layouts::auth>
