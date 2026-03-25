<div class="flex min-h-screen bg-gray-50">
    <div class="fixed left-0 top-0 h-screen z-40">
        <x-dashboard-sidebar />
    </div>
    <!-- Main Content -->
    <div class="flex-1 lg:ml-64 overflow-y-auto overflow-x-hidden">
        <div class="fixed top-0 right-0 left-0 lg:left-64 z-30">
            <x-dashboard-header userRole="Admin" :userInitials="$userInitials" />
        </div>
        <!-- Dashboard Content -->
        <div class="flex-1 p-6 mt-20 lg:mt-24 overflow-y-auto">
            <!-- Overview Cards - Modern Redesign -->
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                <!-- Total Users Card -->
                <div
                    class="group relative bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                    <!-- Gradient Background Effect -->
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-blue-600 to-blue-700 opacity-0 group-hover:opacity-10 transition-opacity duration-300">
                    </div>

                    <!-- Top Accent Line -->
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-400 to-blue-600"></div>

                    <div class="relative p-6">
                        <div class="flex items-center justify-between mb-4">
                            <!-- Icon Container with Gradient Background -->
                            <div
                                class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 text-white flex items-center justify-center shadow-lg shadow-blue-200">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>
                            </div>

                            <!-- Status Badge -->
                            <span
                                class="px-3 py-1 text-xs font-medium text-blue-600 bg-blue-50 rounded-full">Total</span>
                        </div>

                        <!-- Card Content -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Total Users</h3>
                            <div class="flex items-end justify-between">
                                <span class="text-3xl font-bold text-gray-800">{{ $usersCount }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Events Card -->
                <div
                    class="group relative bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-green-600 to-green-700 opacity-0 group-hover:opacity-10 transition-opacity duration-300">
                    </div>
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-green-400 to-green-600"></div>

                    <div class="relative p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="w-14 h-14 rounded-2xl bg-gradient-to-br from-green-500 to-green-600 text-white flex items-center justify-center shadow-lg shadow-green-200">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <span
                                class="px-3 py-1 text-xs font-medium text-green-600 bg-green-50 rounded-full">Active</span>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Total Events</h3>
                            <div class="flex items-end justify-between">
                                <span class="text-3xl font-bold text-gray-800">{{ $eventsCount }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Archived Events Card - Fixed Icon -->
                <div
                    class="group relative bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-yellow-600 to-yellow-700 opacity-0 group-hover:opacity-10 transition-opacity duration-300">
                    </div>
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-yellow-400 to-yellow-600"></div>

                    <div class="relative p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="w-14 h-14 rounded-2xl bg-gradient-to-br from-yellow-500 to-yellow-600 text-white flex items-center justify-center shadow-lg shadow-yellow-200">
                                <!-- Fixed: Proper archive icon instead of the old one -->
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                            </div>
                            <span
                                class="px-3 py-1 text-xs font-medium text-yellow-600 bg-yellow-50 rounded-full">Archived</span>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Archived Events</h3>
                            <div class="flex items-end justify-between">
                                <span class="text-3xl font-bold text-gray-800">{{ $archivedEvents }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Events Card -->
                <div
                    class="group relative bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-orange-600 to-orange-700 opacity-0 group-hover:opacity-10 transition-opacity duration-300">
                    </div>
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-orange-400 to-orange-600"></div>

                    <div class="relative p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-500 to-orange-600 text-white flex items-center justify-center shadow-lg shadow-orange-200">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span
                                class="px-3 py-1 text-xs font-medium text-orange-600 bg-orange-50 rounded-full">Upcoming</span>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Upcoming Events</h3>
                            <div class="flex items-end justify-between">
                                <span class="text-3xl font-bold text-gray-800">{{ $upcomingEvents }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow-md p-4 lg:p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg lg:text-xl font-semibold text-gray-800">Upcoming Events</h2>
                        <a href="{{ route('admin.events') }}"
                            class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center space-x-1">
                            <span>View All</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                    <div class="space-y-4">
                        @forelse($upcomingEventsData as $event)
                            <!-- Update the upcoming events display (around line 90) -->
                            @php
                                $eventDate = \Carbon\Carbon::parse($event->start_date);
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
                                    <div class="text-2xl font-bold text-gray-800">{{ $eventDate->format('d') }}</div>
                                    <div class="text-xs text-gray-600 uppercase">{{ $eventDate->format('M') }}</div>
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
                            </div>
                        @endforelse
                    </div>
                </div>
                <!-- Recent Activities Card - Add this after the Upcoming Events section -->
                <div class="bg-white rounded-lg shadow-md p-4 lg:p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg lg:text-xl font-semibold text-gray-800">Recent Activities</h2>
                        <a href="{{ route('admin.audit-logs') }}"
                            class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center space-x-1">
                            <span>View All</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>

                    <div class="space-y-4">
                        @forelse($recentActivities as $activity)
                            <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-all cursor-pointer"
                                wire:click="openLogDetailsModal({{ $activity->id }})">
                                <!-- Activity Icon based on action -->
                                <div class="flex-shrink-0">
                                    @php
                                        $iconColors = [
                                            'CREATE' => 'bg-green-100 text-green-600',
                                            'UPDATE' => 'bg-yellow-100 text-yellow-600',
                                            'DELETE' => 'bg-red-100 text-red-600',
                                            'LOGIN' => 'bg-blue-100 text-blue-600',
                                            'LOGOUT' => 'bg-gray-100 text-gray-600',
                                            'EXPORT' => 'bg-purple-100 text-purple-600',
                                        ];
                                        $iconColor = $iconColors[$activity->action] ?? 'bg-gray-100 text-gray-600';
                                    @endphp
                                    <div
                                        class="w-8 h-8 {{ $iconColor }} rounded-full flex items-center justify-center">
                                        @switch($activity->action)
                                            @case('CREATE')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4v16m8-8H4" />
                                                </svg>
                                            @break

                                            @case('UPDATE')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                            @break

                                            @case('DELETE')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            @break

                                            @case('LOGIN')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                                </svg>
                                            @break

                                            @default
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                        @endswitch
                                    </div>
                                </div>

                                <!-- Activity Content -->
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ $activity->description }}
                                    </p>
                                    <div class="flex items-center mt-1 text-xs text-gray-500">
                                        <span>{{ $activity->created_at->diffForHumans() }}</span>
                                        @if ($activity->user)
                                            <span class="mx-1">•</span>
                                            <span class="flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                {{ $activity->user->first_name }} {{ $activity->user->last_name }}
                                            </span>
                                        @endif
                                        @if ($activity->ip_address)
                                            <span class="mx-1">•</span>
                                            <span class="font-mono">{{ $activity->ip_address }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Action Badge -->
                                <div class="flex-shrink-0">
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                        @if ($activity->action === 'CREATE') bg-green-100 text-green-800
                        @elseif($activity->action === 'UPDATE') bg-yellow-100 text-yellow-800
                        @elseif($activity->action === 'DELETE') bg-red-100 text-red-800
                        @else bg-blue-100 text-blue-800 @endif">
                                        {{ $activity->action }}
                                    </span>
                                </div>
                            </div>
                            @empty
                                <div class="text-center py-8 text-gray-500">
                                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="mt-2">No recent activities</p>
                                    <p class="text-sm text-gray-400">Activities will appear here as users interact with the
                                        system</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <!-- After Recent Activities Card, add the Data Management section with tabs -->
                <div class="mt-6 bg-white rounded-lg shadow-md p-6" x-data="{ activeTab: 'users' }">
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
                        <!-- Registrations Tab -->
                        <div x-show="activeTab === 'registrations'" x-transition>
                            <livewire:admin-registrations />
                        </div>

                        <!-- Payments Tab -->
                        <div x-show="activeTab === 'payments'" x-transition>
                            <livewire:admin-payments />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODALS SECTION -->

        <!-- Create Event -->
        <x-custom-modal model="showCreateModal" maxWidth="lg" title="Create New Event"
            description="Fill in the details below to create a new event" headerBg="blue">
            <div class="space-y-6">
                @if (session()->has('success'))
                    <div
                        class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg flex items-center space-x-2 animate-slideIn">
                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <form wire:submit.prevent="createEvent" class="space-y-5">
                    <!-- Event Title -->
                    <div class="space-y-1.5">
                        <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                            <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                            </svg>
                            <span>Event Title</span>
                        </label>
                        <div class="relative group">
                            <input type="text" wire:model="title"
                                class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 group-hover:border-blue-300"
                                placeholder="e.g., Annual Sports Festival">
                            @error('title')
                                <span class="absolute -bottom-5 left-0 text-xs text-red-500 flex items-center space-x-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ $message }}</span>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Date and Time -->
                    <!-- Replace the old date/time section (around line 450) with this: -->
                    <!-- Date and Time -->
                    <div class="space-y-1.5">
                        <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                            <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Event Schedule</span>
                        </label>

                        <!-- Start Date & Time -->
                        <div class="grid grid-cols-2 gap-3 mb-2">
                            <div class="relative group">
                                <label class="block text-xs text-gray-600 mb-1">Start Date</label>
                                <input type="date" wire:model="start_date"
                                    class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 group-hover:border-blue-300">
                                @error('start_date')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="relative group">
                                <label class="block text-xs text-gray-600 mb-1">Start Time</label>
                                <input type="time" wire:model="start_time"
                                    class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 group-hover:border-blue-300">
                                @error('start_time')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- End Date & Time -->
                        <div class="grid grid-cols-2 gap-3">
                            <div class="relative group">
                                <label class="block text-xs text-gray-600 mb-1">End Date</label>
                                <input type="date" wire:model="end_date" min="{{ $start_date }}"
                                    class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 group-hover:border-blue-300">
                                @error('end_date')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="relative group">
                                <label class="block text-xs text-gray-600 mb-1">End Time</label>
                                <input type="time" wire:model="end_time"
                                    class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 group-hover:border-blue-300">
                                @error('end_time')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Quick duration presets -->
                        <div class="flex gap-2 mt-2">
                            <button type="button" wire:click="setDuration(1)"
                                class="text-xs px-2 py-1 bg-gray-100 hover:bg-gray-200 rounded-lg">1 Hour</button>
                            <button type="button" wire:click="setDuration(2)"
                                class="text-xs px-2 py-1 bg-gray-100 hover:bg-gray-200 rounded-lg">2 Hours</button>
                            <button type="button" wire:click="setDuration(4)"
                                class="text-xs px-2 py-1 bg-gray-100 hover:bg-gray-200 rounded-lg">4 Hours</button>
                            <button type="button" wire:click="setDuration(24)"
                                class="text-xs px-2 py-1 bg-gray-100 hover:bg-gray-200 rounded-lg">Full Day</button>
                        </div>
                    </div>

                    <!-- Event Type and Location/Link -->
                    <div class="space-y-1.5">
                        <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                            <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Event Type & Location</span>
                        </label>
                        <div class="space-y-3">
                            <select wire:model="type"
                                class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 hover:border-blue-300 appearance-none cursor-pointer">
                                <option value="">Select event type</option>
                                <option value="online">🌐 Online Event</option>
                                <option value="face-to-face">👥 Face-to-Face Event</option>
                            </select>

                            <div class="relative group">
                                <input type="text" wire:model="place_link"
                                    class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 group-hover:border-blue-300"
                                    placeholder="{{ $type === 'online' ? 'Meeting link (Zoom, Google Meet, etc.)' : 'Event venue/location' }}">
                                @error('place_link')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Category and Visibility in Grid -->
                    <div class="grid grid-cols-2 gap-3">
                        <div class="space-y-1.5">
                            <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                                <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z" />
                                </svg>
                                <span>Category</span>
                            </label>
                            <select wire:model="category"
                                class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 hover:border-blue-300">
                                <option value="">Select</option>
                                <option value="academic">📚 Academic</option>
                                <option value="sports">⚽ Sports</option>
                                <option value="cultural">🎭 Cultural</option>
                            </select>
                        </div>

                        <div class="space-y-1.5">
                            <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                                <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span>Visibility</span>
                            </label>
                            <select wire:model="visibility_type"
                                class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 hover:border-blue-300">
                                <option value="all">👥 All Students</option>
                                <option value="grade_level">📋 Grade Levels</option>
                                <option value="shs_strand">🎓 SHS Strands</option>
                                <option value="year_level">📚 Year Levels</option>
                                <option value="college_program">🏫 College Programs</option>
                            </select>
                        </div>
                    </div>

                    <!-- Dynamic Visibility Options -->
                    @if ($visibility_type === 'grade_level')
                        <div class="p-4 bg-blue-50 rounded-xl border-2 border-blue-100 animate-fadeIn">
                            <label class="block text-sm font-semibold text-blue-900 mb-3">Select Grade Levels</label>
                            <div class="flex space-x-6">
                                <label class="flex items-center space-x-2 cursor-pointer group">
                                    <input type="checkbox" wire:model="visible_to_grade_level" value="11"
                                        class="w-5 h-5 text-yellow-500 border-2 border-gray-300 rounded-lg focus:ring-yellow-400 focus:ring-2 transition-all group-hover:border-blue-400">
                                    <span class="text-sm text-gray-700 group-hover:text-blue-600">Grade 11</span>
                                </label>
                                <label class="flex items-center space-x-2 cursor-pointer group">
                                    <input type="checkbox" wire:model="visible_to_grade_level" value="12"
                                        class="w-5 h-5 text-yellow-500 border-2 border-gray-300 rounded-lg focus:ring-yellow-400 focus:ring-2 transition-all group-hover:border-blue-400">
                                    <span class="text-sm text-gray-700 group-hover:text-blue-600">Grade 12</span>
                                </label>
                            </div>
                        </div>
                    @endif

                    <!-- Similar for other visibility types... (keeping them similar style) -->

                    <!-- Description -->
                    <div class="space-y-1.5">
                        <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                            <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
                            <span>Event Description</span>
                        </label>
                        <textarea wire:model="description" rows="3"
                            class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 hover:border-blue-300 resize-none"
                            placeholder="Describe your event..."></textarea>
                        @error('description')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Banner Upload -->
                    <div class="space-y-1.5">
                        <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                            <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Event Banner</span>
                        </label>
                        <div class="file-upload-area group">
                            <input id="dropzone-file" type="file" class="hidden" wire:model="banner" />
                            <label for="dropzone-file" class="cursor-pointer block">
                                <div class="text-center">
                                    <svg class="w-12 h-12 mx-auto text-blue-400 group-hover:text-yellow-500 transition-colors duration-200"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-600 group-hover:text-blue-600">
                                        <span class="font-semibold text-blue-600">Click to upload</span> or drag and drop
                                    </p>
                                    <p class="text-xs text-gray-500">JPG or PNG (MAX. 2MB)</p>
                                </div>
                            </label>
                        </div>
                        @if ($banner)
                            <p class="text-sm text-green-600 flex items-center space-x-1 mt-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>{{ $banner->getClientOriginalName() }}</span>
                            </p>
                        @endif
                    </div>

                    <!-- Payment Toggle -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border-2 border-gray-100">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="font-medium text-gray-700">Require Payment</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="require_payment" class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-yellow-400 peer-checked:to-yellow-500">
                            </div>
                        </label>
                    </div>

                    @if ($require_payment)
                        <div class="animate-slideDown">
                            <label class="block text-sm font-semibold text-blue-900 mb-2">Payment Amount</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-500">₱</span>
                                <input type="number" wire:model="payment_amount" step="0.01" min="0"
                                    class="w-full pl-8 pr-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200"
                                    placeholder="0.00">
                            </div>
                            @error('payment_amount')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex space-x-3 pt-4 border-t-2 border-gray-100">
                        <button type="button" wire:click="closeCreateModal"
                            class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group">
                            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            <span>Cancel</span>
                        </button>
                        <button type="submit"
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group shadow-lg shadow-blue-200">
                            <span>Publish Event</span>
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </x-custom-modal>

        <!-- Update Event -->
        <x-custom-modal model="showEditModal" maxWidth="lg" title="Edit Event"
            description="Update your event details below" headerBg="yellow">
            <div class="space-y-6">
                @if (session()->has('success'))
                    <div
                        class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg flex items-center space-x-2 animate-slideIn">
                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <form wire:submit.prevent="updateEvent" class="space-y-5">
                    <!-- Event Title -->
                    <div class="space-y-1.5">
                        <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                            <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                            </svg>
                            <span>Event Title</span>
                        </label>
                        <div class="relative group">
                            <input type="text" wire:model="title"
                                class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 group-hover:border-blue-300"
                                placeholder="e.g., Annual Sports Festival">
                            @error('title')
                                <span class="absolute -bottom-5 left-0 text-xs text-red-500 flex items-center space-x-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ $message }}</span>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Date and Time -->
                    <!-- Replace the old date/time section (around line 450) with this: -->
                    <!-- Date and Time -->
                    <div class="space-y-1.5">
                        <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                            <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Event Schedule</span>
                        </label>

                        <!-- Start Date & Time -->
                        <div class="grid grid-cols-2 gap-3 mb-2">
                            <div class="relative group">
                                <label class="block text-xs text-gray-600 mb-1">Start Date</label>
                                <input type="date" wire:model="start_date"
                                    class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 group-hover:border-blue-300">
                                @error('start_date')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="relative group">
                                <label class="block text-xs text-gray-600 mb-1">Start Time</label>
                                <input type="time" wire:model="start_time"
                                    class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 group-hover:border-blue-300">
                                @error('start_time')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- End Date & Time -->
                        <div class="grid grid-cols-2 gap-3">
                            <div class="relative group">
                                <label class="block text-xs text-gray-600 mb-1">End Date</label>
                                <input type="date" wire:model="end_date" min="{{ $start_date }}"
                                    class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 group-hover:border-blue-300">
                                @error('end_date')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="relative group">
                                <label class="block text-xs text-gray-600 mb-1">End Time</label>
                                <input type="time" wire:model="end_time"
                                    class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 group-hover:border-blue-300">
                                @error('end_time')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Quick duration presets -->
                        <div class="flex gap-2 mt-2">
                            <button type="button" wire:click="setDuration(1)"
                                class="text-xs px-2 py-1 bg-gray-100 hover:bg-gray-200 rounded-lg">1 Hour</button>
                            <button type="button" wire:click="setDuration(2)"
                                class="text-xs px-2 py-1 bg-gray-100 hover:bg-gray-200 rounded-lg">2 Hours</button>
                            <button type="button" wire:click="setDuration(4)"
                                class="text-xs px-2 py-1 bg-gray-100 hover:bg-gray-200 rounded-lg">4 Hours</button>
                            <button type="button" wire:click="setDuration(24)"
                                class="text-xs px-2 py-1 bg-gray-100 hover:bg-gray-200 rounded-lg">Full Day</button>
                        </div>
                    </div>

                    <!-- Event Type and Location/Link -->
                    <div class="space-y-1.5">
                        <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                            <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Event Type & Location</span>
                        </label>
                        <div class="space-y-3">
                            <select wire:model="type"
                                class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 hover:border-blue-300 appearance-none cursor-pointer">
                                <option value="">Select event type</option>
                                <option value="online">🌐 Online Event</option>
                                <option value="face-to-face">👥 Face-to-Face Event</option>
                            </select>

                            <div class="relative group">
                                <input type="text" wire:model="place_link"
                                    class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 group-hover:border-blue-300"
                                    placeholder="{{ $type === 'online' ? 'Meeting link (Zoom, Google Meet, etc.)' : 'Event venue/location' }}">
                                @error('place_link')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Category and Visibility in Grid -->
                    <div class="grid grid-cols-2 gap-3">
                        <div class="space-y-1.5">
                            <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                                <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z" />
                                </svg>
                                <span>Category</span>
                            </label>
                            <select wire:model="category"
                                class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 hover:border-blue-300">
                                <option value="">Select</option>
                                <option value="academic">📚 Academic</option>
                                <option value="sports">⚽ Sports</option>
                                <option value="cultural">🎭 Cultural</option>
                            </select>
                        </div>

                        <div class="space-y-1.5">
                            <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                                <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span>Visibility</span>
                            </label>
                            <select wire:model="visibility_type"
                                class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 hover:border-blue-300">
                                <option value="all">👥 All Students</option>
                                <option value="grade_level">📋 Grade Levels</option>
                                <option value="shs_strand">🎓 SHS Strands</option>
                                <option value="year_level">📚 Year Levels</option>
                                <option value="college_program">🏫 College Programs</option>
                            </select>
                        </div>
                    </div>

                    <!-- Dynamic Visibility Options -->
                    @if ($visibility_type === 'grade_level')
                        <div class="p-4 bg-blue-50 rounded-xl border-2 border-blue-100 animate-fadeIn">
                            <label class="block text-sm font-semibold text-blue-900 mb-3">Select Grade Levels</label>
                            <div class="flex space-x-6">
                                <label class="flex items-center space-x-2 cursor-pointer group">
                                    <input type="checkbox" wire:model="visible_to_grade_level" value="11"
                                        class="w-5 h-5 text-yellow-500 border-2 border-gray-300 rounded-lg focus:ring-yellow-400 focus:ring-2 transition-all group-hover:border-blue-400">
                                    <span class="text-sm text-gray-700 group-hover:text-blue-600">Grade 11</span>
                                </label>
                                <label class="flex items-center space-x-2 cursor-pointer group">
                                    <input type="checkbox" wire:model="visible_to_grade_level" value="12"
                                        class="w-5 h-5 text-yellow-500 border-2 border-gray-300 rounded-lg focus:ring-yellow-400 focus:ring-2 transition-all group-hover:border-blue-400">
                                    <span class="text-sm text-gray-700 group-hover:text-blue-600">Grade 12</span>
                                </label>
                            </div>
                        </div>
                    @endif

                    <!-- Similar for other visibility types... (keeping them similar style) -->

                    <!-- Description -->
                    <div class="space-y-1.5">
                        <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                            <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
                            <span>Event Description</span>
                        </label>
                        <textarea wire:model="description" rows="3"
                            class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 hover:border-blue-300 resize-none"
                            placeholder="Describe your event..."></textarea>
                        @error('description')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Banner Upload -->
                    <div class="space-y-1.5">
                        <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                            <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Event Banner</span>
                        </label>
                        <div class="file-upload-area group">
                            <input id="dropzone-file" type="file" class="hidden" wire:model="banner" />
                            <label for="dropzone-file" class="cursor-pointer block">
                                <div class="text-center">
                                    <svg class="w-12 h-12 mx-auto text-blue-400 group-hover:text-yellow-500 transition-colors duration-200"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-600 group-hover:text-blue-600">
                                        <span class="font-semibold text-blue-600">Click to upload</span> or drag and drop
                                    </p>
                                    <p class="text-xs text-gray-500">JPG or PNG (MAX. 2MB)</p>
                                </div>
                            </label>
                        </div>
                        @if ($banner)
                            <p class="text-sm text-green-600 flex items-center space-x-1 mt-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>{{ $banner->getClientOriginalName() }}</span>
                            </p>
                        @endif
                    </div>

                    <!-- Payment Toggle -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border-2 border-gray-100">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="font-medium text-gray-700">Require Payment</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="require_payment" class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-yellow-400 peer-checked:to-yellow-500">
                            </div>
                        </label>
                    </div>

                    @if ($require_payment)
                        <div class="animate-slideDown">
                            <label class="block text-sm font-semibold text-blue-900 mb-2">Payment Amount</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-500">₱</span>
                                <input type="number" wire:model="payment_amount" step="0.01" min="0"
                                    class="w-full pl-8 pr-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200"
                                    placeholder="0.00">
                            </div>
                            @error('payment_amount')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                </form>
                <!-- Action Buttons with Edit-specific styling -->
                <div class="flex space-x-3 pt-4 border-t-2 border-gray-100">
                    <button type="button" wire:click="closeEditModal"
                        class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group">
                        <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>Cancel</span>
                    </button>
                    <button type="submit"
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-xl hover:from-yellow-600 hover:to-yellow-700 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group shadow-lg shadow-yellow-200">
                        <span>Update Event</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </button>
                </div>
                </form>
            </div>
        </x-custom-modal>

        <!-- Event Details -->
        <x-custom-modal model="showEventDetailsModal" maxWidth="lg" title="Event Details"
            description="View complete event information" headerBg="green">
            @if ($selectedEvent)
                <div class="space-y-5">
                    <!-- Banner Section with improved styling -->
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

                        <!-- Title Overlay with better positioning -->
                        <div class="absolute bottom-0 left-0 right-0 p-5 text-white">
                            <h1 class="text-2xl font-bold mb-1">{{ $selectedEvent->title }}</h1>
                            <div class="flex items-center space-x-3 text-sm">
                                <span
                                    class="flex items-center space-x-1.5 bg-black/30 px-3 py-1 rounded-full backdrop-blur-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span>{{ $selectedEvent->creator->first_name ?? 'Unknown' }}
                                        {{ $selectedEvent->creator->last_name ?? '' }}</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Description Card with improved styling -->
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

                    <!-- Event Details Grid with improved borders and spacing -->
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Start Date -->
                        <div
                            class="bg-white p-4 rounded-xl border border-gray-200 hover:border-green-300 transition-all duration-200">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-green-100 rounded-lg">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Start Date</p>
                                    <p class="font-semibold text-gray-800">
                                        {{ \Carbon\Carbon::parse($selectedEvent->start_date)->format('F j, Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- End Date -->
                        <div
                            class="bg-white p-4 rounded-xl border border-gray-200 hover:border-green-300 transition-all duration-200">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-green-100 rounded-lg">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">End Date</p>
                                    <p class="font-semibold text-gray-800">
                                        {{ \Carbon\Carbon::parse($selectedEvent->end_date)->format('F j, Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Start Time -->
                        <div
                            class="bg-white p-4 rounded-xl border border-gray-200 hover:border-green-300 transition-all duration-200">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-green-100 rounded-lg">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Start Time</p>
                                    <p class="font-semibold text-gray-800">
                                        {{ \Carbon\Carbon::parse($selectedEvent->start_time)->format('g:i A') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- End Time -->
                        <div
                            class="bg-white p-4 rounded-xl border border-gray-200 hover:border-green-300 transition-all duration-200">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-green-100 rounded-lg">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">End Time</p>
                                    <p class="font-semibold text-gray-800">
                                        {{ \Carbon\Carbon::parse($selectedEvent->end_time)->format('g:i A') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Location/Link (full width) -->
                        <div
                            class="col-span-2 bg-white p-4 rounded-xl border border-gray-200 hover:border-green-300 transition-all duration-200">
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
                                    <span
                                        class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-sm font-medium">🌍
                                        Visible to all students</span>
                                @else
                                    <span
                                        class="px-3 py-1.5 bg-yellow-100 text-yellow-700 rounded-full text-sm font-medium">🔒
                                        Restricted access</span>
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

                    <!-- Action Buttons -->
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
                        <button type="button" wire:click="openEditModal({{ $selectedEvent->id }})"
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-xl hover:from-yellow-600 hover:to-yellow-700 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group shadow-lg shadow-yellow-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <span>Edit Event</span>
                        </button>
                    </div>
                </div>
            @endif
        </x-custom-modal>
    </div>
