<div class="flex min-h-screen bg-gray-50">
    <div class="fixed left-0 top-0 h-screen z-40">
        <x-dashboard-sidebar />
    </div>

    <!-- Main Content -->
    <div class="flex-1 lg:ml-64 overflow-y-auto overflow-x-hidden">
        <!-- Fixed Header -->
        <div class="fixed top-0 right-0 left-0 lg:left-64 z-30">
            <x-dashboard-header userRole="Admin" :userInitials="$userInitials" />
        </div>

        <!-- Dashboard Content -->
        <div class="flex-1 pt-16 lg:pt-20 p-6 mt-16 lg:mt-0 overflow-y-auto">
            <!-- Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <!--Count all users in the system-->
                <x-overview-card title="Total Users" value="{{ $usersCount }}"
                    icon='<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>'
                    iconColor="blue" />
                <!--Count all events in the system-->
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
                <!-- Loads 3 events with dates close to current server date -->
                <div class="bg-white rounded-lg shadow-md p-4 lg:p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg lg:text-xl font-semibold text-gray-800">Upcoming Events</h2>
                        <x-custom-modal 
                        model="showCreateModal" 
                        title="Create New Event"
                        description="Fill in the details below to create a new event for students.">
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

                                <!-- In the create event modal form, add this after the payment section: -->
                                <div class="flex flex-col mb-5">
                                    <h2 class="font-medium text-gray-700 mb-2">Event Visibility</h2>
                                    <select wire:model="visibility_type"
                                        class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="all">Visible to All Students</option>
                                        <option value="grade_level">Specific Grade Levels</option>
                                        <option value="shs_strand">Specific SHS Strands</option>
                                        <option value="year_level">Specific Year Levels</option>
                                        <option value="college_program">Specific College Programs</option>
                                    </select>
                                    @error('visibility_type')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                @if ($visibility_type === 'grade_level')
                                    <div class="flex flex-col mb-5">
                                        <label class="block mb-2 text-sm font-medium text-gray-700">Select Grade
                                            Levels</label>
                                        <div class="space-y-2">
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" wire:model="visible_to_grade_level"
                                                    value="11"
                                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                <span class="ml-2 text-sm text-gray-700">Grade 11</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" wire:model="visible_to_grade_level"
                                                    value="12"
                                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                <span class="ml-2 text-sm text-gray-700">Grade 12</span>
                                            </label>
                                        </div>
                                        @error('visible_to_grade_level')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif

                                @if ($visibility_type === 'shs_strand')
                                    <div class="flex flex-col mb-5">
                                        <label class="block mb-2 text-sm font-medium text-gray-700">Select SHS
                                            Strands</label>
                                        <div class="space-y-2">
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" wire:model="visible_to_shs_strand"
                                                    value="ABM"
                                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                <span class="ml-2 text-sm text-gray-700">ABM</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" wire:model="visible_to_shs_strand"
                                                    value="HUMSS"
                                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                <span class="ml-2 text-sm text-gray-700">HUMSS</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" wire:model="visible_to_shs_strand"
                                                    value="GAS"
                                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                <span class="ml-2 text-sm text-gray-700">GAS</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" wire:model="visible_to_shs_strand"
                                                    value="ICT"
                                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                <span class="ml-2 text-sm text-gray-700">ICT</span>
                                            </label>
                                        </div>
                                        @error('visible_to_shs_strand')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif

                                @if ($visibility_type === 'year_level')
                                    <div class="flex flex-col mb-5">
                                        <label class="block mb-2 text-sm font-medium text-gray-700">Select Year
                                            Levels</label>
                                        <div class="space-y-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <label class="inline-flex items-center">
                                                    <input type="checkbox" wire:model="visible_to_year_level"
                                                        value="{{ $i }}"
                                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                    <span class="ml-2 text-sm text-gray-700">Year
                                                        {{ $i }}</span>
                                                </label>
                                            @endfor
                                        </div>
                                        @error('visible_to_year_level')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif

                                @if ($visibility_type === 'college_program')
                                    <div class="flex flex-col mb-5">
                                        <label class="block mb-2 text-sm font-medium text-gray-700">Select College
                                            Programs</label>
                                        <div class="space-y-2">
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" wire:model="visible_to_college_program"
                                                    value="BSIT"
                                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                <span class="ml-2 text-sm text-gray-700">BSIT</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" wire:model="visible_to_college_program"
                                                    value="BSBA"
                                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                <span class="ml-2 text-sm text-gray-700">BSBA</span>
                                            </label>
                                        </div>
                                        @error('visible_to_college_program')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif

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
                                        <label for="payment_amount"
                                            class="block mb-2.5 text-sm font-medium text-heading">
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
                    <!-- UPCOMING EVENTS HERE - DYNAMIC CONTENT -->
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
                    <!-- Event Details Modal -->
                    <x-custom-modal model="showEventDetailsModal">
                        @if ($selectedEvent)
                            <div class="max-w-2xl mx-auto bg-white rounded-lg">
                                <!-- Banner Section -->
                                <div class="mb-6">
                                    @if ($selectedEvent->banner)
                                        <img src="{{ asset('storage/' . $selectedEvent->banner) }}"
                                            alt="{{ $selectedEvent->title }}"
                                            class="w-full h-48 object-cover rounded-t-lg">
                                    @else
                                        <div
                                            class="w-full h-48 bg-gray-200 rounded-t-lg flex items-center justify-center">
                                            <div class="text-center text-gray-500">
                                                <svg class="w-12 h-12 mx-auto mb-2" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                <p class="text-sm">No banner available</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Content Section -->
                                <div class="px-6 pb-6">
                                    <!-- Event Title -->
                                    <h1 class="text-2xl font-bold text-gray-800 mb-4 text-center">
                                        {{ $selectedEvent->title }}</h1>

                                    <!-- Event Description -->
                                    <p class="text-gray-600 text-center mb-6 leading-relaxed">
                                        {{ $selectedEvent->description }}</p>

                                    <!-- Divider -->
                                    <div class="border-t border-gray-300 my-6"></div>

                                    <!-- Event Details -->
                                    <div class="space-y-4 mb-6">
                                        <!-- Date -->
                                        <div>
                                            <h3 class="font-semibold text-gray-700 mb-1">Date</h3>
                                            <p class="text-gray-600">
                                                {{ \Carbon\Carbon::parse($selectedEvent->date)->format('F j, Y') }}</p>
                                        </div>

                                        <!-- Time -->
                                        <div>
                                            <h3 class="font-semibold text-gray-700 mb-1">Time</h3>
                                            <p class="text-gray-600">
                                                {{ \Carbon\Carbon::parse($selectedEvent->time)->format('g:i A') }}</p>
                                        </div>

                                        <!-- Location/Link -->
                                        <div>
                                            <h3 class="font-semibold text-gray-700 mb-1">
                                                {{ $selectedEvent->type === 'online' ? 'Event Link' : 'Location' }}
                                            </h3>
                                            <p class="text-gray-600 break-words">
                                                @if ($selectedEvent->type === 'online' && filter_var($selectedEvent->place_link, FILTER_VALIDATE_URL))
                                                    <a href="{{ $selectedEvent->place_link }}" target="_blank"
                                                        class="text-blue-600 hover:underline">
                                                        {{ $selectedEvent->place_link }}
                                                    </a>
                                                @else
                                                    {{ $selectedEvent->place_link }}
                                                @endif
                                            </p>
                                        </div>

                                        <!-- Event Type -->
                                        <div>
                                            <h3 class="font-semibold text-gray-700 mb-1">Event Type</h3>
                                            <p class="text-gray-600 capitalize">
                                                {{ str_replace('-', ' ', $selectedEvent->type) }}</p>
                                        </div>

                                        <!-- Category -->
                                        <div>
                                            <h3 class="font-semibold text-gray-700 mb-1">Category</h3>
                                            <p class="text-gray-600 capitalize">{{ $selectedEvent->category }}</p>
                                        </div>

                                        <!-- Payment Information -->
                                        <div>
                                            <h3 class="font-semibold text-gray-700 mb-1">Payment</h3>
                                            <p class="text-gray-600">
                                                @if ($selectedEvent->require_payment)
                                                    <span class="text-red-600 font-semibold">
                                                        Paid Event -
                                                        ₱{{ number_format($selectedEvent->payment_amount, 2) }}
                                                    </span>
                                                @else
                                                    <span class="text-green-600 font-semibold">Free Event</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex gap-3 pt-4 border-t border-gray-200">
                                        <button type="button" wire:click="closeEventDetailsModal"
                                            class="flex-1 px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors font-medium">
                                            Close
                                        </button>
                                        <button type="button" wire:click="openEditModal({{ $selectedEvent->id }})"
                                            class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                            Edit Event
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </x-custom-modal>
                </div>
            </div>

            <!-- Tabbed Tables Section -->
            <!-- Generate Report Modal -->
            <x-custom-modal model="showGenerateReportModal">
                <div class="max-w-md mx-auto p-6">
                    <h1 class="text-xl text-center font-bold mb-2">Export Users Report</h1>
                    <p class="text-center text-gray-600 mb-6">Export current users table data to Excel or CSV format.
                    </p>

                    <div class="mb-6">
                        <p class="text-sm text-gray-700 mb-2">Filters applied:</p>
                        <!-- In the export modal, update the filter list: -->
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Search: {{ $search ?: 'None' }}</li>
                            <li>• Grade Level: {{ $filterGradeLevel ? 'Grade ' . $filterGradeLevel : 'All' }}</li>
                            <li>• Year Level: {{ $filterYearLevel ? 'Year ' . $filterYearLevel : 'All' }}</li>
                            <li>• SHS Strand: {{ $filterSHSStrand ?: 'All' }}</li>
                            <li>• College Program: {{ $filterCollegeProgram ?: 'All' }}</li>
                            <li>• Role: {{ $filterRole ? ucfirst($filterRole) : 'All' }}</li>
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
                        <button type="button" wire:click="closeGenerateReportModal"
                            class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors font-medium">
                            Cancel
                        </button>
                        <button type="button" wire:click="exportUsers"
                            class="flex-1 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors font-medium">
                            Export {{ strtoupper($exportFormat) }}
                        </button>
                    </div>
                </div>
            </x-custom-modal>
            <x-custom-modal model="showArchiveModal">
                <form class="max-w-md mx-auto">
                    <h1 class="text-xl text-center font-bold">Archive Event</h1>
                    <h3 class="text-center mb-6">Move event to archives? This won't be visible to all other users
                        anymore but still can be used for reports.</h3>
                    <div class="flex flex-row gap-1">
                        <button wire:click=""
                            class="w-full px-3 py-1 bg-gray-300 text-white rounded hover:bg-gray-300 text-xs font-medium">Cancel</button>
                        <button wire:click=""
                            class="w-full px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs font-medium">Confirm</button>
                    </div>
                </form>
            </x-custom-modal>
            <div class="bg-white rounded-lg shadow-md p-6" x-data="{ activeTab: 'users' }">
                <!-- Tabs -->
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

                <!-- Tab Content -->
                <div class="overflow-x-auto">
                    <!-- UPDATING USER INFORMATION -->
                    <x-custom-modal model="showEditUserModal">
                        <h1 class="text-xl text-center font-bold">Edit User</h1>
                        <form class="max-w-md mx-auto">
                            <div class="mb-5">
                                <label for="first_name" class="block mb-2.5 text-sm font-medium text-heading">First
                                    Name</label>
                                <input type="text" id="first_name" wire:model="first_name"
                                    class="w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="Enter First Name...">
                            </div>
                            <div class="mb-5">
                                <label for="middle_name" class="block mb-2.5 text-sm font-medium text-heading">Middle
                                    Name</label>
                                <input type="text" id="middle_name" wire:model="middle_name"
                                    class="w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="Enter First Name...">
                            </div>
                            <div class="mb-5">
                                <label for="last_name" class="block mb-2.5 text-sm font-medium text-heading">Last
                                    Name</label>
                                <input type="text" id="last_name" wire:model="last_name"
                                    class="w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="Enter First Name...">
                            </div>
                            <!-- In the edit user modal, update the form fields: -->
                            <div class="flex flex-col mb-5">
                                <label class="block mb-2.5 text-sm font-medium text-heading">Academic
                                    Information</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block mb-1 text-xs text-gray-600">Grade Level</label>
                                        <select wire:model="grade_level"
                                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Select Grade Level</option>
                                            <option value="11">Grade 11</option>
                                            <option value="12">Grade 12</option>
                                        </select>
                                        @error('grade_level')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block mb-1 text-xs text-gray-600">SHS Strand</label>
                                        <select wire:model="shs_strand"
                                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 {{ $year_level ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                            {{ $year_level ? 'disabled' : '' }}>
                                            <option value="">Select SHS Strand</option>
                                            <option value="ABM">ABM</option>
                                            <option value="HUMSS">HUMSS</option>
                                            <option value="GAS">GAS</option>
                                            <option value="ICT">ICT</option>
                                        </select>
                                        @error('shs_strand')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3 mt-3">
                                    <div>
                                        <label class="block mb-1 text-xs text-gray-600">Year Level</label>
                                        <select wire:model="year_level"
                                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
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
                                    <div>
                                        <label class="block mb-1 text-xs text-gray-600">College Program</label>
                                        <select wire:model="college_program"
                                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 {{ $grade_level ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                            {{ $grade_level ? 'disabled' : '' }}>
                                            <option value="">Select College Program</option>
                                            <option value="BSIT">BSIT</option>
                                            <option value="BSBA">BSBA</option>
                                        </select>
                                        @error('college_program')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col mb-5">
                                <label for="number-input"
                                    class="block mb-2.5 text-sm font-medium text-heading">Student ID</label>
                                <input type="number" id="number-input" wire:model="student_id"
                                    aria-describedby="helper-text-explanation"
                                    class="block w-full px-3 py-2.5 bg-neutral-secondary-medium border border-gray-300 rounded-md shadow-sm text-heading text-sm rounded-base focus:ring-brand focus:border-brand placeholder:text-body"
                                    placeholder="Enter Student ID..."/>
                            </div>
                            <div class="mb-5">
                                <label for="email"
                                    class="block mb-2.5 text-sm font-medium text-heading">Email</label>
                                <input type="email" id="email" wire:model="email"
                                    class="w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="Enter First Name...">
                            </div>
                            <div class="flex flex-col mb-5">
                                <h2>Role</h2>
                                <select wire:model="role"
                                    class="block w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="admin">Admin</option>
                                    <option value="organizer">Organizer</option>
                                    <option value="student">Student</option>
                                </select>
                            </div>
                            <div class="mb-5">
                                <button type="submit" wire:click="saveUser"
                                    class="w-full px-4 py-2 bg-blue-600 text-white rounded">Save Changes</button>
                            </div>
                        </form>
                    </x-custom-modal>
                    <!-- DELETING USER INFORMATION -->
                    <x-custom-modal model="showDeleteUserModal">
                        <form class="max-w-md mx-auto">
                            <h1 class="text-xl text-center font-bold">Delete User</h1>
                            <h3 class="text-center mb-6">Are you sure to delete this user?</h3>
                            @if ($deletingUser)
                                <p class="text-center text-gray-600 mb-4">
                                    User: <strong>{{ $deletingUser->first_name }}
                                        {{ $deletingUser->last_name }}</strong>
                                </p>
                            @endif
                            <div class="flex flex-row gap-1">
                                <button type="button" wire:click="closeDeleteUserModal"
                                    class="w-full px-3 py-1 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 text-xs font-medium">Cancel</button>
                                <button type="button" wire:click="deleteUser"
                                    class="w-full px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs font-medium">Confirm</button>
                            </div>
                        </form>
                    </x-custom-modal>
                    <!-- THIS IS THE USERS TABLE-->
                    <div class="overflow-x-auto">
                        <div class="relative bg-neutral-primary-soft shadow-xs rounded-base border border-default"
                            x-show="activeTab === 'users'" x-transition>

                            <!-- Search and Filter Controls -->
                            <div class="p-4 bg-gray-50 border-b border-gray-200">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-semibold text-gray-700">Users Management</h3>
                                    <!-- Move Generate Report button here -->
                                    <button wire:click="openGenerateReportModal"
                                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
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

                            <!-- In the create event modal form, add this after the payment section: -->
                            <div class="flex flex-col mb-5">
                                <h2 class="font-medium text-gray-700 mb-2">Event Visibility</h2>
                                <select wire:model="visibility_type"
                                    class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="all">Visible to All Students</option>
                                    <option value="grade_level">Specific Grade Levels</option>
                                    <option value="shs_strand">Specific SHS Strands</option>
                                    <option value="year_level">Specific Year Levels</option>
                                    <option value="college_program">Specific College Programs</option>
                                </select>
                                @error('visibility_type')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            @if ($visibility_type === 'grade_level')
                                <div class="flex flex-col mb-5">
                                    <label class="block mb-2 text-sm font-medium text-gray-700">Select Grade
                                        Levels</label>
                                    <div class="space-y-2">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" wire:model="visible_to_grade_level" value="11"
                                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-gray-700">Grade 11</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" wire:model="visible_to_grade_level" value="12"
                                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-gray-700">Grade 12</span>
                                        </label>
                                    </div>
                                    @error('visible_to_grade_level')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif

                            @if ($visibility_type === 'shs_strand')
                                <div class="flex flex-col mb-5">
                                    <label class="block mb-2 text-sm font-medium text-gray-700">Select SHS
                                        Strands</label>
                                    <div class="space-y-2">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" wire:model="visible_to_shs_strand" value="ABM"
                                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-gray-700">ABM</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" wire:model="visible_to_shs_strand" value="HUMSS"
                                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-gray-700">HUMSS</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" wire:model="visible_to_shs_strand" value="GAS"
                                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-gray-700">GAS</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" wire:model="visible_to_shs_strand" value="ICT"
                                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-gray-700">ICT</span>
                                        </label>
                                    </div>
                                    @error('visible_to_shs_strand')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif

                            @if ($visibility_type === 'year_level')
                                <div class="flex flex-col mb-5">
                                    <label class="block mb-2 text-sm font-medium text-gray-700">Select Year
                                        Levels</label>
                                    <div class="space-y-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" wire:model="visible_to_year_level"
                                                    value="{{ $i }}"
                                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                <span class="ml-2 text-sm text-gray-700">Year
                                                    {{ $i }}</span>
                                            </label>
                                        @endfor
                                    </div>
                                    @error('visible_to_year_level')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif

                            @if ($visibility_type === 'college_program')
                                <div class="flex flex-col mb-5">
                                    <label class="block mb-2 text-sm font-medium text-gray-700">Select College
                                        Programs</label>
                                    <div class="space-y-2">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" wire:model="visible_to_college_program"
                                                value="BSIT"
                                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-gray-700">BSIT</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" wire:model="visible_to_college_program"
                                                value="BSBA"
                                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-gray-700">BSBA</span>
                                        </label>
                                    </div>
                                    @error('visible_to_college_program')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif

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

                                @if ($editingEvent && $editingEvent->banner && !$banner)
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
                </div>
            </div>
        </div>
    </div>
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