<div class="min-h-screen flex flex-col sm:justify-center items-center pt-4 sm:pt-0 px-4 sm:px-0 relative overflow-hidden" style="min-height: 100vh;
                              background: url('/images/spcc-login-register-bg.jpg') no-repeat center fixed;
                              background-size: cover;">
    <!-- Animated Gradient Background -->
    <div class="fixed inset-0 -z-10 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 animate-gradient"></div>
    
    <!-- Decorative Elements -->
    <div class="absolute top-0 left-0 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
    <div class="absolute top-0 right-0 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
    <div class="absolute -bottom-8 left-20 w-72 h-72 bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>

    <div class="w-full max-w-sm sm:max-w-md mt-4 sm:mt-6 px-6 sm:px-8 py-8 sm:py-10 bg-white/90 backdrop-blur-xl shadow-2xl sm:shadow-3xl overflow-hidden rounded-2xl sm:rounded-3xl border border-white/50 relative">
        <!-- Floating Card Effect -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-transparent rounded-3xl"></div>
        
        <!-- Logo Container with Glow Effect -->
        <div class="mb-6 sm:mb-8 text-center relative">
            <div class="relative inline-block">
                <div class="absolute inset-0 bg-blue-500/20 blur-2xl rounded-full"></div>
                <img 
                    src="{{ asset('images/spcc-logo.png') }}" 
                    alt="SPCC Logo" 
                    class="relative mx-auto h-28 w-28 sm:h-36 sm:w-36 object-contain mb-4 drop-shadow-lg"
                    onerror="console.error('Logo image failed to load')"
                >
            </div>
        </div>

        <!-- Header Section -->
        <div class="text-center mb-6 sm:mb-8">
            <h2 class="text-3xl sm:text-4xl font-bold mb-2 bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-600 bg-clip-text text-transparent animate-gradient-text">
                SPCC Events
            </h2>
            <p class="text-gray-600 text-sm sm:text-base relative inline-block">
                <span class="relative z-10">Sign in to your account</span>
                <span class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-blue-200 to-transparent rounded-full"></span>
            </p>
        </div>

        <!-- Status Messages -->
        <x-validation-errors class="mb-4 animate-fade-in" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-700 bg-gradient-to-r from-green-50 to-emerald-50 p-4 rounded-xl border border-green-200 animate-fade-in shadow-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ $value }}
                </div>
            </div>
        @endsession

        <!-- Login Form -->
        <form wire:submit="login" class="space-y-6">
            <!-- Email Input -->
            <div class="group">
                <div class="flex items-center justify-between mb-2">
                    <x-label for="email" value="{{ __('Email Address') }}" class="text-gray-700 font-medium text-sm sm:text-base" />
                    <svg class="w-5 h-5 text-blue-400 opacity-0 group-focus-within:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <x-input 
                        id="email" 
                        class="block mt-1 w-full pl-10 pr-4 py-3 border-gray-200 focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base rounded-xl transition-all duration-200 group-hover:border-blue-300" 
                        type="email" 
                        wire:model="email"
                        required 
                        autofocus 
                        autocomplete="username"
                        placeholder="Enter your email"
                    />
                </div>
                @error('email') 
                    <span class="flex items-center mt-2 text-red-600 text-xs sm:text-sm">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <!-- Password Input -->
            <div class="group">
                <div class="flex items-center justify-between mb-2">
                    <x-label for="password" value="{{ __('Password') }}" class="text-gray-700 font-medium text-sm sm:text-base" />
                    <svg class="w-5 h-5 text-blue-400 opacity-0 group-focus-within:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <x-input 
                        id="password" 
                        class="block mt-1 w-full pl-10 pr-12 py-3 border-gray-200 focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base rounded-xl transition-all duration-200 group-hover:border-blue-300" 
                        type="password" 
                        wire:model="password"
                        required 
                        autocomplete="current-password"
                        placeholder="Enter your password"
                    />
                </div>
                @error('password') 
                    <span class="flex items-center mt-2 text-red-600 text-xs sm:text-sm">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full mt-6 inline-flex items-center justify-center px-6 py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 border border-transparent rounded-xl font-semibold text-sm text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 active:translate-y-0 group">
                <span>{{ __('Sign In') }}</span>
                <svg class="w-5 h-5 ml-2 opacity-0 group-hover:opacity-100 transition-all duration-200 transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </button>
        </form>

        <!-- Register Link -->
        <div class="mt-8 text-center">
            <p class="text-sm text-gray-600">
                {{ __("Don't have an account?") }}
                <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700 transition-colors hover:underline relative group">
                    {{ __('Create one now') }}
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 group-hover:w-full transition-all duration-300"></span>
                </a>
            </p>
        </div>

        <!-- Footer Note -->
        <div class="mt-6 pt-6 border-t border-gray-100 text-center">
            <p class="text-xs text-gray-500">
                © {{ date('Y') }} ystems Plus Computer College. All rights reserved.
            </p>
        </div>
    </div>
</div>

@push('styles')
<style>
@keyframes gradient {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

@keyframes blob {
    0% { transform: translate(0px, 0px) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
    100% { transform: translate(0px, 0px) scale(1); }
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-gradient {
    background-size: 200% 200%;
    animation: gradient 15s ease infinite;
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

.animate-fade-in {
    animation: fadeIn 0.3s ease-out;
}

.animate-gradient-text {
    background-size: 200% auto;
    animation: gradient 3s linear infinite;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(to bottom, #3b82f6, #6366f1);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(to bottom, #2563eb, #4f46e5);
}
</style>
@endpush