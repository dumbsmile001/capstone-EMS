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
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <x-overview-card title="Registered Participants" value="324"
                    icon='<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>'
                    iconColor="blue" />
                <x-overview-card title="Active Events" value="18"
                    icon='<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>'
                    iconColor="green" />
                <x-overview-card title="Pending Payments" value="45"
                    icon='<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
                    iconColor="yellow" />
                <x-overview-card title="Upcoming Events" value="6"
                    icon='<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>'
                    iconColor="orange" />
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Participant Report (Pie Chart) -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Participant Report</h2>
                    <div class="h-64 flex items-center justify-center">
                        <!-- Chart.js Pie Chart Placeholder - Replace with actual Chart.js implementation -->
                        <canvas id="participantChart" class="max-h-full"></canvas>
                    </div>
                    <div class="mt-4 flex justify-center space-x-6 text-sm">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-blue-500 rounded mr-2"></div>
                            <span>1st Year</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-blue-300 rounded mr-2"></div>
                            <span>2nd Year</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-orange-500 rounded mr-2"></div>
                            <span>3rd Year</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-pink-500 rounded mr-2"></div>
                            <span>4th Year</span>
                        </div>
                    </div>
                </div>

                <!-- Events per Month (Bar Chart) -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Events per Month</h2>
                    <div class="h-64 flex items-center justify-center">
                        <!-- Chart.js Bar Chart Placeholder - Replace with actual Chart.js implementation -->
                        <canvas id="eventsPerMonthChart" class="max-h-full"></canvas>
                    </div>
                </div>
            </div>

            <!-- Tabbed Tables Section <button class="px-4 py-2 text-sm text-blue-600 hover:text-blue-700 font-medium">View All</button> -->
            <div class="bg-white rounded-lg shadow-md p-6" x-data="{ activeTab: 'registrations' }">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Data Management</h2>
                    <x-custom-modal model="showCreateModal">
                        <h1 class="text-xl text-center font-bold">Create Event</h1>
                        <form class="max-w-md mx-auto">
                            <div class="mb-5">
                                <label for="title" class="block mb-2.5 text-sm font-medium text-heading">Event
                                    Title</label>
                                <input type="text" id="title"
                                    class="w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="Enter Event Title...">
                            </div>
                            <div class="flex flex-col mb-5">
                                <h3>Event Date and Time</h3>
                                <div class="flex flex-row">
                                    <input type="date"
                                        class="w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <input type="time"
                                        class="w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                            </div>
                            <div class="flex flex-col mb-5">
                                <h3>Event Type</h3>
                                <div class="flex flex-row">
                                    <div class="flex items-center mb-4">
                                        <input id="default-radio-1" type="radio" value="online" name="default-radio"
                                            class="w-4 h-4 text-neutral-primary border-default-medium bg-neutral-secondary-medium rounded-full checked:border-brand focus:ring-2 focus:outline-none focus:ring-brand-subtle border border-default appearance-none mx-3">
                                        <label for="default-radio-1"
                                            class="select-none ms-2 text-sm font-medium text-heading">Online</label>
                                    </div>
                                    <div class="flex items-center mb-4">
                                        <input id="default-radio-2" type="radio" value="face-to-face"
                                            name="default-radio"
                                            class="w-4 h-4 text-neutral-primary border-default-medium bg-neutral-secondary-medium rounded-full checked:border-brand focus:ring-2 focus:outline-none focus:ring-brand-subtle border border-default appearance-none mx-3">
                                        <label for="default-radio-2"
                                            class="select-none ms-2 text-sm font-medium text-heading">Face-to-face</label>
                                    </div>
                                </div>
                                <h3>Event Place or Link</h3>
                                <input type="text"
                                    class="w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="Enter Event Place or Link...">
                            </div>
                            <div class="flex flex-col mb-5">
                                <h2>Event Category</h2>
                                <select
                                    class="block w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="academic">Academic</option>
                                    <option value="sports">Sports</option>
                                    <option value="cultural">Cultural</option>
                                </select>
                            </div>
                            <div class="flex flex-col mb-5">
                                <h2>Event Description</h2>
                                <input type="text"
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
                                            <p class="mb-2 text-sm"><span class="font-semibold">Click to upload</span>
                                                or drag and drop</p>
                                            <p class="text-xs">JPG or PNG (MAX. 2MB)</p>
                                        </div>
                                        <input id="dropzone-file" type="file" class="hidden" />
                                    </label>
                                </div>
                            </div>
                            <div class="flex items-center mb-5">
                                <input id="default-checkbox" type="checkbox" value=""
                                    class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft">
                                <label for="default-checkbox"
                                    class="select-none ms-2 text-sm font-medium text-heading">Require Payment</label>
                            </div>
                            <div class="flex flex-col mb-5">
                                <label for="number-input"
                                    class="block mb-2.5 text-sm font-medium text-heading">Payment Amount</label>
                                <input type="number" id="number-input" aria-describedby="helper-text-explanation"
                                    class="block w-full px-3 py-2.5 bg-neutral-secondary-medium border border-gray-300 rounded-md shadow-sm text-heading text-sm rounded-base focus:ring-brand focus:border-brand placeholder:text-body"
                                    placeholder="Enter Amount in whole numbers..." required />
                            </div>
                            <div class="mb-5">
                                <button type="submit" wire:click="saveEvent"
                                    class="w-full px-4 py-2 bg-blue-600 text-white rounded">Publish Event</button>
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
                            Recent Registrations
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
                        <button @click="activeTab = 'event_updates'"
                            :class="activeTab === 'event_updates' ? 'border-b-2 border-blue-600 text-blue-600' :
                                'text-gray-500 hover:text-gray-700'"
                            class="px-4 py-2 font-medium text-sm transition-colors">
                            Event Updates
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="overflow-x-auto">
                    <!-- Recent Registrations Table -->
                    <div x-show="activeTab === 'registrations'" x-transition>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Full Name</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Student ID</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Year Level</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Course</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Role</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900">Alex Johnson</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">S12345</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">3rd Year</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">Computer Science</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">Student</td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900">Maria Garcia</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">S12346</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">2nd Year</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">Information Systems</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">Student</td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900">David Wilson</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">S12347</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">4th Year</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">Software Engineering</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">Student</td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900">Lisa Chen</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">S12348</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">1st Year</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">Data Science</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">Student</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Payments Table -->
                    <div x-show="activeTab === 'payments'" x-transition>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Student</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Event</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Amount</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900">Alex Johnson</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">Web Development Workshop</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">₱500.00</td>
                                    <td class="px-4 py-3 text-sm">
                                        <span
                                            class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium">Paid</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900">Maria Garcia</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">Data Science Summit</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">₱750.00</td>
                                    <td class="px-4 py-3 text-sm">
                                        <span
                                            class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-medium">Pending</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900">David Wilson</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">Annual Tech Conference</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">₱1,000.00</td>
                                    <td class="px-4 py-3 text-sm">
                                        <span
                                            class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium">Paid</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900">Lisa Chen</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">Web Development Workshop</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">₱500.00</td>
                                    <td class="px-4 py-3 text-sm">
                                        <span
                                            class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-medium">Pending</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Events Table -->
                    <x-custom-modal model="showEditModal">
                        <h1 class="text-xl text-center font-bold">Edit Event</h1>
                        <form class="max-w-md mx-auto">
                            <div class="mb-5">
                                <label for="title" class="block mb-2.5 text-sm font-medium text-heading">Event
                                    Title</label>
                                <input type="text" id="title"
                                    class="w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="Enter Event Title...">
                            </div>
                            <div class="flex flex-col mb-5">
                                <h3>Event Date and Time</h3>
                                <div class="flex flex-row">
                                    <input type="date"
                                        class="w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <input type="time"
                                        class="w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                            </div>
                            <div class="flex flex-col mb-5">
                                <h3>Event Type</h3>
                                <div class="flex flex-row">
                                    <div class="flex items-center mb-4">
                                        <input id="default-radio-1" type="radio" value="online"
                                            name="default-radio"
                                            class="w-4 h-4 text-neutral-primary border-default-medium bg-neutral-secondary-medium rounded-full checked:border-brand focus:ring-2 focus:outline-none focus:ring-brand-subtle border border-default appearance-none mx-3">
                                        <label for="default-radio-1"
                                            class="select-none ms-2 text-sm font-medium text-heading">Online</label>
                                    </div>
                                    <div class="flex items-center mb-4">
                                        <input id="default-radio-2" type="radio" value="face-to-face"
                                            name="default-radio"
                                            class="w-4 h-4 text-neutral-primary border-default-medium bg-neutral-secondary-medium rounded-full checked:border-brand focus:ring-2 focus:outline-none focus:ring-brand-subtle border border-default appearance-none mx-3">
                                        <label for="default-radio-2"
                                            class="select-none ms-2 text-sm font-medium text-heading">Face-to-face</label>
                                    </div>
                                </div>
                                <h3>Event Place or Link</h3>
                                <input type="text"
                                    class="w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="Enter Event Place or Link...">
                            </div>
                            <div class="flex flex-col mb-5">
                                <h2>Event Category</h2>
                                <select
                                    class="block w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="academic">Academic</option>
                                    <option value="sports">Sports</option>
                                    <option value="cultural">Cultural</option>
                                </select>
                            </div>
                            <div class="flex flex-col mb-5">
                                <h2>Event Description</h2>
                                <input type="text"
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
                                            <p class="mb-2 text-sm"><span class="font-semibold">Click to upload</span>
                                                or drag and drop</p>
                                            <p class="text-xs">JPG or PNG (MAX. 2MB)</p>
                                        </div>
                                        <input id="dropzone-file" type="file" class="hidden" />
                                    </label>
                                </div>
                            </div>
                            <div class="flex items-center mb-5">
                                <input id="default-checkbox" type="checkbox" value=""
                                    class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft">
                                <label for="default-checkbox"
                                    class="select-none ms-2 text-sm font-medium text-heading">Require Payment</label>
                            </div>
                            <div class="flex flex-col mb-5">
                                <label for="number-input"
                                    class="block mb-2.5 text-sm font-medium text-heading">Payment Amount</label>
                                <input type="number" id="number-input" aria-describedby="helper-text-explanation"
                                    class="block w-full px-3 py-2.5 bg-neutral-secondary-medium border border-gray-300 rounded-md shadow-sm text-heading text-sm rounded-base focus:ring-brand focus:border-brand placeholder:text-body"
                                    placeholder="Enter Amount in whole numbers..." required />
                            </div>
                            <div class="mb-5">
                                <button type="submit" wire:click="saveEvent"
                                    class="w-full px-4 py-2 bg-blue-600 text-white rounded">Publish Changes</button>
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
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900">Laravel Workshop</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">11/24/25</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">1:00 PM</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">Face-to-face</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">AVR</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">Academic</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">Laravel tutorials.</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">banner.png</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">Free</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">N/A</td>
                                    <td class="flex flex-row items-center px-4 py-3">
                                        <button wire:click="openEditModal"
                                            class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs font-medium">Edit</button>
                                        <button wire:click="openDeleteModal"
                                            class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs font-medium">Delete</button>
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
                </div>
            </div>
        </div>
    </div>
</div>
