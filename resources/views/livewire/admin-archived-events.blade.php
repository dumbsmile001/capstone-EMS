<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <x-dashboard-sidebar />

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
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
                                                <button wire:click="unarchiveEvent({{ $event->id }})"
                                                    wire:confirm="Are you sure you want to restore this event?"
                                                    class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs font-medium">
                                                    Restore
                                                </button>
                                                <button wire:click="deleteArchivedEvent({{ $event->id }})"
                                                    wire:confirm="Are you sure you want to permanently delete this event? This action cannot be undone."
                                                    class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs font-medium">
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
    <x-custom-modal model="showExportModal">
        <div class="max-w-md mx-auto p-6">
            <h1 class="text-xl text-center font-bold mb-2">Export Archived Events</h1>
            <p class="text-center text-gray-600 mb-6">Export archived events data to Excel or CSV format.</p>
            
            <div class="mb-6">
                <p class="text-sm text-gray-700 mb-2">Current filters applied:</p>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li>• Search: {{ $search ?: 'None' }}</li>
                    <li>• Category: {{ $filterCategory ? ucfirst($filterCategory) : 'All' }}</li>
                    <li>• Type: {{ $filterType ? ucfirst($filterType) : 'All' }}</li>
                    <li>• Creator: {{ $filterCreator && isset($creators[$filterCreator]) ? $creators[$filterCreator] : 'All' }}</li>
                </ul>
            </div>
            
            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-gray-700">Export Format</label>
                <div class="flex space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" wire:model="exportFormat" value="xlsx" 
                            class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Excel (.xlsx)</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" wire:model="exportFormat" value="csv" 
                            class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">CSV (.csv)</span>
                    </label>
                </div>
            </div>
            
            <div class="flex gap-3">
                <button type="button" wire:click="closeExportModal" 
                    class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors font-medium">
                    Cancel
                </button>
                <button type="button" wire:click="exportArchivedEvents" 
                    class="flex-1 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors font-medium">
                    Export {{ strtoupper($exportFormat) }}
                </button>
            </div>
        </div>
    </x-custom-modal>

    <!-- Success Messages -->
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="fixed bottom-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-lg">
            {{ session('success') }}
        </div>
    @endif
</div>