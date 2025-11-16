<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-blue-50 via-yellow-50 to-blue-100">
    <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-xl overflow-hidden sm:rounded-2xl border border-blue-100">
        <div class="mb-6 text-center">
            <x-authentication-card-logo />
        </div>

        <h2 class="text-3xl font-bold text-center mb-2 bg-gradient-to-r from-blue-600 to-yellow-500 bg-clip-text text-transparent">
            Welcome Back
        </h2>
        <p class="text-center text-gray-600 mb-6">Sign in to your account</p>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded-lg">
                {{ $value }}
            </div>
        @endsession

        <form wire:submit="login">
            <div>
                <x-label for="email" value="{{ __('Email') }}" class="text-gray-700 font-medium" />
                <x-input 
                    id="email" 
                    class="block mt-1 w-full border-blue-200 focus:border-blue-500 focus:ring-blue-500" 
                    type="email" 
                    wire:model="email"
                    required 
                    autofocus 
                    autocomplete="username" 
                />
                @error('email') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" class="text-gray-700 font-medium" />
                <x-input 
                    id="password" 
                    class="block mt-1 w-full border-blue-200 focus:border-blue-500 focus:ring-blue-500" 
                    type="password" 
                    wire:model="password"
                    required 
                    autocomplete="current-password" 
                />
                @error('password') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" wire:model="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-6">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-blue-600 hover:text-yellow-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 transition-all duration-150 shadow-lg hover:shadow-xl">
                    {{ __('Log in') }}
                </button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Don't have an account?
                <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-yellow-600 transition-colors">
                    {{ __('Register here') }}
                </a>
            </p>
        </div>
    </div>
</div>


