<div class="flex min-h-screen bg-gray-50">
    <div class="fixed left-0 top-0 h-screen z-40">
        <x-dashboard-sidebar />
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col lg:ml-64">
        <!-- Fixed Header -->
        <div class="fixed top-0 right-0 left-0 lg:left-64 z-30">
            <x-dashboard-header userRole="Student" :userInitials="$userInitials" />
        </div>

        <!-- Dashboard Content -->
        <div class="flex-1 p-6 mt-20 lg:mt-24 overflow-y-auto overflow-x-hidden w-full max-w-full">
            <!-- Overview Cards -->
            <livewire:dashboard-stats />
            
            <!-- Main Content Area - Now full width since we removed the old events section -->
            <div class="space-y-6 mt-6 w-full max-w-full">
                <!-- Featured Events Carousel - Full width and visually striking -->
                <div class="w-full max-w-full">
                    <livewire:event-carousel />
                </div>

                <!-- Tabbed Tables Section -->
                <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-full overflow-x-auto" x-data="{ activeTab: 'registrations' }">
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
                        <div x-show="activeTab === 'registrations'" x-transition>
                            <livewire:registration-history />
                        </div>
                        <div x-show="activeTab === 'tickets'" x-transition>
                            <livewire:student-tickets />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>