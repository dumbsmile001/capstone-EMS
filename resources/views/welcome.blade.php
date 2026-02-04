<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'SPCC Events') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
        @endif
        <style>
            .welcome-bg{
                min-height: 100vh;
                background: url("/images/spcc-background.jpg") no-repeat center fixed;
                background-size: cover;
                position: relative;
            }
            
            .welcome-bg::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1;
            }
            
            .welcome-content {
                position: relative;
                z-index: 2;
            }
        </style>
    </head>
    <body class="relative min-h-screen flex flex-col p-4 lg:p-8 items-center lg:justify-center welcome-bg">

        <header class="w-full lg:max-w-7xl px-4 sm:px-0 text-sm mb-6 not-has-[nav]:hidden welcome-content">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-3 sm:gap-4">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="inline-block px-4 sm:px-5 py-1.5 border-[#19140035] hover:border-[#1915014a] border text-white rounded-sm text-sm leading-normal hover:bg-white/10 transition-colors"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-4 sm:px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 border border-transparent rounded-lg font-semibold text-xs sm:text-sm text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 transition-all duration-150 shadow hover:shadow-lg"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-4 sm:px-6 py-2 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 border border-transparent rounded-lg font-semibold text-xs sm:text-sm text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 disabled:opacity-50 transition-all duration-150 shadow hover:shadow-lg">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <main class="welcome-content flex-1 flex flex-col items-center justify-center w-full lg:max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl">
                 <!-- Logo Image -->
                <div class="mb-4 sm:mb-6 text-center">
                    <img 
                            src="{{ asset('images/spcc-logo.png') }}" 
                            alt="SPCC Logo" 
                            class="mx-auto h-48 w-48 sm:h-32 sm:w-32 object-contain mb-4"
                            onerror="console.error('Logo image failed to load')"
                        >
                </div>
                
                <!-- Welcome Message -->
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 sm:p-8 lg:p-10 border border-white/20 shadow-2xl mb-8 lg:mb-12">
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-4 lg:mb-6">
                        Welcome to SPCC Events Portal!
                    </h2>
                    <p class="text-lg sm:text-xl lg:text-2xl text-white/90 leading-relaxed">
                        Manage, view, and register to different events all in one system. 
                        Stay updated with campus activities, workshops, seminars, and more.
                    </p>
                </div>

                <!-- Key Features -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 mb-8 lg:mb-12">
                    <div class="bg-white/5 backdrop-blur-sm rounded-xl p-5 sm:p-6 border border-white/10 hover:border-white/20 transition-all hover:scale-[1.02]">
                        <div class="text-blue-300 mb-3">
                            <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Event Management</h3>
                        <p class="text-white/70 text-sm">Create, manage, and organize various campus events with ease.</p>
                    </div>
                    
                    <div class="bg-white/5 backdrop-blur-sm rounded-xl p-5 sm:p-6 border border-white/10 hover:border-white/20 transition-all hover:scale-[1.02]">
                        <div class="text-green-300 mb-3">
                            <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Easy Registration</h3>
                        <p class="text-white/70 text-sm">Register for events with just a few clicks. No hassle, no paperwork.</p>
                    </div>
                    
                    <div class="bg-white/5 backdrop-blur-sm rounded-xl p-5 sm:p-6 border border-white/10 hover:border-white/20 transition-all hover:scale-[1.02]">
                        <div class="text-purple-300 mb-3">
                            <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Stay Updated</h3>
                        <p class="text-white/70 text-sm">Get real-time updates about upcoming events.</p>
                    </div>
                </div>

                <!-- Call to Action for Guests -->
                @guest
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a
                        href="{{ route('login') }}"
                        class="inline-flex items-center justify-center px-8 py-3 sm:px-10 sm:py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 border border-transparent rounded-xl font-bold text-base sm:text-lg text-white uppercase tracking-wide focus:outline-none focus:ring-4 focus:ring-blue-500/50 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-[1.02]"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Sign In to Get Started
                    </a>
                    
                    @if (Route::has('register'))
                    <a
                        href="{{ route('register') }}"
                        class="inline-flex items-center justify-center px-8 py-3 sm:px-10 sm:py-4 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 border border-transparent rounded-xl font-bold text-base sm:text-lg text-white uppercase tracking-wide focus:outline-none focus:ring-4 focus:ring-green-500/50 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-[1.02]"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        Create Account
                    </a>
                    @endif
                </div>
                @endguest
            </div>
        </main>

        <!-- Footer -->
        <footer class="welcome-content w-full lg:max-w-7xl px-4 sm:px-0 mt-8 lg:mt-12">
            <div class="text-center text-white/60 text-sm">
                <p>&copy; {{ date('Y') }} Systems Plus Computer College. All rights reserved.</p>
                <p class="mt-1">Your one-stop portal for campus events and activities.</p>
            </div>
        </footer>

    </body>
</html>