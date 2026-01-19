<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <x-dashboard-sidebar />

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Header -->
        <x-dashboard-header userRole="Organizer" :userInitials="$userInitials" />

        <!-- Dashboard Content -->
        <div class="flex-1 p-6">
            <!-- Overview Cards -->
            <!-- organizer-dashboard.blade.php -->
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

            <!-- Tabbed Tables Section <button class="px-4 py-2 text-sm text-blue-600 hover:text-blue-700 font-medium">View All</button> -->
            <div class="bg-white rounded-lg shadow-md p-6" x-data="{ activeTab: 'registrations' }">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Data Management</h2>
                    <x-custom-modal model="showCreateModal">
                        <h1 class="text-xl text-center font-bold mb-4">Create Event</h1>
                        @if (session()->has('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form wire:submit.prevent="createEvent" class="max-w-md mx-auto">
                            <div class="mb-5">
                                <label for="title" class="block mb-2.5 text-sm font-medium text-heading">Event
                                    Title</label>
                                <input type="text" id="title" wire:model="title"
                                    class="w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="Enter Event Title...">
                                @error('title')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex flex-col mb-5">
                                <h3 class="font-medium text-gray-700 mb-2">Event Date and Time</h3>
                                <div class="flex flex-row gap-2">
                                    <div class="w-1/2">
                                        <input type="date" wire:model="date"
                                            class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        @error('date')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="w-1/2">
                                        <input type="time" wire:model="time"
                                            class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        @error('time')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col mb-5">
                                <h2 class="font-medium text-gray-700 mb-2">Event Type</h2>
                                <select wire:model="type"
                                    class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">Select Type</option>
                                    <option value="online">Online</option>
                                    <option value="face-to-face">Face-to-face</option>
                                </select>
                                @error('type')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror

                                <h3 class="font-medium text-gray-700 mt-3 mb-2">Event Place or Link</h3>
                                <input type="text" wire:model="place_link"
                                    class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="Enter Event Place or Link...">
                                @error('place_link')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex flex-col mb-5">
                                <h2 class="font-medium text-gray-700 mb-2">Event Category</h2>
                                <select wire:model="category"
                                    class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">Select Category</option>
                                    <option value="academic">Academic</option>
                                    <option value="sports">Sports</option>
                                    <option value="cultural">Cultural</option>
                                </select>
                                @error('category')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex flex-col mb-5">
                                <h2 class="font-medium text-gray-700 mb-2">Event Description</h2>
                                <textarea wire:model="description" rows="3"
                                    class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="Enter Event Description..."></textarea>
                                @error('description')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex flex-col mb-5">
                                <h2 class="font-medium text-gray-700 mb-2">Event Banner</h2>
                                <div class="flex items-center justify-center w-full">
                                    <label for="dropzone-file"
                                        class="flex flex-col items-center justify-center w-full h-32 bg-neutral-secondary-medium border border-dashed border-default-strong rounded-base cursor-pointer hover:bg-neutral-tertiary-medium">
                                        <div class="flex flex-col items-center justify-center text-body">
                                            <svg class="w-8 h-8 mb-2" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M15 17h3a3 3 0 0 0 0-6h-.025a5.56 5.56 0 0 0 .025-.5A5.5 5.5 0 0 0 7.207 9.021C7.137 9.017 7.071 9 7 9a4 4 0 1 0 0 8h2.167M12 19v-9m0 0-2 2m2-2 2 2" />
                                            </svg>
                                            <p class="mb-1 text-sm">
                                                <span class="font-semibold">Click to upload</span> or drag and drop
                                            </p>
                                            <p class="text-xs">JPG or PNG (MAX. 2MB)</p>
                                        </div>
                                        <input id="dropzone-file" type="file" class="hidden"
                                            wire:model="banner" />
                                    </label>
                                </div>
                                @error('banner')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                                @if ($banner)
                                    <p class="text-xs text-green-600 mt-1">File selected:
                                        {{ $banner->getClientOriginalName() }}</p>
                                @endif
                            </div>

                            <div class="flex items-center mb-5">
                                <input id="default-checkbox" type="checkbox" wire:model="require_payment"
                                    class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft">
                                <label for="default-checkbox"
                                    class="select-none ms-2 text-sm font-medium text-heading">
                                    Require Payment
                                </label>
                            </div>

                            @if ($require_payment)
                                <div class="flex flex-col mb-5">
                                    <label for="payment_amount" class="block mb-2.5 text-sm font-medium text-heading">
                                        Payment Amount
                                    </label>
                                    <input type="number" id="payment_amount" wire:model="payment_amount"
                                        step="0.01" min="0"
                                        class="block w-full px-3 py-2.5 bg-white border border-gray-300 rounded-md shadow-sm text-heading text-sm focus:ring-brand focus:border-brand placeholder:text-body"
                                        placeholder="Enter amount (e.g., 50.00)" />
                                    @error('payment_amount')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif

                            <div class="mb-5 flex gap-2">
                                <button type="button" wire:click="closeCreateModal"
                                    class="w-1/2 px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="w-1/2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                                    Publish Event
                                </button>
                            </div>
                        </form>
                    </x-custom-modal>
                    <button wire:click="openCreateModal"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">Create
                        Event</button>
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
                        <button @click="activeTab = 'events'"
                            :class="activeTab === 'events' ? 'border-b-2 border-blue-600 text-blue-600' :
                                'text-gray-500 hover:text-gray-700'"
                            class="px-4 py-2 font-medium text-sm transition-colors">
                            Events
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
                    <!-- Payments Table -->
                    <div x-show="activeTab === 'payments'" x-transition>
                        <!-- Search and Filter Controls for Payments -->
                        <!-- Search and Filter Controls for Payments -->
                        <div class="mb-4 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                <!-- Student Search -->
                                <div class="md:col-span-2">
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
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
                                        @foreach($paidEvents as $event)
                                            <option value="{{ $event->id }}">{{ Str::limit($event->title, 20) }}</option>
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
                    
                    @if(count($payments) > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Student Name
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Event
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Amount
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Registered Date
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($payments as $payment)
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
                                            @if($payment->payment_status === 'verified')
                                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium">
                                                    <svg class="inline w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Verified
                                                </span>
                                            @elseif($payment->payment_status === 'pending')
                                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-medium">
                                                    <svg class="inline w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Pending
                                                </span>
                                            @elseif($payment->payment_status === 'rejected')
                                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-medium">
                                                    <svg class="inline w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Rejected
                                                </span>
                                            @else
                                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs font-medium">
                                                    Unknown
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($payment->registered_at)->format('M d, Y') }}
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            @if($payment->payment_status === 'pending')
                                                <div class="flex space-x-2">
                                                    <button 
                                                        wire:click="verifyPayment({{ $payment->id }})"
                                                        class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs font-medium transition-colors"
                                                        title="Verify Payment">
                                                        Verify
                                                    </button>
                                                    <button 
                                                        wire:click="rejectPayment({{ $payment->id }})"
                                                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs font-medium transition-colors"
                                                        title="Reject Payment">
                                                        Reject
                                                    </button>
                                                </div>
                                            @elseif($payment->payment_status === 'verified')
                                                <span class="text-xs text-gray-500 italic">
                                                    @if($payment->payment_verified_at)
                                                        Verified on {{ \Carbon\Carbon::parse($payment->payment_verified_at)->format('M d, Y') }}
                                                    @else
                                                        Verified
                                                    @endif
                                                </span>
                                            @else
                                                <span class="text-xs text-gray-500 italic">
                                                    No actions available
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        @if($payments && method_exists($payments, 'links'))
                            <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
                                {{ $payments->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">
                                @if($paymentSearch || $filterPaymentEvent || $filterPaymentStatus)
                                    No payments found matching your filters
                                @else
                                    No payments found
                                @endif
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                There are no pending or verified payments for your paid events yet.
                            </p>
                            <div class="mt-6">
                                <button 
                                    wire:click="refreshPayments"
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Refresh
                                </button>
                            </div>
                        </div>
                    @endif
                    </div>

                    <!-- Events Table -->
                    <x-custom-modal model="showEditModal">
                        <h1 class="text-xl text-center font-bold mb-4">Edit Event</h1>
                        @if (session()->has('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form wire:submit.prevent="updateEvent" class="max-w-md mx-auto">
                            <div class="mb-5">
                                <label for="edit_title" class="block mb-2.5 text-sm font-medium text-heading">Event
                                    Title</label>
                                <input type="text" id="edit_title" wire:model="title"
                                    class="w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="Enter Event Title...">
                                @error('title')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col mb-5">
                                <h3 class="font-medium text-gray-700 mb-2">Event Date and Time</h3>
                                <div class="flex flex-row gap-2">
                                    <div class="w-1/2">
                                        <input type="editdate" wire:model="date"
                                            class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        @error('date')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="w-1/2">
                                        <input type="time" wire:model="time"
                                            class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        @error('time')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col mb-5">
                                <h2 class="font-medium text-gray-700 mb-2">Event Type</h2>
                                <select wire:model="type"
                                    class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">Select Type</option>
                                    <option value="online">Online</option>
                                    <option value="face-to-face">Face-to-face</option>
                                </select>
                                @error('type')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror

                                <h3 class="font-medium text-gray-700 mt-3 mb-2">Event Place or Link</h3>
                                <input type="text" wire:model="place_link"
                                    class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="Enter Event Place or Link...">
                                @error('place_link')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex flex-col mb-5">
                                <h2 class="font-medium text-gray-700 mb-2">Event Category</h2>
                                <select wire:model="category"
                                    class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">Select Category</option>
                                    <option value="academic">Academic</option>
                                    <option value="sports">Sports</option>
                                    <option value="cultural">Cultural</option>
                                </select>
                                @error('category')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex flex-col mb-5">
                                <h2 class="font-medium text-gray-700 mb-2">Event Description</h2>
                                <textarea wire:model="description" rows="3"
                                    class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="Enter Event Description..."></textarea>
                                @error('description')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex flex-col mb-5">
                                <h2 class="font-medium text-gray-700 mb-2">Event Banner</h2>
                                
                                @if($editingEvent && $editingEvent->banner && !$banner)
                                    <div class="mb-3">
                                        <p class="text-sm text-gray-600 mb-2">Current Banner:</p>
                                        <img src="{{ asset('storage/' . $editingEvent->banner) }}" 
                                            alt="Current Banner" 
                                            class="w-full h-48 object-cover rounded-lg border border-gray-300">
                                    </div>
                                @endif
                                
                                <div class="flex items-center justify-center w-full">
                                    <label for="dropzone-file-edit"
                                        class="flex flex-col items-center justify-center w-full h-32 bg-neutral-secondary-medium border border-dashed border-default-strong rounded-base cursor-pointer hover:bg-neutral-tertiary-medium">
                                        <div class="flex flex-col items-center justify-center text-body">
                                            <svg class="w-8 h-8 mb-2" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M15 17h3a3 3 0 0 0 0-6h-.025a5.56 5.56 0 0 0 .025-.5A5.5 5.5 0 0 0 7.207 9.021C7.137 9.017 7.071 9 7 9a4 4 0 1 0 0 8h2.167M12 19v-9m0 0-2 2m2-2 2 2" />
                                            </svg>
                                            <p class="mb-1 text-sm">
                                                <span class="font-semibold">Click to upload</span> or drag and drop
                                            </p>
                                            <p class="text-xs">JPG or PNG (MAX. 2MB)</p>
                                        </div>
                                        <input id="dropzone-file-edit" type="file" class="hidden"
                                            wire:model="banner" />
                                    </label>
                                </div>
                                @error('banner')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                                @if ($banner)
                                    <p class="text-xs text-green-600 mt-1">New file selected:
                                        {{ $banner->getClientOriginalName() }}</p>
                                @endif
                            </div>

                            <div class="flex items-center mb-5">
                                <input id="default-checkbox" type="checkbox" wire:model="require_payment"
                                    class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft">
                                <label for="default-checkbox"
                                    class="select-none ms-2 text-sm font-medium text-heading">
                                    Require Payment
                                </label>
                            </div>

                            @if ($require_payment)
                                <div class="flex flex-col mb-5">
                                    <label for="payment_amount" class="block mb-2.5 text-sm font-medium text-heading">
                                        Payment Amount
                                    </label>
                                    <input type="number" id="payment_amount" wire:model="payment_amount"
                                        step="0.01" min="0"
                                        class="block w-full px-3 py-2.5 bg-white border border-gray-300 rounded-md shadow-sm text-heading text-sm focus:ring-brand focus:border-brand placeholder:text-body"
                                        placeholder="Enter amount (e.g., 50.00)" />
                                    @error('payment_amount')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif

                            <div class="mb-5 flex gap-2">
                                <button type="button" wire:click="closeEditModal"
                                    class="w-1/2 px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="w-1/2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                                    Update Event
                                </button>
                            </div>
                        </form>
                    </x-custom-modal>
                    <x-custom-modal model="showDeleteModal">
                        <form class="max-w-md mx-auto">
                            <h1 class="text-xl text-center font-bold">Delete Event</h1>
                            <h3 class="text-center mb-6">Are you sure to delete this event?</h3>
                            <div class="flex flex-row gap-1">
                                <button wire:click="closeDeleteModal"
                                    class="w-full px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs font-medium">Cancel</button>
                                <button wire:click="deleteEvent"
                                    class="w-full px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs font-medium">Confirm</button>
                            </div>
                        </form>
                    </x-custom-modal>

                    <!-- Events Table -->
                    <div x-show="activeTab === 'events'" x-transition>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Title</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-small text-gray-500 uppercase tracking-wider">
                                        Time</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Type</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Place/Link</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Category</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Description</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Banner</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Paid/Free</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Amount(if paid)</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($events as $event)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $event->title }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-600">
                                            {{ \Carbon\Carbon::parse($event->date)->format('m/d/Y') }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-600">
                                            {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-600">{{ ucfirst($event->type) }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-600">
                                            {{ Str::limit($event->place_link, 20) }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-600">{{ ucfirst($event->category) }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-600">
                                            {{ Str::limit($event->description, 30) }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-600">
                                            @if ($event->banner)
                                                {{ basename($event->banner) }}
                                            @else
                                                No banner
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-600">
                                            {{ $event->require_payment ? 'Paid' : 'Free' }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-600">
                                            {{ $event->require_payment ? '₱' . number_format($event->payment_amount, 2) : 'N/A' }}
                                        </td>
                                        <td class="flex flex-row items-center px-4 py-3 space-x-2">
                                            <button wire:click="openEditModal({{ $event->id }})"
                                                class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs font-medium">Edit</button>
                                            <button wire:click="openDeleteModal({{ $event->id }})"
                                                class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs font-medium">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="px-4 py-3 text-sm text-gray-500 text-center">
                                            No events found. Create your first event!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>