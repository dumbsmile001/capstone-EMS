<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <x-dashboard-sidebar />

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Header -->
        <x-dashboard-header userRole="Student" :userInitials="$userInitials" />

        <!-- Dashboard Content -->
        <div class="flex-1 p-6">
            <!-- Overview Cards -->
            <livewire:dashboard-stats />
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content Area -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Events Section, scrollable -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <livewire:event-registration />
                    </div>

                    <!-- Tabbed Tables Section -->
                    <div class="bg-white rounded-lg shadow-md p-6" x-data="{ activeTab: 'registrations' }">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold text-gray-800">My Data</h2>
                            <button class="px-4 py-2 text-sm text-blue-600 hover:text-blue-700 font-medium">View All</button>
                        </div>
                        
                        <!-- Tabs -->
                        <div class="border-b border-gray-200 mb-4">
                            <nav class="flex space-x-4">
                                <button @click="activeTab = 'registrations'" :class="activeTab === 'registrations' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 font-medium text-sm transition-colors">
                                    Registration History
                                </button>
                                <button @click="activeTab = 'payments'" :class="activeTab === 'payments' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 font-medium text-sm transition-colors">
                                    Payments
                                </button>
                                <button @click="activeTab = 'tickets'" :class="activeTab === 'tickets' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 font-medium text-sm transition-colors">
                                    Tickets
                                </button>
                            </nav>
                        </div>

                        <!-- Tab Content -->
                        <div class="overflow-x-auto">
                            <!-- Replace the Registration History Table section with: -->
                            <div x-show="activeTab === 'registrations'" x-transition>
                                <livewire:registration-history />
                            </div>

                            <!-- Payments Table -->
                            <div x-show="activeTab === 'payments'" x-transition>
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Date</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3 text-sm text-gray-900">Web Development Workshop</td>
                                            <td class="px-4 py-3 text-sm text-gray-600">₱500.00</td>
                                            <td class="px-4 py-3 text-sm text-gray-600">June 20, 2023</td>
                                            <td class="px-4 py-3 text-sm">
                                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium">Paid</span>
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                <button wire:click="viewReceipt(1)" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs font-medium">View Receipt</button>
                                            </td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3 text-sm text-gray-900">Data Science Summit</td>
                                            <td class="px-4 py-3 text-sm text-gray-600">₱750.00</td>
                                            <td class="px-4 py-3 text-sm text-gray-600">-</td>
                                            <td class="px-4 py-3 text-sm">
                                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-medium">Pending</span>
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                <button wire:click="payNow(2)" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs font-medium">Pay Now</button>
                                            </td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3 text-sm text-gray-900">Annual Tech Conference</td>
                                            <td class="px-4 py-3 text-sm text-gray-600">₱1,000.00</td>
                                            <td class="px-4 py-3 text-sm text-gray-600">-</td>
                                            <td class="px-4 py-3 text-sm">
                                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-medium">Pending</span>
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                <button wire:click="payNow(3)" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs font-medium">Pay Now</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Tickets Table -->
                            <div x-show="activeTab === 'tickets'" x-transition>
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ticket ID</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3 text-sm text-gray-900">Web Development Workshop</td>
                                            <td class="px-4 py-3 text-sm text-gray-600">TKT-789012</td>
                                            <td class="px-4 py-3 text-sm text-gray-600">June 22, 2023</td>
                                            <td class="px-4 py-3 text-sm">
                                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-medium">Valid</span>
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                <button wire:click="downloadTicket(1)" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs font-medium">Download</button>
                                            </td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3 text-sm text-gray-900">AI and Machine Learning Seminar</td>
                                            <td class="px-4 py-3 text-sm text-gray-600">TKT-456789</td>
                                            <td class="px-4 py-3 text-sm text-gray-600">May 15, 2023</td>
                                            <td class="px-4 py-3 text-sm">
                                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs font-medium">Used</span>
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                <button wire:click="viewTicket(2)" class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-700 text-xs font-medium">View</button>
                                            </td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3 text-sm text-gray-900">Mobile App Development</td>
                                            <td class="px-4 py-3 text-sm text-gray-600">TKT-123456</td>
                                            <td class="px-4 py-3 text-sm text-gray-600">March 5, 2023</td>
                                            <td class="px-4 py-3 text-sm">
                                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs font-medium">Used</span>
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                <button wire:click="viewTicket(3)" class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-700 text-xs font-medium">View</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="space-y-6">
                    <!-- My Tickets Section (Moved Higher) -->
                    <!-- Replace the entire Tickets Table section with: -->
                    <div x-show="activeTab === 'tickets'" x-transition>
                        <livewire:student-tickets />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
