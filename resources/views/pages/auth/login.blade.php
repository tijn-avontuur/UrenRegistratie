<x-layouts::auth>
    <div class="space-y-6">
        <!-- Title -->
        <div class="text-center space-y-2">
            <h1 class="text-3xl font-bold text-base-content">
                {{ __('Inloggen bij UrenApp') }}
            </h1>
            <p class="text-sm text-base-content/60">
                {{ __('Vul je gegevens in om in te loggen') }}
            </p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-info">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
            @csrf

            <!-- Email Address -->
            <div class="form-control">
                <label class="label pt-1" for="email">
                    <span class="label-text font-medium">{{ __('Email adres') }}</span>
                </label>
                <label class="input input-bordered flex items-center gap-2 {{ $errors->has('email') ? 'input-error' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-60" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                    <input 
                        id="email" 
                        name="email" 
                        type="email" 
                        autocomplete="email" 
                        required 
                        autofocus
                        value="{{ old('email') }}" 
                        placeholder="naam@bedrijf.nl" 
                        class="grow" 
                    />
                </label>
                @error('email')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-control">
                <label class="label pt-1" for="password">
                    <span class="label-text font-medium">{{ __('Wachtwoord') }}</span>
                </label>
                <label class="input input-bordered flex items-center gap-2 {{ $errors->has('password') ? 'input-error' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-60" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <input 
                        id="password" 
                        name="password" 
                        type="password" 
                        autocomplete="current-password" 
                        required
                        placeholder="••••••••" 
                        class="grow" 
                    />
                </label>
                @error('password')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between pt-2">
                <label class="flex items-center gap-3 cursor-pointer group">
                    <div class="relative">
                        <input 
                            id="remember" 
                            name="remember" 
                            type="checkbox" 
                            {{ old('remember') ? 'checked' : '' }}
                            class="peer sr-only" 
                        />
                        <div class="w-11 h-6 bg-base-300 rounded-full peer-checked:bg-primary transition-colors duration-200"></div>
                        <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transition-transform duration-200 peer-checked:translate-x-5"></div>
                    </div>
                    <span class="text-sm text-base-content/70 group-hover:text-base-content transition-colors select-none">
                        {{ __('Onthoud mij') }}
                    </span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="link link-primary link-hover text-sm" wire:navigate>
                        {{ __('Wachtwoord vergeten?') }}
                    </a>
                @endif
            </div>

            <!-- Login Button -->
            <div class="form-control mt-6">
                <button type="submit" class="btn btn-primary btn-lg w-full" data-test="login-button">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    {{ __('Inloggen') }}
                </button>
            </div>
        </form>
    </div>
</x-layouts::auth>
