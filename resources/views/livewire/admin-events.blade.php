<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <x-dashboard-sidebar />

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Header -->
        <x-dashboard-header userRole="Admin" :userInitials="$userInitials" />

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <!-- Header with Stats and Create Button -->
            <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">System Events</h1>
                    <p class="text-gray-600">Manage all events in the system</p>
                </div>
                <button wire:click="openCreateModal"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create New Event
                </button>
            </div>

            <!-- Search and Filter Section -->
            <div class="mb-6 bg-white rounded-lg shadow p-4">
                <div class="grid grid-cols-1 md:grid-cols-6 gap-4 mb-4">
                    <!-- Search -->
                    <div class="md:col-span-2">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" wire:model.live.debounce.300ms="search"
                                class="block w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Search events...">
                        </div>
                    </div>

                    <!-- Type Filter -->
                    <div>
                        <select wire:model.live="filterType"
                            class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Types</option>
                            <option value="online">Online</option>
                            <option value="face-to-face">Face-to-Face</option>
                        </select>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <select wire:model.live="filterCategory"
                            class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Categories</option>
                            <option value="academic">Academic</option>
                            <option value="sports">Sports</option>
                            <option value="cultural">Cultural</option>
                        </select>
                    </div>

                    <!-- Payment Filter -->
                    <div>
                        <select wire:model.live="filterPayment"
                            class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Events</option>
                            <option value="paid">Paid Events</option>
                            <option value="free">Free Events</option>
                        </select>
                    </div>

                    <!-- Creator Filter -->
                    <div>
                        <select wire:model.live="filterCreator"
                            class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Creators</option>
                            @foreach($creators as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <select wire:model.live="filterStatus"
                            class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Status</option>
                            <option value="published">Published</option>
                            <option value="draft">Draft</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <!-- Sort and Per Page -->
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600">Sort by:</span>
                            <select wire:model.live="sortBy"
                                class="text-sm border border-gray-300 rounded-lg px-3 py-1 focus:ring-blue-500 focus:border-blue-500">
                                <option value="date">Date</option>
                                <option value="title">Title</option>
                                <option value="created_at">Created</option>
                            </select>
                            <button wire:click="sortBy($sortBy)" class="p-1 rounded hover:bg-gray-100">
                                @if ($sortDirection === 'asc')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                @endif
                            </button>
                        </div>

                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600">Show:</span>
                            <select wire:model.live="eventsPerPage"
                                class="text-sm border border-gray-300 rounded-lg px-3 py-1 focus:ring-blue-500 focus:border-blue-500">
                                <option value="12">12</option>
                                <option value="24">24</option>
                                <option value="48">48</option>
                            </select>
                        </div>
                    </div>

                    <!-- Reset Filters -->
                    <div>
                        <button wire:click="resetFilters"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-blue-500">
                            Reset Filters
                        </button>
                    </div>
                </div>
            </div>

            <!-- Events Grid -->
            @if (count($events) > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($events as $event)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                            <!-- Banner Image -->
                            <div class="h-48 overflow-hidden">
                                @if ($event->banner)
                                    <img src="{{ asset('storage/' . $event->banner) }}" alt="{{ $event->title }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                                        <span class="text-white text-lg font-semibold">{{ $event->title }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Event Details -->
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-lg font-semibold text-gray-800 truncate">{{ $event->title }}</h3>
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        {{ $event->require_payment ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $event->require_payment ? 'Paid' : 'Free' }}
                                    </span>
                                </div>

                                <p class="text-sm text-gray-600 mb-2">By: {{ $event->creator->first_name ?? 'Unknown' }} {{ $event->creator->last_name ?? '' }}</p>

                                <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $event->description }}</p>

                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $event->date->format('M d, Y') }}
                                    </div>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}
                                    </div>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ $event->type === 'online' ? 'Online' : 'In-Person' }}
                                    </div>
                                </div>

                                <!-- Tags -->
                                <div class="flex flex-wrap gap-1 mb-4">
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                        {{ ucfirst($event->category) }}
                                    </span>
                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">
                                        {{ ucfirst(str_replace('-', ' ', $event->type)) }}
                                    </span>
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        {{ $event->visibility_type === 'all' ? 'bg-green-100 text-green-800' : 'bg-indigo-100 text-indigo-800' }}">
                                        {{ $event->visibility_type === 'all' ? 'All Students' : 'Restricted' }}
                                    </span>
                                    @if ($event->require_payment)
                                        <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                                            ₱{{ number_format($event->payment_amount, 2) }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Actions -->
                                <div class="flex space-x-2">
                                    <button wire:click="openEventDetailsModal({{ $event->id }})"
                                        class="flex-1 px-3 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition-colors font-medium">
                                        View
                                    </button>
                                    <button wire:click="openEditModal({{ $event->id }})"
                                        class="flex-1 px-3 py-2 bg-yellow-600 text-white text-sm rounded hover:bg-yellow-700 transition-colors font-medium">
                                        Edit
                                    </button>
                                    @if ($event->canBeArchived())
                                        <button wire:click="archiveEvent({{ $event->id }})"
                                            wire:confirm="Are you sure you want to archive this event?"
                                            class="flex-1 px-3 py-2 bg-orange-600 text-white text-sm rounded hover:bg-orange-700 transition-colors font-medium">
                                            Archive
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $events->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12 bg-white rounded-lg shadow">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">
                        @if ($search || $filterType || $filterCategory || $filterPayment || $filterCreator || $filterStatus)
                            No events found matching your filters
                        @else
                            No events in the system
                        @endif
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Get started by creating your first event.
                    </p>
                    <div class="mt-6">
                        <button wire:click="openCreateModal"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Create Event
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Include the modals (same as organizer) -->
    <!-- Create Event Modal -->
    <x-custom-modal model="showCreateModal" maxWidth="lg" title="Create New Event" description="Fill in the details below to create a new event" headerBg="blue">
    <div class="space-y-6">
        @if (session()->has('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg flex items-center space-x-2 animate-slideIn">
                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form wire:submit.prevent="createEvent" class="space-y-5">
            <!-- Event Title -->
            <div class="space-y-1.5">
                <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                    <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                    <span>Event Title</span>
                </label>
                <div class="relative group">
                    <input type="text" wire:model="title"
                        class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 group-hover:border-blue-300"
                        placeholder="e.g., Annual Sports Festival">
                    @error('title')
                        <span class="absolute -bottom-5 left-0 text-xs text-red-500 flex items-center space-x-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            <span>{{ $message }}</span>
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Date and Time -->
            <div class="space-y-1.5">
                <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                    <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Date & Time</span>
                </label>
                <div class="grid grid-cols-2 gap-3">
                    <div class="relative group">
                        <input type="date" wire:model="date"
                            class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 group-hover:border-blue-300">
                        @error('date')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="relative group">
                        <input type="time" wire:model="time"
                            class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 group-hover:border-blue-300">
                        @error('time')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Event Type and Location/Link -->
            <div class="space-y-1.5">
                <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                    <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>Event Type & Location</span>
                </label>
                <div class="space-y-3">
                    <select wire:model="type"
                        class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 hover:border-blue-300 appearance-none cursor-pointer">
                        <option value="">Select event type</option>
                        <option value="online">🌐 Online Event</option>
                        <option value="face-to-face">👥 Face-to-Face Event</option>
                    </select>
                    
                    <div class="relative group">
                        <input type="text" wire:model="place_link"
                            class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 group-hover:border-blue-300"
                            placeholder="{{ $type === 'online' ? 'Meeting link (Zoom, Google Meet, etc.)' : 'Event venue/location' }}">
                        @error('place_link')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Category and Visibility in Grid -->
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1.5">
                    <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                        <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                        </svg>
                        <span>Category</span>
                    </label>
                    <select wire:model="category"
                        class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 hover:border-blue-300">
                        <option value="">Select</option>
                        <option value="academic">📚 Academic</option>
                        <option value="sports">⚽ Sports</option>
                        <option value="cultural">🎭 Cultural</option>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                        <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <span>Visibility</span>
                    </label>
                    <select wire:model="visibility_type"
                        class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 hover:border-blue-300">
                        <option value="all">👥 All Students</option>
                        <option value="grade_level">📋 Grade Levels</option>
                        <option value="shs_strand">🎓 SHS Strands</option>
                        <option value="year_level">📚 Year Levels</option>
                        <option value="college_program">🏫 College Programs</option>
                    </select>
                </div>
            </div>

            <!-- Dynamic Visibility Options -->
            @if ($visibility_type === 'grade_level')
                <div class="p-4 bg-blue-50 rounded-xl border-2 border-blue-100 animate-fadeIn">
                    <label class="block text-sm font-semibold text-blue-900 mb-3">Select Grade Levels</label>
                    <div class="flex space-x-6">
                        <label class="flex items-center space-x-2 cursor-pointer group">
                            <input type="checkbox" wire:model="visible_to_grade_level" value="11"
                                class="w-5 h-5 text-yellow-500 border-2 border-gray-300 rounded-lg focus:ring-yellow-400 focus:ring-2 transition-all group-hover:border-blue-400">
                            <span class="text-sm text-gray-700 group-hover:text-blue-600">Grade 11</span>
                        </label>
                        <label class="flex items-center space-x-2 cursor-pointer group">
                            <input type="checkbox" wire:model="visible_to_grade_level" value="12"
                                class="w-5 h-5 text-yellow-500 border-2 border-gray-300 rounded-lg focus:ring-yellow-400 focus:ring-2 transition-all group-hover:border-blue-400">
                            <span class="text-sm text-gray-700 group-hover:text-blue-600">Grade 12</span>
                        </label>
                    </div>
                </div>
            @endif

            <!-- Similar for other visibility types... (keeping them similar style) -->

            <!-- Description -->
            <div class="space-y-1.5">
                <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                    <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                    </svg>
                    <span>Event Description</span>
                </label>
                <textarea wire:model="description" rows="3"
                    class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 hover:border-blue-300 resize-none"
                    placeholder="Describe your event..."></textarea>
                @error('description')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <!-- Banner Upload -->
            <div class="space-y-1.5">
                <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                    <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Event Banner</span>
                </label>
                <div class="file-upload-area group">
                    <input id="dropzone-file" type="file" class="hidden" wire:model="banner" />
                    <label for="dropzone-file" class="cursor-pointer block">
                        <div class="text-center">
                            <svg class="w-12 h-12 mx-auto text-blue-400 group-hover:text-yellow-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <p class="mt-2 text-sm text-gray-600 group-hover:text-blue-600">
                                <span class="font-semibold text-blue-600">Click to upload</span> or drag and drop
                            </p>
                            <p class="text-xs text-gray-500">JPG or PNG (MAX. 2MB)</p>
                        </div>
                    </label>
                </div>
                @if ($banner)
                    <p class="text-sm text-green-600 flex items-center space-x-1 mt-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>{{ $banner->getClientOriginalName() }}</span>
                    </p>
                @endif
            </div>

            <!-- Payment Toggle -->
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border-2 border-gray-100">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-medium text-gray-700">Require Payment</span>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model="require_payment" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-yellow-400 peer-checked:to-yellow-500"></div>
                </label>
            </div>

            @if ($require_payment)
                <div class="animate-slideDown">
                    <label class="block text-sm font-semibold text-blue-900 mb-2">Payment Amount</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-gray-500">₱</span>
                        <input type="number" wire:model="payment_amount" step="0.01" min="0"
                            class="w-full pl-8 pr-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200"
                            placeholder="0.00">
                    </div>
                    @error('payment_amount')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex space-x-3 pt-4 border-t-2 border-gray-100">
                <button type="button" wire:click="closeCreateModal"
                    class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group">
                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Cancel</span>
                </button>
                <button type="submit"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group shadow-lg shadow-blue-200">
                    <span>Publish Event</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</x-custom-modal>

    <!-- Edit Event Modal -->
    <x-custom-modal model="showEditModal" maxWidth="lg" title="Edit Event" description="Update your event details below" headerBg="yellow">
    <div class="space-y-6">
        @if (session()->has('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg flex items-center space-x-2 animate-slideIn">
                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form wire:submit.prevent="updateEvent" class="space-y-5">
            <!-- Event Title -->
            <div class="space-y-1.5">
                <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                    <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                    <span>Event Title</span>
                </label>
                <div class="relative group">
                    <input type="text" wire:model="title"
                        class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 group-hover:border-blue-300"
                        placeholder="e.g., Annual Sports Festival">
                    @error('title')
                        <span class="absolute -bottom-5 left-0 text-xs text-red-500 flex items-center space-x-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            <span>{{ $message }}</span>
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Date and Time -->
            <div class="space-y-1.5">
                <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                    <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Date & Time</span>
                </label>
                <div class="grid grid-cols-2 gap-3">
                    <div class="relative group">
                        <input type="date" wire:model="date"
                            class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 group-hover:border-blue-300">
                        @error('date')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="relative group">
                        <input type="time" wire:model="time"
                            class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 group-hover:border-blue-300">
                        @error('time')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Event Type and Location/Link -->
            <div class="space-y-1.5">
                <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                    <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>Event Type & Location</span>
                </label>
                <div class="space-y-3">
                    <select wire:model="type"
                        class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 hover:border-blue-300 appearance-none cursor-pointer">
                        <option value="">Select event type</option>
                        <option value="online">🌐 Online Event</option>
                        <option value="face-to-face">👥 Face-to-Face Event</option>
                    </select>
                    
                    <div class="relative group">
                        <input type="text" wire:model="place_link"
                            class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 group-hover:border-blue-300"
                            placeholder="{{ $type === 'online' ? 'Meeting link (Zoom, Google Meet, etc.)' : 'Event venue/location' }}">
                        @error('place_link')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Category and Visibility in Grid -->
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1.5">
                    <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                        <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                        </svg>
                        <span>Category</span>
                    </label>
                    <select wire:model="category"
                        class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 hover:border-blue-300">
                        <option value="">Select</option>
                        <option value="academic">📚 Academic</option>
                        <option value="sports">⚽ Sports</option>
                        <option value="cultural">🎭 Cultural</option>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                        <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <span>Visibility</span>
                    </label>
                    <select wire:model="visibility_type"
                        class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 hover:border-blue-300">
                        <option value="all">👥 All Students</option>
                        <option value="grade_level">📋 Grade Levels</option>
                        <option value="shs_strand">🎓 SHS Strands</option>
                        <option value="year_level">📚 Year Levels</option>
                        <option value="college_program">🏫 College Programs</option>
                    </select>
                </div>
            </div>

            <!-- Dynamic Visibility Options -->
            @if ($visibility_type === 'grade_level')
                <div class="p-4 bg-blue-50 rounded-xl border-2 border-blue-100 animate-fadeIn">
                    <label class="block text-sm font-semibold text-blue-900 mb-3">Select Grade Levels</label>
                    <div class="flex space-x-6">
                        <label class="flex items-center space-x-2 cursor-pointer group">
                            <input type="checkbox" wire:model="visible_to_grade_level" value="11"
                                class="w-5 h-5 text-yellow-500 border-2 border-gray-300 rounded-lg focus:ring-yellow-400 focus:ring-2 transition-all group-hover:border-blue-400">
                            <span class="text-sm text-gray-700 group-hover:text-blue-600">Grade 11</span>
                        </label>
                        <label class="flex items-center space-x-2 cursor-pointer group">
                            <input type="checkbox" wire:model="visible_to_grade_level" value="12"
                                class="w-5 h-5 text-yellow-500 border-2 border-gray-300 rounded-lg focus:ring-yellow-400 focus:ring-2 transition-all group-hover:border-blue-400">
                            <span class="text-sm text-gray-700 group-hover:text-blue-600">Grade 12</span>
                        </label>
                    </div>
                </div>
            @endif

            <!-- Similar for other visibility types... (keeping them similar style) -->

            <!-- Description -->
            <div class="space-y-1.5">
                <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                    <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                    </svg>
                    <span>Event Description</span>
                </label>
                <textarea wire:model="description" rows="3"
                    class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 hover:border-blue-300 resize-none"
                    placeholder="Describe your event..."></textarea>
                @error('description')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <!-- Banner Upload -->
            <div class="space-y-1.5">
                <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                    <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Event Banner</span>
                </label>
                <div class="file-upload-area group">
                    <input id="dropzone-file" type="file" class="hidden" wire:model="banner" />
                    <label for="dropzone-file" class="cursor-pointer block">
                        <div class="text-center">
                            <svg class="w-12 h-12 mx-auto text-blue-400 group-hover:text-yellow-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <p class="mt-2 text-sm text-gray-600 group-hover:text-blue-600">
                                <span class="font-semibold text-blue-600">Click to upload</span> or drag and drop
                            </p>
                            <p class="text-xs text-gray-500">JPG or PNG (MAX. 2MB)</p>
                        </div>
                    </label>
                </div>
                @if ($banner)
                    <p class="text-sm text-green-600 flex items-center space-x-1 mt-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>{{ $banner->getClientOriginalName() }}</span>
                    </p>
                @endif
            </div>

            <!-- Payment Toggle -->
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border-2 border-gray-100">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-medium text-gray-700">Require Payment</span>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model="require_payment" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-yellow-400 peer-checked:to-yellow-500"></div>
                </label>
            </div>

            @if ($require_payment)
                <div class="animate-slideDown">
                    <label class="block text-sm font-semibold text-blue-900 mb-2">Payment Amount</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-gray-500">₱</span>
                        <input type="number" wire:model="payment_amount" step="0.01" min="0"
                            class="w-full pl-8 pr-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200"
                            placeholder="0.00">
                    </div>
                    @error('payment_amount')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            @endif
        </form>
            <!-- Action Buttons with Edit-specific styling -->
            <div class="flex space-x-3 pt-4 border-t-2 border-gray-100">
                <button type="button" wire:click="closeEditModal"
                    class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group">
                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Cancel</span>
                </button>
                <button type="submit"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-xl hover:from-yellow-600 hover:to-yellow-700 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group shadow-lg shadow-yellow-200">
                    <span>Update Event</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</x-custom-modal>

    <!-- Event Details Modal -->
    <x-custom-modal model="showEventDetailsModal" maxWidth="lg" title="Event Details" description="View complete event information" headerBg="green">
    @if ($selectedEvent)
        <div class="space-y-5">
            <!-- Banner Section with improved styling -->
            <div class="relative h-48 rounded-xl overflow-hidden border border-gray-200 shadow-sm">
                @if ($selectedEvent->banner)
                    <img src="{{ asset('storage/' . $selectedEvent->banner) }}" 
                         alt="{{ $selectedEvent->title }}"
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent"></div>
                @else
                    <div class="w-full h-full bg-gradient-to-br from-green-600 to-green-800 flex items-center justify-center">
                        <svg class="w-20 h-20 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent"></div>
                @endif
                
                <!-- Title Overlay with better positioning -->
                <div class="absolute bottom-0 left-0 right-0 p-5 text-white">
                    <h1 class="text-2xl font-bold mb-1">{{ $selectedEvent->title }}</h1>
                    <div class="flex items-center space-x-3 text-sm">
                        <span class="flex items-center space-x-1.5 bg-black/30 px-3 py-1 rounded-full backdrop-blur-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>{{ $selectedEvent->creator->first_name ?? 'Unknown' }} {{ $selectedEvent->creator->last_name ?? '' }}</span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Description Card with improved styling -->
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-5 rounded-xl border border-green-200">
                <h3 class="text-sm font-semibold text-green-800 mb-2 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                    </svg>
                    <span>Description</span>
                </h3>
                <p class="text-gray-700 leading-relaxed">{{ $selectedEvent->description }}</p>
            </div>

            <!-- Event Details Grid with improved borders and spacing -->
            <div class="grid grid-cols-2 gap-4">
                <!-- Date -->
                <div class="bg-white p-4 rounded-xl border border-gray-200 hover:border-green-300 transition-all duration-200">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Date</p>
                            <p class="font-semibold text-gray-800">{{ $selectedEvent->date->format('F j, Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Time -->
                <div class="bg-white p-4 rounded-xl border border-gray-200 hover:border-green-300 transition-all duration-200">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Time</p>
                            <p class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($selectedEvent->time)->format('g:i A') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Location/Link (full width) -->
                <div class="col-span-2 bg-white p-4 rounded-xl border border-gray-200 hover:border-green-300 transition-all duration-200">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-500">{{ $selectedEvent->type === 'online' ? 'Event Link' : 'Location' }}</p>
                            @if ($selectedEvent->type === 'online' && filter_var($selectedEvent->place_link, FILTER_VALIDATE_URL))
                                <a href="{{ $selectedEvent->place_link }}" target="_blank"
                                   class="font-semibold text-green-600 hover:text-green-700 hover:underline transition-colors flex items-center space-x-1 break-all">
                                    <span>{{ $selectedEvent->place_link }}</span>
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
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
                        <span class="w-2 h-2 rounded-full {{ $selectedEvent->type === 'online' ? 'bg-green-500' : 'bg-orange-500' }}"></span>
                        <span class="font-medium capitalize">{{ str_replace('-', ' ', $selectedEvent->type) }}</span>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-xl border border-gray-200">
                    <p class="text-xs text-gray-500 mb-2">Category</p>
                    <div class="flex items-center space-x-2">
                        @php
                            $categoryColors = [
                                'academic' => 'bg-blue-100 text-blue-700',
                                'sports' => 'bg-green-100 text-green-700',
                                'cultural' => 'bg-purple-100 text-purple-700'
                            ];
                        @endphp
                        <span class="px-3 py-1.5 rounded-full text-xs font-semibold {{ $categoryColors[$selectedEvent->category] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ ucfirst($selectedEvent->category) }}
                        </span>
                    </div>
                </div>

                <!-- Visibility -->
                <div class="col-span-2 bg-white p-4 rounded-xl border border-gray-200">
                    <p class="text-xs text-gray-500 mb-2">Visibility</p>
                    <div class="flex items-center space-x-2">
                        @if($selectedEvent->visibility_type === 'all')
                            <span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-sm font-medium">🌍 Visible to all students</span>
                        @else
                            <span class="px-3 py-1.5 bg-yellow-100 text-yellow-700 rounded-full text-sm font-medium">🔒 Restricted access</span>
                        @endif
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="col-span-2 bg-gradient-to-r from-gray-50 to-gray-100 p-4 rounded-xl border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 {{ $selectedEvent->require_payment ? 'bg-yellow-100' : 'bg-green-100' }} rounded-lg">
                                <svg class="w-5 h-5 {{ $selectedEvent->require_payment ? 'text-yellow-600' : 'text-green-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Payment Status</p>
                                @if ($selectedEvent->require_payment)
                                    <p class="text-xl font-bold text-yellow-600">₱{{ number_format($selectedEvent->payment_amount, 2) }}</p>
                                @else
                                    <p class="text-xl font-bold text-green-600">Free Event</p>
                                @endif
                            </div>
                        </div>
                        @if($selectedEvent->require_payment)
                            <span class="px-3 py-1.5 bg-yellow-100 text-yellow-700 rounded-full text-sm font-medium">Paid</span>
                        @else
                            <span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-sm font-medium">Free</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-3 pt-4 border-t border-gray-200">
                <button type="button" wire:click="closeEventDetailsModal"
                    class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group">
                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Close</span>
                </button>
            </div>
        </div>
    @endif
</x-custom-modal>

    <!-- Delete Event Modal -->
    <x-custom-modal model="showDeleteModal">
        <form class="max-w-md mx-auto">
            <h1 class="text-xl text-center font-bold">Delete Event</h1>
            <h3 class="text-center mb-6">Are you sure to delete this event?</h3>
            <div class="flex flex-row gap-1">
                <button wire:click="closeDeleteModal"
                    class="w-full px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs font-medium">Cancel</button>
                <button wire:click="deleteEvent"
                    class="w-full px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs font-medium">Confirm</button>
            </div>
        </form>
    </x-custom-modal>
</div>