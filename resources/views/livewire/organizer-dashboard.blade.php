<div class="flex min-h-screen bg-gray-50">
    <div class="fixed left-0 top-0 h-screen z-40">
        <x-dashboard-sidebar />
    </div>

    <!-- Main Content -->
    <div class="flex-1 lg:ml-64 overflow-y-auto overflow-x-hidden">
        <!-- Fixed Header -->
        <div class="fixed top-0 right-0 left-0 lg:left-64 z-30">
            <x-dashboard-header userRole="Organizer" :userInitials="$userInitials" />
        </div>

        <!-- Dashboard Content -->
        <div class="flex-1 p-6 mt-20 lg:mt-24 overflow-y-auto">
            <!-- Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <x-overview-card title="Event Registrations" :value="$eventRegistrationsCount"
                    icon='<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>'
                    iconColor="blue" />
                <x-overview-card title="Ongoing Events" :value="$ongoingEventsCount"
                    icon='<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>'
                    iconColor="green" />
                <x-overview-card title="Upcoming Events" :value="$upcomingEventsCount"
                    icon='<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
                    iconColor="yellow" />
                <x-overview-card title="Pending Payments" :value="$pendingPaymentsCount"
                    icon='<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>'
                    iconColor="orange" />
            </div>

            <!-- After the Overview Cards section and before the Data Management section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Upcoming Events Card -->
                <div class="bg-white rounded-lg shadow-md p-4 lg:p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg lg:text-xl font-semibold text-gray-800">My Upcoming Events</h2>
                        <a href="{{ route('organizer.events') }}"
                            class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center space-x-1">
                            <span>Create New</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                        </a>
                    </div>

                    <div class="space-y-4">
                        @forelse($upcomingEventsData as $event)
                            @php
                                $startDate = \Carbon\Carbon::parse($event->start_date);
                                $borderColor = match ($loop->index % 3) {
                                    0 => 'border-blue-500',
                                    1 => 'border-green-500',
                                    2 => 'border-orange-500',
                                    default => 'border-blue-500',
                                };
                                $bgColor = match ($loop->index % 3) {
                                    0 => 'bg-blue-50',
                                    1 => 'bg-green-50',
                                    2 => 'bg-orange-50',
                                    default => 'bg-blue-50',
                                };
                            @endphp

                            <div class="flex items-center space-x-4 p-4 border-l-4 {{ $borderColor }} {{ $bgColor }} rounded-lg hover:shadow-md transition-all cursor-pointer transform hover:scale-[1.02]"
                                wire:click="openEventDetailsModal({{ $event->id }})">
                                <div class="text-center min-w-12">
                                    <div class="text-2xl font-bold text-gray-800">{{ $startDate->format('d') }}</div>
                                    <div class="text-xs text-gray-600 uppercase">{{ $startDate->format('M') }}</div>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800">{{ $event->title }}</h3>
                                    <p class="text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }} - 
                                        {{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }} •
                                        {{ $event->type === 'online' ? 'Online' : 'In-person' }}
                                    </p>
                                    @if ($event->require_payment)
                                        <p class="text-xs text-red-600 font-medium mt-1">
                                            Paid Event - ₱{{ number_format($event->payment_amount, 2) }}
                                        </p>
                                    @else
                                        <p class="text-xs text-green-600 font-medium mt-1">Free Event</p>
                                    @endif
                                </div>
                                <div class="text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-lg">
                                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <p class="mt-2 text-gray-600">No upcoming events</p>
                                <p class="text-sm text-gray-500 mt-1">Create your first event to get started</p>
                                <a href="{{ route('organizer.events') }}"
                                    class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    Create Event
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-4 lg:p-6">
                    <livewire:event-calendar />
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6" x-data="{ activeTab: 'registrations' }">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Data Management</h2>
                </div>
                <!-- Tabs -->
                <div class="border-b border-gray-200 mb-4">
                    <nav class="flex space-x-4">
                        <button @click="activeTab = 'registrations'"
                            :class="activeTab === 'registrations' ? 'border-b-2 border-blue-600 text-blue-600' :
                                'text-gray-500 hover:text-gray-700'"
                            class="px-4 py-2 font-medium text-sm transition-colors">
                            Event Registrations
                        </button>
                        <button @click="activeTab = 'payments'"
                            :class="activeTab === 'payments' ? 'border-b-2 border-blue-600 text-blue-600' :
                                'text-gray-500 hover:text-gray-700'"
                            class="px-4 py-2 font-medium text-sm transition-colors">
                            Payments
                        </button>
                    </nav>
                </div>
                <!-- Tab Content -->
                <div class="overflow-x-auto">
                    <!-- Registrations Table for Organizer,  -->
                    <div x-show="activeTab === 'registrations'" x-transition>
                        <livewire:organizer-registrations />
                    </div>

                    <!-- Payments Table -->
                    <div x-show="activeTab === 'payments'" x-transition>
                        <!-- Search and Filter Controls for Payments -->
                        <div class="mb-4 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-gray-700">Payments Management</h3>
                                <button wire:click="openExportModal('payments')"
                                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Export to Excel/CSV
                                </button>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                <!-- Student Search -->
                                <div class="md:col-span-2">
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                            </svg>
                                        </div>
                                        <input type="text" wire:model.live.debounce.300ms="paymentSearch"
                                            class="block w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="Search by student name, email, or ID...">
                                    </div>
                                </div>

                                <!-- Event Filter -->
                                <div>
                                    <select wire:model.live="filterPaymentEvent"
                                        class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">All Events</option>
                                        @foreach ($paidEvents as $event)
                                            <option value="{{ $event->id }}">{{ Str::limit($event->title, 20) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Payment Status Filter -->
                                <div>
                                    <select wire:model.live="filterPaymentStatus"
                                        class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">All Status</option>
                                        <option value="pending">Pending</option>
                                        <option value="verified">Verified</option>
                                        <option value="rejected">Rejected</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Results Per Page -->
                                <div>
                                    <select wire:model.live="paymentsPerPage"
                                        class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                                        <option value="10">10 per page</option>
                                        <option value="25">25 per page</option>
                                        <option value="50">50 per page</option>
                                    </select>
                                </div>

                                <!-- Reset Filters Button -->
                                <div class="md:col-span-2">
                                    <button wire:click="resetPaymentFilters"
                                        class="w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        Reset All Filters
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Success/Info Messages -->
                        @if (session()->has('success'))
                            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session()->has('info'))
                            <div class="mb-4 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded">
                                {{ session('info') }}
                            </div>
                        @endif
                        <div class="overflow-x-auto">
                            @if (count($payments) > 0)
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Student Name
                                            </th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Email
                                            </th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Event
                                            </th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Amount
                                            </th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Registered Date
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($payments as $payment)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-3 text-sm text-gray-900">
                                                    {{ $payment->user->first_name }} {{ $payment->user->last_name }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-600">
                                                    {{ $payment->user->email }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-600">
                                                    {{ Str::limit($payment->event->title, 30) }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-600">
                                                    ₱{{ number_format($payment->event->payment_amount, 2) }}
                                                </td>
                                                <td class="px-4 py-3 text-sm">
                                                    @if ($payment->payment_status === 'verified')
                                                        <span
                                                            class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium">
                                                            <svg class="inline w-4 h-4 mr-1" fill="currentColor"
                                                                viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd"
                                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                            Verified
                                                        </span>
                                                    @elseif($payment->payment_status === 'pending')
                                                        <span
                                                            class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-medium">
                                                            <svg class="inline w-4 h-4 mr-1" fill="currentColor"
                                                                viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd"
                                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                            Pending
                                                        </span>
                                                    @elseif($payment->payment_status === 'rejected')
                                                        <span
                                                            class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-medium">
                                                            <svg class="inline w-4 h-4 mr-1" fill="currentColor"
                                                                viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd"
                                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                            Rejected
                                                        </span>
                                                    @else
                                                        <span
                                                            class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs font-medium">
                                                            Unknown
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-500">
                                                    {{ \Carbon\Carbon::parse($payment->registered_at)->format('M d, Y') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Pagination -->
                                @if ($payments && method_exists($payments, 'links'))
                                    <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
                                        {{ $payments->links() }}
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">
                                        @if ($paymentSearch || $filterPaymentEvent || $filterPaymentStatus)
                                            No payments found matching your filters
                                        @else
                                            No payments found
                                        @endif
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        There are no pending or verified payments for your paid events yet.
                                    </p>
                                    <div class="mt-6">
                                        <button wire:click="refreshPayments"
                                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                                </path>
                                            </svg>
                                            Refresh
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-custom-modal model="showExportPaymentsModal" maxWidth="lg" title="Export Payments Report"
        description="Export current payments table data to Excel or CSV format" headerBg="green">
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
                            <span class="text-green-600">{{ $paymentSearch ?: 'None' }}</span>
                        </p>
                        <p class="text-green-700">
                            <span class="font-medium">Event:</span>
                            <span class="text-green-600">
                                {{ $filterPaymentEvent ? $paidEvents->firstWhere('id', $filterPaymentEvent)->title ?? 'Selected Event' : 'All Events' }}
                            </span>
                        </p>
                    </div>
                    <div class="space-y-2">
                        <p class="text-green-700">
                            <span class="font-medium">Payment Status:</span>
                            <span
                                class="text-green-600">{{ $filterPaymentStatus ? ucfirst($filterPaymentStatus) : 'All' }}</span>
                        </p>
                    </div>
                </div>

                <!-- Total Records Badge -->
                <div class="mt-3 pt-3 border-t border-green-200">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-green-700">Payments to export:</span>
                        <span class="px-3 py-1 bg-green-200 text-green-800 rounded-full text-sm font-semibold">
                            {{ count($payments) }} payments
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
                <button type="button" wire:click="exportData"
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
    <!-- Event Details Modal -->
    <x-custom-modal model="showEventDetailsModal" maxWidth="lg" title="Event Details"
        description="View complete event information" headerBg="green">
        @if ($selectedEvent)
            <div class="space-y-5">
                <!-- Banner Section -->
                <div class="relative h-48 rounded-xl overflow-hidden border border-gray-200 shadow-sm">
                    @if ($selectedEvent->banner)
                        <img src="{{ asset('storage/' . $selectedEvent->banner) }}"
                            alt="{{ $selectedEvent->title }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent"></div>
                    @else
                        <div
                            class="w-full h-full bg-gradient-to-br from-green-600 to-green-800 flex items-center justify-center">
                            <svg class="w-20 h-20 text-white/40" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent"></div>
                    @endif

                    <!-- Title Overlay -->
                    <div class="absolute bottom-0 left-0 right-0 p-5 text-white">
                        <h1 class="text-2xl font-bold mb-1">{{ $selectedEvent->title }}</h1>
                        <div class="flex items-center space-x-3 text-sm">
                            <span
                                class="flex items-center space-x-1.5 bg-black/30 px-3 py-1 rounded-full backdrop-blur-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>Organized by you</span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Description Card -->
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-5 rounded-xl border border-green-200">
                    <h3 class="text-sm font-semibold text-green-800 mb-2 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                        <span>Description</span>
                    </h3>
                    <p class="text-gray-700 leading-relaxed">{{ $selectedEvent->description }}</p>
                </div>

                <!-- Event Details Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- In the Event Details Modal, update the date and time display sections -->
                    <!-- Date -->
                    <div class="bg-white p-4 rounded-xl border border-gray-200 hover:border-green-300 transition-all">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-green-100 rounded-lg">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Start Date</p>
                                <p class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($selectedEvent->start_date)->format('F j, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Time -->
                    <div class="bg-white p-4 rounded-xl border border-gray-200 hover:border-green-300 transition-all">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-green-100 rounded-lg">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Time</p>
                                <p class="font-semibold text-gray-800">
                                    {{ \Carbon\Carbon::parse($selectedEvent->start_time)->format('g:i A') }} - 
                                    {{ \Carbon\Carbon::parse($selectedEvent->end_time)->format('g:i A') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Location/Link -->
                    <div
                        class="col-span-2 bg-white p-4 rounded-xl border border-gray-200 hover:border-green-300 transition-all">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-green-100 rounded-lg">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-gray-500">
                                    {{ $selectedEvent->type === 'online' ? 'Event Link' : 'Location' }}</p>
                                @if ($selectedEvent->type === 'online' && filter_var($selectedEvent->place_link, FILTER_VALIDATE_URL))
                                    <a href="{{ $selectedEvent->place_link }}" target="_blank"
                                        class="font-semibold text-green-600 hover:text-green-700 hover:underline transition-colors flex items-center space-x-1 break-all">
                                        <span>{{ $selectedEvent->place_link }}</span>
                                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                    </a>
                                @else
                                    <p class="font-semibold text-gray-800">{{ $selectedEvent->place_link }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Type and Category -->
                    <div class="bg-white p-4 rounded-xl border border-gray-200">
                        <p class="text-xs text-gray-500 mb-2">Event Type</p>
                        <div class="flex items-center space-x-2">
                            <span
                                class="w-2 h-2 rounded-full {{ $selectedEvent->type === 'online' ? 'bg-green-500' : 'bg-orange-500' }}"></span>
                            <span
                                class="font-medium capitalize">{{ str_replace('-', ' ', $selectedEvent->type) }}</span>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-xl border border-gray-200">
                        <p class="text-xs text-gray-500 mb-2">Category</p>
                        <div class="flex items-center space-x-2">
                            @php
                                $categoryColors = [
                                    'academic' => 'bg-blue-100 text-blue-700',
                                    'sports' => 'bg-green-100 text-green-700',
                                    'cultural' => 'bg-purple-100 text-purple-700',
                                ];
                            @endphp
                            <span
                                class="px-3 py-1.5 rounded-full text-xs font-semibold {{ $categoryColors[$selectedEvent->category] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($selectedEvent->category) }}
                            </span>
                        </div>
                    </div>

                    <!-- Visibility -->
                    <div class="col-span-2 bg-white p-4 rounded-xl border border-gray-200">
                        <p class="text-xs text-gray-500 mb-2">Visibility</p>
                        <div class="flex items-center space-x-2">
                            @if ($selectedEvent->visibility_type === 'all')
                                <span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-sm font-medium">
                                    🌍 Visible to all students
                                </span>
                            @else
                                <span
                                    class="px-3 py-1.5 bg-yellow-100 text-yellow-700 rounded-full text-sm font-medium">
                                    🔒 Restricted access
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div
                        class="col-span-2 bg-gradient-to-r from-gray-50 to-gray-100 p-4 rounded-xl border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="p-2 {{ $selectedEvent->require_payment ? 'bg-yellow-100' : 'bg-green-100' }} rounded-lg">
                                    <svg class="w-5 h-5 {{ $selectedEvent->require_payment ? 'text-yellow-600' : 'text-green-600' }}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Payment Status</p>
                                    @if ($selectedEvent->require_payment)
                                        <p class="text-xl font-bold text-yellow-600">
                                            ₱{{ number_format($selectedEvent->payment_amount, 2) }}</p>
                                    @else
                                        <p class="text-xl font-bold text-green-600">Free Event</p>
                                    @endif
                                </div>
                            </div>
                            @if ($selectedEvent->require_payment)
                                <span
                                    class="px-3 py-1.5 bg-yellow-100 text-yellow-700 rounded-full text-sm font-medium">Paid</span>
                            @else
                                <span
                                    class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-sm font-medium">Free</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Action Buttons - Edit button only shows for events created by this organizer -->
                <div class="flex space-x-3 pt-4 border-t border-gray-200">
                    <button type="button" wire:click="closeEventDetailsModal"
                        class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group">
                        <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>Close</span>
                    </button>
                </div>
            </div>
        @endif
    </x-custom-modal>
    <!-- Add this right before the closing </div> tags of your dashboard content -->
<!-- Calendar Events Modal (Global) -->
<x-custom-modal 
    model="showCalendarEventsModal" 
    maxWidth="lg" 
    title="{{ $selectedCalendarDate ? 'Events for ' . $selectedCalendarDate->format('F j, Y') : 'Events' }}"
    description="{{ $calendarEventCount }} event{{ $calendarEventCount != 1 ? 's' : '' }} scheduled"
    headerBg="blue"
    :showCloseButton="true"
>
    <div class="space-y-4">
        @if(empty($selectedCalendarEvents) || count($selectedCalendarEvents) === 0)
            <div class="text-center py-8 text-gray-500">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="text-lg">No events scheduled for this day</p>
            </div>
        @else
            <div class="space-y-3 max-h-96 overflow-y-auto pr-2">
                @foreach($selectedCalendarEvents as $event)
                    <div class="p-4 border-l-4 border-blue-500 bg-blue-50 rounded-lg hover:shadow-md transition-all cursor-pointer hover:scale-[1.02] transform" wire:click="handleEventClick({{ $event['id'] }})">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-800 text-lg mb-2">{{ $event['title'] }}</h4>
                                <div class="grid grid-cols-2 gap-3 text-sm">
                                    <!-- Update the time display in the calendar events modal -->
                                    <div class="flex items-center space-x-2 text-gray-600">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>{{ \Carbon\Carbon::parse($event['start_time'])->format('g:i A') }} - 
                                            {{ \Carbon\Carbon::parse($event['end_time'])->format('g:i A') }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-gray-600">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span class="capitalize">{{ str_replace('-', ' ', $event['type']) }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-gray-600 col-span-2">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z" />
                                        </svg>
                                        <span class="capitalize">{{ $event['category'] }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="ml-4">
                                @if($event['require_payment'])
                                    <span class="inline-flex items-center px-3 py-1.5 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        ₱{{ number_format($event['payment_amount'], 2) }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Free
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Modal Footer -->
    <x-slot name="footer">
        <button type="button" 
                wire:click="closeCalendarEventsModal"
                class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium text-sm">
            Close
        </button>
    </x-slot>
</x-custom-modal>
</div>
