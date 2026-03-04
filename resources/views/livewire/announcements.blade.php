<div class="flex min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="fixed left-0 top-0 h-screen z-40">
        <x-dashboard-sidebar />
    </div>

    <!-- Main Content -->
    <div class="flex-1 lg:ml-64">
        <div class="fixed top-0 right-0 left-0 lg:left-64 z-30">
            <x-dashboard-header userRole="Organizer" :userInitials="$userInitials" />
        </div>

        <!-- Announcements Content -->
        <div class="px-4 sm:px-6 lg:px-8 py-8 mt-20 lg:mt-24">
            <!-- Header Section with Stats -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <div class="h-10 w-2 bg-gradient-to-b from-green-600 to-green-500 rounded-full"></div>
                            <h1 class="text-3xl font-bold text-gray-800">Announcements</h1>
                        </div>
                        <p class="mt-2 text-gray-600">Keep everyone informed and engaged with important updates</p>
                    </div>
                    
                    <!-- Quick Stats -->
                    <div class="mt-4 md:mt-0 flex gap-4">
                        <div class="bg-white/60 backdrop-blur-sm rounded-2xl px-6 py-3 shadow-sm border border-gray-200">
                            <p class="text-sm text-gray-500">Total Announcements</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalCount }}</p>
                        </div>
                        <div class="bg-white/60 backdrop-blur-sm rounded-2xl px-6 py-3 shadow-sm border border-gray-200">
                            <p class="text-sm text-gray-500">This Month</p>
                            <p class="text-2xl font-bold text-blue-600">{{ $thisMonthCount }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Filters & Search Bar -->
<div class="mb-8 bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Search Bar - Enhanced -->
        <div class="flex-1">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Search Announcements</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search by title or description..." 
                    class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 text-gray-700 placeholder-gray-400"
                >
                @if($search)
                    <button 
                        wire:click="$set('search', '')"
                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                @endif
            </div>
            @if($search)
                <p class="mt-2 text-sm text-gray-500">
                    Searching for: <span class="font-semibold text-blue-600">"{{ $search }}"</span>
                </p>
            @endif
        </div>

        <!-- Filter Controls - Enhanced -->
        <div class="flex flex-col sm:flex-row gap-4">
            <!-- Category Filter -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                <div class="relative">
                    <select 
                        wire:model.live="categoryFilter"
                        class="appearance-none w-full pl-4 pr-10 py-4 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 bg-white text-gray-700 font-medium transition-all duration-200 cursor-pointer hover:border-gray-300"
                    >
                        <option value="">All Categories</option>
                        <option value="general" class="text-blue-600">📢 General</option>
                        <option value="event" class="text-green-600">🎉 Events</option>
                        <option value="reminder" class="text-yellow-600">⏰ Reminders</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Sort Direction -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Sort By</label>
                <div class="relative">
                    <select 
                        wire:model.live="sortDirection"
                        class="appearance-none w-full pl-4 pr-10 py-4 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 bg-white text-gray-700 font-medium transition-all duration-200 cursor-pointer hover:border-gray-300"
                    >
                        <option value="desc">⬇️ Latest First</option>
                        <option value="asc">⬆️ Oldest First</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Clear Filters Button (Enhanced) -->
            @if($search || $categoryFilter || $sortDirection != 'desc')
                <div class="flex items-end">
                    <button 
                        wire:click="clearFilters"
                        class="px-6 py-4 bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 rounded-xl hover:from-gray-200 hover:to-gray-300 transition-all duration-200 flex items-center gap-2 font-medium shadow-sm hover:shadow border border-gray-300"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Clear Filters
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Active Filters Pills (Enhanced) -->
    @if($search || $categoryFilter)
        <div class="mt-4 pt-4 border-t border-gray-100">
            <div class="flex flex-wrap items-center gap-2">
                <span class="text-sm text-gray-500">Active filters:</span>
                @if($search)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-sm border border-blue-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        "{{ $search }}"
                        <button wire:click="$set('search', '')" class="hover:text-blue-900">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </span>
                @endif
                @if($categoryFilter)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 
                        @switch($categoryFilter)
                            @case('event') bg-green-50 text-green-700 border-green-200 @break
                            @case('reminder') bg-yellow-50 text-yellow-700 border-yellow-200 @break
                            @default bg-blue-50 text-blue-700 border-blue-200
                        @endswitch
                        rounded-lg text-sm border">
                        @switch($categoryFilter)
                            @case('event') 🎉 @break
                            @case('reminder') ⏰ @break
                            @default 📢
                        @endswitch
                        {{ ucfirst($categoryFilter) }}
                        <button wire:click="$set('categoryFilter', '')" class="hover:text-current opacity-60 hover:opacity-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </span>
                @endif
            </div>
        </div>
    @endif
</div>

            <!-- Main Content Grid - Reordered for mobile -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Sidebar - Takes 1/3 of the space on desktop, appears first on mobile -->
                <div class="lg:col-span-1 order-first lg:order-1 space-y-6">
                    <!-- Create Announcement Card (for authorized users) -->
                    @role(['admin', 'organizer'])
                    <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl shadow-lg p-6 text-white">
                        <h3 class="text-lg font-semibold mb-2">Create New Announcement</h3>
                        <p class="text-blue-100 text-sm mb-4">Share important updates with your team or audience</p>
                        <button 
                            wire:click="openAnnouncementModal" 
                            class="w-full bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white font-medium py-3 px-4 rounded-xl transition-all duration-200 flex items-center justify-center gap-2 group"
                        >
                            <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            New Announcement
                        </button>
                    </div>
                    @endrole

                    <!-- Quick Stats Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Overview</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                                <span class="text-gray-600">General</span>
                                <span class="font-semibold text-gray-900">{{ $generalCount }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                                <span class="text-gray-600">Events</span>
                                <span class="font-semibold text-green-600">{{ $eventCount }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                                <span class="text-gray-600">Reminders</span>
                                <span class="font-semibold text-yellow-600">{{ $reminderCount }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Active Filters Card (shown when filters are applied) -->
                    @if($search || $categoryFilter)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Active Filters</h3>
                        <div class="space-y-2">
                            @if($search)
                                <div class="flex items-center justify-between p-2 bg-blue-50 text-blue-700 rounded-lg">
                                    <span class="text-sm">Search: "{{ $search }}"</span>
                                    <button wire:click="$set('search', '')" class="hover:text-blue-900">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            @endif
                            @if($categoryFilter)
                                <div class="flex items-center justify-between p-2 bg-green-50 text-green-700 rounded-lg">
                                    <span class="text-sm">Category: {{ ucfirst($categoryFilter) }}</span>
                                    <button wire:click="$set('categoryFilter', '')" class="hover:text-green-900">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Announcements Feed - Takes 2/3 of the space on desktop, appears second on mobile -->
                <div class="lg:col-span-2 order-last lg:order-2">
                    <x-announcements-feed 
                        :announcements="$announcements"
                    />
                </div>
            </div>
        </div>
    </div>

    <!-- Global Modals - Moved outside the main content flow but still within the Livewire component -->
    
    <!-- Create/Edit Modal -->
    <x-custom-modal 
        model="showAnnouncementModal" 
        maxWidth="lg"
        :title="$editingId ? 'Edit Announcement' : 'Create New Announcement'"
        description="{{ $editingId ? 'Update your announcement details below' : 'Fill in the details below to create a new announcement' }}"
        headerBg="{{ $editingId ? 'yellow' : 'blue' }}"
    >
        <form wire:submit.prevent="saveAnnouncement" class="space-y-6">
            @if (session()->has('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif
            
            @if (session()->has('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                    {{ session('error') }}
                </div>
            @endif
            
            <!-- Title Field -->
            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                    Announcement Title
                    <span class="text-xs font-normal text-gray-500 ml-2">e.g., Important Update, Event Reminder</span>
                </label>
                <input 
                    type="text" 
                    id="title" 
                    wire:model="title" 
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                    placeholder="Enter announcement title..."
                    required 
                />
                @error('title') 
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category Field -->
            <div>
                <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">
                    Category
                </label>
                <select 
                    id="category" 
                    wire:model="category" 
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                >
                    <option value="general">General Announcement</option>
                    <option value="event">Event Announcement</option>
                    <option value="reminder">Reminder</option>
                </select>
                @error('category') 
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description Field -->
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                    Description
                </label>
                <textarea 
                    id="description" 
                    wire:model="description" 
                    rows="5" 
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 resize-none"
                    placeholder="Write your announcement content here..."
                    required
                ></textarea>
                @error('description') 
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex gap-3 pt-4">
                <button 
                    type="submit" 
                    class="flex-1 px-6 py-3 font-medium rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all duration-200 transform hover:scale-[1.02] 
                        @if($editingId)
                            bg-yellow-600 text-white hover:bg-yellow-700 focus:ring-yellow-500
                        @else
                            bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500
                        @endif"
                >
                    {{ $editingId ? 'Update Announcement' : 'Publish Announcement' }}
                </button>
                <button 
                    type="button" 
                    wire:click="closeAnnouncementModal" 
                    class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition-all duration-200"
                >
                    Cancel
                </button>
            </div>
        </form>
    </x-custom-modal>

    <!-- Delete Confirmation Modal -->
    <x-custom-modal 
        model="showDeleteModal" 
        maxWidth="md"
        title="Delete Announcement"
        description="This action cannot be undone"
        headerBg="red"
        :showCloseButton="true"
    >
        <div class="text-center py-2">
            <!-- Warning Icon -->
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.928-.833-2.698 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
            
            <!-- Confirmation Message -->
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Are you absolutely sure?</h3>
            <p class="text-sm text-gray-500 mb-4">
                This will permanently delete this announcement and remove all associated data.
            </p>
            
            <!-- Announcement Details -->
            @if($announcementToDelete)
                <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left">
                    <p class="text-xs text-gray-500 mb-1">Announcement:</p>
                    <p class="font-medium text-gray-900">"{{ $announcementToDelete->title }}"</p>
                    @if($announcementToDelete->category)
                        <span class="inline-block mt-2 px-2 py-1 text-xs font-semibold rounded 
                            @switch($announcementToDelete->category)
                                @case('event') bg-green-100 text-green-800 @break
                                @case('reminder') bg-yellow-100 text-yellow-800 @break
                                @default bg-blue-100 text-blue-800
                            @endswitch">
                            {{ ucfirst($announcementToDelete->category) }}
                        </span>
                    @endif
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex gap-3">
                <button 
                    wire:click="deleteAnnouncement" 
                    class="flex-1 px-4 py-3 bg-red-600 text-white font-medium rounded-xl hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200"
                >
                    Confirm Delete
                </button>
                <button 
                    wire:click="closeDeleteModal" 
                    class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition-all duration-200"
                >
                    Cancel
                </button>
            </div>
        </div>
    </x-custom-modal>
</div>