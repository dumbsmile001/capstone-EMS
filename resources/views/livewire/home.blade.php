<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <x-dashboard-sidebar />

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Header -->
        <x-dashboard-header :userRole="$userRole" :userInitials="$userInitials" />

        <!-- Home Content -->
        <div class="flex-1 p-6">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Welcome Home</h2>
                <p class="text-gray-600 mb-6">Stay updated with the latest announcements and news</p>

                <!-- Announcements Feed -->
                <x-announcements-feed :announcements="[
                    ['title' => 'Welcome to the New Semester!', 'content' => 'Check out the exciting events we have planned for this semester. Make sure to register early for popular events as spots are limited.', 'posted' => 'Posted 2 days ago'],
                    ['title' => 'Tech Conference Registration Open', 'content' => 'Register now for the Annual Tech Conference on June 15th. This is a great opportunity to learn from industry experts and network with peers.', 'posted' => 'Posted 5 days ago'],
                    ['title' => 'Workshop Reminder', 'content' => 'Don\'t forget about the Web Development Workshop this Friday at 2:00 PM. Bring your laptops and be ready for hands-on learning!', 'posted' => 'Posted 1 week ago'],
                    ['title' => 'System Maintenance Scheduled', 'content' => 'The system will be undergoing maintenance on June 10th from 2:00 AM to 4:00 AM. Please plan accordingly.', 'posted' => 'Posted 2 weeks ago'],
                    ['title' => 'New Features Added', 'content' => 'We\'ve added new features to improve your experience. Check out the updated dashboard and event registration system.', 'posted' => 'Posted 3 weeks ago'],
                ]" />
            </div>
        </div>
    </div>
</div>

