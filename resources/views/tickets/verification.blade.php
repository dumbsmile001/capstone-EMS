<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ticket Verification - {{ $ticket->ticket_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-lg bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Status Header -->
            <div class="p-6 text-center {{ $justMarkedAsUsed ? 'bg-green-600' : ($ticket->isActive() ? 'bg-green-500' : ($ticket->isUsed() ? 'bg-red-500' : 'bg-yellow-500')) }} text-white">
                <div class="text-4xl mb-3">
                    @if($justMarkedAsUsed)
                        <i class="fas fa-check-circle"></i>
                    @elseif($ticket->isActive())
                        <i class="fas fa-check-circle"></i>
                    @elseif($ticket->isUsed())
                        <i class="fas fa-times-circle"></i>
                    @else
                        <i class="fas fa-exclamation-triangle"></i>
                    @endif
                </div>
                <h1 class="text-2xl font-bold">
                    @if($justMarkedAsUsed)
                        ATTENDANCE RECORDED
                    @elseif($ticket->isActive())
                        TICKET VERIFIED
                    @elseif($ticket->isUsed())
                        TICKET ALREADY USED
                    @else
                        TICKET INVALID
                    @endif
                </h1>
                <p class="mt-2 opacity-90">
                    {{ $ticket->ticket_number }}
                </p>
                @if($justMarkedAsUsed)
                <p class="mt-2 text-sm bg-green-700 rounded-lg px-3 py-1 inline-block">
                    <i class="fas fa-clock mr-1"></i> Used at {{ $ticket->used_at->format('g:i A') }}
                </p>
                @endif
            </div>

            <!-- Ticket Info -->
            <div class="p-6">
                <!-- Event Info -->
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
                        Event Information
                    </h2>
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h3 class="font-bold text-lg text-gray-800">{{ $event->title }}</h3>
                        <div class="mt-2 grid grid-cols-2 gap-3">
                            <div>
                                <p class="text-xs text-gray-600">Start Date</p>
                                <p class="font-medium">{{ \Carbon\Carbon::parse($event->start_date)->format('M j, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600">End Date</p>
                                <p class="font-medium">
                                    @if(\Carbon\Carbon::parse($event->start_date)->format('Y-m-d') != \Carbon\Carbon::parse($event->end_date)->format('Y-m-d'))
                                        {{ \Carbon\Carbon::parse($event->end_date)->format('M j, Y') }}
                                    @else
                                        Same day
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600">Start Time</p>
                                <p class="font-medium">{{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600">End Time</p>
                                <p class="font-medium">{{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}</p>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p class="text-xs text-gray-600">Location</p>
                            <p class="font-medium">{{ $event->place_link }}</p>
                        </div>
                    </div>
                </div>

                <!-- Attendee Info -->
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-user text-green-500 mr-2"></i>
                        Attendee Information
                    </h2>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-800">{{ $user->first_name }} {{ $user->last_name }}</p>
                                <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                @if ($user->student_id)
                                    <p class="text-xs text-gray-500 mt-1">Student ID: {{ $user->student_id }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ticket Details -->
                <div class="bg-gray-50 p-4 rounded-lg border">
                    <h3 class="font-semibold text-gray-800 mb-3">
                        <i class="fas fa-ticket-alt text-purple-500 mr-2"></i>
                        Ticket Details
                    </h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-600">Ticket Number</p>
                            <p class="font-bold font-mono">{{ $ticket->ticket_number }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600">Status</p>
                            <p class="font-bold">
                                @if ($ticket->isActive())
                                    <span class="text-green-600">ACTIVE</span>
                                @elseif($ticket->isUsed())
                                    <span class="text-red-600">USED</span>
                                @else
                                    <span class="text-yellow-600">INACTIVE</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="mt-3 text-sm text-gray-600">
                        <p><i class="far fa-clock mr-1"></i> Generated:
                            {{ $ticket->generated_at->format('M j, Y g:i A') }}</p>
                        @if ($ticket->isUsed() && $ticket->used_at)
                            <p><i class="far fa-calendar-times mr-1"></i> Used:
                                {{ $ticket->used_at->format('M j, Y g:i A') }}</p>
                        @endif
                    </div>
                </div>

                <!-- Payment Status (if applicable) -->
                @if ($event->require_payment)
                    <div class="mt-4 bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                        <h3 class="font-semibold text-yellow-800 mb-2">
                            <i class="fas fa-money-bill-wave mr-2"></i>
                            Payment Status
                        </h3>
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-yellow-700">Amount</p>
                                <p class="text-lg font-bold">₱{{ number_format($event->payment_amount, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-yellow-700">Status</p>
                                <p class="font-bold">
                                    @if ($registration->payment_status === 'verified')
                                        <span class="text-green-600">PAID ✓</span>
                                    @else
                                        <span class="text-red-600">NOT PAID</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Quick Actions -->
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <p class="text-center text-gray-600 text-sm mb-3">
                        Scanned at {{ now()->format('g:i A') }}
                    </p>
                    <div class="flex justify-center space-x-3">
                        @auth
                            @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('organizer'))
                                @if ($ticket->isActive())
                                    <button id="markUsedBtn" data-ticket="{{ $ticket->ticket_number }}"
                                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                        <i class="fas fa-check mr-1"></i> Mark Used
                                    </button>
                                @endif
                            @endif
                        @endauth

                        <a href="{{ url('/') }}"
                            class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                            <i class="fas fa-home mr-1"></i> Go Home
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-800 text-white p-4 text-center">
                <p class="text-sm">
                    <i class="fas fa-qrcode mr-1"></i>
                    QR Code Verification • {{ config('app.name', 'Event System') }}
                </p>
                <p class="text-xs text-gray-400 mt-1">
                    Verification ID: {{ substr(md5($ticket->ticket_number), 0, 8) }}
                </p>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle mark as used button click
        const markUsedBtn = document.getElementById('markUsedBtn');
        if (markUsedBtn) {
            markUsedBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                const ticketNumber = this.dataset.ticket;
                const button = this;
                const originalText = button.innerHTML;
                
                // Show loading state
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Processing...';
                
                // Get CSRF token
                const token = document.querySelector('meta[name="csrf-token"]')?.content || 
                             '{{ csrf_token() }}';
                
                fetch('{{ route("ticket.mark-used", ["ticketNumber" => "REPLACE"]) }}'.replace('REPLACE', ticketNumber), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw err; });
                    }
                    return response.json();
                })
                .then(data => {
                    // Success - show success message and reload after a delay
                    button.innerHTML = '<i class="fas fa-check mr-1"></i> Success!';
                    button.classList.remove('bg-green-600', 'hover:bg-green-700');
                    button.classList.add('bg-green-700', 'cursor-default');
                    
                    // Show a brief success message
                    const statusHeader = document.querySelector('.bg-green-500, .bg-red-500, .bg-yellow-500');
                    if (statusHeader) {
                        statusHeader.classList.remove('bg-green-500');
                        statusHeader.classList.add('bg-green-600');
                        statusHeader.querySelector('h1').textContent = 'ATTENDANCE RECORDED';
                    }
                    
                    // Reload after a short delay to show updated status
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.error || 'An error occurred while marking the ticket as used.');
                    
                    // Reset button
                    button.disabled = false;
                    button.innerHTML = originalText;
                });
            });
        }
    });
    </script>
</body>
</html>