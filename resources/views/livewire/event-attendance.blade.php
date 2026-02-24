{{-- resources/views/livewire/event-attendance.blade.php --}}
<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <x-dashboard-sidebar />

    <!-- Main Content -->
    <div class="flex-1 overflow-y-auto overflow-x-hidden">
        <div class="fixed top-0 right-0 left-0 lg:left-64 z-30">
            <x-dashboard-header userRole="Organizer" :userInitials="$userInitials" />
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6 mt-20 lg:mt-24">
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
    <!-- Export Attendance Modal -->
<x-custom-modal 
    model="showExportModal" 
    maxWidth="lg" 
    title="Export Attendance Report" 
    description="Export current attendance data to Excel or CSV format" 
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
                            {{ $filterEvent ? ($events->firstWhere('id', $filterEvent)->title ?? 'Selected Event') : 'All Events' }}
                        </span>
                    </p>
                </div>
                <div class="space-y-2">
                    <p class="text-green-700">
                        <span class="font-medium">Payment:</span> 
                        <span class="text-green-600">{{ $filterPayment === 'paid' ? 'Paid Only' : ($filterPayment === 'free' ? 'Free Only' : 'All') }}</span>
                    </p>
                    <p class="text-green-700">
                        <span class="font-medium">Date:</span> 
                        <span class="text-green-600">{{ $filterDate ? \Carbon\Carbon::parse($filterDate)->format('M d, Y') : 'All Dates' }}</span>
                    </p>
                </div>
            </div>
            
            <!-- Total Records Badge -->
            <div class="mt-3 pt-3 border-t border-green-200">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-green-700">Records to export:</span>
                    <span class="px-3 py-1 bg-green-200 text-green-800 rounded-full text-sm font-semibold">
                        {{ count($attendance) }} attendance records
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
            <button type="button" wire:click="exportAttendance"
                class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group shadow-lg shadow-green-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                <span>Export</span>
            </button>
        </div>
    </div>
</x-custom-modal>
</div>
