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
        <div class="flex-1 pt-16 lg:pt-20 p-6 mt-16 lg:mt-0 overflow-y-auto">
            <!-- Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <x-overview-card title="Total Users" value="{{ $usersCount }}"
                    icon='<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>'
                    iconColor="blue" />
                <x-overview-card title="Total Events" value="{{ $eventsCount }}"
                    icon='<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>'
                    iconColor="green" />
                <x-overview-card title="Archived Events" value="{{ $archivedEvents }}"
                    icon='<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>'
                    iconColor="yellow" />
                <x-overview-card title="Upcoming Events" value="{{ $upcomingEvents }}"
                    icon='<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
                    iconColor="orange" />
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow-md p-4 lg:p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg lg:text-xl font-semibold text-gray-800">Upcoming Events</h2>
                        <button wire:click="openCreateModal"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">Create
                            Event</button>
                    </div>
                    <div class="space-y-4">
                        @forelse($upcomingEventsData as $event)
                            @php
                                $eventDate = \Carbon\Carbon::parse($event->date);
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
                                        {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }} •
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
            </div>
            <div class="bg-white rounded-lg shadow-md p-6" x-data="{ activeTab: 'users' }">
                <div class="border-b border-gray-200 mb-4">
                    <nav class="flex space-x-4">
                        <button @click="activeTab = 'users'"
                            :class="activeTab === 'users' ? 'border-b-2 border-blue-600 text-blue-600' :
                                'text-gray-500 hover:text-gray-700'"
                            class="px-4 py-2 font-medium text-sm transition-colors">
                            Users
                        </button>
                    </nav>
                </div>
                <div class="overflow-x-auto">
                    <div class="overflow-x-auto">
                        <div class="relative bg-neutral-primary-soft shadow-xs rounded-base border border-default"
                            x-show="activeTab === 'users'" x-transition>
                            <!-- Search and Filter Controls -->
                            <div class="p-4 bg-gray-50 border-b border-gray-200">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-semibold text-gray-700">Users Management</h3>
                                    <button wire:click="openGenerateReportModal"
                                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Export to Excel/CSV
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-4">
                                    <!-- Search Box -->
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
                                            <input type="text" wire:model.live.debounce.300ms="search"
                                                class="block w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500"
                                                placeholder="Search by name, email, or student ID...">
                                        </div>
                                    </div>

                                    <!-- Grade Level Filter -->
                                    <div>
                                        <select wire:model.live="filterGradeLevel"
                                            class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">All Grade Levels</option>
                                            <option value="11">Grade 11</option>
                                            <option value="12">Grade 12</option>
                                        </select>
                                    </div>

                                    <!-- Year Level Filter -->
                                    <div>
                                        <select wire:model.live="filterYearLevel"
                                            class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">All Year Levels</option>
                                            <option value="1">Year 1</option>
                                            <option value="2">Year 2</option>
                                            <option value="3">Year 3</option>
                                            <option value="4">Year 4</option>
                                            <option value="5">Year 5</option>
                                        </select>
                                    </div>

                                    <!-- SHS Strand Filter -->
                                    <div>
                                        <select wire:model.live="filterSHSStrand"
                                            class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">All SHS Strands</option>
                                            <option value="ABM">ABM</option>
                                            <option value="HUMSS">HUMSS</option>
                                            <option value="GAS">GAS</option>
                                            <option value="ICT">ICT</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <!-- College Program Filter -->
                                    <div>
                                        <select wire:model.live="filterCollegeProgram"
                                            class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">All College Programs</option>
                                            <option value="BSIT">BSIT</option>
                                            <option value="BSBA">BSBA</option>
                                        </select>
                                    </div>
                                    <!-- Role Filter -->
                                    <div>
                                        <select wire:model.live="filterRole"
                                            class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">All Roles</option>
                                            @foreach ($availableRoles as $role)
                                                <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Results Per Page -->
                                    <div>
                                        <select wire:model.live="perPage"
                                            class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                                            <option value="10">10 per page</option>
                                            <option value="25">25 per page</option>
                                            <option value="50">50 per page</option>
                                            <option value="100">100 per page</option>
                                        </select>
                                    </div>

                                    <!-- Reset Filters Button -->
                                    <div>
                                        <button wire:click="resetFilters"
                                            class="w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            Reset All Filters
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Users Table -->
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Name</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Email</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Grade Level</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Year Level</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                SHS Strand</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                College Program</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Student ID</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Role</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Actions</th>
                                        </tr>
                                    </thead>
                                    <!--Dynamically loaded data-->
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($users as $user)
                                            <tr class="hover:bg-gray-50">
                                                <!--users.first_name + users.last_name-->
                                                <td class="px-4 py-3 text-sm text-gray-900">{{ $user->first_name }}
                                                    {{ $user->last_name }}</td>
                                                <!--users.email-->
                                                <td class="px-4 py-3 text-sm text-gray-600">{{ $user->email }}</td>
                                                <!--users.grade_level,only if student and senior high, N/A if not-->
                                                <td class="px-4 py-3 text-sm text-gray-600">
                                                    {{ $user->grade_level ? 'Grade ' . $user->grade_level : 'N/A' }}
                                                </td>
                                                <!--users.year_level, only if student and college, N/A if not-->
                                                <td class="px-4 py-3 text-sm text-gray-600">
                                                    {{ $user->year_level ? 'Year ' . $user->year_level : 'N/A' }}
                                                </td>
                                                <!--users.shs_strand, only if student and SHS, N/A if not-->
                                                <td class="px-4 py-3 text-sm text-gray-600">
                                                    {{ $user->shs_strand ?? 'N/A' }}
                                                </td>
                                                <!--users.college_program, only if student and college, N/A if not-->
                                                <td class="px-4 py-3 text-sm text-gray-600">
                                                    {{ $user->college_program ?? 'N/A' }}
                                                </td>
                                                <!--users.student_id, only if student, N/A if not-->
                                                <td class="px-4 py-3 text-sm text-gray-600">
                                                    {{ $user->student_id ?? 'N/A' }}
                                                </td>
                                                <!--Spatie Roles-->
                                                <td class="px-4 py-3 text-sm text-gray-600">
                                                    @foreach ($user->roles as $role)
                                                        <span
                                                            class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs capitalize">
                                                            {{ $role->name }}
                                                        </span>
                                                    @endforeach
                                                </td>
                                                <!--Edit, Delete-->
                                                <td class="flex flex-row items-center px-4 py-3 space-x-2">
                                                    <!--Edit User Modal-->
                                                    <button wire:click="openEditUserModal({{ $user->id }})"
                                                        class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs font-medium">Edit</button>
                                                    <!--Delete User Modal-->
                                                    <button wire:click="openDeleteUserModal({{ $user->id }})"
                                                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs font-medium">Delete</button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                                    <div class="flex flex-col items-center justify-center">
                                                        <svg class="w-12 h-12 mb-4 text-gray-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        <p class="text-lg font-medium text-gray-600">No users found</p>
                                                        <p class="text-sm text-gray-500 mt-1">
                                                            @if ($search || $filterGradeLevel || $filterYearLevel || $filterSHSStrand || $filterCollegeProgram || $filterRole)
                                                                Try adjusting your search or filters
                                                            @else
                                                                No users in the system yet
                                                            @endif
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- Simple Pagination -->
                            @if ($users && method_exists($users, 'links'))
                                <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
                                    {{ $users->links() }}
                                </div>
                            @endif
                        </div>
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
                <div class="space-y-1.5">
                    <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                        <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Date & Time</span>
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="relative group">
                            <input type="date" wire:model="date"
                                class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 group-hover:border-blue-300">
                            @error('date')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="relative group">
                            <input type="time" wire:model="time"
                                class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 group-hover:border-blue-300">
                            @error('time')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>
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
                <div class="space-y-1.5">
                    <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                        <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Date & Time</span>
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="relative group">
                            <input type="date" wire:model="date"
                                class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 group-hover:border-blue-300">
                            @error('date')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="relative group">
                            <input type="time" wire:model="time"
                                class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 group-hover:border-blue-300">
                            @error('time')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>
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
                    <!-- Date -->
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
                                <p class="text-xs text-gray-500">Date</p>
                                <p class="font-semibold text-gray-800">{{ $selectedEvent->date->format('F j, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Time -->
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
                                <p class="text-xs text-gray-500">Time</p>
                                <p class="font-semibold text-gray-800">
                                    {{ \Carbon\Carbon::parse($selectedEvent->time)->format('g:i A') }}</p>
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

    <!-- Export Users Report -->
    <x-custom-modal model="showGenerateReportModal" maxWidth="lg" title="Export Users Report"
        description="Export filtered user data to Excel or CSV format" headerBg="green">
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
                            <span class="font-medium">Grade Level:</span>
                            <span
                                class="text-green-600">{{ $filterGradeLevel ? 'Grade ' . $filterGradeLevel : 'All' }}</span>
                        </p>
                        <p class="text-green-700">
                            <span class="font-medium">Year Level:</span>
                            <span
                                class="text-green-600">{{ $filterYearLevel ? 'Year ' . $filterYearLevel : 'All' }}</span>
                        </p>
                    </div>
                    <div class="space-y-2">
                        <p class="text-green-700">
                            <span class="font-medium">SHS Strand:</span>
                            <span class="text-green-600">{{ $filterSHSStrand ?: 'All' }}</span>
                        </p>
                        <p class="text-green-700">
                            <span class="font-medium">College Program:</span>
                            <span class="text-green-600">{{ $filterCollegeProgram ?: 'All' }}</span>
                        </p>
                        <p class="text-green-700">
                            <span class="font-medium">Role:</span>
                            <span class="text-green-600">{{ $filterRole ? ucfirst($filterRole) : 'All' }}</span>
                        </p>
                    </div>
                </div>

                <!-- Total Records Badge -->
                <div class="mt-3 pt-3 border-t border-green-200">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-green-700">Records to export:</span>
                        <span class="px-3 py-1 bg-green-200 text-green-800 rounded-full text-sm font-semibold">
                            {{ $users->total() ?? 0 }} users
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

            <!-- Additional Export Options (Optional) -->
            <div class="p-4 bg-gray-50 rounded-xl border-2 border-gray-100">
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" wire:model="includeHeaders"
                        class="w-5 h-5 text-green-600 border-2 border-gray-300 rounded-lg focus:ring-green-500 focus:ring-2">
                    <div>
                        <span class="font-medium text-gray-700">Include column headers</span>
                        <p class="text-xs text-gray-500">Recommended for data analysis</p>
                    </div>
                </label>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-3 pt-4 border-t-2 border-gray-100">
                <button type="button" wire:click="closeGenerateReportModal"
                    class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group">
                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Cancel</span>
                </button>
                <button type="button" wire:click="exportUsers"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group shadow-lg shadow-green-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Export {{ strtoupper($exportFormat) }}</span>
                </button>
            </div>
        </div>
    </x-custom-modal>

    <!-- Update User -->
    <x-custom-modal model="showEditUserModal" maxWidth="lg" title="Edit User"
        description="Update user information and academic details" headerBg="blue">
        <form wire:submit.prevent="saveUser" class="space-y-6">
            <!-- Personal Information Section -->
            <div class="space-y-4">
                <h3
                    class="text-sm font-semibold text-gray-700 flex items-center space-x-2 pb-2 border-b border-gray-200">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Personal Information</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- First Name -->
                    <div class="space-y-1.5">
                        <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                            <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>First Name</span>
                        </label>
                        <div class="relative group">
                            <input type="text" wire:model="first_name"
                                class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 group-hover:border-blue-300"
                                placeholder="Enter first name">
                            @error('first_name')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Middle Name -->
                    <div class="space-y-1.5">
                        <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                            <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Middle Name</span>
                        </label>
                        <div class="relative group">
                            <input type="text" wire:model="middle_name"
                                class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 group-hover:border-blue-300"
                                placeholder="Enter middle name">
                        </div>
                    </div>

                    <!-- Last Name -->
                    <div class="space-y-1.5">
                        <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                            <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Last Name</span>
                        </label>
                        <div class="relative group">
                            <input type="text" wire:model="last_name"
                                class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 group-hover:border-blue-300"
                                placeholder="Enter last name">
                            @error('last_name')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Academic Information Section -->
            <div class="space-y-4">
                <h3
                    class="text-sm font-semibold text-gray-700 flex items-center space-x-2 pb-2 border-b border-gray-200">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                    <span>Academic Information</span>
                </h3>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Grade Level -->
                    <div class="space-y-1.5">
                        <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                            <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            <span>Grade Level</span>
                        </label>
                        <select wire:model="grade_level"
                            class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 hover:border-blue-300">
                            <option value="">Select Grade Level</option>
                            <option value="11">📚 Grade 11</option>
                            <option value="12">📚 Grade 12</option>
                        </select>
                        @error('grade_level')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- SHS Strand -->
                    <div class="space-y-1.5">
                        <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                            <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span>SHS Strand</span>
                        </label>
                        <select wire:model="shs_strand"
                            class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 hover:border-blue-300 {{ $grade_level ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                            {{ $grade_level ? 'disabled' : '' }}>
                            <option value="">Select SHS Strand</option>
                            <option value="ABM">📊 ABM</option>
                            <option value="HUMSS">📖 HUMSS</option>
                            <option value="GAS">🔬 GAS</option>
                            <option value="ICT">💻 ICT</option>
                        </select>
                        @error('shs_strand')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Year Level -->
                    <div class="space-y-1.5">
                        <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                            <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Year Level</span>
                        </label>
                        <select wire:model="year_level"
                            class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 hover:border-blue-300">
                            <option value="">Select Year Level</option>
                            <option value="1">1st Year</option>
                            <option value="2">2nd Year</option>
                            <option value="3">3rd Year</option>
                            <option value="4">4th Year</option>
                            <option value="5">5th Year</option>
                        </select>
                        @error('year_level')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- College Program -->
                    <div class="space-y-1.5">
                        <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                            <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span>College Program</span>
                        </label>
                        <select wire:model="college_program"
                            class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 hover:border-blue-300 {{ $year_level ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                            {{ $year_level ? 'disabled' : '' }}>
                            <option value="">Select College Program</option>
                            <option value="BSIT">💻 BSIT</option>
                            <option value="BSBA">📈 BSBA</option>
                        </select>
                        @error('college_program')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Account Information Section -->
            <div class="space-y-4">
                <h3
                    class="text-sm font-semibold text-gray-700 flex items-center space-x-2 pb-2 border-b border-gray-200">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                    <span>Account Information</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Student ID -->
                    <div class="space-y-1.5">
                        <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                            <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                            </svg>
                            <span>Student ID</span>
                        </label>
                        <div class="relative group">
                            <input type="text" wire:model="student_id"
                                class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 group-hover:border-blue-300"
                                placeholder="Enter student ID">
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="space-y-1.5">
                        <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                            <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>Email</span>
                        </label>
                        <div class="relative group">
                            <input type="email" wire:model="email"
                                class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 group-hover:border-blue-300"
                                placeholder="user@example.com">
                            @error('email')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Role -->
                    <div class="space-y-1.5">
                        <label class="flex items-center space-x-2 text-sm font-semibold text-blue-900">
                            <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Role</span>
                        </label>
                        <select wire:model="role"
                            class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 hover:border-blue-300">
                            <option value="admin">👑 Admin</option>
                            <option value="organizer">🎯 Organizer</option>
                            <option value="student">🎓 Student</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-3 pt-4 border-t-2 border-gray-100">
                <button type="button" wire:click="closeEditUserModal"
                    class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group">
                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Cancel</span>
                </button>
                <button type="submit" wire:click="saveUser"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group shadow-lg shadow-blue-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Save Changes</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </button>
            </div>
        </form>
    </x-custom-modal>

    <!-- Delete User -->
    <x-custom-modal model="showDeleteUserModal" maxWidth="sm" title="Delete User"
        description="This action cannot be undone" headerBg="red" :showCloseButton="true">
        <div class="text-center space-y-6">
            <!-- Warning Icon -->
            <div class="flex justify-center">
                <div class="p-4 bg-red-100 rounded-full">
                    <svg class="w-16 h-16 text-red-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>

            <!-- Warning Message -->
            <div class="space-y-2">
                <h3 class="text-lg font-semibold text-gray-900">Are you absolutely sure?</h3>
                <p class="text-sm text-gray-600">
                    This will permanently delete the user account and remove all associated data.
                    @if ($deletingUser)
                        <br>
                        <span class="font-semibold text-red-600">User: {{ $deletingUser->first_name }}
                            {{ $deletingUser->last_name }}</span>
                    @endif
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 pt-4">
                <button type="button" wire:click="closeDeleteUserModal"
                    class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span>Cancel</span>
                </button>
                <button type="button" wire:click="deleteUser"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group shadow-lg shadow-red-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <span>Confirm Delete</span>
                </button>
            </div>
        </div>
    </x-custom-modal>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('editUserModal', () => {
            // Handle field disabling based on grade_level/year_level
            Livewire.on('updated', (component, name, value) => {
                if (name === 'grade_level' && value) {
                    // If grade_level is selected, disable college_program
                    const collegeProgramSelect = document.querySelector(
                        'select[wire\\:model="college_program"]');
                    if (collegeProgramSelect) {
                        collegeProgramSelect.disabled = true;
                        collegeProgramSelect.classList.add('bg-gray-100', 'cursor-not-allowed');
                    }
                } else if (name === 'year_level' && value) {
                    // If year_level is selected, disable shs_strand
                    const shsStrandSelect = document.querySelector(
                        'select[wire\\:model="shs_strand"]');
                    if (shsStrandSelect) {
                        shsStrandSelect.disabled = true;
                        shsStrandSelect.classList.add('bg-gray-100', 'cursor-not-allowed');
                    }
                }
            });
        });
    });
</script>