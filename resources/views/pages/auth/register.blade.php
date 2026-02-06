<x-layouts::auth>
    <div class="space-y-6">
        <!-- Icon -->
        <div class="flex justify-center">
            <div class="rounded-full bg-primary/20 p-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-primary" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
        </div>

        <!-- Title -->
        <div class="text-center space-y-2">
            <h1 class="text-3xl font-bold text-base-content">
                {{ __('Account aanmaken') }}
            </h1>
            <p class="text-sm text-base-content/60">
                {{ __('Maak een nieuw account aan om te beginnen') }}
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="space-y-6">
            @csrf
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">
                    {{ __('Naam') }}
                </label>
                <div class="mt-1">
                    <input id="name" name="name" type="text" autocomplete="name" required autofocus
                        value="{{ old('name') }}" placeholder="{{ __('Volledige naam') }}"
                        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md py-2 px-3 border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }}" />
                </div>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">
                    {{ __('Email adres') }}
                </label>
                <div class="mt-1">
                    <input id="email" name="email" type="email" autocomplete="email" required
                        value="{{ old('email') }}" placeholder="email@example.com"
                        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md py-2 px-3 border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }}" />
                </div>
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">
                    {{ __('Wachtwoord') }}
                </label>
                <div class="mt-1">
                    <input id="password" name="password" type="password" autocomplete="new-password" required
                        placeholder="{{ __('Wachtwoord') }}"
                        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md py-2 px-3 border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }}" />
                </div>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                    {{ __('Bevestig wachtwoord') }}
                </label>
                <div class="mt-1">
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                        required placeholder="{{ __('Bevestig wachtwoord') }}"
                        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md py-2 px-3 border border-gray-300" />
                </div>
            </div>

            <div>
                <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors"
                    data-test="register-user-button">
                    {{ __('Account aanmaken') }}
                </button>
            </div>
        </form>

        <div class="text-center text-sm text-gray-600">
            <span>{{ __('Heb je al een account?') }}</span>
            <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500"
                wire:navigate>{{ __('Inloggen') }}</a>
        </div>
    </div>
</x-layouts::auth>

