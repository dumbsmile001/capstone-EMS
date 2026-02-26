<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Used - {{ $ticket->ticket_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-lg bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Success Header -->
            <div class="p-6 text-center bg-green-600 text-white">
                <div class="text-4xl mb-3">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h1 class="text-2xl font-bold">ATTENDANCE RECORDED</h1>
                <p class="mt-2 opacity-90">
                    {{ $ticket->ticket_number }}
                </p>
            </div>

            <!-- Success Message -->
            <div class="p-6">
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                    <div class="text-5xl text-green-600 mb-3">
                        <i class="fas fa-party-horn"></i>
                    </div>
                    <h2 class="text-xl font-bold text-green-800 mb-2">Welcome to the Event!</h2>
                    <p class="text-green-700">
                        Ticket has been successfully marked as used.<br>
                        Event attendance has been recorded.
                    </p>
                    <div class="mt-4 inline-flex items-center bg-green-100 px-4 py-2 rounded-full">
                        <i class="fas fa-clock text-green-600 mr-2"></i>
                        <span class="text-green-800">Used at: {{ now()->format('g:i A') }}</span>
                    </div>
                </div>

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
                                @if($user->student_id)
                                <p class="text-xs text-gray-500 mt-1">Student ID: {{ $user->student_id }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <p class="text-center text-gray-600 text-sm mb-3">
                        <i class="fas fa-info-circle mr-1"></i>
                        This ticket has been recorded. Scanning again will show it as used.
                    </p>
                    <div class="flex justify-center space-x-3">
                        <a href="{{ url('/') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                            <i class="fas fa-home mr-1"></i> Go Home
                        </a>
                        <button onclick="window.location.reload()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-sync-alt mr-1"></i> Scan Again
                        </button>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-800 text-white p-4 text-center">
                <p class="text-sm">
                    <i class="fas fa-check-circle mr-1"></i>
                    Attendance Recorded • {{ config('app.name', 'Event System') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Confetti effect for success -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Launch confetti
            confetti({
                particleCount: 100,
                spread: 70,
                origin: { y: 0.6 }
            });
        });
    </script>
</body>
</html>