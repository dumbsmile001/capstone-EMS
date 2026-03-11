<div x-data="{
    init() {
        setInterval(() => {
            @this.call('nextSlide')
        }, 7000)
    }
}" x-init="init()" class="w-full max-w-full overflow-hidden [&_img]:max-w-full [&_img]:w-full">
    <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl shadow-2xl overflow-hidden w-full">
        <!-- Header with Yellow Gradient -->
        <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-yellow-500 to-amber-600">
            <div class="flex items-center justify-between">
                <h2 class="text-lg sm:text-xl font-bold text-white flex items-center gap-1 sm:gap-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    Upcoming Events
                </h2>
                <a href="{{ route('student.events') }}"
                    class="text-xs sm:text-sm text-white/90 hover:text-white transition-colors flex items-center gap-1 bg-black/20 px-2 sm:px-3 py-1 sm:py-1.5 rounded-full backdrop-blur-sm whitespace-nowrap">
                    View All
                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>

        @if ($events->count() > 0)
            <!-- Carousel Container -->
            <div class="relative w-full">
                <!-- Main Slide - Fixed heights to prevent expansion -->
                <div class="relative h-[280px] sm:h-[350px] md:h-[400px] overflow-hidden w-full">
                    @foreach ($events as $index => $event)
                        <div
                            class="absolute inset-0 transition-opacity duration-500 ease-in-out w-full {{ $index === $currentIndex ? 'opacity-100 z-10' : 'opacity-0 z-0' }}">
                            <!-- Background Image with Overlay - FIXED: Added object-contain for mobile -->
                            <div class="absolute inset-0 w-full">
                                @if ($event->banner)
                                    <img src="{{ asset('storage/' . $event->banner) }}" alt="{{ $event->title }}"
                                        class="w-full h-full object-cover md:object-cover object-contain md:object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-indigo-500 to-purple-600"></div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent">
                                </div>
                            </div>

                            <!-- Content with responsive padding - Added left/right padding to avoid buttons -->
                            <div class="absolute bottom-0 left-0 right-0 p-4 sm:p-6 text-white w-full">
                                <!-- Added pl-8 sm:pl-12 pr-8 sm:pr-12 to create space for buttons -->
                                <div class="max-w-full pl-8 sm:pl-12 pr-8 sm:pr-12">
                                    <!-- Event Type Badge - Responsive sizing -->
                                    <div class="flex flex-wrap gap-1 sm:gap-2 mb-2 sm:mb-3">
                                        <span
                                            class="px-2 sm:px-3 py-0.5 sm:py-1 bg-white/20 backdrop-blur-sm rounded-full text-[10px] sm:text-xs font-semibold whitespace-nowrap">
                                            {{ ucfirst($event->type) }}
                                        </span>
                                        <span
                                            class="px-2 sm:px-3 py-0.5 sm:py-1 bg-white/20 backdrop-blur-sm rounded-full text-[10px] sm:text-xs font-semibold whitespace-nowrap">
                                            {{ ucfirst($event->category) }}
                                        </span>
                                        @if ($event->require_payment && $event->payment_amount)
                                            <span
                                                class="px-2 sm:px-3 py-0.5 sm:py-1 bg-yellow-500/80 backdrop-blur-sm rounded-full text-[10px] sm:text-xs font-semibold whitespace-nowrap">
                                                ₱{{ number_format($event->payment_amount, 2) }}
                                            </span>
                                        @else
                                            <span
                                                class="px-2 sm:px-3 py-0.5 sm:py-1 bg-green-500/80 backdrop-blur-sm rounded-full text-[10px] sm:text-xs font-semibold whitespace-nowrap">
                                                Free
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Title - responsive sizing -->
                                    <h3 class="text-lg sm:text-xl md:text-2xl font-bold mb-1 sm:mb-2 break-words line-clamp-2 sm:line-clamp-1">
                                        {{ $event->title }}
                                    </h3>

                                    <!-- Date and Time - responsive -->
                                    <div class="flex flex-wrap items-center gap-2 sm:gap-4 mb-2 sm:mb-3 text-xs sm:text-sm text-gray-200">
                                        <span class="flex items-center whitespace-nowrap">
                                            <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <span class="truncate max-w-[80px] sm:max-w-none">{{ \Carbon\Carbon::parse($event->start_date)->format('M j, Y') }}</span>
                                        </span>
                                        <span class="flex items-center whitespace-nowrap">
                                            <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>{{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}</span>
                                        </span>
                                    </div>

                                    <!-- Description - hide on mobile, show on larger screens -->
                                    <p class="hidden sm:block text-xs sm:text-sm text-gray-200 mb-2 sm:mb-4 max-w-xl sm:max-w-2xl break-words line-clamp-2 sm:line-clamp-1">
                                        {{ Str::limit($event->description, 100) }}
                                    </p>

                                    <!-- Location/Online - responsive -->
                                    <div class="mb-3 sm:mb-4">
                                        @if ($event->type === 'online')
                                            <span class="flex items-center text-xs sm:text-sm text-indigo-300">
                                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                                    </path>
                                                </svg>
                                                <span class="truncate max-w-[120px] sm:max-w-[200px] md:max-w-[300px]">Online Event</span>
                                            </span>
                                        @else
                                            <span class="flex items-center text-xs sm:text-sm text-gray-200">
                                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                    </path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                <span class="truncate max-w-[120px] sm:max-w-[200px] md:max-w-[300px]">{{ $event->place_link }}</span>
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Register Button - responsive sizing -->
                                    <a href="{{ route('student.events') }}"
                                        class="inline-flex items-center px-4 sm:px-6 py-1.5 sm:py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors text-xs sm:text-sm font-medium shadow-lg whitespace-nowrap">
                                        View Details
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 ml-1 sm:ml-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Navigation Buttons - responsive sizing and positioning -->
                <button wire:click="prevSlide"
                    class="absolute left-1 sm:left-2 top-1/2 -translate-y-1/2 z-20 w-8 h-8 sm:w-10 sm:h-10 bg-white/20 backdrop-blur-sm hover:bg-white/30 rounded-full flex items-center justify-center text-white transition-all hover:scale-110">
                    <svg class="w-4 h-4 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                </button>
                <button wire:click="nextSlide"
                    class="absolute right-1 sm:right-2 top-1/2 -translate-y-1/2 z-20 w-8 h-8 sm:w-10 sm:h-10 bg-white/20 backdrop-blur-sm hover:bg-white/30 rounded-full flex items-center justify-center text-white transition-all hover:scale-110">
                    <svg class="w-4 h-4 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                        </path>
                    </svg>
                </button>

                <!-- Indicators - responsive -->
                <div class="absolute bottom-2 sm:bottom-4 left-1/2 -translate-x-1/2 z-20 flex gap-1 sm:gap-2">
                    @foreach ($events as $index => $event)
                        <button wire:click="goToSlide({{ $index }})" class="group">
                            <div
                                class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full transition-all {{ $index === $currentIndex ? 'w-4 sm:w-6 bg-white' : 'bg-white/50 group-hover:bg-white/75' }}">
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>
        @else
            <!-- Empty State - responsive -->
            <div class="flex flex-col items-center justify-center py-8 sm:py-12 px-4 sm:px-6 w-full">
                <svg class="w-16 h-16 sm:w-20 sm:h-20 text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
                <p class="text-sm sm:text-base text-gray-400 text-center">No upcoming events available at the moment.</p>
            </div>
        @endif
    </div>
</div>