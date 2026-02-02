<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <x-dashboard-sidebar />

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Header -->
        <x-dashboard-header :userRole="$userRole" :userInitials="$userInitials" />

        <!-- Announcements Content -->
        <div class="flex-1 p-6">
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