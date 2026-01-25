<div class="min-h-screen flex flex-col sm:justify-center items-center pt-4 sm:pt-0 px-4 sm:px-0 relative">
    <!-- Blue Gradient Background -->
    <div class="fixed inset-0 -z-10 bg-gradient-to-br from-blue-50 via-blue-100 to-blue-200"></div>

    <div class="w-full max-w-sm sm:max-w-md mt-4 sm:mt-6 px-4 sm:px-6 py-6 sm:py-8 bg-white/95 backdrop-blur-sm shadow-lg sm:shadow-xl overflow-hidden rounded-lg sm:rounded-2xl border border-blue-100">
        <!-- Logo Image -->
        <div class="mb-4 sm:mb-6 text-center">
            <img 
                    src="{{ asset('images/spcc-logo.png') }}" 
                    alt="SPCC Logo" 
                    class="mx-auto h-24 w-24 sm:h-32 sm:w-32 object-contain mb-4"
                    onerror="console.error('Logo image failed to load')"
                >
        </div>

        <h2 class="text-2xl sm:text-3xl font-bold text-center mb-2 bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent">
            SPCC Events Management
        </h2>
        <p class="text-center text-gray-600 mb-4 sm:mb-6 text-sm sm:text-base">Sign in to your account</p>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded-lg">
                {{ $value }}
            </div>
        @endsession

        <form wire:submit="login">
            <div>
                <x-label for="email" value="{{ __('Email') }}" class="text-gray-700 font-medium text-sm sm:text-base" />
                <x-input 
                    id="email" 
                    class="block mt-1 w-full border-blue-200 focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base" 
                    type="email" 
                    wire:model="email"
                    required 
                    autofocus 
                    autocomplete="username" 
                />
                @error('email') <span class="text-red-600 text-xs sm:text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" class="text-gray-700 font-medium text-sm sm:text-base" />
                <x-input 
                    id="password" 
                    class="block mt-1 w-full border-blue-200 focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base" 
                    type="password" 
                    wire:model="password"
                    required 
                    autocomplete="current-password" 
                />
                @error('password') <span class="text-red-600 text-xs sm:text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" wire:model="remember" />
                    <span class="ms-2 text-xs sm:text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mt-6 gap-3">
                @if (Route::has('password.request'))
                    <a class="underline text-xs sm:text-sm text-blue-600 hover:text-blue-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-4 sm:px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 border border-transparent rounded-lg font-semibold text-xs sm:text-sm text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 transition-all duration-150 shadow hover:shadow-lg">
                    {{ __('Log in') }}
                </button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <p class="text-xs sm:text-sm text-gray-600">
                Don't have an account?
                <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                    {{ __('Register here') }}
                </a>
            </p>
        </div>
    </div>
</div>