<div>
    @if($tickets->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Event Details
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ticket Information
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Registration Date
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($tickets as $registration)
                        @if($registration->ticket)
                            <tr class="hover:bg-gray-50">
                                <!-- Event Details Column -->
                                <td class="px-4 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $registration->event->title }}</div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        <div class="flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ \Carbon\Carbon::parse($registration->event->date)->format('F j, Y') }}
                                        </div>
                                        <div class="flex items-center gap-1 mt-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ \Carbon\Carbon::parse($registration->event->time)->format('g:i A') }}
                                        </div>
                                        <div class="flex items-center gap-1 mt-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            {{ $registration->event->type === 'online' ? 'Online Event' : 'In-Person' }}
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- Ticket Information Column -->
                                <td class="px-4 py-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $registration->ticket->ticket_number }}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        Generated: {{ $registration->ticket->generated_at->format('M j, Y g:i A') }}
                                    </div>
                                    @if($registration->event->require_payment)
                                        <div class="text-xs text-gray-500 mt-1">
                                            Amount: ₱{{ number_format($registration->event->payment_amount, 2) }}
                                        </div>
                                    @endif
                                </td>
                                
                                <!-- Registration Date -->
                                <td class="px-4 py-4 text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($registration->registered_at)->format('M j, Y g:i A') }}
                                </td>
                                
                                <!-- Status Column -->
                                <td class="px-4 py-4">
                                    @if($registration->ticket->isActive())
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium">
                                            Active
                                        </span>
                                    @elseif($registration->ticket->isPendingPayment())
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-medium">
                                            Pending Payment
                                        </span>
                                    @elseif($registration->ticket->isUsed())
                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs font-medium">
                                            Used
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-medium">
                                            Invalid
                                        </span>
                                    @endif
                                    
                                    @if($registration->payment_status === 'verified')
                                        <div class="text-xs text-green-600 mt-1">
                                            Payment Verified
                                        </div>
                                    @elseif($registration->payment_status === 'pending')
                                        <div class="text-xs text-yellow-600 mt-1">
                                            Payment Pending
                                        </div>
                                    @elseif($registration->payment_status === 'rejected')
                                        <div class="text-xs text-red-600 mt-1">
                                            Payment Rejected
                                        </div>
                                    @endif
                                </td>
                                
                                <!-- Actions Column -->
                                <td class="px-4 py-4">
                                    <div class="flex space-x-2">
                                        <!-- View Ticket Button -->
                                        <button 
                                            wire:click="viewTicket({{ $registration->id }})"
                                            class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs font-medium transition-colors flex items-center gap-1"
                                        >
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            View Ticket
                                        </button>
                                        
                                        <!-- Download Button (only for active tickets) -->
                                        @if($registration->ticket->isActive())
                                            <button 
                                                wire:click="downloadTicket({{ $registration->id }})"
                                                class="px-3 py-1.5 bg-green-600 text-white rounded hover:bg-green-700 text-xs font-medium transition-colors flex items-center gap-1"
                                            >
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                                </svg>
                                                Download
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Ticket View Modal -->
        @if($showTicketModal && $selectedTicket)
            <x-custom-modal model="showTicketModal">
                <div class="max-w-2xl mx-auto">
                    <!-- Modal Header -->
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 text-center">Event Ticket</h2>
                        <p class="text-center text-gray-600 mt-1">Your digital ticket for admission</p>
                    </div>
                    
                    <!-- Ticket Content -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border-2 border-blue-200">
                        <!-- Ticket Header -->
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">{{ $selectedTicket->event->title }}</h3>
                                <p class="text-sm text-gray-600">{{ $selectedTicket->event->category }} Event</p>
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
                                    <p class="text-xs text-gray-500">Event Date</p>
                                    <p class="font-medium">
                                        {{ \Carbon\Carbon::parse($selectedTicket->event->date)->format('F j, Y') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Event Time</p>
                                    <p class="font-medium">
                                        {{ \Carbon\Carbon::parse($selectedTicket->event->time)->format('g:i A') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Event Type</p>
                                    <p class="font-medium">
                                        {{ ucfirst($selectedTicket->event->type) }}
                                        @if($selectedTicket->event->type === 'face-to-face')
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
                                    <p class="font-medium">
                                        {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                                    </p>
                                    @if(Auth::user()->student_id)
                                        <p class="text-xs text-gray-600">ID: {{ Auth::user()->student_id }}</p>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Registration Date</p>
                                    <p class="font-medium">
                                        {{ \Carbon\Carbon::parse($selectedTicket->registered_at)->format('M j, Y') }}
                                    </p>
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
                                    <!-- Placeholder QR Code -->
                                    <div class="w-48 h-48 flex items-center justify-center bg-gray-100 border border-gray-300 rounded">
                                        <div class="text-center">
                                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                            </svg>
                                            <p class="text-xs text-gray-500">QR Code Placeholder</p>
                                            <p class="text-xs text-gray-400 mt-1">{{ $selectedTicket->ticket->ticket_number }}</p>
                                        </div>
                                    </div>
                                    <p class="text-xs text-center text-gray-500 mt-2">
                                        Present this code at the event entrance
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Event Description -->
                        @if($selectedTicket->event->description)
                            <div class="border-t border-gray-200 pt-4 mb-6">
                                <h4 class="font-medium text-gray-700 mb-2">Event Description</h4>
                                <p class="text-sm text-gray-600">{{ $selectedTicket->event->description }}</p>
                            </div>
                        @endif
                        
                        <!-- Modal Actions -->
                        <div class="flex justify-center space-x-4 pt-4 border-t border-gray-200">
                            <button 
                                wire:click="closeTicketModal"
                                type="button"
                                class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors font-medium"
                            >
                                Close
                            </button>
                            @if($selectedTicket->ticket->isActive())
                                <button 
                                    wire:click="downloadTicket({{ $selectedTicket->id }})"
                                    type="button"
                                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium flex items-center gap-2"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    Download Ticket (PDF)
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </x-custom-modal>
        @endif
    @else
        <div class="text-center py-12">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Tickets Yet</h3>
            <p class="text-gray-500 max-w-md mx-auto">
                You haven't registered for any events with tickets. Register for an event to receive your digital ticket!
            </p>
            <a href="{{ route('events') }}" class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors text-sm font-medium">
                Browse Events
            </a>
        </div>
    @endif
    
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
</div>