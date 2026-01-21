<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invalid Ticket - {{ $ticket->ticket_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-red-600 text-white p-8 text-center">
                <div class="text-5xl mb-4">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h1 class="text-2xl font-bold">Invalid Ticket</h1>
                <p class="text-red-100 mt-2">This ticket cannot be verified</p>
            </div>
            
            <div class="p-8">
                <div class="text-center mb-6">
                    <div class="inline-block p-4 bg-gray-100 rounded-lg mb-4">
                        <div class="text-3xl text-gray-600">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <div class="font-mono text-gray-800 mt-2">{{ $ticket->ticket_number }}</div>
                    </div>
                    
                    <p class="text-gray-600 mb-6">{{ $message ?? 'This ticket is no longer valid for entry.' }}</p>
                    
                    <div class="space-y-4">
                        <div class="text-left bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Ticket Status</p>
                            <p class="font-semibold text-gray-800">{{ ucfirst($ticket->status) }}</p>
                        </div>
                        
                        @if($ticket->used_at)
                        <div class="text-left bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Used On</p>
                            <p class="font-semibold text-gray-800">
                                {{ \Carbon\Carbon::parse($ticket->used_at)->format('M j, Y g:i A') }}
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
                
                <div class="text-center">
                    <a 
                        href="{{ url('/') }}" 
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                    >
                        <i class="fas fa-home mr-2"></i>
                        Return to Home
                    </a>
                </div>
            </div>
            
            <div class="bg-gray-50 p-4 border-t text-center text-gray-600 text-sm">
                <p>Event Management System • {{ config('app.name', 'Laravel') }}</p>
            </div>
        </div>
    </div>
</body>
</html>