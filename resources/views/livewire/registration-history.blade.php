<div>
    <!-- Success/Info Messages -->
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

    <!-- Main Container -->
    <div class="bg-white rounded-lg shadow-md p-1.5">
        <div class="overflow-x-auto">
            <div class="relative bg-gradient-to-br from-blue-50 to-yellow-50 shadow-xs rounded-xl border border-green-100">
                
                <!-- Search and Filter Controls -->
                <div class="p-5 bg-white/80 backdrop-blur-sm border-b border-green-100 rounded-t-xl">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="text-lg font-semibold text-green-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Registration History
                        </h3>
                    </div>

                    <!-- Filter Grid -->
                    <div class="space-y-4">
                        <!-- First Row -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                            <!-- Search Box - Expanded -->
                            <div class="md:col-span-2">
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-green-400 group-focus-within:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" wire:model.live.debounce.300ms="search"
                                        class="block w-full pl-10 pr-4 py-2.5 text-sm border-2 border-green-200 rounded-xl bg-white focus:border-emerald-400 focus:ring-2 focus:ring-emerald-200 transition-all duration-200 group-hover:border-green-300"
                                        placeholder="Search by event name...">
                                </div>
                            </div>

                            <!-- Category Filter -->
                            <div>
                                <select wire:model.live="filterCategory"
                                    class="block w-full px-3 py-2.5 text-sm border-2 border-green-200 rounded-xl bg-white focus:border-emerald-400 focus:ring-2 focus:ring-emerald-200 transition-all duration-200 hover:border-green-300">
                                    <option value="">🏷️ All Categories</option>
                                    @foreach ($availableCategories as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status Filter -->
                            <div>
                                <select wire:model.live="filterStatus"
                                    class="block w-full px-3 py-2.5 text-sm border-2 border-green-200 rounded-xl bg-white focus:border-emerald-400 focus:ring-2 focus:ring-emerald-200 transition-all duration-200 hover:border-green-300">
                                    <option value="">📊 All Status</option>
                                    <option value="registered">Registered</option>
                                    <option value="attended">Attended</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                        </div>

                        <!-- Second Row -->
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
                            <!-- Results Per Page -->
                            <div>
                                <select wire:model.live="perPage"
                                    class="block w-full px-3 py-2.5 text-sm border-2 border-green-200 rounded-xl bg-white focus:border-emerald-400 focus:ring-2 focus:ring-emerald-200 transition-all duration-200 hover:border-green-300">
                                    <option value="10">📄 10 per page</option>
                                    <option value="25">📄 25 per page</option>
                                    <option value="50">📄 50 per page</option>
                                    <option value="100">📄 100 per page</option>
                                </select>
                            </div>

                            <!-- Reset Filters Button - spans 4 columns -->
                            <div class="md:col-span-4">
                                <button wire:click="resetFilters"
                                    class="w-full px-4 py-2.5 text-sm font-medium text-green-700 bg-green-50 border-2 border-green-200 rounded-xl hover:bg-emerald-50 hover:border-emerald-400 hover:text-emerald-700 focus:ring-2 focus:ring-emerald-200 transition-all duration-200 flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Reset All Filters
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Registrations Table -->
                <div class="overflow-x-auto">
                    @if ($registrations->count() > 0)
                        <table class="min-w-full divide-y divide-green-100">
                            <thead class="bg-gradient-to-r from-green-600 to-emerald-700">
                                <tr>
                                    <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Event Name</th>
                                    <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Category</th>
                                    <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Event Date</th>
                                    <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Registration Date</th>
                                    <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-green-50">
                                @foreach ($registrations as $index => $registration)
                                    <tr class="{{ $index % 2 === 0 ? 'bg-white hover:bg-green-50' : 'bg-green-50/30 hover:bg-green-100' }} transition-colors duration-150 group">
                                        <td class="px-4 py-3">
                                            <div class="flex flex-col">
                                                <span class="text-sm font-medium text-gray-900">{{ $registration->event->title }}</span>
                                            </div>
                                        </td>

                                        <td class="px-4 py-3">
                                            <span class="text-sm text-gray-600 capitalize">{{ $registration->event->category }}</span>
                                        </td>

                                        <td class="px-4 py-3">
                                            <div class="flex flex-col">
                                                <span class="text-sm text-gray-900">
                                                    {{ \Carbon\Carbon::parse($registration->event->start_date)->format('F j, Y') }}
                                                </span>
                                                @if($registration->event->start_date != $registration->event->end_date)
                                                    <span class="text-xs text-gray-500">
                                                        to {{ \Carbon\Carbon::parse($registration->event->end_date)->format('F j, Y') }}
                                                    </span>
                                                @endif
                                                <span class="text-xs text-gray-400 mt-1">
                                                    {{ \Carbon\Carbon::parse($registration->event->start_time)->format('g:i A') }} - 
                                                    {{ \Carbon\Carbon::parse($registration->event->end_time)->format('g:i A') }}
                                                </span>
                                            </div>
                                        </td>

                                        <td class="px-4 py-3">
                                            <span class="text-sm text-gray-600 font-medium">
                                                {{ \Carbon\Carbon::parse($registration->registered_at)->format('F j, Y') }}
                                            </span>
                                        </td>

                                        <td class="px-4 py-3">
                                            @if($registration->status === 'registered')
                                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-lg text-xs font-medium">Registered</span>
                                            @elseif($registration->status === 'attended')
                                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-lg text-xs font-medium">Attended</span>
                                            @elseif($registration->status === 'cancelled')
                                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-lg text-xs font-medium">Cancelled</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($registrations && method_exists($registrations, 'links'))
                        <div class="px-4 py-4 bg-white/80 backdrop-blur-sm border-t border-green-100 rounded-b-xl">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-green-700">
                                    Showing <span class="font-semibold">{{ $registrations->firstItem() }}</span>
                                    to <span class="font-semibold">{{ $registrations->lastItem() }}</span>
                                    of <span class="font-semibold">{{ $registrations->total() }}</span> results
                                </div>

                                <div class="flex items-center space-x-2">
                                    @if ($registrations->onFirstPage())
                                        <span class="px-3 py-2 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                            </svg>
                                        </span>
                                    @else
                                        <button wire:click="previousPage"
                                            class="px-3 py-2 bg-white text-green-600 border-2 border-green-200 rounded-lg hover:bg-emerald-400 hover:text-white hover:border-emerald-400 transition-all duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                            </svg>
                                        </button>
                                    @endif

                                    @foreach ($registrations->getUrlRange(max(1, $registrations->currentPage() - 2), min($registrations->lastPage(), $registrations->currentPage() + 2)) as $page => $url)
                                        <button wire:click="gotoPage({{ $page }})"
                                            class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 
                                                {{ $page === $registrations->currentPage()
                                                    ? 'bg-gradient-to-r from-green-600 to-emerald-700 text-white shadow-md shadow-green-200'
                                                    : 'bg-white text-green-700 border-2 border-green-200 hover:bg-emerald-400 hover:text-white hover:border-emerald-400' }}">
                                            {{ $page }}
                                        </button>
                                    @endforeach

                                    @if ($registrations->hasMorePages())
                                        <button wire:click="nextPage"
                                            class="px-3 py-2 bg-white text-green-600 border-2 border-green-200 rounded-lg hover:bg-emerald-400 hover:text-white hover:border-emerald-400 transition-all duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                    @else
                                        <span class="px-3 py-2 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <!-- Empty State -->
                    <div class="px-4 py-12 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-16 h-16 mb-4 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-lg font-medium text-green-800">No registration history found</p>
                            <p class="text-sm text-green-600 mt-1">
                                @if ($search || $filterCategory || $filterStatus)
                                    Try adjusting your search or filters
                                @else
                                    You haven't registered for any events yet
                                @endif
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>