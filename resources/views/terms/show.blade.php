{{-- resources/views/terms/show.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Terms and Conditions - SPCC Events</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700" rel="stylesheet" />
    
    <!-- Styles -->
    @vite(['resources/css/app.css'])
    
    <!-- Scripts -->
    @vite(['resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="javascript:history.back()" class="inline-flex items-center text-blue-600 hover:text-blue-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back
                </a>
            </div>

            <!-- Terms Card -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-blue-100">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-8 sm:px-8">
                    <div class="flex items-center justify-center mb-4">
                        <img src="{{ asset('images/spcc-logo.png') }}" alt="SPCC Logo" class="h-16 w-16 object-contain">
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-center text-white">
                        Terms and Conditions
                    </h1>
                    @if(isset($terms) && $terms)
                        <p class="text-center text-blue-100 mt-2 text-sm">
                            Version {{ $terms->version }} • Effective {{ $terms->effective_date->format('F j, Y') }}
                        </p>
                    @endif
                </div>

                <!-- Content -->
                <div class="p-6 sm:p-8">
                    <div class="prose prose-blue max-w-none">
                        @if(isset($terms) && $terms)
                            {!! $terms->content !!}
                            
                            @if($terms->summary)
                                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 my-6 rounded-r-lg">
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                        </svg>
                                        <div>
                                            <h4 class="text-blue-800 font-semibold mb-1">Summary</h4>
                                            <p class="text-blue-700 text-sm">{{ $terms->summary }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            {!! $defaultTerms ?? '' !!}
                        @endif
                    </div>

                    <!-- Acceptance Actions -->
                    @auth
                        @php
                            $user = auth()->user();
                            $latestTerms = isset($terms) ? $terms : null;
                        @endphp
                        
                        @if($latestTerms && method_exists($user, 'hasAcceptedLatestTerms') && !$user->hasAcceptedLatestTerms())
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        <div class="flex-1">
                                            <p class="text-yellow-800 text-sm">
                                                You need to accept the latest Terms and Conditions to continue using the system.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <form action="{{ route('terms.accept') }}" method="POST" class="flex justify-end">
                                    @csrf
                                    <input type="hidden" name="terms_version_id" value="{{ $latestTerms->id }}">
                                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-lg transition-all shadow-md hover:shadow-lg">
                                        I Accept the Terms and Conditions
                                    </button>
                                </form>
                            </div>
                        @elseif($latestTerms && method_exists($user, 'hasAcceptedLatestTerms') && $user->hasAcceptedLatestTerms())
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <p class="text-green-700">You have accepted the latest Terms and Conditions.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endauth
                </div>

                <!-- Footer -->
                <div class="bg-gray-50 px-6 py-4 text-center text-gray-500 text-sm border-t border-gray-100">
                    <p>© {{ date('Y') }} Systems Plus Computer College. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>