<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <x-dashboard-sidebar />

    <!-- Main Content -->
    <div class="flex-1 overflow-y-auto overflow-x-hidden">
        <!-- Header -->
        <x-dashboard-header userRole="Admin" :userInitials="$userInitials" />

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <!-- Header -->
            <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Archived Events</h1>
                    <p class="text-gray-600">View and manage all archived events in the system</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.events') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Active Events
                    </a>
                    <button wire:click="openExportModal"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Export
                    </button>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="mb-6 bg-white rounded-lg shadow p-4">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
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
                                placeholder="Search archived events...">
                        </div>
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

                    <!-- Type Filter -->
                    <div>
                        <select wire:model.live="filterType"
                            class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Types</option>
                            <option value="online">Online</option>
                            <option value="face-to-face">Face-to-Face</option>
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
                </div>
            </div>

            <!-- Events Table -->
            @if(count($events) > 0)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Event Name
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Creator
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date & Time
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Category & Type
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Payment
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Registrations
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Archived On
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($events as $event)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                @if($event->banner)
                                                    <div class="flex-shrink-0 h-10 w-10 mr-3">
                                                        <img class="h-10 w-10 rounded-full object-cover" 
                                                             src="{{ asset('storage/' . $event->banner) }}" 
                                                             alt="{{ $event->title }}">
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">{{ $event->title }}</div>
                                                    <div class="text-xs text-gray-500">{{ Str::limit($event->description, 50) }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $event->creator->first_name ?? 'Unknown' }} {{ $event->creator->last_name ?? '' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $event->date->format('M d, Y') }}</div>
                                            <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-col gap-1">
                                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 w-fit">
                                                    {{ ucfirst($event->category) }}
                                                </span>
                                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800 w-fit">
                                                    {{ ucfirst(str_replace('-', ' ', $event->type)) }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($event->require_payment)
                                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 font-semibold">
                                                    ₱{{ number_format($event->payment_amount, 2) }}
                                                </span>
                                            @else
                                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                                    Free
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $event->registrations_count }}</div>
                                            <div class="text-xs text-gray-500">registrations</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $event->archived_at->format('M d, Y') }}</div>
                                            <div class="text-xs text-gray-500">{{ $event->archived_at->format('g:i A') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
    <div class="flex space-x-2">
        <button wire:click="confirmRestore({{ $event->id }})"
            class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs font-medium inline-flex items-center gap-1 transition-colors">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            Restore
        </button>
        <button wire:click="confirmDelete({{ $event->id }})"
            class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs font-medium inline-flex items-center gap-1 transition-colors">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            Delete
        </button>
    </div>
</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $events->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12 bg-white rounded-lg shadow">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No archived events</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        All events are currently active.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('admin.events') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            View Active Events
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Export Modal -->
    <!-- Enhanced Export Modal -->
<x-custom-modal 
    model="showExportModal" 
    maxWidth="lg" 
    title="Export Archived Events" 
    description="Export archived events data with current filters" 
    headerBg="green"
>
    <div class="space-y-6">
        <!-- Current Filters Summary Card -->
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-5 rounded-xl border border-green-200">
            <div class="flex items-center space-x-2 mb-3">
                <div class="p-1.5 bg-green-200 rounded-lg">
                    <svg class="w-4 h-4 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
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
                </div>
            </div>
            
            <!-- Total Records Badge -->
            <div class="mt-3 pt-3 border-t border-green-200">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-green-700">Events to export:</span>
                    <span class="px-3 py-1 bg-green-200 text-green-800 rounded-full text-sm font-semibold">
                        {{ count($events) }} events
                    </span>
                </div>
            </div>
        </div>

        <!-- Export Format Selection -->
        <div class="space-y-3">
            <label class="flex items-center space-x-2 text-sm font-semibold text-green-800">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
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
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                                    <path d="M14 2v6h6M8 13h8M8 17h4" stroke="white" stroke-width="2"/>
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
                            <div class="p-3 bg-green-100 rounded-full mb-2">
                                <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
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

        <!-- Export Options -->
        <div class="grid grid-cols-2 gap-4 p-4 bg-gray-50 rounded-xl border-2 border-gray-100">
            <label class="flex items-center space-x-3 cursor-pointer">
                <input type="checkbox" wire:model="includeEventDetails" class="w-5 h-5 text-green-600 border-2 border-gray-300 rounded-lg focus:ring-green-500 focus:ring-2">
                <span class="text-sm font-medium text-gray-700">Include descriptions</span>
            </label>
            <label class="flex items-center space-x-3 cursor-pointer">
                <input type="checkbox" wire:model="includeRegistrationData" class="w-5 h-5 text-green-600 border-2 border-gray-300 rounded-lg focus:ring-green-500 focus:ring-2">
                <span class="text-sm font-medium text-gray-700">Include registration counts</span>
            </label>
        </div>

        <!-- Date Range (Optional) -->
        <div class="space-y-3">
            <label class="flex items-center space-x-2 text-sm font-semibold text-green-800">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span>Archive Date Range (Optional)</span>
            </label>
            <div class="grid grid-cols-2 gap-3">
                <input type="date" wire:model="dateFrom" 
                    class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-200"
                    placeholder="From">
                <input type="date" wire:model="dateTo"
                    class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-200"
                    placeholder="To">
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex space-x-3 pt-4 border-t-2 border-gray-100">
            <button type="button" wire:click="closeExportModal"
                class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Cancel</span>
            </button>
            <button type="button" wire:click="exportArchivedEvents"
                class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group shadow-lg shadow-green-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                <span>Export {{ strtoupper($exportFormat) }}</span>
            </button>
        </div>
    </div>
</x-custom-modal>

<!-- Restore Confirmation Modal -->
<x-confirmation-modal 
    model="showRestoreConfirmation"
    title="Restore Event"
    :message="'Are you sure you want to restore the event &quot;' . $selectedEventTitle . '&quot;? This will make it active again.'"
    confirmButtonText="Yes, Restore"
    confirmButtonColor="green"
/>

<!-- Delete Confirmation Modal -->
<x-confirmation-modal 
    model="showDeleteConfirmation"
    title="Permanently Delete Event"
    :message="'Are you sure you want to permanently delete &quot;' . $selectedEventTitle . '&quot;? This action cannot be undone.'"
    confirmButtonText="Yes, Delete Permanently"
    confirmButtonColor="red"
/>

    <!-- Success Messages -->
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="fixed bottom-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-lg">
            {{ session('success') }}
        </div>
    @endif
</div>