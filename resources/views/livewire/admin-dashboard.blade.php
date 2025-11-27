<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <x-dashboard-sidebar />

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Header -->
        <x-dashboard-header userRole="Admin" :userInitials="$userInitials" />

        <!-- Dashboard Content -->
        <div class="flex-1 p-6">
            <!-- Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <!--Count all users in the system-->
                <x-overview-card title="Total Users" value="[users_count]"
                    icon='<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>'
                    iconColor="blue" />
                <!--Count all events in the system-->
                <x-overview-card title="Total Events" value="[events_count]"
                    icon='<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>'
                    iconColor="green" />
                <x-overview-card title="Archived Events" value="[archived_events]"
                    icon='<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>'
                    iconColor="yellow" />
                <x-overview-card title="Upcoming Events" value="[calendar_popup]"
                    icon='<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
                    iconColor="orange" />
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Recent Activity Card, cards switch order according to activity date and time-->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Activity</h2>
                    <div class="space-y-4">
                        <div
                            class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">System Logins</p>
                                    <p class="text-sm text-gray-600">[logins within 24 hours]</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </div>
                        <div
                            class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Event Updates</p>
                                    <p class="text-sm text-gray-600">[event updates within the week]</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </div>
                        <div
                            class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">User Updates</p>
                                    <p class="text-sm text-gray-600">[user updates within a month]</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Loads 3 events with dates close to current server date -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-800">Upcoming Events</h2>
                        <!--Will share features through a create-edit component-->
                        <x-custom-modal model="showCreateModal">
                            <h1 class="text-xl text-center font-bold">Create Event</h1>
                            @if (session()->has('success'))
                                <div class="text-gree-600">{{ session('success') }}</div>
                            @endif
                            <form wire:submit.prevent="createEvent" class="max-w-md mx-auto">
                                <div class="mb-5">
                                    <label for="title" class="block mb-2.5 text-sm font-medium text-heading">Event
                                        Title</label>
                                    <input type="text" id="title" wire:model="title"
                                        class="w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        placeholder="Enter Event Title...">
                                </div>
                                <div class="flex flex-col mb-5">
                                    <h3>Event Date and Time</h3>
                                    <div class="flex flex-row">
                                        <input type="date" wire:model="date"
                                            class="w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <input type="time" wire:model="time"
                                            class="w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    </div>
                                </div>
                                <div class="flex flex-col mb-5">
                                    <h2>Event Type</h2>
                                    <select wire:model="type"
                                        class="block w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="online">Online</option>
                                        <option value="face-to-face">Face-to-face</option>
                                    </select>
                                    <h3>Event Place or Link</h3>
                                    <input type="text"
                                        class="w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        placeholder="Enter Event Place or Link...">
                                </div>
                                <div class="flex flex-col mb-5">
                                    <h2>Event Category</h2>
                                    <select wire:model="category"
                                        class="block w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="academic">Academic</option>
                                        <option value="sports">Sports</option>
                                        <option value="cultural">Cultural</option>
                                    </select>
                                </div>
                                <div class="flex flex-col mb-5">
                                    <h2>Event Description</h2>
                                    <input type="text" wire:model="description"
                                        class="w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        placeholder="Enter Event Description...">
                                </div>
                                <div class="flex flex-col mb-5">
                                    <h2>Event Banner</h2>
                                    <div class="flex items-center justify-center w-full">
                                        <label for="dropzone-file"
                                            class="flex flex-col items-center justify-center w-full h-64 bg-neutral-secondary-medium border border-dashed border-default-strong rounded-base cursor-pointer hover:bg-neutral-tertiary-medium">
                                            <div class="flex flex-col items-center justify-center text-body pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-4" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M15 17h3a3 3 0 0 0 0-6h-.025a5.56 5.56 0 0 0 .025-.5A5.5 5.5 0 0 0 7.207 9.021C7.137 9.017 7.071 9 7 9a4 4 0 1 0 0 8h2.167M12 19v-9m0 0-2 2m2-2 2 2" />
                                                </svg>
                                                <p class="mb-2 text-sm"><span class="font-semibold">Click to
                                                        upload</span>
                                                    or drag and drop</p>
                                                <p class="text-xs">JPG or PNG (MAX. 2MB)</p>
                                            </div>
                                            <input id="dropzone-file" type="file" class="hidden" />
                                        </label>
                                    </div>
                                </div>
                                <div class="flex items-center mb-5">
                                    <input id="default-checkbox" type="checkbox" wire:model="require_payment"
                                        class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft">
                                    <label for="default-checkbox"
                                        class="select-none ms-2 text-sm font-medium text-heading">Require
                                        Payment</label>
                                </div>
                                <div class="flex flex-col mb-5">
                                    <label for="number-input"
                                        class="block mb-2.5 text-sm font-medium text-heading">Payment Amount</label>
                                    <input type="number" id="number-input"
                                        aria-describedby="helper-text-explanation"
                                        class="block w-full px-3 py-2.5 bg-neutral-secondary-medium border border-gray-300 rounded-md shadow-sm text-heading text-sm rounded-base focus:ring-brand focus:border-brand placeholder:text-body"
                                        placeholder="Enter Amount in whole numbers..." />
                                </div>
                                <div class="mb-5">
                                    <button class="w-full px-4 py-2 bg-blue-600 text-white rounded">Publish Event</button>
                                </div>
                            </form>
                        </x-custom-modal>
                        <button wire:click="openCreateModal"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">Create
                            Event</button>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4 p-3 border-l-4 border-blue-500 bg-blue-50 rounded">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600">15</div>
                                <div class="text-xs text-gray-600 uppercase">JUN</div>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800">Annual Tech Conference</h3>
                                <p class="text-sm text-gray-600">10:00 AM - 4:00 PM</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4 p-3 border-l-4 border-green-500 bg-green-50 rounded">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-600">22</div>
                                <div class="text-xs text-gray-600 uppercase">JUN</div>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800">Web Development Workshop</h3>
                                <p class="text-sm text-gray-600">2:00 PM - 5:00 PM</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4 p-3 border-l-4 border-orange-500 bg-orange-50 rounded">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-orange-600">05</div>
                                <div class="text-xs text-gray-600 uppercase">JUL</div>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800">Data Science Summit</h3>
                                <p class="text-sm text-gray-600">9:00 AM - 6:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabbed Tables Section -->
            <x-custom-modal model="showGenerateReportModal">
                <form class="max-w-md mx-auto">
                    <h1 class="text-xl text-center font-bold">Generate Report</h1>
                    <h3 class="text-center mb-6">This will download an excel file of the current table, continue?</h3>
                    <div class="flex flex-row gap-1">
                        <button wire:click=""
                            class="w-full px-3 py-1 bg-gray-300 text-white rounded hover:bg-gray-300 text-xs font-medium">Cancel</button>
                        <button wire:click=""
                            class="w-full px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs font-medium">Confirm</button>
                    </div>
                </form>
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
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Monitoring</h2>
                    <button wire:click="openGenerateReportModal"
                        class="px-4 py-2 text-sm text-blue-600 hover:text-blue-700 font-medium">Generate
                        Report</button>
                </div>

                <!-- Tabs -->
                <div class="border-b border-gray-200 mb-4">
                    <nav class="flex space-x-4">
                        <button @click="activeTab = 'users'"
                            :class="activeTab === 'users' ? 'border-b-2 border-blue-600 text-blue-600' :
                                'text-gray-500 hover:text-gray-700'"
                            class="px-4 py-2 font-medium text-sm transition-colors">
                            Users
                        </button>
                        <button @click="activeTab = 'user_updates'"
                            :class="activeTab === 'user_updates' ? 'border-b-2 border-blue-600 text-blue-600' :
                                'text-gray-500 hover:text-gray-700'"
                            class="px-4 py-2 font-medium text-sm transition-colors">
                            User Updates
                        </button>
                        <button @click="activeTab = 'events'"
                            :class="activeTab === 'events' ? 'border-b-2 border-blue-600 text-blue-600' :
                                'text-gray-500 hover:text-gray-700'"
                            class="px-4 py-2 font-medium text-sm transition-colors">
                            Events
                        </button>
                        <button @click="activeTab = 'event_updates'"
                            :class="activeTab === 'event_updates' ? 'border-b-2 border-blue-600 text-blue-600' :
                                'text-gray-500 hover:text-gray-700'"
                            class="px-4 py-2 font-medium text-sm transition-colors">
                            Event Updates
                        </button>
                        <button @click="activeTab = 'system_logins'"
                            :class="activeTab === 'system_logins' ? 'border-b-2 border-blue-600 text-blue-600' :
                                'text-gray-500 hover:text-gray-700'"
                            class="px-4 py-2 font-medium text-sm transition-colors">
                            Logins
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="overflow-x-auto">
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
                            <div class="flex flex-col mb-5">
                                <label for="number-input"
                                    class="block mb-2.5 text-sm font-medium text-heading">Student ID</label>
                                <input type="number" id="number-input" wire:model="studentId" aria-describedby="helper-text-explanation"
                                    class="block w-full px-3 py-2.5 bg-neutral-secondary-medium border border-gray-300 rounded-md shadow-sm text-heading text-sm rounded-base focus:ring-brand focus:border-brand placeholder:text-body"
                                    placeholder="Enter Student ID..." required />
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
                    <x-custom-modal model="showDeleteUserModal">
                        <form class="max-w-md mx-auto">
                            <h1 class="text-xl text-center font-bold">Delete User</h1>
                            <h3 class="text-center mb-6">Are you sure to delete this user?</h3>
                            <div class="flex flex-row gap-1">
                                <button wire:click=""
                                    class="w-full px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs font-medium">Cancel</button>
                                <button wire:click=""
                                    class="w-full px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs font-medium">Confirm</button>
                            </div>
                        </form>
                    </x-custom-modal>
                    <!-- Users Table, pulls data from users -->
                    <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default"
                        x-show="activeTab === 'users'" x-transition>
                        <table class="min-w-max divide-y divide-gray-200">
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
                                        Program</th>
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
                                <tr class="hover:bg-gray-50">
                                    <!--users.first_name + users.last_name-->
                                    <td class="px-4 py-3 text-sm text-gray-900">Zed Villanueva</td>
                                    <!--users.email-->
                                    <td class="px-4 py-3 text-sm text-gray-600">zed_villanueva@gmail.com</td>
                                    <!--users.grade_level,only if student and senior high, N/A if not-->
                                    <td class="px-4 py-3 text-sm text-gray-600">N/A</td>
                                    <!--users.year_level, only if student and college, N/A if not-->
                                    <td class="px-4 py-3 text-sm text-gray-600">4</td>
                                    <!--users.program, only if student, N/A if not-->
                                    <td class="px-4 py-3 text-sm text-gray-600">BSIT</td>
                                    <!--users.student_id, only if student, N/A if not-->
                                    <td class="px-4 py-3 text-sm text-gray-600">123456789</td>
                                    <!--Spatie Roles-->
                                    <td class="px-4 py-3 text-sm text-gray-600">Student</td>
                                    <!--Edit, Delete-->
                                    <td class="flex flex-row items-center px-4 py-3">
                                        <!--Edit User Modal-->
                                        <button wire:click="openEditUserModal"
                                            class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs font-medium">Edit</button>
                                        <!--Delete User Modal-->
                                        <button wire:click="openDeleteUserModal"
                                            class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs font-medium">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- User Updates Table -->
                    <div x-show="activeTab === 'user_updates'" x-transition>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        User</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Role</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Permissions</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Updated By</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action</th>
                                </tr>
                            </thead>
                            <!--Dynamically loaded data-->
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr class="hover:bg-gray-50">
                                    <!--users.first_name + users.last_name-->
                                    <td class="px-4 py-3 text-sm text-gray-900">Zed Villanueva</td>
                                    <!--Spatie Roles-->
                                    <td class="px-4 py-3 text-sm text-gray-600">Student</td>
                                    <!--Spatie Permissions-->
                                    <td class="px-4 py-3 text-sm text-gray-600">
                                        <span
                                            class="px-2 py-1 bg-yellow-100 text-green-800 rounded text-xs">view-events</span>
                                        <span
                                            class="px-2 py-1 bg-yellow-100 text-green-800 rounded text-xs">view-announcements</span>
                                        <span
                                            class="px-2 py-1 bg-yellow-100 text-green-800 rounded text-xs">events-registration</span>
                                    </td>
                                    <!--users.first_name + users.last_name-->
                                    <td class="px-4 py-3 text-sm text-gray-900">Lance De Felipe</td>
                                    <!--users.updated_at-->
                                    <td class="px-4 py-3 text-sm text-gray-900">November 25, 2025</td>
                                    <!--Updated, Deleted-->
                                    <td class="px-4 py-3 text-sm">
                                        <span
                                            class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Updated</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!--Will share features through a create-edit component-->
                    <x-custom-modal model="showEditModal">
                        <h1 class="text-xl text-center font-bold">Edit Event</h1>
                        <h1 class="text-xl text-center font-bold">Create Event</h1>
                            @if (session()->has('success'))
                                <div class="text-gree-600">{{ session('success') }}</div>
                            @endif
                            <form wire:submit.prevent="createEvent" class="max-w-md mx-auto">
                                <div class="mb-5">
                                    <label for="title" class="block mb-2.5 text-sm font-medium text-heading">Event
                                        Title</label>
                                    <input type="text" id="title" wire:model="title"
                                        class="w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        placeholder="Enter Event Title...">
                                </div>
                                <div class="flex flex-col mb-5">
                                    <h3>Event Date and Time</h3>
                                    <div class="flex flex-row">
                                        <input type="date" wire:model="date"
                                            class="w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <input type="time" wire:model="time"
                                            class="w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    </div>
                                </div>
                                <div class="flex flex-col mb-5">
                                    <h2>Event Type</h2>
                                    <select wire:model="type"
                                        class="block w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="online">Online</option>
                                        <option value="face-to-face">Face-to-face</option>
                                    </select>
                                    <h3>Event Place or Link</h3>
                                    <input type="text"
                                        class="w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        placeholder="Enter Event Place or Link...">
                                </div>
                                <div class="flex flex-col mb-5">
                                    <h2>Event Category</h2>
                                    <select wire:model="category"
                                        class="block w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="academic">Academic</option>
                                        <option value="sports">Sports</option>
                                        <option value="cultural">Cultural</option>
                                    </select>
                                </div>
                                <div class="flex flex-col mb-5">
                                    <h2>Event Description</h2>
                                    <input type="text" wire:model="description"
                                        class="w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        placeholder="Enter Event Description...">
                                </div>
                                <div class="flex flex-col mb-5">
                                    <h2>Event Banner</h2>
                                    <div class="flex items-center justify-center w-full">
                                        <label for="dropzone-file"
                                            class="flex flex-col items-center justify-center w-full h-64 bg-neutral-secondary-medium border border-dashed border-default-strong rounded-base cursor-pointer hover:bg-neutral-tertiary-medium">
                                            <div class="flex flex-col items-center justify-center text-body pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-4" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M15 17h3a3 3 0 0 0 0-6h-.025a5.56 5.56 0 0 0 .025-.5A5.5 5.5 0 0 0 7.207 9.021C7.137 9.017 7.071 9 7 9a4 4 0 1 0 0 8h2.167M12 19v-9m0 0-2 2m2-2 2 2" />
                                                </svg>
                                                <p class="mb-2 text-sm"><span class="font-semibold">Click to
                                                        upload</span>
                                                    or drag and drop</p>
                                                <p class="text-xs">JPG or PNG (MAX. 2MB)</p>
                                            </div>
                                            <input id="dropzone-file" type="file" class="hidden" />
                                        </label>
                                    </div>
                                </div>
                                <div class="flex items-center mb-5">
                                    <input id="default-checkbox" type="checkbox" wire:model="require_payment"
                                        class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft">
                                    <label for="default-checkbox"
                                        class="select-none ms-2 text-sm font-medium text-heading">Require
                                        Payment</label>
                                </div>
                                <div class="flex flex-col mb-5">
                                    <label for="number-input"
                                        class="block mb-2.5 text-sm font-medium text-heading">Payment Amount</label>
                                    <input type="number" id="number-input"
                                        aria-describedby="helper-text-explanation"
                                        class="block w-full px-3 py-2.5 bg-neutral-secondary-medium border border-gray-300 rounded-md shadow-sm text-heading text-sm rounded-base focus:ring-brand focus:border-brand placeholder:text-body"
                                        placeholder="Enter Amount in whole numbers..." />
                                </div>
                                <div class="mb-5">
                                    <button class="w-full px-4 py-2 bg-blue-600 text-white rounded">Publish Event</button>
                                </div>
                            </form>
                    </x-custom-modal>
                    <x-custom-modal model="showDeleteModal">
                        <form class="max-w-md mx-auto">
                            <h1 class="text-xl text-center font-bold">Delete Event</h1>
                            <h3 class="text-center mb-6">Are you sure to delete this event?</h3>
                            <div class="flex flex-row gap-1">
                                <button wire:click=""
                                    class="w-full px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs font-medium">Cancel</button>
                                <button wire:click=""
                                    class="w-full px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs font-medium">Confirm</button>
                            </div>
                        </form>
                    </x-custom-modal>
                    <!--Events table, pulls data from events < venues table-->
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
                            <!--Dynamically loaded data-->
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr class="hover:bg-gray-50">
                                    <!--events.title-->
                                    <td class="px-4 py-3 text-sm text-gray-900">Laravel Workshop</td>
                                    <!--events.date-->
                                    <td class="px-4 py-3 text-sm text-gray-600">11/24/25</td>
                                    <!--events.time-->
                                    <td class="px-4 py-3 text-sm text-gray-600">1:00 PM</td>
                                    <!--events.type-->
                                    <td class="px-4 py-3 text-sm text-gray-600">Face-to-face</td>
                                    <!--events.place-->
                                    <td class="px-4 py-3 text-sm text-gray-600">AVR</td>
                                    <!--events.category-->
                                    <td class="px-4 py-3 text-sm text-gray-600">Academic</td>
                                    <!--events.description-->
                                    <td class="px-4 py-3 text-sm text-gray-600">Laravel tutorials.</td>
                                    <!--events.banner-->
                                    <td class="px-4 py-3 text-sm text-gray-600">banner.png</td>
                                    <!--events.require_payment, Paid = 1, Free = 0-->
                                    <td class="px-4 py-3 text-sm text-gray-600">Free</td>
                                    <!--events.amount, only if events.require_payment == 1(Paid)-->
                                    <td class="px-4 py-3 text-sm text-gray-600">N/A</td>
                                    <!--Edit, Delete-->
                                    <td class="flex flex-row items-center px-4 py-3">
                                        <button wire:click="openEditModal"
                                            class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs font-medium">Edit</button>
                                        <button wire:click="openDeleteModal"
                                            class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs font-medium">Delete</button>
                                        <button wire:click="openArchiveModal"
                                            class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-700 text-xs font-medium">Archive</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Event Updates Table -->
                    <div x-show="activeTab === 'event_updates'" x-transition>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Event</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Updated By</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action</th>
                                </tr>
                            </thead>
                            <!--Dynamically loaded data-->
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr class="hover:bg-gray-50">
                                    <!--events.title-->
                                    <td class="px-4 py-3 text-sm text-gray-900">Laravel Workshop</td>
                                    <!--users.first_name + users.last_name-->
                                    <td class="px-4 py-3 text-sm text-gray-600">Lance De Felipe</td>
                                    <!--current_date-->
                                    <td class="px-4 py-3 text-sm text-gray-600">November 25, 2025</td>
                                    <!--Created, Updated, Deleted-->
                                    <td class="px-4 py-3 text-sm">
                                        <span
                                            class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Updated</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Logins Table -->
                    <div x-show="activeTab === 'system_logins'" x-transition>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Role</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date</th>
                                </tr>
                            </thead>
                            <!--Dynamically loaded data-->
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr class="hover:bg-gray-50">
                                    <!--users.first_name + users.last_name-->
                                    <td class="px-4 py-3 text-sm text-gray-900">Don Alba</td>
                                    <!--Spatie Roles-->
                                    <td class="px-4 py-3 text-sm text-gray-600">Student</td>
                                    <!--current_server_date-->
                                    <td class="px-4 py-3 text-sm text-gray-600">November 25, 2025</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
