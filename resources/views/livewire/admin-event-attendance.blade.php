<div class="flex min-h-screen bg-gray-50">
    <div class="fixed left-0 top-0 h-screen z-40">
        <x-dashboard-sidebar />
    </div>

    <!-- Main Content -->
    <div class="flex-1 lg:ml-64 overflow-y-auto overflow-x-hidden">
        <div class="fixed top-0 right-0 left-0 lg:left-64 z-30">
            <x-dashboard-header userRole="Admin" :userInitials="$userInitials" />
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6 mt-20 lg:mt-24">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <div class="h-10 w-2 bg-gradient-to-b from-blue-600 to-blue-500 rounded-full"></div>
                            <h1 class="text-3xl font-bold text-gray-800">Event Attendance Overview</h1>
                        </div>
                        <p class="text-sm text-gray-600 ml-5">Monitor attendance across all events and organizers</p>
                    </div>
                    <button wire:click="openExportModal"
                        class="px-4 py-2.5 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-200 font-medium flex items-center gap-2 shadow-lg shadow-green-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Export to Excel/CSV
                    </button>
                </div>
            </div>

            <!-- Filters Card - Modern Design (Matching Audit Logs) -->
            <div class="bg-white rounded-2xl shadow-xl p-6 mb-8 border-t-4 border-t-blue-600">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <span class="bg-blue-100 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                        </span>
                        Filter Attendance
                    </h3>
                    <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                        {{ $attendance->total() }} records found
                    </span>
                </div>

                <!-- First Row of Filters -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search - Full Width -->
                    <div class="md:col-span-2">
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" wire:model.live.debounce.300ms="search"
                                class="block w-full pl-10 pr-4 py-3 text-sm border-2 border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                placeholder="Search by ticket number, student name, email, or ID...">
                        </div>
                    </div>

                    <!-- Event Filter -->
                    <div>
                        <select wire:model.live="filterEvent"
                            class="block w-full px-4 py-3 text-sm border-2 border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all appearance-none cursor-pointer">
                            <option value="">All Events</option>
                            @foreach ($events as $event)
                                <option value="{{ $event->id }}">{{ Str::limit($event->title, 25) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Payment Filter -->
                    <div>
                        <select wire:model.live="filterPayment"
                            class="block w-full px-4 py-3 text-sm border-2 border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all appearance-none cursor-pointer">
                            <option value="">All Events</option>
                            <option value="paid">Paid Events</option>
                            <option value="free">Free Events</option>
                        </select>
                    </div>
                </div>

                <!-- Second Row of Filters -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                    <!-- Organizer Filter -->
                    <div>
                        <select wire:model.live="filterOrganizer"
                            class="block w-full px-4 py-3 text-sm border-2 border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all appearance-none cursor-pointer">
                            <option value="">All Organizers</option>
                            @foreach ($organizers as $organizer)
                                <option value="{{ $organizer->id }}">
                                    {{ $organizer->first_name }} {{ $organizer->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date Filter -->
                    <div>
                        <input type="date" wire:model.live="filterDate"
                            class="block w-full px-4 py-3 text-sm border-2 border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    </div>

                    <!-- Results Per Page -->
                    <div>
                        <select wire:model.live="perPage"
                            class="block w-full px-4 py-3 text-sm border-2 border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all appearance-none cursor-pointer">
                            <option value="10">10 per page</option>
                            <option value="25">25 per page</option>
                            <option value="50">50 per page</option>
                            <option value="100">100 per page</option>
                        </select>
                    </div>

                    <!-- Reset Filters Button -->
                    <div>
                        <button wire:click="resetFilters"
                            class="w-full px-4 py-3 text-sm font-medium text-yellow-700 bg-yellow-50 border-2 border-yellow-300 rounded-xl hover:bg-yellow-100 focus:ring-2 focus:ring-yellow-500 transition-all flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Reset Filters
                        </button>
                    </div>
                </div>
            </div>

            <!-- Attendance Table -->
            @if (count($attendance) > 0)
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gradient-to-r from-blue-600 to-blue-700">
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0z" />
                                            </svg>
                                            Ticket & Student Info
                                        </div>
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                            </svg>
                                            Event Details
                                        </div>
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                            </svg>
                                            Payment & Registration
                                        </div>
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Attendance
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($attendance as $index => $ticket)
                                    <tr
                                        class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-blue-50/30' }} hover:bg-yellow-50 transition-colors duration-150">
                                        <!-- Ticket & Student Info -->
                                        <td class="px-6 py-4">
                                            <div class="flex items-start space-x-3">
                                                <div class="flex-shrink-0">
                                                    <div
                                                        class="h-10 w-10 bg-gradient-to-br from-blue-100 to-yellow-100 rounded-lg flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-blue-600" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center gap-2 mb-1">
                                                        <span
                                                            class="text-sm font-semibold text-blue-600">{{ $ticket->ticket_number }}</span>
                                                        <span
                                                            class="px-2 py-0.5 text-xs bg-gray-100 text-gray-600 rounded-full">Ticket</span>
                                                    </div>
                                                    <div class="font-medium text-gray-900">
                                                        {{ $ticket->registration->user->first_name }}
                                                        {{ $ticket->registration->user->last_name }}
                                                    </div>
                                                    <div class="text-xs text-gray-500 flex items-center gap-1 mt-1">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                        {{ $ticket->registration->user->email }}
                                                    </div>
                                                    <div class="flex flex-wrap gap-2 mt-2">
                                                        @if ($ticket->registration->user->student_id)
                                                            <span
                                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-blue-100 text-blue-700">
                                                                <svg class="w-3 h-3 mr-1" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0z" />
                                                                </svg>
                                                                ID: {{ $ticket->registration->user->student_id }}
                                                            </span>
                                                        @endif
                                                        @if ($ticket->registration->user->grade_level || $ticket->registration->user->year_level)
                                                            <span
                                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-purple-100 text-purple-700">
                                                                <svg class="w-3 h-3 mr-1" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                                                                </svg>
                                                                {{ $ticket->registration->user->grade_level ? 'Grade ' . $ticket->registration->user->grade_level : 'Year ' . $ticket->registration->user->year_level }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="text-xs text-gray-600 mt-1 font-medium">
                                                        {{ $ticket->registration->user->college_program ?? ($ticket->registration->user->shs_strand ?? '') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Event Details -->
                                        <td class="px-6 py-4">
                                            <div class="flex items-start space-x-3">
                                                <div class="flex-shrink-0">
                                                    <div
                                                        class="h-10 w-10 bg-gradient-to-br from-green-100 to-emerald-100 rounded-lg flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-green-600" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="font-semibold text-gray-900 mb-1">
                                                        {{ $ticket->registration->event->title }}</div>
                                                    <div class="flex items-center text-xs text-gray-600 mb-2">
                                                        <svg class="w-3 h-3 mr-1" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                        {{ $ticket->registration->event->creator->first_name }}
                                                        {{ $ticket->registration->event->creator->last_name }}
                                                    </div>
                                                    <p class="text-xs text-gray-600 mb-2 line-clamp-2">
                                                        {{ Str::limit($ticket->registration->event->description, 60) }}
                                                    </p>
                                                    <div class="space-y-1">
                                                        <div class="flex items-center text-xs text-gray-700">
                                                            <svg class="w-3 h-3 mr-1 text-gray-500" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                            {{ $ticket->registration->event->start_date->format('M d, Y') }}
                                                            -
                                                            {{ $ticket->registration->event->end_date->format('M d, Y') }}
                                                        </div>
                                                        <div class="flex items-center text-xs text-gray-700">
                                                            <svg class="w-3 h-3 mr-1 text-gray-500" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            {{ \Carbon\Carbon::parse($ticket->registration->event->start_time)->format('g:i A') }}
                                                            -
                                                            {{ \Carbon\Carbon::parse($ticket->registration->event->end_time)->format('g:i A') }}
                                                        </div>
                                                    </div>
                                                    <div class="flex flex-wrap gap-1 mt-2">
                                                        <span
                                                            class="px-2 py-0.5 text-xs rounded-full bg-blue-100 text-blue-700 flex items-center">
                                                            <svg class="w-3 h-3 mr-1" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a3 3 0 01-3-3V6a3 3 0 013-3z" />
                                                            </svg>
                                                            {{ ucfirst($ticket->registration->event->category) }}
                                                        </span>
                                                        <span
                                                            class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-700 flex items-center">
                                                            <svg class="w-3 h-3 mr-1" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />
                                                            </svg>
                                                            {{ ucfirst(str_replace('-', ' ', $ticket->registration->event->type)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Payment & Registration -->
                                        <td class="px-6 py-4">
                                            <div class="flex items-start space-x-3">
                                                <div class="flex-shrink-0">
                                                    <div
                                                        class="h-10 w-10 bg-gradient-to-br from-yellow-100 to-orange-100 rounded-lg flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-yellow-600" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="flex-1">
                                                    @if ($ticket->registration->event->require_payment)
                                                        <div class="mb-2">
                                                            <span
                                                                class="inline-flex items-center px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700 font-medium">
                                                                <svg class="w-3 h-3 mr-1" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                                ₱{{ number_format($ticket->registration->event->payment_amount, 2) }}
                                                            </span>
                                                        </div>
                                                        <div class="flex items-center text-xs mb-1">
                                                            <span
                                                                class="font-medium text-gray-600 mr-2">Payment:</span>
                                                            @if ($ticket->registration->payment_status === 'verified')
                                                                <span class="inline-flex items-center text-green-600">
                                                                    <svg class="w-3 h-3 mr-1" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                    Verified
                                                                </span>
                                                            @elseif($ticket->registration->payment_status === 'pending')
                                                                <span class="inline-flex items-center text-yellow-600">
                                                                    <svg class="w-3 h-3 mr-1" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                    Pending
                                                                </span>
                                                            @else
                                                                <span class="inline-flex items-center text-red-600">
                                                                    <svg class="w-3 h-3 mr-1" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                    {{ ucfirst($ticket->registration->payment_status) }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 text-xs rounded-full bg-green-100 text-green-700 font-medium mb-2">
                                                            <svg class="w-3 h-3 mr-1" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            Free Event
                                                        </span>
                                                    @endif

                                                    <div class="space-y-1 mt-2 text-xs text-gray-600">
                                                        <div class="flex items-center">
                                                            <svg class="w-3 h-3 mr-1 text-gray-400" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            Registered:
                                                            {{ $ticket->registration->registered_at->format('M d, Y g:i A') }}
                                                        </div>
                                                        @if ($ticket->registration->payment_verified_at && $ticket->registration->payment_verified_by)
                                                            <div class="flex items-center">
                                                                <svg class="w-3 h-3 mr-1 text-gray-400" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                                Verified:
                                                                {{ $ticket->registration->payment_verified_at->format('M d, Y') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Attendance -->
                                        <td class="px-6 py-4">
                                            <div class="flex items-start space-x-3">
                                                <div class="flex-shrink-0">
                                                    <div
                                                        class="h-10 w-10 bg-gradient-to-br from-green-100 to-emerald-100 rounded-lg flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-green-600" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="flex-1">
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 text-xs rounded-full bg-green-100 text-green-700 font-medium mb-2">
                                                        <svg class="w-3 h-3 mr-1" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        Present
                                                    </span>

                                                    <div class="space-y-1 text-xs text-gray-600">
                                                        <div class="flex items-center">
                                                            <svg class="w-3 h-3 mr-1 text-gray-400" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0z" />
                                                            </svg>
                                                            Generated:
                                                            {{ $ticket->generated_at->format('M d, Y g:i A') }}
                                                        </div>
                                                        <div class="flex items-center">
                                                            <svg class="w-3 h-3 mr-1 text-gray-400" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            Marked: {{ $ticket->used_at->format('M d, Y g:i A') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Modern Pagination (Matching Audit Logs) -->
                <div class="mt-6 bg-white rounded-2xl shadow-xl p-4">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div class="text-sm text-gray-600">
                            Showing <span class="font-semibold text-blue-600">{{ $attendance->firstItem() }}</span>
                            to <span class="font-semibold text-blue-600">{{ $attendance->lastItem() }}</span>
                            of <span class="font-semibold text-blue-600">{{ $attendance->total() }}</span> results
                        </div>

                        <div class="flex items-center gap-2">
                            @if ($attendance->onFirstPage())
                                <span
                                    class="px-3 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-200 rounded-lg cursor-not-allowed">
                                    Previous
                                </span>
                            @else
                                <button wire:click="previousPage" wire:loading.attr="disabled"
                                    class="px-3 py-2 text-sm font-medium text-blue-600 bg-white border border-blue-200 rounded-lg hover:bg-blue-50 transition-colors">
                                    Previous
                                </button>
                            @endif

                            <div class="flex items-center gap-1">
                                @php
                                    $currentPage = $attendance->currentPage();
                                    $lastPage = $attendance->lastPage();
                                    $start = max($currentPage - 2, 1);
                                    $end = min($currentPage + 2, $lastPage);
                                @endphp

                                @if ($start > 1)
                                    <button wire:click="gotoPage(1)"
                                        class="w-10 h-10 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-blue-50 transition-colors">
                                        1
                                    </button>
                                    @if ($start > 2)
                                        <span class="px-2 text-gray-400">...</span>
                                    @endif
                                @endif

                                @for ($page = $start; $page <= $end; $page++)
                                    @if ($page == $currentPage)
                                        <span
                                            class="w-10 h-10 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-yellow-600 border border-transparent rounded-lg flex items-center justify-center">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <button wire:click="gotoPage({{ $page }})"
                                            class="w-10 h-10 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-blue-50 transition-colors">
                                            {{ $page }}
                                        </button>
                                    @endif
                                @endfor

                                @if ($end < $lastPage)
                                    @if ($end < $lastPage - 1)
                                        <span class="px-2 text-gray-400">...</span>
                                    @endif
                                    <button wire:click="gotoPage({{ $lastPage }})"
                                        class="w-10 h-10 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-blue-50 transition-colors">
                                        {{ $lastPage }}
                                    </button>
                                @endif
                            </div>

                            @if ($attendance->hasMorePages())
                                <button wire:click="nextPage" wire:loading.attr="disabled"
                                    class="px-3 py-2 text-sm font-medium text-blue-600 bg-white border border-blue-200 rounded-lg hover:bg-blue-50 transition-colors">
                                    Next
                                </button>
                            @else
                                <span
                                    class="px-3 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-200 rounded-lg cursor-not-allowed">
                                    Next
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty State (Matching Audit Logs Style) -->
                <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
                    <div class="flex flex-col items-center justify-center">
                        <svg class="w-16 h-16 mb-4 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900">
                            @if ($search || $filterEvent || $filterPayment || $filterDate || $filterOrganizer)
                                No attendance records found matching your filters
                            @else
                                No attendance records yet
                            @endif
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Attendance records will appear here after tickets are scanned and marked as used.
                        </p>
                        @if ($search || $filterEvent || $filterPayment || $filterDate || $filterOrganizer)
                            <div class="mt-6">
                                <button wire:click="resetFilters"
                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-600 to-yellow-700 text-white rounded-xl hover:from-yellow-700 hover:to-yellow-800 transition-all duration-200 font-medium shadow-lg shadow-yellow-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Reset Filters
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Export Modal (Matching Audit Logs Style) -->
    <x-custom-modal model="showExportModal" maxWidth="lg" title="Export Attendance Report"
        description="Export attendance data to Excel or CSV format" headerBg="green">
        <div class="space-y-6">
            <!-- Current Filters Summary Card -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-5 rounded-xl border border-green-200">
                <div class="flex items-center space-x-2 mb-3">
                    <div class="p-1.5 bg-green-200 rounded-lg">
                        <svg class="w-4 h-4 text-green-700" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
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
                                {{ $filterEvent ? $events->firstWhere('id', $filterEvent)->title ?? 'Selected Event' : 'All Events' }}
                            </span>
                        </p>
                        <p class="text-green-700">
                            <span class="font-medium">Organizer:</span>
                            <span class="text-green-600">
                                {{ $filterOrganizer ? $organizers->firstWhere('id', $filterOrganizer)?->first_name . ' ' . $organizers->firstWhere('id', $filterOrganizer)?->last_name ?? 'Selected Organizer' : 'All Organizers' }}
                            </span>
                        </p>
                    </div>
                    <div class="space-y-2">
                        <p class="text-green-700">
                            <span class="font-medium">Payment:</span>
                            <span
                                class="text-green-600">{{ $filterPayment === 'paid' ? 'Paid Only' : ($filterPayment === 'free' ? 'Free Only' : 'All') }}</span>
                        </p>
                        <p class="text-green-700">
                            <span class="font-medium">Date:</span>
                            <span
                                class="text-green-600">{{ $filterDate ? \Carbon\Carbon::parse($filterDate)->format('M d, Y') : 'All Dates' }}</span>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Choose Export Format</span>
                </label>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Excel Option -->
                    <label class="relative cursor-pointer">
                        <input type="radio" wire:model="exportFormat" value="xlsx" class="sr-only peer">
                        <div
                            class="p-4 bg-white border-2 border-gray-200 rounded-xl peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-green-300 transition-all duration-200">
                            <div class="flex flex-col items-center text-center">
                                <div class="p-3 bg-green-100 rounded-full mb-2">
                                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z" />
                                        <path d="M14 2v6h6M8 13h8M8 17h4" stroke="white" stroke-width="2" />
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
                        <div
                            class="p-4 bg-white border-2 border-gray-200 rounded-xl peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-green-300 transition-all duration-200">
                            <div class="flex flex-col items-center text-center">
                                <div class="p-3 bg-green-100 rounded-full mb-2">
                                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z" />
                                        <text x="8" y="18" fill="white" font-size="10"
                                            font-weight="bold">CSV</text>
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
                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Cancel</span>
                </button>
                <button type="button" wire:click="exportAttendance"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group shadow-lg shadow-green-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span>Export</span>
                </button>
            </div>
        </div>
    </x-custom-modal>
</div>