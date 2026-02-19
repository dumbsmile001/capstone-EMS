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

    <!-- Export Modal -->
    <!-- Export Modal -->
<x-custom-modal 
    model="showExportModal" 
    maxWidth="lg" 
    title="Export Registrations Report" 
    description="Export current registrations data with applied filters" 
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
                        <span class="font-medium">Event:</span> 
                        <span class="text-green-600">
                            {{ $filterEvent && isset($availableEvents[$filterEvent]) ? $availableEvents[$filterEvent] : 'All Events' }}
                        </span>
                    </p>
                </div>
                <div class="space-y-2">
                    <p class="text-green-700">
                        <span class="font-medium">Payment Status:</span> 
                        <span class="text-green-600">{{ $filterPaymentStatus ? ucfirst($filterPaymentStatus) : 'All' }}</span>
                    </p>
                    <p class="text-green-700">
                        <span class="font-medium">Ticket Status:</span> 
                        <span class="text-green-600">{{ $filterTicketStatus ? ucfirst(str_replace('_', ' ', $filterTicketStatus)) : 'All' }}</span>
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

        <!-- Action Buttons -->
        <div class="flex space-x-3 pt-4 border-t-2 border-gray-100">
            <button type="button" wire:click="closeExportModal"
                class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Cancel</span>
            </button>
            <button type="button" wire:click="exportRegistrations"
                class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group shadow-lg shadow-green-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                <span>Export</span>
            </button>
        </div>
    </div>
</x-custom-modal>

    <!-- Search and Filter Controls -->
    <div class="mb-4 p-4 bg-gray-50 border border-gray-200 rounded-lg">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Registrations Management</h3>
            <button wire:click="openExportModal"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export to Excel/CSV
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            <!-- Search Box -->
            <div class="md:col-span-2">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="search"
                        class="block w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Search by student name, email, or ID...">
                </div>
            </div>

            <!-- Event Filter -->
            <div>
                <select wire:model.live="filterEvent"
                    class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Events</option>
                    @foreach ($availableEvents as $id => $title)
                        <option value="{{ $id }}">{{ $title }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Payment Status Filter -->
            <div>
                <select wire:model.live="filterPaymentStatus"
                    class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Payment Status</option>
                    <option value="pending">Pending</option>
                    <option value="verified">Verified</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Ticket Status Filter -->
            <div>
                <select wire:model.live="filterTicketStatus"
                    class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Ticket Status</option>
                    <option value="active">Active</option>
                    <option value="pending_payment">Pending Payment</option>
                    <option value="used">Used</option>
                </select>
            </div>

            <!-- Results Per Page -->
            <div>
                <select wire:model.live="perPage"
                    class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                    <option value="10">10 per page</option>
                    <option value="25">25 per page</option>
                    <option value="50">50 per page</option>
                    <option value="100">100 per page</option>
                </select>
            </div>

            <!-- Reset Filters Button -->
            <div class="md:col-span-2">
                <button wire:click="resetFilters"
                    class="w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    Reset All Filters
                </button>
            </div>
        </div>
    </div>
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
                                <p class="text-xs text-gray-500">Event Date</p>
                                <p class="font-medium">
                                    {{ \Carbon\Carbon::parse($selectedTicketRegistration->event->date)->format('F j, Y') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Event Time</p>
                                <p class="font-medium">
                                    {{ \Carbon\Carbon::parse($selectedTicketRegistration->event->time)->format('g:i A') }}
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
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Verify Payment</h3>

                    <div class="mb-4">
                        <p class="text-sm text-gray-600">
                            Verify payment for <strong>{{ $selectedRegistration->user->first_name }}
                                {{ $selectedRegistration->user->last_name }}</strong>
                            for event: <strong>{{ $selectedRegistration->event->title }}</strong>
                        </p>
                        <p class="text-sm text-gray-600 mt-2">
                            Amount:
                            <strong>₱{{ number_format($selectedRegistration->event->payment_amount, 2) }}</strong>
                        </p>
                    </div>

                    <div class="mb-4">
                        <label for="verificationNotes" class="block text-sm font-medium text-gray-700 mb-2">
                            Verification Notes (Optional)
                        </label>
                        <textarea wire:model="verificationNotes" id="verificationNotes" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Add any notes about the payment verification..."></textarea>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6">
                        <button wire:click="closePaymentModal" type="button"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors text-sm font-medium">
                            Cancel
                        </button>
                        <button wire:click="confirmPaymentVerification" type="button"
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors text-sm font-medium">
                            Confirm Payment
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="overflow-x-auto">
    @if ($registrations->count() > 0)
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Student Name
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Student ID
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Event
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Ticket</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Payment
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($registrations as $registration)
                    <tr class="hover:bg-gray-50">
                        <!-- Student Name -->
                        <td class="px-4 py-3 text-sm text-gray-900">
                            {{ $registration->user->first_name }} {{ $registration->user->last_name }}
                        </td>

                        <!-- Student ID -->
                        <td class="px-4 py-3 text-sm text-gray-600">
                            {{ $registration->user->student_id ?? 'N/A' }}
                        </td>

                        <!-- Event -->
                        <td class="px-4 py-3 text-sm text-gray-600">
                            {{ $registration->event->title }}
                            <div class="text-xs text-gray-500">
                                ₱{{ number_format($registration->event->payment_amount, 2) }}
                            </div>
                        </td>

                        <!-- Registration Status -->
                        <td class="px-4 py-3 text-sm">
                            @if ($registration->status === 'registered')
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-medium">
                                    Registered
                                </span>
                            @elseif($registration->status === 'attended')
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium">
                                    Attended
                                </span>
                            @elseif($registration->status === 'cancelled')
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-medium">
                                    Cancelled
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-sm">
                            @if ($registration->ticket)
                                @if ($registration->ticket->isActive())
                                    <span
                                        class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium">Active</span>
                                @elseif($registration->ticket->isPendingPayment())
                                    <span
                                        class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-medium">Pending
                                        Payment</span>
                                @elseif($registration->ticket->isUsed())
                                    <span
                                        class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs font-medium">Used</span>
                                @endif
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $registration->ticket->ticket_number }}
                                </div>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-medium">No
                                    Ticket</span>
                            @endif
                        </td>

                        <!-- Payment Status -->
                        <td class="px-4 py-3 text-sm">
                            @if (!$registration->event->require_payment)
                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs font-medium">
                                    Free
                                </span>
                            @else
                                @if ($registration->isPaymentVerified())
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium">
                                        Verified
                                    </span>
                                    @if ($registration->payment_verified_at)
                                        <div class="text-xs text-gray-500 mt-1">
                                            {{ $registration->payment_verified_at->format('M j, Y g:i A') }}
                                        </div>
                                    @endif
                                @elseif($registration->isPaymentRejected())
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-medium">
                                        Rejected
                                    </span>
                                @else
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-medium">
                                        Pending
                                    </span>
                                @endif
                            @endif
                        </td>
                        <!-- Actions -->
                        <!-- Actions -->
                        <td class="px-4 py-3 text-sm">
                            @php
                                $buttons = $this->getActionButtons($registration);
                            @endphp

                            <div class="flex flex-wrap gap-1">
                                @if ($registration->event->require_payment)
                                    <!-- Paid Event Buttons -->
                                    @if ($buttons['verify'])
                                        <button wire:click="verifyPayment({{ $registration->id }})"
                                            class="p-1.5 bg-green-100 text-green-700 rounded hover:bg-green-200 transition-colors relative group"
                                            title="Verify Payment">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span
                                                class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-1 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                                Verify Payment
                                            </span>
                                        </button>
                                    @endif

                                    @if ($buttons['reject'])
                                        <button wire:click="rejectPayment({{ $registration->id }})"
                                            class="p-1.5 bg-red-100 text-red-700 rounded hover:bg-red-200 transition-colors relative group"
                                            title="Reject Payment">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span
                                                class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-1 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                                Reject Payment
                                            </span>
                                        </button>
                                    @endif

                                    @if ($buttons['reset'])
                                        <button wire:click="resetPaymentStatus({{ $registration->id }})"
                                            class="p-1.5 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition-colors relative group"
                                            title="Reset Status">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            <span
                                                class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-1 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                                Reset Status
                                            </span>
                                        </button>
                                    @endif
                                @endif

                                <!-- Ticket Buttons (Common for both paid and free events) -->
                                @if ($buttons['generate'])
                                    <button wire:click="generateTicket({{ $registration->id }})"
                                        class="p-1.5 bg-blue-100 text-blue-700 rounded hover:bg-blue-200 transition-colors relative group"
                                        title="Generate Ticket">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        <span
                                            class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-1 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                            Generate Ticket
                                        </span>
                                    </button>
                                @endif

                                @if ($buttons['view'])
                                    <button wire:click="viewTicket({{ $registration->id }})"
                                        class="p-1.5 bg-purple-100 text-purple-700 rounded hover:bg-purple-200 transition-colors relative group"
                                        title="View Ticket">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span
                                            class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-1 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                            View Ticket
                                        </span>
                                    </button>
                                @endif

                                @if ($buttons['regenerate'])
                                    <button wire:click="regenerateTicket({{ $registration->id }})"
                                        class="p-1.5 bg-orange-100 text-orange-700 rounded hover:bg-orange-200 transition-colors relative group"
                                        title="Regenerate Ticket">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        <span
                                            class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-1 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                            Regenerate Ticket
                                        </span>
                                    </button>
                                @endif

                                <!-- Status messages for edge cases -->
                                @if ($registration->event->require_payment)
                                    @if ($registration->isPaymentRejected() && !$buttons['reset'])
                                        <span class="text-xs text-red-600 bg-red-50 px-2 py-1 rounded">Rejected</span>
                                    @endif
                                @else
                                    @if (!$registration->ticket && !$buttons['generate'])
                                        <span class="text-xs text-yellow-600 bg-yellow-50 px-2 py-1 rounded">Ticket
                                            Error</span>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Pagination -->
        @if ($registrations && method_exists($registrations, 'links'))
            <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
                {{ $registrations->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-8">
            <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
            </svg>
            <p class="mt-4 text-gray-500">
                @if ($search || $filterEvent || $filterPaymentStatus || $filterTicketStatus)
                    No registrations found matching your filters.
                @else
                    No registrations found for your events.
                @endif
            </p>
        </div>
    @endif
    </div>
</div>
