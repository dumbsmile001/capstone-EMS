<div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <!-- My Events Card -->
    <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
        <!-- Gradient Background Effect -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-blue-700 opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
        
        <!-- Top Accent Line -->
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-400 to-blue-600"></div>
        
        <div class="relative p-6">
            <div class="flex items-center justify-between mb-4">
                <!-- Icon Container with Gradient Background -->
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 text-white flex items-center justify-center shadow-lg shadow-blue-200">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                
                <!-- Status Badge -->
                <span class="px-3 py-1 text-xs font-medium text-blue-600 bg-blue-50 rounded-full">Total</span>
            </div>
            
            <!-- Card Content -->
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">My Events</h3>
                <div class="flex items-end justify-between">
                    <span class="text-3xl font-bold text-gray-800">{{ $stats['my_events'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Events Card -->
    <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-orange-600 to-orange-700 opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-orange-400 to-orange-600"></div>
        
        <div class="relative p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-500 to-orange-600 text-white flex items-center justify-center shadow-lg shadow-orange-200">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="px-3 py-1 text-xs font-medium text-orange-600 bg-orange-50 rounded-full">Upcoming</span>
            </div>
            
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">Upcoming Events</h3>
                <div class="flex items-end justify-between">
                    <span class="text-3xl font-bold text-gray-800">{{ $stats['upcoming_events'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- My Tickets Card -->
    <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-green-600 to-green-700 opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-green-400 to-green-600"></div>
        
        <div class="relative p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-green-500 to-green-600 text-white flex items-center justify-center shadow-lg shadow-green-200">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                    </svg>
                </div>
                <span class="px-3 py-1 text-xs font-medium text-green-600 bg-green-50 rounded-full">Active</span>
            </div>
            
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">My Tickets</h3>
                <div class="flex items-end justify-between">
                    <span class="text-3xl font-bold text-gray-800">{{ $stats['my_tickets'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Payments Card -->
    <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-yellow-600 to-yellow-700 opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-yellow-400 to-yellow-600"></div>
        
        <div class="relative p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-yellow-500 to-yellow-600 text-white flex items-center justify-center shadow-lg shadow-yellow-200">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <span class="px-3 py-1 text-xs font-medium text-yellow-600 bg-yellow-50 rounded-full">Pending</span>
            </div>
            
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">Pending Payments</h3>
                <div class="flex items-end justify-between">
                    <span class="text-3xl font-bold text-gray-800">{{ $stats['pending_payments'] }}</span>
                </div>
            </div>
        </div>
    </div>
</div>