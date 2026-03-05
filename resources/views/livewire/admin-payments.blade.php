<div>
    <!-- Success/Info Messages -->
    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('info'))
        <div class="mb-4 p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded">
            {{ session('info') }}
        </div>
    @endif

    <!-- Main Container -->
    <div class="bg-white rounded-lg shadow-md p-1.5">
        <div class="overflow-x-auto">
            <div
                class="relative bg-gradient-to-br from-yellow-50 to-yellow-50 shadow-xs rounded-xl border border-yellow-100">

                <!-- Search and Filter Controls -->
                <div class="p-5 bg-white/80 backdrop-blur-sm border-b border-yellow-100 rounded-t-xl">
                    <div class="flex justify-between items-center mb-5 gap-2">
                        <h3 class="text-lg font-semibold text-yellow-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Payments
                        </h3>
                        <button wire:click="openExportModal"
                            class="px-4 py-2 bg-gradient-to-r from-green-600 to-green-800 text-white rounded-lg hover:from-green-500 hover:to-green-600 transition-all duration-200 text-sm font-medium flex items-center gap-2 shadow-md shadow-green-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Export to Excel/CSV
                        </button>
                    </div>

                    <!-- Filter Grid -->
                    <div class="space-y-4">
                        <!-- First Row -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                            <!-- Search Box - Expanded -->
                            <div class="md:col-span-2">
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-yellow-400 group-focus-within:text-yellow-500 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" wire:model.live.debounce.300ms="paymentSearch"
                                        class="block w-full pl-10 pr-4 py-2.5 text-sm border-2 border-yellow-200 rounded-xl bg-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 group-hover:border-yellow-300"
                                        placeholder="Search by student name, email, or ID...">
                                </div>
                            </div>

                            <!-- Event Filter -->
                            <div>
                                <select wire:model.live="filterPaymentEvent"
                                    class="block w-full px-3 py-2.5 text-sm border-2 border-yellow-200 rounded-xl bg-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 hover:border-yellow-300 appearance-none cursor-pointer">
                                    <option value="">📋 All Events</option>
                                    @foreach ($paidEvents as $event)
                                        <option value="{{ $event->id }}">{{ Str::limit($event->title, 25) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Payment Status Filter -->
                            <div>
                                <select wire:model.live="filterPaymentStatus"
                                    class="block w-full px-3 py-2.5 text-sm border-2 border-yellow-200 rounded-xl bg-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 hover:border-yellow-300">
                                    <option value="">💰 All Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="verified">Verified</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>
                        </div>

                        <!-- Second Row -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                            <!-- Results Per Page -->
                            <div>
                                <select wire:model.live="paymentsPerPage"
                                    class="block w-full px-3 py-2.5 text-sm border-2 border-yellow-200 rounded-xl bg-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 hover:border-yellow-300">
                                    <option value="10">📄 10 per page</option>
                                    <option value="25">📄 25 per page</option>
                                    <option value="50">📄 50 per page</option>
                                    <option value="100">📄 100 per page</option>
                                </select>
                            </div>

                            <!-- Reset Filters Button - spans 3 columns -->
                            <div class="md:col-span-3">
                                <button wire:click="resetPaymentFilters"
                                    class="w-full px-4 py-2.5 text-sm font-medium text-yellow-700 bg-yellow-50 border-2 border-yellow-200 rounded-xl hover:bg-yellow-50 hover:border-yellow-400 hover:text-yellow-700 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Reset All Filters
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payments Table -->
                <div class="overflow-x-auto">
                    @if ($payments->count() > 0)
                        <table class="min-w-full divide-y divide-yellow-100">
                            <thead class="bg-gradient-to-r from-yellow-400 to-yellow-700">
                                <tr>
                                    <th
                                        class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        Student</th>
                                    <th
                                        class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        Email</th>
                                    <th
                                        class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        Event</th>
                                    <th
                                        class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        Organizer</th>
                                    <th
                                        class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        Amount</th>
                                    <th
                                        class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        Registered Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-yellow-50">
                                @foreach ($payments as $index => $payment)
                                    <tr
                                        class="{{ $index % 2 === 0 ? 'bg-white hover:bg-yellow-50' : 'bg-yellow-50/30 hover:bg-yellow-100' }} transition-colors duration-150 group">
                                        <!-- Student Name -->
                                        <td class="px-4 py-3">
                                            <span
                                                class="text-sm font-medium text-gray-900">{{ $payment->user->first_name }}
                                                {{ $payment->user->last_name }}</span>
                                        </td>

                                        <!-- Email -->
                                        <td class="px-4 py-3">
                                            <span class="text-sm text-gray-600">{{ $payment->user->email }}</span>
                                        </td>

                                        <!-- Event -->
                                        <td class="px-4 py-3">
                                            <span
                                                class="text-sm text-gray-900">{{ Str::limit($payment->event->title, 25) }}</span>
                                        </td>

                                        <!-- Organizer -->
                                        <td class="px-4 py-3 text-sm text-gray-600">
                                            {{ $payment->event->creator->first_name ?? 'N/A' }}
                                            {{ $payment->event->creator->last_name ?? '' }}
                                        </td>

                                        <!-- Amount -->
                                        <td class="px-4 py-3">
                                            <span
                                                class="text-sm font-medium text-gray-900">₱{{ number_format($payment->event->payment_amount, 2) }}</span>
                                        </td>

                                        <!-- Payment Status -->
                                        <td class="px-4 py-3">
                                            @if ($payment->payment_status === 'verified')
                                                <div class="flex flex-col">
                                                    <span
                                                        class="px-2 py-1 bg-green-100 text-green-800 rounded-lg text-xs font-medium flex items-center gap-1">
                                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        Verified
                                                    </span>
                                                    @if ($payment->payment_verified_at)
                                                        <span
                                                            class="text-xs text-gray-500 mt-1">{{ $payment->payment_verified_at->format('M d, Y') }}</span>
                                                    @endif
                                                </div>
                                            @elseif($payment->payment_status === 'pending')
                                                <span
                                                    class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-lg text-xs font-medium flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    Pending
                                                </span>
                                            @elseif($payment->payment_status === 'rejected')
                                                <span
                                                    class="px-2 py-1 bg-red-100 text-red-800 rounded-lg text-xs font-medium flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    Rejected
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Registered Date -->
                                        <td class="px-4 py-3 text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($payment->registered_at)->format('M d, Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
                <!-- Pagination -->
                @if ($payments && method_exists($payments, 'links'))
                    <div class="px-4 py-4 bg-white/80 backdrop-blur-sm border-t border-yellow-100 rounded-b-xl">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-yellow-700">
                                Showing <span class="font-semibold">{{ $payments->firstItem() ?? 0 }}</span>
                                to <span class="font-semibold">{{ $payments->lastItem() ?? 0 }}</span>
                                of <span class="font-semibold">{{ $payments->total() }}</span> results
                            </div>

                            <div class="flex items-center space-x-2">
                                @if ($payments->onFirstPage())
                                    <span class="px-3 py-2 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </span>
                                @else
                                    <button wire:click="previousPage"
                                        class="px-3 py-2 bg-white text-yellow-600 border-2 border-yellow-200 rounded-lg hover:bg-yellow-400 hover:text-white hover:border-yellow-400 transition-all duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </button>
                                @endif

                                @foreach ($payments->getUrlRange(max(1, $payments->currentPage() - 2), min($payments->lastPage(), $payments->currentPage() + 2)) as $page => $url)
                                    <button wire:click="gotoPage({{ $page }})"
                                        class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 
                                            {{ $page === $payments->currentPage()
                                                ? 'bg-gradient-to-r from-yellow-600 to-yellow-700 text-white shadow-md shadow-yellow-200'
                                                : 'bg-white text-yellow-700 border-2 border-yellow-200 hover:bg-yellow-400 hover:text-white hover:border-yellow-400' }}">
                                        {{ $page }}
                                    </button>
                                @endforeach

                                @if ($payments->hasMorePages())
                                    <button wire:click="nextPage"
                                        class="px-3 py-2 bg-white text-yellow-600 border-2 border-yellow-200 rounded-lg hover:bg-yellow-400 hover:text-white hover:border-yellow-400 transition-all duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                @else
                                    <span class="px-3 py-2 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="px-4 py-12 text-center text-gray-500">
                    <div class="flex flex-col items-center justify-center">
                        <svg class="w-16 h-16 mb-4 text-yellow-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <p class="text-lg font-medium text-yellow-800">No payments found</p>
                        <p class="text-sm text-yellow-600 mt-1">
                            @if ($paymentSearch || $filterPaymentEvent || $filterPaymentStatus)
                                Try adjusting your search or filters
                            @else
                                No payments in the system yet
                            @endif
                        </p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Export Modal -->
    <x-custom-modal model="showExportPaymentsModal" maxWidth="lg" title="Export Payments Report"
        description="Export all payments data with applied filters" headerBg="green">
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
                            {{ $payments->total() }} payments
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
</div>