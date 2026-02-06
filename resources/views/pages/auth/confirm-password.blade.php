<x-layouts::auth>
    <div class="space-y-6">
        <!-- Title -->
        <div class="text-center space-y-2">
            <h1 class="text-3xl font-bold text-base-content">
                {{ __('Bevestig wachtwoord') }}
            </h1>
            <p class="text-sm text-base-content/60">
                {{ __('Dit is een beveiligd gedeelte. Bevestig je wachtwoord om door te gaan.') }}
            </p>
        </div>

        @if (session('status'))
            <div class="alert alert-warning">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('password.confirm.store') }}" class="space-y-5">
            @csrf

            <div class="form-control">
                <label class="label pt-1" for="password">
                    <span class="label-text font-medium">{{ __('Wachtwoord') }}</span>
                </label>
                <input id="password" name="password" type="password" autocomplete="current-password" required
                    placeholder="••••••••"
                    class="input input-bordered w-full {{ $errors->has('password') ? 'input-error' : '' }}" />
                @error('password')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>

            <div class="form-control mt-6">
                <button type="submit" class="btn btn-primary btn-lg w-full" data-test="confirm-password-button">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ __('Bevestigen') }}
                </button>
            </div>
        </form>
    </div>
</x-layouts::auth>
