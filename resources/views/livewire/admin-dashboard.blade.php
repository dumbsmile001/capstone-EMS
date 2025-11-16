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
                <x-overview-card 
                    title="Total Users" 
                    value="1,254" 
                    icon='<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>'
                    iconColor="blue"
                />
                <x-overview-card 
                    title="Total Events" 
                    value="48" 
                    icon='<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>'
                    iconColor="green"
                />
                <x-overview-card 
                    title="Total Payments" 
                    value="856" 
                    icon='<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>'
                    iconColor="yellow"
                />
                <x-overview-card 
                    title="Upcoming Events" 
                    value="12" 
                    icon='<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
                    iconColor="orange"
                />
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Recent Activity Card -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Activity</h2>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">User Logins</p>
                                    <p class="text-sm text-gray-600">15 new logins in the last hour</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Event Updates</p>
                                    <p class="text-sm text-gray-600">3 events updated today</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Role Changes</p>
                                    <p class="text-sm text-gray-600">2 user roles modified</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Events Card -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-800">Upcoming Events</h2>
                        <button wire:click="createEvent" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">Create Event</button>
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

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Users Table -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-800">Users</h2>
                        <button class="px-4 py-2 text-sm text-blue-600 hover:text-blue-700 font-medium">View All</button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900">John Smith</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">john.smith@example.com</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">Student</td>
                                    <td class="px-4 py-3 text-sm text-green-600 font-medium">Active</td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900">Sarah Johnson</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">sarah.j@example.com</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">Organizer</td>
                                    <td class="px-4 py-3 text-sm text-green-600 font-medium">Active</td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900">Michael Brown</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">m.brown@example.com</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">Student</td>
                                    <td class="px-4 py-3 text-sm text-yellow-600 font-medium">Pending</td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900">Emily Davis</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">emily.davis@example.com</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">Admin</td>
                                    <td class="px-4 py-3 text-sm text-green-600 font-medium">Active</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Announcements Feed -->
                <x-announcements-feed :announcements="[
                    ['title' => 'System Maintenance', 'content' => 'The system will be undergoing maintenance on June 10th from 2:00 AM to 4:00 AM.', 'posted' => 'Posted 2 hours ago'],
                    ['title' => 'New Features Added', 'content' => 'We\'ve added new reporting features to the admin dashboard.', 'posted' => 'Posted 1 day ago'],
                    ['title' => 'Upcoming Training', 'content' => 'Training session for new organizers scheduled for June 12th.', 'posted' => 'Posted 2 days ago'],
                ]" />
            </div>
        </div>
    </div>
</div>
