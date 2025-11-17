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
                <x-overview-card 
                    title="Registered Participants" 
                    value="324" 
                    icon='<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>'
                    iconColor="blue"
                />
                <x-overview-card 
                    title="Active Events" 
                    value="18" 
                    icon='<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>'
                    iconColor="green"
                />
                <x-overview-card 
                    title="Pending Payments" 
                    value="45" 
                    icon='<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
                    iconColor="yellow"
                />
                <x-overview-card 
                    title="Upcoming Events" 
                    value="6" 
                    icon='<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>'
                    iconColor="orange"
                />
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

            <!-- Tabbed Tables Section -->
            <div class="bg-white rounded-lg shadow-md p-6" x-data="{ activeTab: 'registrations' }">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Data Management</h2>
                    <button class="px-4 py-2 text-sm text-blue-600 hover:text-blue-700 font-medium">View All</button>
                </div>
                
                <!-- Tabs -->
                <div class="border-b border-gray-200 mb-4">
                    <nav class="flex space-x-4">
                        <button @click="activeTab = 'registrations'" :class="activeTab === 'registrations' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 font-medium text-sm transition-colors">
                            Recent Registrations
                        </button>
                        <button @click="activeTab = 'payments'" :class="activeTab === 'payments' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 font-medium text-sm transition-colors">
                            Payments
                        </button>
                        <button @click="activeTab = 'events'" :class="activeTab === 'events' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 font-medium text-sm transition-colors">
                            Events
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
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Full Name</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student ID</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Year Level</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
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
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900">Alex Johnson</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">Web Development Workshop</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">₱500.00</td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium">Paid</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900">Maria Garcia</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">Data Science Summit</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">₱750.00</td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-medium">Pending</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900">David Wilson</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">Annual Tech Conference</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">₱1,000.00</td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium">Paid</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900">Lisa Chen</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">Web Development Workshop</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">₱500.00</td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-medium">Pending</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Events Table -->
                    <div x-show="activeTab === 'events'" x-transition>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event Name</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Participants</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900">Annual Tech Conference</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">June 15, 2023</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">124</td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium">Active</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900">Web Development Workshop</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">June 22, 2023</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">45</td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium">Active</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900">Data Science Summit</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">July 5, 2023</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">89</td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-medium">Upcoming</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900">AI Workshop</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">July 12, 2023</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">32</td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-medium">Upcoming</span>
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

@push('scripts')
<script>
    // Chart.js will be initialized here when the package is installed
    // For now, this is a placeholder
    document.addEventListener('DOMContentLoaded', function() {
        // Pie Chart for Participant Report
        const participantCtx = document.getElementById('participantChart');
        if (participantCtx) {
            // Chart.js code will go here
            // Example:
            // new Chart(participantCtx, {
            //     type: 'pie',
            //     data: { ... }
            // });
        }

        // Bar Chart for Events per Month
        const eventsCtx = document.getElementById('eventsPerMonthChart');
        if (eventsCtx) {
            // Chart.js code will go here
            // Example:
            // new Chart(eventsCtx, {
            //     type: 'bar',
            //     data: { ... }
            // });
        }
    });
</script>
@endpush
