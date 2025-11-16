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

            <!-- Bottom Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Registrations Table -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-800">Recent Registrations</h2>
                        <button wire:click="viewAllRegistrations" class="px-4 py-2 text-sm text-blue-600 hover:text-blue-700 font-medium">View All</button>
                    </div>
                    <div class="overflow-x-auto">
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
                </div>

                <!-- Announcements Feed -->
                <x-announcements-feed :announcements="[
                    ['title' => 'Event Reminder', 'content' => 'Don\'t forget the Web Development Workshop this Friday at 2:00 PM.', 'posted' => 'Posted 1 day ago'],
                    ['title' => 'Payment Deadline', 'content' => 'Payment for the Data Science Summit is due by June 20th.', 'posted' => 'Posted 3 days ago'],
                    ['title' => 'New Event Published', 'content' => 'The Annual Tech Conference has been published and is open for registration.', 'posted' => 'Posted 5 days ago'],
                ]" />
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
