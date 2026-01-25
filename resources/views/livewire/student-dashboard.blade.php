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
                            <!-- Tickets Table -->
                            <div x-show="activeTab === 'tickets'" x-transition>
                                <livewire:student-tickets />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
