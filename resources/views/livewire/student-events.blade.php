<div class="flex min-h-screen bg-gray-50">
    <div class="fixed left-0 top-0 h-screen z-40">
        <x-dashboard-sidebar />
    </div>

    <!-- Main Content -->
    <div class="flex-1 lg:ml-64 overflow-y-auto overflow-x-hidden">
        <div class="fixed top-0 right-0 left-0 lg:left-64 z-30">
            <x-dashboard-header userRole="Student" :userInitials="$userInitials" />
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6 mt-20 lg:mt-24">
            <!-- Header with Stats -->
            <div class="mb-6">
                <div class="flex items-center gap-3 mb-2">
                    <div class="h-10 w-2 bg-gradient-to-b from-green-600 to-green-500 rounded-full"></div>
                    <h1 class="text-3xl font-bold text-gray-800">Available Events</h1>
                </div>
                <p class="text-gray-600">Browse and register for upcoming events</p>
                
                <!-- Stats Cards - Keep as is since they look good -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                    <!-- ... existing stats cards ... -->
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if (session()->has('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Search and Filter Section - Redesigned to match organizer -->
            <div class="mb-6 bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <!-- Header with gradient -->
                <div class="bg-gradient-to-r from-green-600 to-green-500 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                            </div>
                            <h2 class="text-lg font-semibold text-white">Filter Events</h2>
                        </div>
                        <span class="text-sm text-green-100 bg-white/10 px-3 py-1 rounded-full">
                            {{ $events->total() }} events found
                        </span>
                    </div>
                </div>

                <!-- Filter Body -->
                <div class="p-6">
                    <!-- Main Filters Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                        <!-- Search - Full width on mobile, span 2 on desktop -->
                        <div class="lg:col-span-1">
                            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    Search Events
                                </span>
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400 group-focus-within:text-green-500 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" wire:model.live.debounce.300ms="search"
                                    class="block w-full pl-10 pr-4 py-3 text-sm border-2 border-gray-200 rounded-xl bg-white 
                               focus:ring-2 focus:ring-green-200 focus:border-green-400 
                               transition-all duration-200 group-hover:border-green-300"
                                    placeholder="Search by title, description...">

                                <!-- Clear search button (shows when search has value) -->
                                @if ($search)
                                    <button wire:click="$set('search', '')"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </div>

                        <!-- Type Filter -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7h8m-8 5h5m-5 5h3M4 7h5v5H4V7zm0 10h3v-5H4v5z" />
                                    </svg>
                                    Event Type
                                </span>
                            </label>
                            <div class="relative">
                                <select wire:model.live="filterType"
                                    class="w-full px-4 py-3 text-sm border-2 border-gray-200 rounded-xl bg-white 
                               focus:ring-2 focus:ring-green-200 focus:border-green-400 
                               transition-all duration-200 appearance-none cursor-pointer hover:border-green-300">
                                    <option value="">All Types</option>
                                    <option value="online">🌐 Online</option>
                                    <option value="face-to-face">👥 Face-to-Face</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Category Filter -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z" />
                                    </svg>
                                    Category
                                </span>
                            </label>
                            <div class="relative">
                                <select wire:model.live="filterCategory"
                                    class="w-full px-4 py-3 text-sm border-2 border-gray-200 rounded-xl bg-white 
                               focus:ring-2 focus:ring-green-200 focus:border-green-400 
                               transition-all duration-200 appearance-none cursor-pointer hover:border-green-300">
                                    <option value="">All Categories</option>
                                    <option value="academic">📚 Academic</option>
                                    <option value="sports">⚽ Sports</option>
                                    <option value="cultural">🎭 Cultural</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Filter -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Payment
                                </span>
                            </label>
                            <div class="relative">
                                <select wire:model.live="filterPayment"
                                    class="w-full px-4 py-3 text-sm border-2 border-gray-200 rounded-xl bg-white 
                               focus:ring-2 focus:ring-green-200 focus:border-green-400 
                               transition-all duration-200 appearance-none cursor-pointer hover:border-green-300">
                                    <option value="">All Events</option>
                                    <option value="paid">💰 Paid Events</option>
                                    <option value="free">🎁 Free Events</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Bar: Sort, Per Page, and Reset -->
                    <div
                        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pt-4 border-t border-gray-100">
                        <!-- Left side: Sort and Per Page -->
                        <div class="flex flex-wrap items-center gap-4">
                            <!-- Sort -->
                            <div class="flex items-center space-x-3 bg-gray-50 px-4 py-2 rounded-xl">
                                <span class="text-sm font-medium text-gray-700">Sort by:</span>
                                <select wire:model.live="sortBy"
                                    class="text-sm border-0 bg-transparent focus:ring-0 font-semibold text-green-600 cursor-pointer">
                                    <option value="start_date">Date</option>
                                    <option value="title">Title</option>
                                    <option value="created_at">Created</option>
                                </select>
                                <button wire:click="sortBy('{{ $sortBy }}')"
                                    class="p-1.5 rounded-lg hover:bg-white transition-colors">
                                    @if ($sortDirection === 'asc')
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    @endif
                                </button>
                            </div>

                            <!-- Per Page -->
                            <div class="flex items-center space-x-3 bg-gray-50 px-4 py-2 rounded-xl">
                                <span class="text-sm font-medium text-gray-700">Show:</span>
                                <select wire:model.live="eventsPerPage"
                                    class="text-sm border-0 bg-transparent focus:ring-0 font-semibold text-green-600 cursor-pointer">
                                    <option value="12">12</option>
                                    <option value="24">24</option>
                                    <option value="48">48</option>
                                </select>
                                <span class="text-sm text-gray-500">per page</span>
                            </div>

                            <!-- Active Filters Count (shows when filters are applied) -->
                            @php
                                $activeFilters = collect([
                                    $filterType,
                                    $filterCategory,
                                    $filterPayment,
                                    $search,
                                ])
                                    ->filter()
                                    ->count();
                            @endphp

                            @if ($activeFilters > 0)
                                <div class="flex items-center gap-2">
                                    <span
                                        class="px-2.5 py-1.5 bg-green-100 text-green-700 rounded-lg text-xs font-semibold">
                                        {{ $activeFilters }} active {{ Str::plural('filter', $activeFilters) }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Reset Filters Button -->
                        <div>
                            <button wire:click="resetFilters"
                                class="group px-5 py-2.5 bg-gradient-to-r from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 
                           border border-green-200 rounded-xl transition-all duration-200 
                           flex items-center gap-2 text-sm font-medium text-green-700
                           hover:shadow-md hover:shadow-green-100">
                                <svg class="w-4 h-4 group-hover:rotate-180 transition-transform duration-500"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Reset All Filters
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Events Grid - Your existing cards remain exactly the same -->
            @if (count($events) > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($events as $event)
                        @php
                            $isPastEvent = $event->hasEnded();
                        @endphp
                        <div
                            class="group relative bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden border border-gray-100 hover:border-green-200 flex flex-col h-[420px]">
                            <!-- Your existing event card code - completely unchanged -->
                            <!-- Clickable wrapper for entire card (except buttons) -->
                            <div wire:click="openEventDetailsModal({{ $event->id }})" class="cursor-pointer flex-1">
                                <!-- Banner Image with Gradient Overlay - Fixed height -->
                                <div class="h-36 overflow-hidden relative">
                                    @if ($event->banner)
                                        <img src="{{ asset('storage/' . $event->banner) }}" alt="{{ $event->title }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div
                                            class="w-full h-full bg-gradient-to-br from-green-600 to-purple-600 flex items-center justify-center">
                                            <span
                                                class="text-white text-2xl font-bold opacity-50">{{ strtoupper(substr($event->title, 0, 2)) }}</span>
                                        </div>
                                    @endif

                                    <!-- Gradient Overlay -->
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent">
                                    </div>

                                    <!-- Payment Badge - Top Right -->
                                    <div class="absolute top-2 right-2">
                                        <span
                                            class="px-2 py-0.5 text-[10px] font-semibold rounded-full 
                                                {{ $event->require_payment ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $event->require_payment ? 'Paid' : 'Free' }}
                                        </span>
                                    </div>

                                    <!-- Past Event Badge -->
                                    @if ($isPastEvent)
                                        <div class="absolute top-2 left-2">
                                            <span class="px-2 py-0.5 text-[10px] font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Past Event
                                            </span>
                                        </div>
                                    @endif

                                    <!-- Date badge -->
                                    <div class="absolute bottom-2 left-2 flex items-center gap-2">
                                        <div class="bg-white/90 backdrop-blur-sm rounded-lg px-2 py-1 shadow-lg">
                                            <span class="text-[10px] font-semibold text-gray-800">
                                                {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}
                                                @if(\Carbon\Carbon::parse($event->start_date)->format('Y-m-d') != \Carbon\Carbon::parse($event->end_date)->format('Y-m-d'))
                                                    - {{ \Carbon\Carbon::parse($event->end_date)->format('M d, Y') }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Content Section - Fixed height with flex column -->
                                <div class="p-4 flex flex-col h-[calc(420px-144px-60px)]">
                                    <!-- Title and Organizer - Fixed height -->
                                    <div class="mb-2">
                                        <h3
                                            class="text-base font-bold text-gray-800 mb-0.5 line-clamp-1 group-hover:text-green-600 transition-colors">
                                            {{ $event->title }}
                                        </h3>
                                        <p class="text-xs text-gray-500 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            {{ $event->creator->first_name ?? 'Unknown' }}
                                            {{ $event->creator->last_name ?? '' }}
                                        </p>
                                    </div>

                                    <!-- Description Preview - Single line only -->
                                    <p class="text-xs text-gray-600 mb-3 line-clamp-1">
                                        {{ $event->description }}
                                    </p>

                                    <!-- Tags Row - Fixed position -->
                                    <div class="flex flex-wrap gap-1 mb-3">
                                        <span
                                            class="px-2 py-0.5 text-[10px] font-medium rounded-full bg-blue-100 text-blue-700 flex items-center gap-1">
                                            <span class="w-1 h-1 rounded-full bg-blue-500"></span>
                                            {{ ucfirst($event->category) }}
                                        </span>

                                        <span
                                            class="px-2 py-0.5 text-[10px] font-medium rounded-full bg-yellow-100 text-yellow-700 flex items-center gap-1">
                                            <span class="w-1 h-1 rounded-full bg-yellow-500"></span>
                                            {{ $event->type === 'online' ? '🌐 Online' : '📍 In-Person' }}
                                        </span>

                                        @if ($event->require_payment)
                                            <span
                                                class="px-2 py-0.5 text-[10px] font-medium rounded-full bg-purple-100 text-purple-700">
                                                ₱{{ number_format($event->payment_amount, 2) }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Registration Status -->
                                    @if($this->isRegistered($event->id))
                                        <div class="flex items-center gap-1 text-[10px] text-green-600 mb-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="font-medium">You're registered</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Action Buttons - Fixed height at bottom -->
                            <div class="px-4 pb-4 flex gap-2 border-t border-gray-100 pt-3 mt-auto">
                                @if($event->canRegister())
                                    @if($this->isRegistered($event->id))
                                        <button wire:click="cancelRegistration({{ $event->id }})" 
                                            wire:confirm="Are you sure you want to cancel your registration?"
                                            class="flex-1 px-2 py-2 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded-xl transition-all duration-200 transform hover:scale-105 hover:shadow-lg hover:shadow-red-200 flex items-center justify-center gap-1 group">
                                            <svg class="w-3.5 h-3.5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            <span>Cancel</span>
                                        </button>
                                    @else
                                        <button wire:click="registerForEvent({{ $event->id }})" 
                                            class="flex-1 px-2 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-xl transition-all duration-200 transform hover:scale-105 hover:shadow-lg hover:shadow-green-200 flex items-center justify-center gap-1 group">
                                            <svg class="w-3.5 h-3.5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>Register</span>
                                        </button>
                                    @endif
                                @else
                                    <button disabled class="flex-1 px-2 py-2 bg-gray-300 cursor-not-allowed text-white text-xs font-medium rounded-xl">
                                        {{ $event->hasStarted() ? 'Event Started' : 'Registration Closed' }}
                                    </button>
                                @endif
                                
                                <button wire:click="openEventDetailsModal({{ $event->id }})"
                                    class="px-2 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-medium rounded-xl transition-all duration-200 transform hover:scale-105 flex items-center justify-center group"
                                    title="View Details">
                                    <svg class="w-3.5 h-3.5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Hover Effect Indicator -->
                            <div
                                class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-green-500 to-purple-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300">
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination - Updated to match organizer style -->
                @if ($events->hasPages())
                    <div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <!-- Results Info -->
                        <div class="text-sm text-gray-600 bg-gray-50 px-4 py-2 rounded-lg">
                            Showing
                            <span class="font-semibold text-green-600">{{ $events->firstItem() }}</span>
                            to
                            <span class="font-semibold text-green-600">{{ $events->lastItem() }}</span>
                            of
                            <span class="font-semibold text-purple-600">{{ $events->total() }}</span>
                            results
                        </div>

                        <!-- Pagination Links -->
                        <div class="flex items-center gap-2">
                            @if ($events->onFirstPage())
                                <span
                                    class="px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 rounded-xl cursor-not-allowed">
                                    Previous
                                </span>
                            @else
                                <button wire:click="previousPage"
                                    class="group px-4 py-2 text-sm font-medium text-green-600 bg-green-50 rounded-xl 
                           hover:bg-gradient-to-r hover:from-green-600 hover:to-green-700 hover:text-white
                           transition-all duration-200 flex items-center gap-2">
                                    <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>
                                    Previous
                                </button>
                            @endif

                            <!-- Page Numbers -->
                            <div class="hidden sm:flex items-center gap-1">
                                @foreach ($events->getUrlRange(1, $events->lastPage()) as $page => $url)
                                    @if ($page == $events->currentPage())
                                        <span
                                            class="w-10 h-10 flex items-center justify-center rounded-xl 
                                   bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold
                                   shadow-md shadow-green-200">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <button wire:click="gotoPage({{ $page }})"
                                            class="w-10 h-10 flex items-center justify-center rounded-xl 
                                   text-gray-600 hover:bg-purple-50 hover:text-purple-600 
                                   font-medium transition-all duration-200 
                                   hover:shadow-md hover:shadow-purple-100">
                                            {{ $page }}
                                        </button>
                                    @endif
                                @endforeach
                            </div>

                            @if ($events->hasMorePages())
                                <button wire:click="nextPage"
                                    class="group px-4 py-2 text-sm font-medium text-green-600 bg-green-50 rounded-xl 
                           hover:bg-gradient-to-r hover:from-green-600 hover:to-green-700 hover:text-white
                           transition-all duration-200 flex items-center gap-2">
                                    Next
                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            @else
                                <span
                                    class="px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 rounded-xl cursor-not-allowed">
                                    Next
                                </span>
                            @endif
                        </div>
                    </div>
                @else
                    <!-- Simple results info when no pagination needed -->
                    <div class="mt-8 flex justify-center">
                        <div class="text-sm text-gray-600 bg-gray-50 px-6 py-3 rounded-xl">
                            Showing
                            <span class="font-semibold text-green-600">1</span>
                            to
                            <span class="font-semibold text-green-600">{{ count($events) }}</span>
                            of
                            <span class="font-semibold text-purple-600">{{ count($events) }}</span>
                            results
                        </div>
                    </div>
                @endif
            @else
                <!-- Empty State - Updated to match new styling -->
                <div class="text-center py-12 bg-white rounded-2xl shadow-sm border border-gray-100">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">
                        @if ($search || $filterType || $filterCategory || $filterPayment)
                            No events found matching your filters
                        @else
                            No events available at the moment
                        @endif
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Check back later for upcoming events.
                    </p>
                    @if ($search || $filterType || $filterCategory || $filterPayment)
                        <div class="mt-6">
                            <button wire:click="resetFilters"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800">
                                Reset Filters
                            </button>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Event Details Modal - Updated with green theme to match student view -->
    <x-custom-modal model="showEventDetailsModal" maxWidth="lg" title="Event Details"
        description="View complete event information" headerBg="green">
        @if ($selectedEvent)
            @php
                $isPastEvent = $selectedEvent->hasEnded();
            @endphp
            <div class="space-y-5">
                <!-- Banner Section -->
                <div class="relative h-48 rounded-xl overflow-hidden border border-gray-200 shadow-sm">
                    @if ($selectedEvent->banner)
                        <img src="{{ asset('storage/' . $selectedEvent->banner) }}"
                            alt="{{ $selectedEvent->title }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent"></div>
                    @else
                        <div
                            class="w-full h-full bg-gradient-to-br from-green-600 to-green-800 flex items-center justify-center">
                            <svg class="w-20 h-20 text-white/40" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent"></div>
                    @endif

                    <!-- Past Event Badge -->
                    @if ($isPastEvent)
                        <div class="absolute top-4 right-4">
                            <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm font-medium">
                                Past Event
                            </span>
                        </div>
                    @endif

                    <!-- Title Overlay -->
                    <div class="absolute bottom-0 left-0 right-0 p-5 text-white">
                        <h1 class="text-2xl font-bold mb-1">{{ $selectedEvent->title }}</h1>
                        <div class="flex items-center space-x-3 text-sm">
                            <span
                                class="flex items-center space-x-1.5 bg-black/30 px-3 py-1 rounded-full backdrop-blur-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>{{ $selectedEvent->creator->first_name ?? 'Unknown' }}
                                    {{ $selectedEvent->creator->last_name ?? '' }}</span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Description Card -->
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-5 rounded-xl border border-green-200">
                    <h3 class="text-sm font-semibold text-green-800 mb-2 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                        <span>Description</span>
                    </h3>
                    <p class="text-gray-700 leading-relaxed">{{ $selectedEvent->description }}</p>
                </div>

                <!-- Event Details Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Start Date -->
                    <div
                        class="bg-white p-4 rounded-xl border border-gray-200 hover:border-green-300 transition-all duration-200">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-green-100 rounded-lg">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Start Date</p>
                                <p class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($selectedEvent->start_date)->format('F j, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- End Date -->
                    <div
                        class="bg-white p-4 rounded-xl border border-gray-200 hover:border-green-300 transition-all duration-200">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-green-100 rounded-lg">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">End Date</p>
                                <p class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($selectedEvent->end_date)->format('F j, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Start Time -->
                    <div
                        class="bg-white p-4 rounded-xl border border-gray-200 hover:border-green-300 transition-all duration-200">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-green-100 rounded-lg">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Start Time</p>
                                <p class="font-semibold text-gray-800">
                                    {{ \Carbon\Carbon::parse($selectedEvent->start_time)->format('g:i A') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- End Time -->
                    <div
                        class="bg-white p-4 rounded-xl border border-gray-200 hover:border-green-300 transition-all duration-200">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-green-100 rounded-lg">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">End Time</p>
                                <p class="font-semibold text-gray-800">
                                    {{ \Carbon\Carbon::parse($selectedEvent->end_time)->format('g:i A') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Location/Link (full width) -->
                    <div
                        class="col-span-2 bg-white p-4 rounded-xl border border-gray-200 hover:border-green-300 transition-all duration-200">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-green-100 rounded-lg">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-gray-500">
                                    {{ $selectedEvent->type === 'online' ? 'Event Link' : 'Location' }}</p>
                                @if ($selectedEvent->type === 'online' && filter_var($selectedEvent->place_link, FILTER_VALIDATE_URL))
                                    <a href="{{ $selectedEvent->place_link }}" target="_blank"
                                        class="font-semibold text-green-600 hover:text-green-700 hover:underline transition-colors flex items-center space-x-1 break-all">
                                        <span>{{ $selectedEvent->place_link }}</span>
                                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                    </a>
                                @else
                                    <p class="font-semibold text-gray-800">{{ $selectedEvent->place_link }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Type and Category -->
                    <div class="bg-white p-4 rounded-xl border border-gray-200">
                        <p class="text-xs text-gray-500 mb-2">Event Type</p>
                        <div class="flex items-center space-x-2">
                            <span
                                class="w-2 h-2 rounded-full {{ $selectedEvent->type === 'online' ? 'bg-green-500' : 'bg-orange-500' }}"></span>
                            <span
                                class="font-medium capitalize">{{ str_replace('-', ' ', $selectedEvent->type) }}</span>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-xl border border-gray-200">
                        <p class="text-xs text-gray-500 mb-2">Category</p>
                        <div class="flex items-center space-x-2">
                            @php
                                $categoryColors = [
                                    'academic' => 'bg-blue-100 text-blue-700',
                                    'sports' => 'bg-green-100 text-green-700',
                                    'cultural' => 'bg-purple-100 text-purple-700',
                                ];
                            @endphp
                            <span
                                class="px-3 py-1.5 rounded-full text-xs font-semibold {{ $categoryColors[$selectedEvent->category] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($selectedEvent->category) }}
                            </span>
                        </div>
                    </div>

                    <!-- Visibility -->
                    <div class="col-span-2 bg-white p-4 rounded-xl border border-gray-200">
                        <p class="text-xs text-gray-500 mb-2">Visibility</p>
                        <div class="flex items-center space-x-2">
                            @if ($selectedEvent->visibility_type === 'all')
                                <span
                                    class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-sm font-medium">🌍
                                    Visible to all students</span>
                            @else
                                <span
                                    class="px-3 py-1.5 bg-yellow-100 text-yellow-700 rounded-full text-sm font-medium">🔒
                                    Restricted access</span>
                            @endif
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div
                        class="col-span-2 bg-gradient-to-r from-gray-50 to-gray-100 p-4 rounded-xl border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="p-2 {{ $selectedEvent->require_payment ? 'bg-yellow-100' : 'bg-green-100' }} rounded-lg">
                                    <svg class="w-5 h-5 {{ $selectedEvent->require_payment ? 'text-yellow-600' : 'text-green-600' }}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Payment Status</p>
                                    @if ($selectedEvent->require_payment)
                                        <p class="text-xl font-bold text-yellow-600">
                                            ₱{{ number_format($selectedEvent->payment_amount, 2) }}</p>
                                    @else
                                        <p class="text-xl font-bold text-green-600">Free Event</p>
                                    @endif
                                </div>
                            </div>
                            @if ($selectedEvent->require_payment)
                                <span
                                    class="px-3 py-1.5 bg-yellow-100 text-yellow-700 rounded-full text-sm font-medium">Paid</span>
                            @else
                                <span
                                    class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-sm font-medium">Free</span>
                            @endif
                        </div>
                    </div>

                    <!-- Registration Status in Modal -->
                    @if($this->isRegistered($selectedEvent->id))
                        <div class="col-span-2 bg-green-50 p-4 rounded-xl border border-green-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 bg-green-100 rounded-lg">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Your Registration Status</p>
                                        <p class="text-lg font-bold text-green-600">You are registered for this event</p>
                                    </div>
                                </div>
                                @if(!$isPastEvent && $selectedEvent->canCancelRegistration())
                                    <button 
                                        wire:click="cancelRegistration({{ $selectedEvent->id }})" 
                                        wire:confirm="Are you sure you want to cancel your registration?"
                                        class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium transition-colors"
                                    >
                                        Cancel Registration
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-3 pt-4 border-t border-gray-200">
                    <button type="button" wire:click="closeEventDetailsModal"
                        class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group">
                        <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>Close</span>
                    </button>
                    
                    @if(!$isPastEvent && !$this->isRegistered($selectedEvent->id) && $selectedEvent->canRegister())
                        <button type="button" wire:click="registerForEvent({{ $selectedEvent->id }})" wire:click="closeEventDetailsModal"
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group shadow-lg shadow-green-200">
                            <span>Register Now</span>
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </button>
                    @endif
                    
                    @if($isPastEvent)
                        <div class="flex-1 px-6 py-3 bg-gray-100 text-gray-500 rounded-xl font-medium text-center">
                            This event has passed
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </x-custom-modal>
</div>