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

    @if (session()->has('info'))
        <div class="mb-4 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded">
            {{ session('info') }}
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
                            Event Registrations
                        </h3>
                        <button wire:click="openExportModal"
                            class="px-4 py-2 bg-gradient-to-r from-green-600 to-green-800 text-white rounded-lg hover:from-green-500 hover:to-green-600 transition-all duration-200 text-sm font-medium flex items-center gap-2 shadow-md shadow-green-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Export to Excel/CSV
                        </button>
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
                                        placeholder="Search by student name, email, or ID...">
                                </div>
                            </div>

                            <!-- Event Filter -->
                            <div>
                                <select wire:model.live="filterEvent"
                                    class="block w-full px-3 py-2.5 text-sm border-2 border-green-200 rounded-xl bg-white focus:border-emerald-400 focus:ring-2 focus:ring-emerald-200 transition-all duration-200 hover:border-green-300 appearance-none cursor-pointer">
                                    <option value="">📋 All Events</option>
                                    @foreach ($availableEvents as $id => $title)
                                        <option value="{{ $id }}">{{ Str::limit($title, 25) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Payment Status Filter -->
                            <div>
                                <select wire:model.live="filterPaymentStatus"
                                    class="block w-full px-3 py-2.5 text-sm border-2 border-green-200 rounded-xl bg-white focus:border-emerald-400 focus:ring-2 focus:ring-emerald-200 transition-all duration-200 hover:border-green-300">
                                    <option value="">💰 All Payment Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="verified">Verified</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>
                        </div>

                        <!-- Second Row -->
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
                            <!-- Ticket Status Filter -->
                            <div>
                                <select wire:model.live="filterTicketStatus"
                                    class="block w-full px-3 py-2.5 text-sm border-2 border-green-200 rounded-xl bg-white focus:border-emerald-400 focus:ring-2 focus:ring-emerald-200 transition-all duration-200 hover:border-green-300">
                                    <option value="">🎟️ All Ticket Status</option>
                                    <option value="active">Active</option>
                                    <option value="pending_payment">Pending Payment</option>
                                    <option value="used">Used</option>
                                </select>
                            </div>

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

                            <!-- Reset Filters Button - spans 3 columns -->
                            <div class="md:col-span-3">
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
                                    <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Student</th>
                                    <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Event</th>
                                    <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Status</th>
                                    <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Ticket</th>
                                    <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Payment</th>
                                    <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-green-50">
                                @foreach ($registrations as $index => $registration)
                                    <tr class="{{ $index % 2 === 0 ? 'bg-white hover:bg-green-50' : 'bg-green-50/30 hover:bg-green-100' }} transition-colors duration-150 group">
                                        <!-- Student Info -->
                                        <td class="px-4 py-3">
                                            <div class="flex flex-col">
                                                <span class="text-sm font-medium text-gray-900">{{ $registration->user->first_name }} {{ $registration->user->last_name }}</span>
                                                <span class="text-xs text-gray-500 font-mono">{{ $registration->user->student_id ?? 'N/A' }}</span>
                                                <span class="text-xs text-gray-400">{{ $registration->user->email }}</span>
                                            </div>
                                        </td>

                                        <!-- Event -->
                                        <td class="px-4 py-3">
                                            <div class="flex flex-col">
                                                <span class="text-sm text-gray-900">{{ Str::limit($registration->event->title, 25) }}</span>
                                                @if ($registration->event->require_payment)
                                                    <span class="text-xs text-emerald-600 font-medium">₱{{ number_format($registration->event->payment_amount, 2) }}</span>
                                                @else
                                                    <span class="text-xs text-gray-500">Free Event</span>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Registration Status -->
                                        <td class="px-4 py-3">
                                            @if ($registration->status === 'registered')
                                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-lg text-xs font-medium">Registered</span>
                                            @elseif($registration->status === 'attended')
                                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-lg text-xs font-medium">Attended</span>
                                            @elseif($registration->status === 'cancelled')
                                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-lg text-xs font-medium">Cancelled</span>
                                            @endif
                                        </td>

                                        <!-- Ticket -->
                                        <td class="px-4 py-3">
                                            @if ($registration->ticket)
                                                <div class="flex flex-col">
                                                    @if ($registration->ticket->isActive())
                                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-lg text-xs font-medium">Active</span>
                                                    @elseif($registration->ticket->isPendingPayment())
                                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-lg text-xs font-medium">Pending</span>
                                                    @elseif($registration->ticket->isUsed())
                                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-lg text-xs font-medium">Used</span>
                                                    @endif
                                                    <span class="text-xs text-gray-500 mt-1 font-mono">{{ substr($registration->ticket->ticket_number, -8) }}</span>
                                                </div>
                                            @else
                                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-lg text-xs font-medium">None</span>
                                            @endif
                                        </td>

                                        <!-- Payment Status -->
                                        <td class="px-4 py-3">
                                            @if (!$registration->event->require_payment)
                                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-lg text-xs font-medium">Free</span>
                                            @else
                                                @if ($registration->isPaymentVerified())
                                                    <div class="flex flex-col">
                                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-lg text-xs font-medium">Verified</span>
                                                        @if ($registration->payment_verified_at)
                                                            <span class="text-xs text-gray-500 mt-1">{{ $registration->payment_verified_at->format('M d, Y') }}</span>
                                                        @endif
                                                    </div>
                                                @elseif($registration->isPaymentRejected())
                                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-lg text-xs font-medium">Rejected</span>
                                                @else
                                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-lg text-xs font-medium">Pending</span>
                                                @endif
                                            @endif
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-4 py-3">
                                            @php
                                                $buttons = $this->getActionButtons($registration);
                                            @endphp

                                            <div class="flex items-center space-x-2">
                                                @if ($registration->event->require_payment)
                                                    @if ($buttons['verify'])
                                                        <button wire:click="verifyPayment({{ $registration->id }})"
                                                            class="p-2 bg-green-100 text-green-600 rounded-lg hover:bg-green-600 hover:text-white transition-all duration-200 group/verify"
                                                            title="Verify Payment">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                        </button>
                                                    @endif

                                                    @if ($buttons['reject'])
                                                        <button wire:click="rejectPayment({{ $registration->id }})"
                                                            class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-200 group/reject"
                                                            title="Reject Payment">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    @endif

                                                    @if ($buttons['reset'])
                                                        <button wire:click="resetPaymentStatus({{ $registration->id }})"
                                                            class="p-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-600 hover:text-white transition-all duration-200 group/reset"
                                                            title="Reset Status">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                            </svg>
                                                        </button>
                                                    @endif
                                                @endif

                                                @if ($buttons['generate'])
                                                    <button wire:click="generateTicket({{ $registration->id }})"
                                                        class="p-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all duration-200 group/generate"
                                                        title="Generate Ticket">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                        </svg>
                                                    </button>
                                                @endif

                                                @if ($buttons['view'])
                                                    <button wire:click="viewTicket({{ $registration->id }})"
                                                        class="p-2 bg-purple-100 text-purple-600 rounded-lg hover:bg-purple-600 hover:text-white transition-all duration-200 group/view"
                                                        title="View Ticket">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </button>
                                                @endif

                                                @if ($buttons['regenerate'])
                                                    <button wire:click="regenerateTicket({{ $registration->id }})"
                                                        class="p-2 bg-orange-100 text-orange-600 rounded-lg hover:bg-orange-600 hover:text-white transition-all duration-200 group/regenerate"
                                                        title="Regenerate Ticket">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                        </svg>
                                                    </button>
                                                @endif
                                            </div>
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
                                Showing <span class="font-semibold">{{ $registrations->firstItem() ?? 0 }}</span>
                                to <span class="font-semibold">{{ $registrations->lastItem() ?? 0 }}</span>
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
                        <p class="text-lg font-medium text-green-800">No registrations found</p>
                        <p class="text-sm text-green-600 mt-1">
                            @if ($search || $filterEvent || $filterPaymentStatus || $filterTicketStatus)
                                Try adjusting your search or filters
                            @else
                                No registrations for your events yet
                            @endif
                        </p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Export Modal -->
    <x-custom-modal model="showExportModal" maxWidth="lg" title="Export Registrations Report"
        description="Export current registrations data with applied filters" headerBg="green">
        <div class="space-y-6">
            <!-- Current Filters Summary Card -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-5 rounded-xl border border-green-200">
                <div class="flex items-center space-x-2 mb-3">
                    <div class="p-1.5 bg-green-200 rounded-lg">
                        <svg class="w-4 h-4 text-green-700" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
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
                            <span class="font-medium">Event:</span>
                            <span class="text-green-600">
                                {{ $filterEvent && isset($availableEvents[$filterEvent]) ? $availableEvents[$filterEvent] : 'All Events' }}
                            </span>
                        </p>
                    </div>
                    <div class="space-y-2">
                        <p class="text-green-700">
                            <span class="font-medium">Payment Status:</span>
                            <span
                                class="text-green-600">{{ $filterPaymentStatus ? ucfirst($filterPaymentStatus) : 'All' }}</span>
                        </p>
                        <p class="text-green-700">
                            <span class="font-medium">Ticket Status:</span>
                            <span
                                class="text-green-600">{{ $filterTicketStatus ? ucfirst(str_replace('_', ' ', $filterTicketStatus)) : 'All' }}</span>
                        </p>
                    </div>
                </div>

                <!-- Total Records Badge -->
                <div class="mt-3 pt-3 border-t border-green-200">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-green-700">Registrations to export:</span>
                        <span class="px-3 py-1 bg-green-200 text-green-800 rounded-full text-sm font-semibold">
                            {{ $registrations->total() }} registrations
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
                        <div
                            class="p-4 bg-white border-2 border-gray-200 rounded-xl peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-green-300 transition-all duration-200">
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
                        <div
                            class="p-4 bg-white border-2 border-gray-200 rounded-xl peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-green-300 transition-all duration-200">
                            <div class="flex flex-col items-center text-center">
                                <div class="p-3 bg-green-100 rounded-full mb-2">
                                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z" />
                                        <text x="8" y="18" fill="white" font-size="10"
                                            font-weight="bold">CSV</text>
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
                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Cancel</span>
                </button>
                <button type="button" wire:click="exportRegistrations"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group shadow-lg shadow-green-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span>Export</span>
                </button>
            </div>
        </div>
    </x-custom-modal>
    <!-- Ticket View Modal -->
    @if ($showTicketModal && $selectedTicketRegistration)
        <x-custom-modal model="showTicketModal">
            <div class="max-w-2xl mx-auto">
                <!-- Modal Header -->
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 text-center">Event Ticket</h2>
                    <p class="text-center text-gray-600 mt-1">Ticket for
                        {{ $selectedTicketRegistration->user->first_name }}
                        {{ $selectedTicketRegistration->user->last_name }}</p>
                </div>

                <!-- Ticket Content -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border-2 border-blue-200">
                    <!-- Ticket Header -->
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">{{ $selectedTicketRegistration->event->title }}
                            </h3>
                            <p class="text-sm text-gray-600">{{ $selectedTicketRegistration->event->category }} Event
                            </p>
                            <p class="text-sm text-gray-600 mt-1">Organized by: {{ Auth::user()->first_name }}
                                {{ Auth::user()->last_name }}</p>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-blue-700">
                                {{ $selectedTicketRegistration->ticket->ticket_number }}</div>
                            <div class="text-xs text-gray-500 mt-1">Ticket ID</div>
                        </div>
                    </div>

                    <!-- Ticket Details Grid -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="space-y-2">
                            <div>
                                <p class="text-xs text-gray-500">Event Date & Time</p>
                                <p class="font-medium">
                                    {{ \Carbon\Carbon::parse($selectedTicketRegistration->event->start_date)->format('F j, Y') }}
                                    -
                                    {{ \Carbon\Carbon::parse($selectedTicketRegistration->event->end_date)->format('F j, Y') }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($selectedTicketRegistration->event->start_time)->format('g:i A') }}
                                    -
                                    {{ \Carbon\Carbon::parse($selectedTicketRegistration->event->end_time)->format('g:i A') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Event Type</p>
                                <p class="font-medium">
                                    {{ ucfirst($selectedTicketRegistration->event->type) }}
                                    @if ($selectedTicketRegistration->event->type === 'face-to-face')
                                        <span class="text-xs text-gray-600 block">
                                            {{ Str::limit($selectedTicketRegistration->event->place_link, 40) }}
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div>
                                <p class="text-xs text-gray-500">Attendee</p>
                                <p class="font-medium">
                                    {{ $selectedTicketRegistration->user->first_name }}
                                    {{ $selectedTicketRegistration->user->last_name }}
                                </p>
                                @if ($selectedTicketRegistration->user->student_id)
                                    <p class="text-xs text-gray-600">Student ID:
                                        {{ $selectedTicketRegistration->user->student_id }}</p>
                                @endif
                                <p class="text-xs text-gray-600">Email: {{ $selectedTicketRegistration->user->email }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Registration Date</p>
                                <p class="font-medium">
                                    {{ \Carbon\Carbon::parse($selectedTicketRegistration->registered_at)->format('M j, Y g:i A') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Ticket Status</p>
                                <p class="font-medium">
                                    @if ($selectedTicketRegistration->ticket->isActive())
                                        <span class="text-green-600">Active</span>
                                    @elseif($selectedTicketRegistration->ticket->isPendingPayment())
                                        <span class="text-yellow-600">Pending Payment</span>
                                    @elseif($selectedTicketRegistration->ticket->isUsed())
                                        <span class="text-gray-600">Used</span>
                                    @endif
                                </p>
                            </div>
                            @if ($selectedTicketRegistration->event->require_payment)
                                <div>
                                    <p class="text-xs text-gray-500">Payment Status</p>
                                    <p class="font-medium">
                                        @if ($selectedTicketRegistration->payment_status === 'verified')
                                            <span class="text-green-600">Verified ✓</span>
                                            @if ($selectedTicketRegistration->payment_verified_at)
                                                <div class="text-xs text-gray-600">
                                                    Verified on:
                                                    {{ $selectedTicketRegistration->payment_verified_at->format('M j, Y g:i A') }}
                                                </div>
                                                @if ($selectedTicketRegistration->payment_verified_by)
                                                    <div class="text-xs text-gray-600">
                                                        Verified by:
                                                        {{ $selectedTicketRegistration->paymentVerifier->first_name ?? 'Admin' }}
                                                    </div>
                                                @endif
                                            @endif
                                        @elseif($selectedTicketRegistration->payment_status === 'pending')
                                            <span class="text-yellow-600">Pending</span>
                                        @elseif($selectedTicketRegistration->payment_status === 'rejected')
                                            <span class="text-red-600">Rejected</span>
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- QR Code Section -->
                    <div class="border-t border-gray-200 pt-6 mb-6">
                        <h4 class="text-center font-medium text-gray-700 mb-4">Scan QR Code for Entry</h4>
                        <div class="flex justify-center">
                            <div class="bg-white p-4 rounded-lg border">
                                <!-- Placeholder QR Code -->
                                <div
                                    class="w-48 h-48 flex items-center justify-center bg-gray-100 border border-gray-300 rounded">
                                    <div class="text-center">
                                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-2" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                                            </path>
                                        </svg>
                                        <p class="text-xs text-gray-500">QR Code Placeholder</p>
                                        <p class="text-xs text-gray-400 mt-1">
                                            {{ $selectedTicketRegistration->ticket->ticket_number }}</p>
                                    </div>
                                </div>
                                <p class="text-xs text-center text-gray-500 mt-2">
                                    Scan this code at the event entrance
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Event Description -->
                    @if ($selectedTicketRegistration->event->description)
                        <div class="border-t border-gray-200 pt-4 mb-6">
                            <h4 class="font-medium text-gray-700 mb-2">Event Description</h4>
                            <p class="text-sm text-gray-600">{{ $selectedTicketRegistration->event->description }}</p>
                        </div>
                    @endif

                    <!-- Ticket Information -->
                    <div class="border-t border-gray-200 pt-4 mb-6">
                        <h4 class="font-medium text-gray-700 mb-2">Ticket Information</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-500">Generated At</p>
                                <p class="text-sm font-medium">
                                    {{ $selectedTicketRegistration->ticket->generated_at->format('M j, Y g:i A') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Event Price</p>
                                <p class="text-sm font-medium">
                                    @if ($selectedTicketRegistration->event->require_payment)
                                        ₱{{ number_format($selectedTicketRegistration->event->payment_amount, 2) }}
                                    @else
                                        Free
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="flex justify-center space-x-4 pt-4 border-t border-gray-200">
                        <button wire:click="closeTicketModal" type="button"
                            class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors font-medium">
                            Close
                        </button>
                        @if ($selectedTicketRegistration->ticket->isActive())
                            <a href="{{ route('ticket.download', $selectedTicketRegistration->ticket->id) }}"
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Download Ticket (PDF)
                            </a>
                            <button wire:click="regenerateTicket({{ $selectedTicketRegistration->id }})"
                                type="button"
                                class="px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors font-medium flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                    </path>
                                </svg>
                                Regenerate Ticket
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </x-custom-modal>
    @endif
    <!-- Payment Verification Modal -->
    @if ($showPaymentModal && $selectedRegistration)
        <x-custom-modal model="showPaymentModal" maxWidth="sm" title="Verify Payment"
            description="Confirm payment verification for this registration" headerBg="green">
            <div class="space-y-6">
                <!-- Registration Summary Card -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-5 rounded-xl border border-green-200">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="p-2 bg-green-200 rounded-full">
                            <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-green-800">Student Information</h3>
                            <p class="text-sm text-green-600">{{ $selectedRegistration->user->first_name }}
                                {{ $selectedRegistration->user->last_name }}</p>
                        </div>
                    </div>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between items-center py-2 border-b border-green-200">
                            <span class="text-green-700 font-medium">Student ID:</span>
                            <span class="text-green-900">{{ $selectedRegistration->user->student_id ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-green-200">
                            <span class="text-green-700 font-medium">Event:</span>
                            <span class="text-green-900 text-right">{{ $selectedRegistration->event->title }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-green-200">
                            <span class="text-green-700 font-medium">Amount:</span>
                            <span
                                class="text-green-900 font-bold">₱{{ number_format($selectedRegistration->event->payment_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-green-700 font-medium">Current Status:</span>
                            <span class="px-3 py-1 bg-yellow-200 text-yellow-800 rounded-full text-xs font-semibold">
                                Pending Verification
                            </span>
                        </div>
                    </div>
                </div>
                <!-- Action Buttons -->
                <div class="flex space-x-3 pt-4 border-t-2 border-gray-100">
                    <button type="button" wire:click="closePaymentModal"
                        class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group">
                        <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>Cancel</span>
                    </button>
                    <button type="button" wire:click="confirmPaymentVerification"
                        class="flex-1 px-4 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-200 font-medium flex items-center justify-center space-x-2 shadow-lg shadow-green-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Verify Payment</span>
                    </button>
                </div>
            </div>
        </x-custom-modal>
    @endif
    <!-- Reject Payment Confirmation Modal -->
    @if ($showRejectModal && $selectedRegistration)
        <x-custom-modal model="showRejectModal" maxWidth="sm" title="Reject Payment"
            description="Are you sure you want to reject this payment?" headerBg="red">
            <div class="space-y-6">
                <!-- Warning Card -->
                <div class="bg-gradient-to-br from-red-50 to-rose-50 p-5 rounded-xl border border-red-200">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="p-2 bg-red-200 rounded-full">
                            <svg class="w-5 h-5 text-red-700" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-red-800">Confirmation Required</h3>
                            <p class="text-sm text-red-600">This action cannot be undone</p>
                        </div>
                    </div>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between items-center py-2 border-b border-red-200">
                            <span class="text-red-700 font-medium">Student:</span>
                            <span class="text-red-900">{{ $selectedRegistration->user->first_name }}
                                {{ $selectedRegistration->user->last_name }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-red-200">
                            <span class="text-red-700 font-medium">Event:</span>
                            <span class="text-red-900">{{ $selectedRegistration->event->title }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-red-700 font-medium">Amount:</span>
                            <span
                                class="text-red-900 font-bold">₱{{ number_format($selectedRegistration->event->payment_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Rejection Notes
            <div class="space-y-2">
                <label class="flex items-center space-x-2 text-sm font-semibold text-red-800">
                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>Rejection Reason (Optional)</span>
                </label>
                <textarea wire:model="rejectionNotes" rows="3"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all duration-200 resize-none"
                    placeholder="Provide reason for rejecting this payment..."></textarea>
            </div>-->

                <!-- Action Buttons -->
                <div class="flex space-x-3 pt-4 border-t-2 border-gray-100">
                    <button type="button" wire:click="closeRejectModal"
                        class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group">
                        <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>Keep Payment</span>
                    </button>
                    <button type="button" wire:click="confirmPaymentRejection"
                        class="flex-1 px-4 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-200 font-medium flex items-center justify-center space-x-2 shadow-lg shadow-red-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span>Reject Payment</span>
                    </button>
                </div>
            </div>
        </x-custom-modal>
    @endif
</div>