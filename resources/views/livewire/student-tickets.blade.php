<div>
    @if($tickets->count() > 0)
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ticket ID</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($tickets as $registration)
                    @if($registration->ticket)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $registration->event->title }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $registration->ticket->ticket_number }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                {{ $registration->event->date->format('F j, Y') }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                @if($registration->ticket->isActive())
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium">Active</span>
                                @elseif($registration->ticket->isPendingPayment())
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-medium">Pending Payment</span>
                                @elseif($registration->ticket->isUsed())
                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs font-medium">Used</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm space-x-2">
                                @if($registration->ticket->isActive())
                                    <button 
                                        wire:click="downloadTicket({{ $registration->ticket->id }})"
                                        class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs font-medium"
                                    >
                                        Download
                                    </button>
                                @else
                                    <button 
                                        wire:click="viewTicket({{ $registration->ticket->id }})"
                                        class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-700 text-xs font-medium"
                                    >
                                        View
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-center py-8">
            <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
            </svg>
            <p class="mt-4 text-gray-500">No tickets found. Register for an event to get your ticket!</p>
        </div>
    @endif
</div>