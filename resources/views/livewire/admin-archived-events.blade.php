<div class="flex min-h-screen bg-gray-50">
    <div class="fixed left-0 top-0 h-screen z-40">
        <x-dashboard-sidebar />
    </div>

    <!-- Main Content -->
    <div class="flex-1 lg:ml-64 overflow-y-auto overflow-x-hidden">
        <div class="fixed top-0 right-0 left-0 lg:left-64 z-30">
            <x-dashboard-header userRole="Organizer" :userInitials="$userInitials" />
        </div>

        <div class="flex-1 p-6 mt-20 lg:mt-24">
            <!-- Header with Stats -->
            <div class="mb-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Archived Events</h1>
                        <p class="text-gray-600">View and manage all archived events in the system</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.events') }}"
                            class="px-4 py-2.5 bg-white border-2 border-blue-600 text-blue-600 rounded-xl hover:bg-blue-50 transition-all duration-200 font-medium flex items-center gap-2 shadow-sm hover:shadow">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Active Events
                        </a>
                        <button wire:click="openExportModal"
                            class="px-4 py-2.5 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-200 font-medium flex items-center gap-2 shadow-lg shadow-green-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Export
                        </button>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
                    <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-blue-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Total Archived</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $events->total() }}</p>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-yellow-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">This Month</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $thisMonthCount }}</p>
                            </div>
                            <div class="p-3 bg-yellow-100 rounded-lg">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-blue-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Total Registrations</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $totalRegistrations }}</p>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-yellow-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Paid Events</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $paidEventsCount }}</p>
                            </div>
                            <div class="p-3 bg-yellow-100 rounded-lg">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Search and Filter Section -->
            <div class="mb-6 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Filter Header with Results Count -->
                <div class="p-4 bg-gradient-to-r from-blue-600 to-yellow-500 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-white">Filter Events</h2>
                        </div>
                        <span class="text-sm text-blue-100 bg-white/10 px-3 py-1 rounded-full">
                            {{ $events->total() }} events found
                        </span>
                    </div>
                </div>

                <!-- Filter Controls -->
                <div class="p-5">
                    <!-- Search Bar - Prominent like in reference -->
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">SEARCH EVENTS</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" wire:model.live.debounce.300ms="search"
                                class="block w-full pl-11 pr-4 py-3 text-sm border-2 border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition-all"
                                placeholder="Search by title, description...">
                        </div>
                    </div>

                    <!-- Filter Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Event Type Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">EVENT TYPE</label>
                            <select wire:model.live="filterType"
                                class="block w-full px-4 py-2.5 text-sm border-2 border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition-all">
                                <option value="">All Types</option>
                                <option value="online">Online</option>
                                <option value="face-to-face">Face-to-Face</option>
                            </select>
                        </div>

                        <!-- Category Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">CATEGORY</label>
                            <select wire:model.live="filterCategory"
                                class="block w-full px-4 py-2.5 text-sm border-2 border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition-all">
                                <option value="">All Categories</option>
                                <option value="academic">Academic</option>
                                <option value="sports">Sports</option>
                                <option value="cultural">Cultural</option>
                            </select>
                        </div>

                        <!-- Payment Filter (NEW) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">PAYMENT</label>
                            <select wire:model.live="filterPayment"
                                class="block w-full px-4 py-2.5 text-sm border-2 border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition-all">
                                <option value="">All Events</option>
                                <option value="free">Free</option>
                                <option value="paid">Paid</option>
                            </select>
                        </div>

                        <!-- Creator Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">CREATOR</label>
                            <select wire:model.live="filterCreator"
                                class="block w-full px-4 py-2.5 text-sm border-2 border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition-all">
                                <option value="">All Creators</option>
                                @foreach ($creators as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Bottom Filter Row: Sort and Per Page (like reference) -->
                    <div class="mt-5 pt-4 border-t border-gray-100 flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-gray-600">Sort by:</span>
                                <select wire:model.live="sortField"
                                    class="text-sm border-0 bg-transparent focus:ring-0 font-semibold text-blue-600 cursor-pointer">
                                    <option value="archived_at">Date Archived</option>
                                    <option value="title">Event Name</option>
                                    <option value="start_date">Event Date</option>
                                    <option value="registrations_count">Registrations</option>
                                </select>
                                <button wire:click="$set('sortDirection', '{{ $sortDirection === 'asc' ? 'desc' : 'asc' }}')"
                                    class="p-1.5 hover:bg-gray-100 rounded-lg transition-colors">
                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if ($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4 4m0 0l4-4m-4 4V4" />
                                        @endif
                                    </svg>
                                </button>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-gray-600">Show:</span>
                                <select wire:model.live="eventsPerPage"
                                    class="text-sm border-0 bg-transparent focus:ring-0 font-semibold text-blue-600 cursor-pointer">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                                <span class="text-sm text-gray-600">per page</span>
                            </div>
                        </div>
                        
                        <!-- Reset Filters Button -->
                        <button wire:click="resetFilters"
                            class="px-4 py-2 text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1 hover:bg-blue-50 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Reset All Filters
                        </button>
                    </div>
                </div>
            </div>

            <!-- Events Table with Blue Header and Striped Rows -->
            @if (count($events) > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-blue-600 to-blue-700">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        Event Name
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        Creator
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        Date & Time
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        Category & Type
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        Payment
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        Registrations
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        Archived On
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($events as $index => $event)
                                    <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-blue-50/30' }} hover:bg-yellow-50/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                @if ($event->banner)
                                                    <div class="flex-shrink-0 h-10 w-10 mr-3">
                                                        <img class="h-10 w-10 rounded-lg object-cover ring-2 ring-gray-200"
                                                            src="{{ asset('storage/' . $event->banner) }}"
                                                            alt="{{ $event->title }}">
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="text-sm font-semibold text-gray-900">{{ $event->title }}</div>
                                                    <div class="text-xs text-gray-500">{{ Str::limit($event->description, 40) }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center mr-2">
                                                    <span class="text-xs font-medium text-blue-600">
                                                        {{ substr($event->creator->first_name ?? 'U', 0, 1) }}{{ substr($event->creator->last_name ?? 'N', 0, 1) }}
                                                    </span>
                                                </div>
                                                <div class="text-sm text-gray-900">
                                                    {{ $event->creator->first_name ?? 'Unknown' }}
                                                    {{ $event->creator->last_name ?? '' }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $event->start_date->format('M d, Y') }}</div>
                                            <div class="text-xs text-gray-500">
                                                {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }} - 
                                                {{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-col gap-1.5">
                                                <span class="px-2.5 py-1 text-xs rounded-full bg-blue-100 text-blue-700 font-medium w-fit">
                                                    {{ ucfirst($event->category) }}
                                                </span>
                                                <span class="px-2.5 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700 font-medium w-fit">
                                                    {{ ucfirst(str_replace('-', ' ', $event->type)) }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($event->require_payment)
                                                <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700 font-semibold">
                                                    ₱{{ number_format($event->payment_amount, 2) }}
                                                </span>
                                            @else
                                                <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-medium">
                                                    Free
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-semibold text-gray-900">{{ $event->registrations_count }}</div>
                                            <div class="text-xs text-gray-500">registrations</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $event->archived_at->format('M d, Y') }}</div>
                                            <div class="text-xs text-gray-500">{{ $event->archived_at->format('g:i A') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <!-- Restore Icon Button -->
                                                <button wire:click="confirmRestore({{ $event->id }})"
                                                    class="p-2 bg-green-100 text-green-600 rounded-lg hover:bg-green-200 transition-colors group relative"
                                                    title="Restore Event">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                    </svg>
                                                    <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                                        Restore
                                                    </span>
                                                </button>
                                                
                                                <!-- Delete Icon Button -->
                                                <button wire:click="confirmDelete({{ $event->id }})"
                                                    class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors group relative"
                                                    title="Delete Permanently">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                                        Delete
                                                    </span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination with Info -->
                <div class="mt-6 flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        Showing <span class="font-medium">{{ $events->firstItem() }}</span> to 
                        <span class="font-medium">{{ $events->lastItem() }}</span> of 
                        <span class="font-medium">{{ $events->total() }}</span> archived events
                    </div>
                    <div class="flex-1 flex justify-end">
                        {{ $events->links() }}
                    </div>
                </div>
            @else
                <!-- Enhanced Empty State -->
                <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="flex justify-center mb-4">
                        <div class="p-4 bg-blue-100 rounded-full">
                            <svg class="h-16 w-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">No archived events found</h3>
                    <p class="mt-1 text-sm text-gray-500 max-w-md mx-auto">
                        @if($search || $filterCategory || $filterType || $filterPayment || $filterCreator)
                            No events match your current filters. Try adjusting your search criteria.
                        @else
                            All events are currently active. Archived events will appear here when you archive them.
                        @endif
                    </p>
                    @if($search || $filterCategory || $filterType || $filterPayment || $filterCreator)
                        <div class="mt-6">
                            <button wire:click="resetFilters"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700">
                                Reset All Filters
                            </button>
                        </div>
                    @else
                        <div class="mt-6">
                            <a href="{{ route('admin.events') }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700">
                                View Active Events
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Enhanced Export Modal with Blue/Yellow Theme -->
    <x-custom-modal model="showExportModal" maxWidth="lg" title="Export Archived Events"
        description="Export archived events data with current filters" headerBg="green">
        <div class="space-y-6">
            <!-- Current Filters Summary Card -->
            <div class="bg-gradient-to-br from-green-50 to-yellow-50 p-5 rounded-xl border border-green-200">
                <div class="flex items-center space-x-2 mb-3">
                    <div class="p-1.5 bg-green-200 rounded-lg">
                        <svg class="w-4 h-4 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-green-800">Active Filters</h3>
                </div>

                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div class="space-y-2">
                        <p class="text-green-700">
                            <span class="font-medium">Search:</span>
                            <span class="text-green-600">{{ $search ?: 'None' }}</span>
                        </p>
                        <p class="text-green-700">
                            <span class="font-medium">Category:</span>
                            <span class="text-green-600">{{ $filterCategory ? ucfirst($filterCategory) : 'All' }}</span>
                        </p>
                        <p class="text-green-700">
                            <span class="font-medium">Payment:</span>
                            <span class="text-green-600">{{ $filterPayment ? ucfirst($filterPayment) : 'All' }}</span>
                        </p>
                    </div>
                    <div class="space-y-2">
                        <p class="text-green-700">
                            <span class="font-medium">Type:</span>
                            <span class="text-green-600">{{ $filterType ? ucfirst($filterType) : 'All' }}</span>
                        </p>
                        <p class="text-green-700">
                            <span class="font-medium">Creator:</span>
                            <span class="text-green-600">{{ $filterCreator && isset($creators[$filterCreator]) ? $creators[$filterCreator] : 'All' }}</span>
                        </p>
                        <p class="text-green-700">
                            <span class="font-medium">Sort:</span>
                            <span class="text-green-600">{{ ucfirst(str_replace('_', ' ', $sortField)) }} ({{ $sortDirection }})</span>
                        </p>
                    </div>
                </div>

                <!-- Total Records Badge -->
                <div class="mt-3 pt-3 border-t border-green-200">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-green-700">Events to export:</span>
                        <span class="px-3 py-1 bg-green-200 text-green-800 rounded-full text-sm font-semibold">
                            {{ $events->total() }} events
                        </span>
                    </div>
                </div>
            </div>

            <!-- Export Format Selection -->
            <div class="space-y-3">
                <label class="flex items-center space-x-2 text-sm font-semibold text-green-800">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Choose Export Format</span>
                </label>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Excel Option -->
                    <label class="relative cursor-pointer">
                        <input type="radio" wire:model="exportFormat" value="xlsx" class="sr-only peer">
                        <div class="p-4 bg-white border-2 border-gray-200 rounded-xl peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-green-300 transition-all duration-200">
                            <div class="flex flex-col items-center text-center">
                                <div class="p-3 bg-green-100 rounded-full mb-2">
                                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z" />
                                        <path d="M14 2v6h6M8 13h8M8 17h4" stroke="white" stroke-width="2" />
                                    </svg>
                                </div>
                                <span class="font-semibold text-gray-800">Excel</span>
                                <span class="text-xs text-gray-500 mt-1">.xlsx format</span>
                            </div>
                        </div>
                    </label>

                    <!-- CSV Option -->
                    <label class="relative cursor-pointer">
                        <input type="radio" wire:model="exportFormat" value="csv" class="sr-only peer">
                        <div class="p-4 bg-white border-2 border-gray-200 rounded-xl peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-green-300 transition-all duration-200">
                            <div class="flex flex-col items-center text-center">
                                <div class="p-3 bg-yellow-100 rounded-full mb-2">
                                    <svg class="w-8 h-8 text-yellow-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z" />
                                        <text x="8" y="18" fill="white" font-size="10" font-weight="bold">CSV</text>
                                    </svg>
                                </div>
                                <span class="font-semibold text-gray-800">CSV</span>
                                <span class="text-xs text-gray-500 mt-1">Comma separated</span>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-3 pt-4 border-t-2 border-gray-100">
                <button type="button" wire:click="closeExportModal"
                    class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group">
                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Cancel</span>
                </button>
                <button type="button" wire:click="exportArchivedEvents"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group shadow-lg shadow-green-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span>Export {{ strtoupper($exportFormat) }}</span>
                </button>
            </div>
        </div>
    </x-custom-modal>

    <!-- Restore Confirmation Modal with Blue Theme -->
    <x-confirmation-modal model="showRestoreConfirmation" 
        title="Restore Event" 
        :message="'Are you sure you want to restore the event &quot;' . $selectedEventTitle . '&quot;? This will make it active again.'"
        confirmButtonText="Yes, Restore" 
        confirmButtonColor="green" />

    <!-- Delete Confirmation Modal with Red Theme -->
    <x-confirmation-modal model="showDeleteConfirmation" 
        title="Permanently Delete Event" 
        :message="'Are you sure you want to permanently delete &quot;' . $selectedEventTitle . '&quot;? This action cannot be undone.'"
        confirmButtonText="Yes, Delete Permanently" 
        confirmButtonColor="red" />

    <!-- Success Messages with Enhanced Styling -->
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="fixed bottom-4 right-4 bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg shadow-lg flex items-center gap-3">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('success') }}
        </div>
    @endif
</div>