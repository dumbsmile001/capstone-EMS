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
                            <a 
                                href="{{ route('ticket.download', $selectedTicketRegistration->ticket->id) }}"
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium flex items-center gap-2"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Download Ticket (PDF)
                            </a>
                            <button wire:click="regenerateTicket({{ $selectedTicketRegistration->id }})" type="button"
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
                        <td class="px-4 py-3 text-sm space-x-2">
                            @php
                                $buttons = $this->getActionButtons($registration);
                            @endphp

                            @if ($registration->event->require_payment)
                                <!-- Paid Event Buttons -->
                                @if ($buttons['verify'])
                                    <button wire:click="verifyPayment({{ $registration->id }})"
                                        class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs font-medium transition-colors"
                                        title="Verify payment">
                                        Verify Payment
                                    </button>
                                @endif

                                @if ($buttons['reject'])
                                    <button wire:click="rejectPayment({{ $registration->id }})"
                                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs font-medium transition-colors"
                                        title="Reject payment">
                                        Reject
                                    </button>
                                @endif

                                @if ($buttons['reset'])
                                    <button wire:click="resetPaymentStatus({{ $registration->id }})"
                                        class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-700 text-xs font-medium transition-colors"
                                        title="Reset payment status">
                                        Reset
                                    </button>
                                @endif

                                @if ($buttons['generate'])
                                    <button wire:click="generateTicket({{ $registration->id }})"
                                        class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs font-medium transition-colors"
                                        title="Generate ticket">
                                        Generate Ticket
                                    </button>
                                @endif

                                @if ($buttons['view'])
                                    <button wire:click="viewTicket({{ $registration->id }})"
                                        class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs font-medium transition-colors"
                                        title="View ticket">
                                        View Ticket
                                    </button>
                                @endif

                                @if ($buttons['regenerate'])
                                    <button wire:click="regenerateTicket({{ $registration->id }})"
                                        class="px-3 py-1 bg-orange-600 text-white rounded hover:bg-orange-700 text-xs font-medium transition-colors"
                                        title="Regenerate ticket">
                                        Regenerate
                                    </button>
                                @endif

                                <!-- Show status for rejected payments -->
                                @if ($registration->isPaymentRejected() && !$buttons['reset'])
                                    <span class="text-xs text-red-600">Payment Rejected</span>
                                @endif
                            @else
                                <!-- Free Event Buttons -->
                                @if ($buttons['generate'])
                                    <button wire:click="generateTicket({{ $registration->id }})"
                                        class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs font-medium transition-colors"
                                        title="Generate ticket">
                                        Generate Ticket
                                    </button>
                                @endif

                                @if ($buttons['view'])
                                    <button wire:click="viewTicket({{ $registration->id }})"
                                        class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs font-medium transition-colors"
                                        title="View ticket">
                                        View Ticket
                                    </button>
                                @endif

                                @if ($buttons['regenerate'])
                                    <button wire:click="regenerateTicket({{ $registration->id }})"
                                        class="px-3 py-1 bg-orange-600 text-white rounded hover:bg-orange-700 text-xs font-medium transition-colors"
                                        title="Regenerate ticket">
                                        Regenerate
                                    </button>
                                @endif

                                <!-- Edge case: ticket should exist but doesn't -->
                                @if (!$registration->ticket && !$buttons['generate'])
                                    <span class="text-xs text-yellow-600">Ticket Error</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-center py-8">
            <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
            </svg>
            <p class="mt-4 text-gray-500">No registrations found for your events.</p>
        </div>
    @endif
</div>
