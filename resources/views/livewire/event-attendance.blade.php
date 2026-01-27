{{-- resources/views/livewire/event-attendance.blade.php --}}
<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <x-dashboard-sidebar />

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Header -->
        <x-dashboard-header userRole="Organizer" :userInitials="$userInitials" />

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <!-- Header -->
            <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Event Attendance</h1>
                    <p class="text-gray-600">Track and manage event attendance using scanned tickets</p>
                </div>
                <div class="flex items-center gap-4">
                    <!-- Statistics Card -->
                    <div class="px-4 py-2 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="text-sm text-blue-600 font-medium">Total Attendance</div>
                        <div class="text-2xl font-bold text-blue-700">{{ $totalAttendance }}</div>
                    </div>
                    <a href="{{ route('organizer.events') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Events
                    </a>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="mb-6 bg-white rounded-lg shadow p-4">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-700">Attendance Management</h2>
                    <button wire:click="openExportModal"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Export to Excel/CSV
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div class="md:col-span-2">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" wire:model.live.debounce.300ms="search"
                                class="block w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Search by ticket number, student name, email, or ID...">
                        </div>
                    </div>

                    <!-- Event Filter -->
                    <div>
                        <select wire:model.live="filterEvent"
                            class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Events</option>
                            @foreach ($events as $event)
                                <option value="{{ $event->id }}">{{ Str::limit($event->title, 25) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Payment Filter -->
                    <div>
                        <select wire:model.live="filterPayment"
                            class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Events</option>
                            <option value="paid">Paid Events</option>
                            <option value="free">Free Events</option>
                        </select>
                    </div>
                </div>

                <!-- Second Row of Filters -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <!-- Date Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Attendance Date</label>
                        <input type="date" wire:model.live="filterDate"
                            class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Results Per Page -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Results Per Page</label>
                        <select wire:model.live="perPage"
                            class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="10">10 per page</option>
                            <option value="25">25 per page</option>
                            <option value="50">50 per page</option>
                            <option value="100">100 per page</option>
                        </select>
                    </div>

                    <!-- Reset Filters Button -->
                    <div class="flex items-end">
                        <button wire:click="resetFilters"
                            class="w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            Reset All Filters
                        </button>
                    </div>
                </div>
            </div>

            <!-- Attendance Table -->
            @if (count($attendance) > 0)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ticket & Student Info
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Event Details
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Payment & Registration
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Attendance
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                {{-- In event-attendance.blade.php, update the data access --}}
                                @foreach ($attendance as $ticket)
                                    <tr class="hover:bg-gray-50">
                                        <!-- Ticket & Student Info -->
                                        <td class="px-6 py-4">
                                            <div class="mb-3">
                                                <div class="text-sm font-semibold text-blue-600">
                                                    {{ $ticket->ticket_number }}</div>
                                                <div class="text-xs text-gray-500">Ticket Number</div>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $ticket->registration->user->first_name }}
                                                    {{ $ticket->registration->user->last_name }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $ticket->registration->user->email }}</div>
                                                <div class="text-xs text-gray-500 mt-1">
                                                    @if ($ticket->registration->user->student_id)
                                                        ID: {{ $ticket->registration->user->student_id }}
                                                    @endif
                                                    @if ($ticket->registration->user->grade_level)
                                                        • Grade {{ $ticket->registration->user->grade_level }}
                                                    @endif
                                                    @if ($ticket->registration->user->year_level)
                                                        • Year {{ $ticket->registration->user->year_level }}
                                                    @endif
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    @if ($ticket->registration->user->college_program)
                                                        {{ $ticket->registration->user->college_program }}
                                                    @elseif($ticket->registration->user->shs_strand)
                                                        {{ $ticket->registration->user->shs_strand }}
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Event Details -->
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $ticket->registration->event->title }}</div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ Str::limit($ticket->registration->event->description, 60) }}</div>
                                            <div class="mt-2">
                                                <div class="text-sm text-gray-900">
                                                    {{ $ticket->registration->event->date->format('M d, Y') }}
                                                    at
                                                    {{ \Carbon\Carbon::parse($ticket->registration->event->time)->format('g:i A') }}
                                                </div>
                                                <div class="flex flex-wrap gap-1 mt-1">
                                                    <span
                                                        class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                                        {{ ucfirst($ticket->registration->event->category) }}
                                                    </span>
                                                    <span
                                                        class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">
                                                        {{ ucfirst(str_replace('-', ' ', $ticket->registration->event->type)) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Payment & Registration -->
                                        <td class="px-6 py-4">
                                            @if ($ticket->registration->event->require_payment)
                                                <div class="mb-2">
                                                    <span
                                                        class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 font-semibold">
                                                        ₱{{ number_format($ticket->registration->event->payment_amount, 2) }}
                                                    </span>
                                                </div>
                                                <div class="text-xs">
                                                    <span class="font-medium">Payment:</span>
                                                    @if ($ticket->registration->payment_status === 'verified')
                                                        <span class="text-green-600">Verified</span>
                                                    @elseif($ticket->registration->payment_status === 'pending')
                                                        <span class="text-yellow-600">Pending</span>
                                                    @else
                                                        <span class="text-red-600">Rejected</span>
                                                    @endif
                                                </div>
                                            @else
                                                <span
                                                    class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 font-semibold">
                                                    Free Event
                                                </span>
                                            @endif
                                            <div class="text-xs text-gray-500 mt-2">
                                                <div>Registered:
                                                    {{ $ticket->registration->registered_at->format('M d, Y g:i A') }}
                                                </div>
                                                @if ($ticket->registration->payment_verified_at && $ticket->registration->payment_verified_by)
                                                    <div>Payment Verified:
                                                        {{ $ticket->registration->payment_verified_at->format('M d, Y') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Attendance -->
                                        <td class="px-6 py-4">
                                            <div class="mb-2">
                                                <span
                                                    class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 font-semibold">
                                                    Present
                                                </span>
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                <div>Ticket Generated:
                                                    {{ $ticket->generated_at->format('M d, Y g:i A') }}</div>
                                                <div>Attendance Marked: {{ $ticket->used_at->format('M d, Y g:i A') }}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $attendance->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12 bg-white rounded-lg shadow">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">
                        @if ($search || $filterEvent || $filterPayment || $filterDate)
                            No attendance records found matching your filters
                        @else
                            No attendance records yet
                        @endif
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Attendance records will appear here after tickets are scanned and marked as used.
                    </p>
                    <div class="mt-6">
                        <button wire:click="resetFilters"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                            Reset Filters
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Export Modal -->
    <x-custom-modal model="showExportModal">
        <div class="max-w-md mx-auto p-6">
            <h1 class="text-xl text-center font-bold mb-2">Export Attendance Report</h1>
            <p class="text-center text-gray-600 mb-6">Export current attendance data to Excel or CSV format.</p>

            <div class="mb-6">
                <p class="text-sm text-gray-700 mb-2">Current filters applied:</p>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li>• Search: {{ $search ?: 'None' }}</li>
                    <li>• Event:
                        {{ $filterEvent ? $events->firstWhere('id', $filterEvent)->title ?? 'Selected Event' : 'All Events' }}
                    </li>
                    <li>• Payment:
                        {{ $filterPayment === 'paid' ? 'Paid Only' : ($filterPayment === 'free' ? 'Free Only' : 'All') }}
                    </li>
                    <li>• Date: {{ $filterDate ? \Carbon\Carbon::parse($filterDate)->format('M d, Y') : 'All Dates' }}
                    </li>
                </ul>
            </div>

            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-gray-700">Export Format</label>
                <div class="flex space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" wire:model="exportFormat" value="xlsx"
                            class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Excel (.xlsx)</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" wire:model="exportFormat" value="csv"
                            class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">CSV (.csv)</span>
                    </label>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="button" wire:click="closeExportModal"
                    class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors font-medium">
                    Cancel
                </button>
                <button type="button" wire:click="exportAttendance"
                    class="flex-1 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors font-medium">
                    Export {{ strtoupper($exportFormat) }}
                </button>
            </div>
        </div>
    </x-custom-modal>
</div>
