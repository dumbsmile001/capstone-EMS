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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                            </svg>
                            My Tickets
                        </h3>
                    </div>

                    <!-- Filter Grid -->
                    <div class="space-y-4">
                        <!-- First Row -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
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

                <!-- Tickets Table -->
                <div class="overflow-x-auto">
                    @if ($tickets->count() > 0)
                        <table class="min-w-full divide-y divide-green-100">
                            <thead class="bg-gradient-to-r from-green-600 to-emerald-700">
                                <tr>
                                    <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Event Details</th>
                                    <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Ticket Information</th>
                                    <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Registration Date</th>
                                    <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Status</th>
                                    <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-green-50">
                                @foreach ($tickets as $index => $registration)
                                    @if($registration->ticket)
                                        <tr class="{{ $index % 2 === 0 ? 'bg-white hover:bg-green-50' : 'bg-green-50/30 hover:bg-green-100' }} transition-colors duration-150 group">
                                            <!-- Event Details Column -->
                                            <td class="px-4 py-4">
                                                <div class="flex flex-col">
                                                    <span class="text-sm font-medium text-gray-900">{{ $registration->event->title }}</span>
                                                    <div class="text-xs text-gray-500 mt-1 space-y-1">
                                                        <div class="flex items-center gap-1">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                            {{ \Carbon\Carbon::parse($registration->event->start_date)->format('F j, Y') }}
                                                            @if(\Carbon\Carbon::parse($registration->event->start_date)->format('Y-m-d') != \Carbon\Carbon::parse($registration->event->end_date)->format('Y-m-d'))
                                                                - {{ \Carbon\Carbon::parse($registration->event->end_date)->format('F j, Y') }}
                                                            @endif
                                                        </div>
                                                        <div class="flex items-center gap-1">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                            {{ \Carbon\Carbon::parse($registration->event->start_time)->format('g:i A') }} - 
                                                            {{ \Carbon\Carbon::parse($registration->event->end_time)->format('g:i A') }}
                                                        </div>
                                                        <div class="flex items-center gap-1">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            </svg>
                                                            {{ $registration->event->type === 'online' ? 'Online Event' : 'In-Person' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            
                                            <!-- Ticket Information Column -->
                                            <td class="px-4 py-4">
                                                <div class="flex flex-col">
                                                    <span class="text-sm font-mono font-medium text-gray-900">
                                                        {{ $registration->ticket->ticket_number }}
                                                    </span>
                                                    <span class="text-xs text-gray-500 mt-1">
                                                        Generated: {{ $registration->ticket->generated_at->format('M j, Y g:i A') }}
                                                    </span>
                                                    @if($registration->event->require_payment)
                                                        <span class="text-xs text-emerald-600 font-medium mt-1">
                                                            ₱{{ number_format($registration->event->payment_amount, 2) }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            
                                            <!-- Registration Date -->
                                            <td class="px-4 py-4">
                                                <span class="text-sm text-gray-600">
                                                    {{ \Carbon\Carbon::parse($registration->registered_at)->format('M j, Y g:i A') }}
                                                </span>
                                            </td>
                                            
                                            <!-- Status Column -->
                                            <td class="px-4 py-4">
                                                <div class="flex flex-col space-y-1">
                                                    @if($registration->ticket->isActive())
                                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-lg text-xs font-medium self-start">
                                                            Active
                                                        </span>
                                                    @elseif($registration->ticket->isPendingPayment())
                                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-lg text-xs font-medium self-start">
                                                            Pending Payment
                                                        </span>
                                                    @elseif($registration->ticket->isUsed())
                                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-lg text-xs font-medium self-start">
                                                            Used
                                                        </span>
                                                    @endif
                                                    
                                                    @if($registration->payment_status === 'verified')
                                                        <span class="text-xs text-green-600">Payment Verified</span>
                                                    @elseif($registration->payment_status === 'pending')
                                                        <span class="text-xs text-yellow-600">Payment Pending</span>
                                                    @elseif($registration->payment_status === 'rejected')
                                                        <span class="text-xs text-red-600">Payment Rejected</span>
                                                    @endif
                                                </div>
                                            </td>
                                            
                                            <!-- Actions Column -->
                                            <td class="px-4 py-4">
                                                <div class="flex items-center space-x-2">
                                                    <button 
                                                        wire:click="viewTicket({{ $registration->id }})"
                                                        class="p-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all duration-200 group/view"
                                                        title="View Ticket">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($tickets && method_exists($tickets, 'links'))
                        <div class="px-4 py-4 bg-white/80 backdrop-blur-sm border-t border-green-100 rounded-b-xl">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-green-700">
                                    Showing <span class="font-semibold">{{ $tickets->firstItem() }}</span>
                                    to <span class="font-semibold">{{ $tickets->lastItem() }}</span>
                                    of <span class="font-semibold">{{ $tickets->total() }}</span> results
                                </div>

                                <div class="flex items-center space-x-2">
                                    @if ($tickets->onFirstPage())
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

                                    @foreach ($tickets->getUrlRange(max(1, $tickets->currentPage() - 2), min($tickets->lastPage(), $tickets->currentPage() + 2)) as $page => $url)
                                        <button wire:click="gotoPage({{ $page }})"
                                            class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 
                                                {{ $page === $tickets->currentPage()
                                                    ? 'bg-gradient-to-r from-green-600 to-emerald-700 text-white shadow-md shadow-green-200'
                                                    : 'bg-white text-green-700 border-2 border-green-200 hover:bg-emerald-400 hover:text-white hover:border-emerald-400' }}">
                                            {{ $page }}
                                        </button>
                                    @endforeach

                                    @if ($tickets->hasMorePages())
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
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                                <svg class="w-10 h-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                </svg>
                            </div>
                            <p class="text-lg font-medium text-green-800">No Tickets Yet</p>
                            <p class="text-sm text-green-600 mt-1">
                                @if ($search || $filterTicketStatus)
                                    Try adjusting your search or filters
                                @else
                                    You haven't registered for any events with tickets yet
                                @endif
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Ticket View Modal -->
    @if ($showTicketModal && $selectedTicket)
        <x-custom-modal model="showTicketModal">
            <div class="max-w-2xl mx-auto">
                <!-- Modal Header -->
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 text-center">Event Ticket</h2>
                    <p class="text-center text-gray-600 mt-1">Ticket for {{ $selectedTicket->user->first_name }} {{ $selectedTicket->user->last_name }}</p>
                </div>

                <!-- Ticket Content -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border-2 border-blue-200">
                    <!-- Ticket Header -->
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">{{ $selectedTicket->event->title }}</h3>
                            <p class="text-sm text-gray-600">{{ ucfirst($selectedTicket->event->category) }} Event</p>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-blue-700">{{ $selectedTicket->ticket->ticket_number }}</div>
                            <div class="text-xs text-gray-500 mt-1">Ticket ID</div>
                        </div>
                    </div>

                    <!-- Ticket Details Grid -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="space-y-2">
                            <div>
                                <p class="text-xs text-gray-500">Event Date & Time</p>
                                <p class="font-medium">
                                    {{ \Carbon\Carbon::parse($selectedTicket->event->start_date)->format('F j, Y') }}
                                    @if($selectedTicket->event->start_date != $selectedTicket->event->end_date)
                                        - {{ \Carbon\Carbon::parse($selectedTicket->event->end_date)->format('F j, Y') }}
                                    @endif
                                </p>
                                <p class="text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($selectedTicket->event->start_time)->format('g:i A') }} -
                                    {{ \Carbon\Carbon::parse($selectedTicket->event->end_time)->format('g:i A') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Event Type</p>
                                <p class="font-medium">
                                    {{ ucfirst($selectedTicket->event->type) }}
                                    @if($selectedTicket->event->type === 'face-to-face' && $selectedTicket->event->place_link)
                                        <span class="text-xs text-gray-600 block">
                                            {{ Str::limit($selectedTicket->event->place_link, 40) }}
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div>
                                <p class="text-xs text-gray-500">Attendee</p>
                                <p class="font-medium">{{ $selectedTicket->user->first_name }} {{ $selectedTicket->user->last_name }}</p>
                                @if($selectedTicket->user->student_id)
                                    <p class="text-xs text-gray-600">Student ID: {{ $selectedTicket->user->student_id }}</p>
                                @endif
                                <p class="text-xs text-gray-600">Email: {{ $selectedTicket->user->email }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Registration Date</p>
                                <p class="font-medium">{{ \Carbon\Carbon::parse($selectedTicket->registered_at)->format('M j, Y g:i A') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Ticket Status</p>
                                <p class="font-medium">
                                    @if($selectedTicket->ticket->isActive())
                                        <span class="text-green-600">Active</span>
                                    @elseif($selectedTicket->ticket->isPendingPayment())
                                        <span class="text-yellow-600">Pending Payment</span>
                                    @elseif($selectedTicket->ticket->isUsed())
                                        <span class="text-gray-600">Used</span>
                                    @endif
                                </p>
                            </div>
                            @if($selectedTicket->event->require_payment)
                                <div>
                                    <p class="text-xs text-gray-500">Payment Status</p>
                                    <p class="font-medium">
                                        @if($selectedTicket->payment_status === 'verified')
                                            <span class="text-green-600">Verified ✓</span>
                                        @elseif($selectedTicket->payment_status === 'pending')
                                            <span class="text-yellow-600">Pending</span>
                                        @elseif($selectedTicket->payment_status === 'rejected')
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
                                <!-- Placeholder QR Code - Replace with actual QR code generation -->
                                <div class="w-48 h-48 flex items-center justify-center bg-gray-100 border border-gray-300 rounded">
                                    <div class="text-center">
                                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                        </svg>
                                        <p class="text-xs text-gray-500">QR Code Placeholder</p>
                                        <p class="text-xs text-gray-400 mt-1">{{ $selectedTicket->ticket->ticket_number }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="flex justify-center space-x-4 pt-4 border-t border-gray-200">
                        <button wire:click="closeTicketModal" type="button"
                            class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors font-medium">
                            Close
                        </button>
                        @if($selectedTicket->ticket->isActive())
                            <a href="{{ route('ticket.download', $selectedTicket->ticket->id) }}"
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Download Ticket (PDF)
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </x-custom-modal>
    @endif
</div>