<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <x-dashboard-sidebar />

    <!-- Main Content -->
    <div class="flex-1 overflow-y-auto overflow-x-hidden">
        <div class="fixed top-0 right-0 left-0 lg:left-64 z-30">
            <x-dashboard-header userRole="Organizer" :userInitials="$userInitials" />
        </div>

        <!-- Announcements Content -->
        <div class="flex-1 p-6 mt-20 lg:mt-24">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Announcements</h2>
                <p class="text-gray-600 mb-6">Stay updated with the latest announcements and news</p>
                
                <!-- Announcements Feed -->
                <x-announcements-feed 
                    :announcements="$announcements"
                    :editingId="$editingId"
                    :announcementToDelete="$announcementToDelete"
                />
            </div>
        </div>
    </div>
</div>