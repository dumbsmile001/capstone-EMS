@php
    $user = auth()->user();
    $userRole = $user?->getRoleNames()->first() ?? 'student';
    
    $dashboardRoutes = [
        'admin' => route('dashboard.admin'),
        'organizer' => route('dashboard.organizer'),
        'student' => route('dashboard.student'),
    ];
    
    $dashboardRoute = $dashboardRoutes[$userRole] ?? route('dashboard.student');
    
    $isDashboardRoute = request()->routeIs('dashboard.*') || request()->routeIs('home');
@endphp

<!-- Mobile sidebar toggle -->
<div class="lg:hidden fixed top-4 left-4 z-50">
    <button id="sidebarToggle" class="p-2 bg-blue-900 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
        <svg id="menuIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
        <svg id="closeIcon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>

<!-- Sidebar with mobile classes -->
<div id="sidebar" class="fixed lg:static w-64 bg-blue-900 min-h-screen text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-300 z-40">
    <div class="p-6 border-b border-blue-800">
        <h1 class="text-2xl font-bold">SPCC</h1>
    </div>
    <nav class="mt-6">
        <a href="{{ route('home') }}" class="flex items-center px-6 py-3 hover:bg-blue-800 transition-colors {{ $isDashboardRoute ? 'bg-blue-800' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('announcements') }}" class="flex items-center px-6 py-3 hover:bg-blue-800 transition-colors {{ request()->routeIs('announcements') ? 'bg-blue-800' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <span>Announcements</span>
        </a>
        {{-- Add these menu items for admin role --}}
        @if($userRole === 'admin')
        <a href="{{ route('admin.events') }}" 
        class="flex items-center px-6 py-3 hover:bg-blue-800 transition-colors {{ request()->routeIs('admin.events') ? 'bg-blue-800' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <span>Events</span>
        </a>
        <a href="{{ route('admin.events.archived') }}" 
        class="flex items-center px-6 py-3 hover:bg-blue-800 transition-colors {{ request()->routeIs('admin.events.archived') ? 'bg-blue-800' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
            </svg>
            <span>Archived Events</span>
        </a>
        @endif
        @if($userRole === 'organizer')
        <a href="{{ route('organizer.events') }}" 
            class="flex items-center px-6 py-3 hover:bg-blue-800 transition-colors {{ request()->routeIs('organizer.events') ? 'bg-blue-800' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <span>Events</span>
        </a>
        <a href="{{ route('organizer.events.archived') }}" 
            class="flex items-center px-6 py-3 hover:bg-blue-800 transition-colors {{ request()->routeIs('organizer.events.archived') ? 'bg-blue-800' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
            </svg>
            <span>Archived Events</span>
        </a>
        <a href="{{ route('organizer.attendance') }}" 
            class="flex items-center px-6 py-3 hover:bg-blue-800 transition-colors {{ request()->routeIs('organizer.attendance') ? 'bg-blue-800' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
            </svg>
            <span>Event Attendance</span>
        </a>
        @endif
        {{-- Add this in the nav section after the announcements link --}}
        @if($userRole === 'student')
            <a href="{{ route('student.events') }}" 
                class="flex items-center px-6 py-3 hover:bg-blue-800 transition-colors {{ request()->routeIs('student.events') ? 'bg-blue-800' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <span>Events</span>
            </a>
        @endif
    </nav>
</div>

<!-- Overlay for mobile sidebar -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden hidden"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const menuIcon = document.getElementById('menuIcon');
    const closeIcon = document.getElementById('closeIcon');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const body = document.body;
    
    sidebarToggle.addEventListener('click', function() {
        const isOpening = sidebar.classList.contains('-translate-x-full');
        
        sidebar.classList.toggle('-translate-x-full');
        menuIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');
        sidebarOverlay.classList.toggle('hidden');
        
        // Toggle body class to prevent scrolling
        body.classList.toggle('sidebar-open', isOpening);
    });
    
    sidebarOverlay.addEventListener('click', function() {
        sidebar.classList.add('-translate-x-full');
        menuIcon.classList.remove('hidden');
        closeIcon.classList.add('hidden');
        sidebarOverlay.classList.add('hidden');
        
        // Remove class to re-enable scrolling
        body.classList.remove('sidebar-open');
    });
    
    // Close sidebar when clicking on links (mobile only)
    if (window.innerWidth < 1024) {
        const sidebarLinks = sidebar.querySelectorAll('a');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function() {
                sidebar.classList.add('-translate-x-full');
                menuIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
                sidebarOverlay.classList.add('hidden');
                
                // Remove class to re-enable scrolling
                body.classList.remove('sidebar-open');
            });
        });
    }
    
    // Optional: Remove class on window resize to desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) {
            body.classList.remove('sidebar-open');
        }
    });
});
</script>