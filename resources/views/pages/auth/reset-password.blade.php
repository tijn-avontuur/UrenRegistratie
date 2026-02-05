<x-layouts::auth>
    <div class="space-y-6">
        <!-- Title -->
        <div class="text-center space-y-2">
            <h1 class="text-3xl font-bold text-base-content">
                {{ __('Wachtwoord resetten') }}
            </h1>
            <p class="text-sm text-base-content/60">
                {{ __('Vul je nieuwe wachtwoord in') }}
            </p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-info">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
            @csrf
            <!-- Token -->
            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <!-- Email Address -->
            <div class="form-control">
                <label class="label pt-1" for="email">
                    <span class="label-text font-medium">{{ __('Email adres') }}</span>
                </label>
                <input id="email" name="email" type="email" autocomplete="email" required
                    value="{{ request('email') }}"
                    class="input input-bordered w-full {{ $errors->has('email') ? 'input-error' : '' }}" />
                @error('email')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-control">
                <label class="label pt-1" for="password">
                    <span class="label-text font-medium">{{ __('Nieuw wachtwoord') }}</span>
                </label>
                <input id="password" name="password" type="password" autocomplete="new-password" required
                    placeholder="••••••••"
                    class="input input-bordered w-full {{ $errors->has('password') ? 'input-error' : '' }}" />
                @error('password')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-control">
                <label class="label pt-1" for="password_confirmation">
                    <span class="label-text font-medium">{{ __('Bevestig wachtwoord') }}</span>
                </label>
                <input id="password_confirmation" name="password_confirmation" type="password"
                    autocomplete="new-password" required placeholder="••••••••" class="input input-bordered w-full" />
            </div>

            <div class="form-control mt-6">
                <button type="submit" class="btn btn-primary btn-lg w-full" data-test="reset-password-button">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                    {{ __('Wachtwoord resetten') }}
                </button>
            </div>
        </form>
    </div>
</x-layouts::auth>
