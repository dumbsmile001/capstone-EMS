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

    <!-- Payment Verification Modal -->
    @if($showPaymentModal && $selectedRegistration)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Verify Payment</h3>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-600">
                            Verify payment for <strong>{{ $selectedRegistration->user->first_name }} {{ $selectedRegistration->user->last_name }}</strong>
                            for event: <strong>{{ $selectedRegistration->event->title }}</strong>
                        </p>
                        <p class="text-sm text-gray-600 mt-2">
                            Amount: <strong>₱{{ number_format($selectedRegistration->event->payment_amount, 2) }}</strong>
                        </p>
                    </div>

                    <div class="mb-4">
                        <label for="verificationNotes" class="block text-sm font-medium text-gray-700 mb-2">
                            Verification Notes (Optional)
                        </label>
                        <textarea 
                            wire:model="verificationNotes"
                            id="verificationNotes"
                            rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Add any notes about the payment verification..."
                        ></textarea>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6">
                        <button 
                            wire:click="closePaymentModal"
                            type="button"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors text-sm font-medium"
                        >
                            Cancel
                        </button>
                        <button 
                            wire:click="confirmPaymentVerification"
                            type="button"
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors text-sm font-medium"
                        >
                            Confirm Payment
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($registrations->count() > 0)
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
                @foreach($registrations as $registration)
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
                            @if($registration->status === 'registered')
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
                            @if($registration->ticket)
                                @if($registration->ticket->isActive())
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium">Active</span>
                                @elseif($registration->ticket->isPendingPayment())
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-medium">Pending Payment</span>
                                @elseif($registration->ticket->isUsed())
                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs font-medium">Used</span>
                                @endif
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $registration->ticket->ticket_number }}
                                </div>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-medium">No Ticket</span>
                            @endif
                        </td>
                        
                        <!-- Payment Status -->
                        <td class="px-4 py-3 text-sm">
                            @if(!$registration->event->require_payment)
                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs font-medium">
                                    Free
                                </span>
                            @else
                                @if($registration->isPaymentVerified())
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium">
                                        Verified
                                    </span>
                                    @if($registration->payment_verified_at)
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
                        <!-- In the Actions column, update the buttons: -->
                        <td class="px-4 py-3 text-sm space-x-2">
                            @if($registration->event->require_payment)
                                @if($registration->status === 'registered')
                                    @if($registration->isPaymentPending())
                                        <button 
                                            wire:click="verifyPayment({{ $registration->id }})"
                                            class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs font-medium transition-colors"
                                        >
                                            Verify Payment
                                        </button>
                                        <button 
                                            wire:click="rejectPayment({{ $registration->id }})"
                                            class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs font-medium transition-colors"
                                        >
                                            Reject
                                        </button>
                                    @elseif($registration->isPaymentVerified() || $registration->isPaymentRejected())
                                        <button 
                                            wire:click="resetPaymentStatus({{ $registration->id }})"
                                            class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-700 text-xs font-medium transition-colors"
                                        >
                                            Reset
                                        </button>
                                    @endif
                                @endif
                            @endif
                            
                            <!-- Always show ticket actions -->
                            @if($registration->ticket)
                                <button 
                                    wire:click="viewTicket({{ $registration->id }})"
                                    class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs font-medium transition-colors"
                                >
                                    View Ticket
                                </button>
                                <button 
                                    wire:click="regenerateTicket({{ $registration->id }})"
                                    class="px-3 py-1 bg-orange-600 text-white rounded hover:bg-orange-700 text-xs font-medium transition-colors"
                                >
                                    Regenerate
                                </button>
                            @else
                                <button 
                                    wire:click="generateTicket({{ $registration->id }})"
                                    class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs font-medium transition-colors"
                                >
                                    Generate Ticket
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-center py-8">
            <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <p class="mt-4 text-gray-500">No registrations found for your events.</p>
        </div>
    @endif
</div>