<div>
    <!-- Success/Error Messages -->
    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <!-- Events Section -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Upcoming Events</h2>
        
        @if($events->count() > 0)
            <div class="space-y-4">
                @foreach($events as $event)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-lg transition-shadow">
                        <!-- Event Banner -->
                        @if($event->banner)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $event->banner) }}" alt="{{ $event->title }}" class="w-full h-48 object-cover rounded-lg">
                            </div>
                        @endif
                        
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $event->title }}</h3>
                        <p class="text-sm text-gray-600 mb-3">{{ Str::limit($event->description, 150) }}</p>
                        
                        <div class="flex flex-wrap gap-2 text-sm text-gray-600 mb-3">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $event->date->format('F j, Y') }}
                            </span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}
                            </span>
                            <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">
                                {{ ucfirst($event->type) }}
                            </span>
                            <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">
                                {{ ucfirst($event->category) }}
                            </span>
                            @if($event->require_payment && $event->payment_amount)
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">
                                    ₱{{ number_format($event->payment_amount, 2) }}
                                </span>
                            @else
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                                    Free
                                </span>
                            @endif
                        </div>

                        <!-- Location/Online Link -->
                        <div class="mb-3">
                            @if($event->type === 'online')
                                <span class="flex items-center text-sm text-blue-600">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                    </svg>
                                    Online Event
                                </span>
                            @else
                                <span class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $event->place_link }}
                                </span>
                            @endif
                        </div>
                        
                        <div class="flex items-center justify-between">
                            @if($this->isRegistered($event->id))
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                    Registered
                                </span>
                                <button 
                                    wire:click="cancelRegistration({{ $event->id }})" 
                                    wire:confirm="Are you sure you want to cancel your registration?"
                                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors text-sm font-medium"
                                >
                                    Cancel Registration
                                </button>
                            @else
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                                    Registration Open
                                </span>
                                <button 
                                    wire:click="registerForEvent({{ $event->id }})" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium"
                                >
                                    Register Now
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <p class="mt-4 text-gray-500">No upcoming events available at the moment.</p>
            </div>
        @endif
    </div>
</div>