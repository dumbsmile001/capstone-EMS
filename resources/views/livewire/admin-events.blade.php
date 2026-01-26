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
    <x-custom-modal model="showCreateModal">
        <h1 class="text-xl text-center font-bold mb-4">Create Event</h1>
        @if (session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        <form wire:submit.prevent="createEvent" class="max-w-md mx-auto">
            <!-- Form fields (same as your existing create modal) -->
            <!-- You can copy the form from your existing create modal -->
            <div class="mb-5">
                <label for="title" class="block mb-2.5 text-sm font-medium text-heading">Event
                    Title</label>
                <input type="text" id="title" wire:model="title"
                    class="w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    placeholder="Enter Event Title...">
                @error('title')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col mb-5">
                <h3 class="font-medium text-gray-700 mb-2">Event Date and Time</h3>
                <div class="flex flex-row gap-2">
                    <div class="w-1/2">
                        <input type="date" wire:model="date"
                            class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('date')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-1/2">
                        <input type="time" wire:model="time"
                            class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('time')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex flex-col mb-5">
                <h2 class="font-medium text-gray-700 mb-2">Event Type</h2>
                <select wire:model="type"
                    class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Select Type</option>
                    <option value="online">Online</option>
                    <option value="face-to-face">Face-to-face</option>
                </select>
                @error('type')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror

                <h3 class="font-medium text-gray-700 mt-3 mb-2">Event Place or Link</h3>
                <input type="text" wire:model="place_link"
                    class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    placeholder="Enter Event Place or Link...">
                @error('place_link')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col mb-5">
                <h2 class="font-medium text-gray-700 mb-2">Event Category</h2>
                <select wire:model="category"
                    class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Select Category</option>
                    <option value="academic">Academic</option>
                    <option value="sports">Sports</option>
                    <option value="cultural">Cultural</option>
                </select>
                @error('category')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <!-- Add this in BOTH create and edit modals, after the payment amount section -->
            <!-- Visibility Section -->
            <div class="flex flex-col mb-5">
                <h2 class="font-medium text-gray-700 mb-2">Event Visibility</h2>
                <select wire:model="visibility_type"
                    class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="all">Visible to All Students</option>
                    <option value="grade_level">Specific Grade Levels</option>
                    <option value="shs_strand">Specific SHS Strands</option>
                    <option value="year_level">Specific Year Levels</option>
                    <option value="college_program">Specific College Programs</option>
                </select>
                @error('visibility_type')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            @if ($visibility_type === 'grade_level')
                <div class="flex flex-col mb-5">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Select Grade Levels</label>
                    <div class="space-y-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="visible_to_grade_level" value="11"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Grade 11</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="visible_to_grade_level" value="12"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Grade 12</span>
                        </label>
                    </div>
                </div>
            @endif

            @if ($visibility_type === 'shs_strand')
                <div class="flex flex-col mb-5">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Select SHS Strands</label>
                    <div class="space-y-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="visible_to_shs_strand" value="ABM"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">ABM</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="visible_to_shs_strand" value="HUMSS"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">HUMSS</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="visible_to_shs_strand" value="GAS"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">GAS</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="visible_to_shs_strand" value="ICT"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">ICT</span>
                        </label>
                    </div>
                </div>
            @endif

            @if ($visibility_type === 'year_level')
                <div class="flex flex-col mb-5">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Select Year Levels</label>
                    <div class="space-y-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <label class="inline-flex items-center">
                                <input type="checkbox" wire:model="visible_to_year_level"
                                    value="{{ $i }}"
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Year {{ $i }}</span>
                            </label>
                        @endfor
                    </div>
                </div>
            @endif

            @if ($visibility_type === 'college_program')
                <div class="flex flex-col mb-5">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Select College Programs</label>
                    <div class="space-y-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="visible_to_college_program" value="BSIT"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">BSIT</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="visible_to_college_program" value="BSBA"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">BSBA</span>
                        </label>
                    </div>
                </div>
            @endif

            <div class="flex flex-col mb-5">
                <h2 class="font-medium text-gray-700 mb-2">Event Description</h2>
                <textarea wire:model="description" rows="3"
                    class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    placeholder="Enter Event Description..."></textarea>
                @error('description')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col mb-5">
                <h2 class="font-medium text-gray-700 mb-2">Event Banner</h2>
                <div class="flex items-center justify-center w-full">
                    <label for="dropzone-file"
                        class="flex flex-col items-center justify-center w-full h-32 bg-neutral-secondary-medium border border-dashed border-default-strong rounded-base cursor-pointer hover:bg-neutral-tertiary-medium">
                        <div class="flex flex-col items-center justify-center text-body">
                            <svg class="w-8 h-8 mb-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 17h3a3 3 0 0 0 0-6h-.025a5.56 5.56 0 0 0 .025-.5A5.5 5.5 0 0 0 7.207 9.021C7.137 9.017 7.071 9 7 9a4 4 0 1 0 0 8h2.167M12 19v-9m0 0-2 2m2-2 2 2" />
                            </svg>
                            <p class="mb-1 text-sm">
                                <span class="font-semibold">Click to upload</span> or drag and drop
                            </p>
                            <p class="text-xs">JPG or PNG (MAX. 2MB)</p>
                        </div>
                        <input id="dropzone-file" type="file" class="hidden" wire:model="banner" />
                    </label>
                </div>
                @error('banner')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
                @if ($banner)
                    <p class="text-xs text-green-600 mt-1">File selected:
                        {{ $banner->getClientOriginalName() }}</p>
                @endif
            </div>

            <div class="flex items-center mb-5">
                <input id="default-checkbox" type="checkbox" wire:model="require_payment"
                    class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft">
                <label for="default-checkbox" class="select-none ms-2 text-sm font-medium text-heading">
                    Require Payment
                </label>
            </div>

            @if ($require_payment)
                <div class="flex flex-col mb-5">
                    <label for="payment_amount" class="block mb-2.5 text-sm font-medium text-heading">
                        Payment Amount
                    </label>
                    <input type="number" id="payment_amount" wire:model="payment_amount" step="0.01"
                        min="0"
                        class="block w-full px-3 py-2.5 bg-white border border-gray-300 rounded-md shadow-sm text-heading text-sm focus:ring-brand focus:border-brand placeholder:text-body"
                        placeholder="Enter amount (e.g., 50.00)" />
                    @error('payment_amount')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            @endif

            <div class="mb-5 flex gap-2">
                <button type="button" wire:click="closeCreateModal"
                    class="w-1/2 px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">
                    Cancel
                </button>
                <button type="submit"
                    class="w-1/2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                    Publish Event
                </button>
            </div>
        </form>
    </x-custom-modal>

    <!-- Edit Event Modal -->
    <x-custom-modal model="showEditModal">
        <h1 class="text-xl text-center font-bold mb-4">Edit Event</h1>
        @if (session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        <form wire:submit.prevent="updateEvent" class="max-w-md mx-auto">
            <!-- Form fields (same as your existing edit modal) -->
            <!-- You can copy the form from your existing edit modal -->
            <div class="mb-5">
                <label for="edit_title" class="block mb-2.5 text-sm font-medium text-heading">Event
                    Title</label>
                <input type="text" id="edit_title" wire:model="title"
                    class="w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    placeholder="Enter Event Title...">
                @error('title')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex flex-col mb-5">
                <h3 class="font-medium text-gray-700 mb-2">Event Date and Time</h3>
                <div class="flex flex-row gap-2">
                    <div class="w-1/2">
                        <input type="date" wire:model="date"
                            class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('date')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-1/2">
                        <input type="time" wire:model="time"
                            class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('time')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex flex-col mb-5">
                <h2 class="font-medium text-gray-700 mb-2">Event Type</h2>
                <select wire:model="type"
                    class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Select Type</option>
                    <option value="online">Online</option>
                    <option value="face-to-face">Face-to-face</option>
                </select>
                @error('type')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror

                <h3 class="font-medium text-gray-700 mt-3 mb-2">Event Place or Link</h3>
                <input type="text" wire:model="place_link"
                    class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    placeholder="Enter Event Place or Link...">
                @error('place_link')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col mb-5">
                <h2 class="font-medium text-gray-700 mb-2">Event Category</h2>
                <select wire:model="category"
                    class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Select Category</option>
                    <option value="academic">Academic</option>
                    <option value="sports">Sports</option>
                    <option value="cultural">Cultural</option>
                </select>
                @error('category')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <!-- Add this in BOTH create and edit modals, after the payment amount section -->
            <!-- Visibility Section -->
            <div class="flex flex-col mb-5">
                <h2 class="font-medium text-gray-700 mb-2">Event Visibility</h2>
                <select wire:model="visibility_type"
                    class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="all">Visible to All Students</option>
                    <option value="grade_level">Specific Grade Levels</option>
                    <option value="shs_strand">Specific SHS Strands</option>
                    <option value="year_level">Specific Year Levels</option>
                    <option value="college_program">Specific College Programs</option>
                </select>
                @error('visibility_type')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            @if ($visibility_type === 'grade_level')
                <div class="flex flex-col mb-5">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Select Grade Levels</label>
                    <div class="space-y-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="visible_to_grade_level" value="11"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Grade 11</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="visible_to_grade_level" value="12"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Grade 12</span>
                        </label>
                    </div>
                </div>
            @endif

            @if ($visibility_type === 'shs_strand')
                <div class="flex flex-col mb-5">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Select SHS Strands</label>
                    <div class="space-y-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="visible_to_shs_strand" value="ABM"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">ABM</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="visible_to_shs_strand" value="HUMSS"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">HUMSS</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="visible_to_shs_strand" value="GAS"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">GAS</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="visible_to_shs_strand" value="ICT"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">ICT</span>
                        </label>
                    </div>
                </div>
            @endif

            @if ($visibility_type === 'year_level')
                <div class="flex flex-col mb-5">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Select Year Levels</label>
                    <div class="space-y-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <label class="inline-flex items-center">
                                <input type="checkbox" wire:model="visible_to_year_level"
                                    value="{{ $i }}"
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Year {{ $i }}</span>
                            </label>
                        @endfor
                    </div>
                </div>
            @endif

            @if ($visibility_type === 'college_program')
                <div class="flex flex-col mb-5">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Select College Programs</label>
                    <div class="space-y-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="visible_to_college_program" value="BSIT"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">BSIT</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="visible_to_college_program" value="BSBA"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">BSBA</span>
                        </label>
                    </div>
                </div>
            @endif

            <div class="flex flex-col mb-5">
                <h2 class="font-medium text-gray-700 mb-2">Event Description</h2>
                <textarea wire:model="description" rows="3"
                    class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    placeholder="Enter Event Description..."></textarea>
                @error('description')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col mb-5">
                <h2 class="font-medium text-gray-700 mb-2">Event Banner</h2>

                @if ($editingEvent && $editingEvent->banner && !$banner)
                    <div class="mb-3">
                        <p class="text-sm text-gray-600 mb-2">Current Banner:</p>
                        <img src="{{ asset('storage/' . $editingEvent->banner) }}" alt="Current Banner"
                            class="w-full h-48 object-cover rounded-lg border border-gray-300">
                    </div>
                @endif

                <div class="flex items-center justify-center w-full">
                    <label for="dropzone-file-edit"
                        class="flex flex-col items-center justify-center w-full h-32 bg-neutral-secondary-medium border border-dashed border-default-strong rounded-base cursor-pointer hover:bg-neutral-tertiary-medium">
                        <div class="flex flex-col items-center justify-center text-body">
                            <svg class="w-8 h-8 mb-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 17h3a3 3 0 0 0 0-6h-.025a5.56 5.56 0 0 0 .025-.5A5.5 5.5 0 0 0 7.207 9.021C7.137 9.017 7.071 9 7 9a4 4 0 1 0 0 8h2.167M12 19v-9m0 0-2 2m2-2 2 2" />
                            </svg>
                            <p class="mb-1 text-sm">
                                <span class="font-semibold">Click to upload</span> or drag and drop
                            </p>
                            <p class="text-xs">JPG or PNG (MAX. 2MB)</p>
                        </div>
                        <input id="dropzone-file-edit" type="file" class="hidden" wire:model="banner" />
                    </label>
                </div>
                @error('banner')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
                @if ($banner)
                    <p class="text-xs text-green-600 mt-1">New file selected:
                        {{ $banner->getClientOriginalName() }}</p>
                @endif
            </div>

            <div class="flex items-center mb-5">
                <input id="default-checkbox" type="checkbox" wire:model="require_payment"
                    class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft">
                <label for="default-checkbox" class="select-none ms-2 text-sm font-medium text-heading">
                    Require Payment
                </label>
            </div>

            @if ($require_payment)
                <div class="flex flex-col mb-5">
                    <label for="payment_amount" class="block mb-2.5 text-sm font-medium text-heading">
                        Payment Amount
                    </label>
                    <input type="number" id="payment_amount" wire:model="payment_amount" step="0.01"
                        min="0"
                        class="block w-full px-3 py-2.5 bg-white border border-gray-300 rounded-md shadow-sm text-heading text-sm focus:ring-brand focus:border-brand placeholder:text-body"
                        placeholder="Enter amount (e.g., 50.00)" />
                    @error('payment_amount')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            @endif

            <div class="mb-5 flex gap-2">
                <button type="button" wire:click="closeEditModal"
                    class="w-1/2 px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">
                    Cancel
                </button>
                <button type="submit"
                    class="w-1/2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                    Update Event
                </button>
            </div>
        </form>
    </x-custom-modal>

    <!-- Event Details Modal -->
    <x-custom-modal model="showEventDetailsModal">
        @if ($selectedEvent)
            <div class="max-w-2xl mx-auto bg-white rounded-lg">
                <!-- Banner Section -->
                <div class="mb-6">
                    @if ($selectedEvent->banner)
                        <img src="{{ asset('storage/' . $selectedEvent->banner) }}"
                            alt="{{ $selectedEvent->title }}"
                            class="w-full h-48 object-cover rounded-t-lg">
                    @else
                        <div class="w-full h-48 bg-gray-200 rounded-t-lg flex items-center justify-center">
                            <div class="text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-sm">No banner available</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Content Section -->
                <div class="px-6 pb-6">
                    <!-- Event Title -->
                    <h1 class="text-2xl font-bold text-gray-800 mb-4 text-center">{{ $selectedEvent->title }}</h1>
                    
                    <!-- Creator Info -->
                    <div class="flex items-center justify-center mb-4">
                        <span class="text-gray-600">
                            Created by: <strong>{{ $selectedEvent->creator->first_name ?? 'Unknown' }} {{ $selectedEvent->creator->last_name ?? '' }}</strong>
                        </span>
                    </div>

                    <!-- Event Description -->
                    <p class="text-gray-600 text-center mb-6 leading-relaxed">{{ $selectedEvent->description }}</p>

                    <!-- Divider -->
                    <div class="border-t border-gray-300 my-6"></div>

                    <!-- Event Details -->
                    <div class="space-y-4 mb-6">
                        <!-- Date -->
                        <div>
                            <h3 class="font-semibold text-gray-700 mb-1">Date</h3>
                            <p class="text-gray-600">{{ $selectedEvent->date->format('F j, Y') }}</p>
                        </div>

                        <!-- Time -->
                        <div>
                            <h3 class="font-semibold text-gray-700 mb-1">Time</h3>
                            <p class="text-gray-600">{{ \Carbon\Carbon::parse($selectedEvent->time)->format('g:i A') }}</p>
                        </div>

                        <!-- Location/Link -->
                        <div>
                            <h3 class="font-semibold text-gray-700 mb-1">
                                {{ $selectedEvent->type === 'online' ? 'Event Link' : 'Location' }}
                            </h3>
                            <p class="text-gray-600 break-words">
                                @if ($selectedEvent->type === 'online' && filter_var($selectedEvent->place_link, FILTER_VALIDATE_URL))
                                    <a href="{{ $selectedEvent->place_link }}" target="_blank"
                                        class="text-blue-600 hover:underline">
                                        {{ $selectedEvent->place_link }}
                                    </a>
                                @else
                                    {{ $selectedEvent->place_link }}
                                @endif
                            </p>
                        </div>

                        <!-- Event Type -->
                        <div>
                            <h3 class="font-semibold text-gray-700 mb-1">Event Type</h3>
                            <p class="text-gray-600 capitalize">{{ str_replace('-', ' ', $selectedEvent->type) }}</p>
                        </div>

                        <!-- Category -->
                        <div>
                            <h3 class="font-semibold text-gray-700 mb-1">Category</h3>
                            <p class="text-gray-600 capitalize">{{ $selectedEvent->category }}</p>
                        </div>

                        <!-- Visibility -->
                        <div>
                            <h3 class="font-semibold text-gray-700 mb-1">Visibility</h3>
                            <p class="text-gray-600">
                                @if($selectedEvent->visibility_type === 'all')
                                    <span class="text-green-600 font-semibold">Visible to all students</span>
                                @else
                                    <span class="text-indigo-600 font-semibold">Restricted to specific groups</span>
                                @endif
                            </p>
                        </div>

                        <!-- Payment Information -->
                        <div>
                            <h3 class="font-semibold text-gray-700 mb-1">Payment</h3>
                            <p class="text-gray-600">
                                @if ($selectedEvent->require_payment)
                                    <span class="text-red-600 font-semibold">
                                        Paid Event - ₱{{ number_format($selectedEvent->payment_amount, 2) }}
                                    </span>
                                @else
                                    <span class="text-green-600 font-semibold">Free Event</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 pt-4 border-t border-gray-200">
                        <button type="button" wire:click="closeEventDetailsModal"
                            class="flex-1 px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors font-medium">
                            Close
                        </button>
                        <button type="button" wire:click="openEditModal({{ $selectedEvent->id }})"
                            class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                            Edit Event
                        </button>
                    </div>
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