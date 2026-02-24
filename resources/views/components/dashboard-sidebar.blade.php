@php
    $user = auth()->user();
    $userRole = $user?->getRoleNames()->first() ?? 'student';

    // Get user initials
    $firstName = $user?->first_name ?? '';
    $lastName = $user?->last_name ?? '';
    $fullName = trim($firstName . ' ' . $lastName);

    // Generate initials
    $initials = '';
    if ($firstName) {
        $initials .= substr($firstName, 0, 1);
    }
    if ($lastName) {
        $initials .= substr($lastName, 0, 1);
    }
    if (empty($initials)) {
        $initials = 'U';
    }

    $dashboardRoutes = [
        'admin' => route('dashboard.admin'),
        'organizer' => route('dashboard.organizer'),
        'student' => route('dashboard.student'),
    ];

    $dashboardRoute = $dashboardRoutes[$userRole] ?? route('dashboard.student');

    $isDashboardRoute = request()->routeIs('dashboard.*') || request()->routeIs('home');

    // Define unique icons for each menu item
    $menuIcons = [
        'dashboard' =>
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />',
        'announcements' =>
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />',
        'events' =>
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />',
        'archived' =>
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />',
        'audit' =>
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />',
        'attendance' =>
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />',
    ];
@endphp

<!-- Mobile sidebar toggle - Repositioned to be properly aligned -->
<div class="lg:hidden fixed top-4 right-4 z-50">
    <button id="sidebarToggle"
        class="p-3 bg-gradient-to-r from-blue-900 to-blue-800 text-yellow-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
        <svg id="menuIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
        <svg id="closeIcon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>

<!-- Sidebar with mobile classes - Enhanced with yellow accents -->
<div id="sidebar"
    class="fixed lg:static w-64 bg-gradient-to-b from-blue-900 to-blue-950 min-h-screen text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-40 flex flex-col shadow-2xl">
    <!-- User Info Section - Enhanced with yellow border and hover effect -->
    <div class="p-6 border-b-2 border-yellow-400 relative overflow-hidden group">
        <!-- Decorative element -->
        <div
            class="absolute top-0 right-0 w-20 h-20 bg-yellow-400 opacity-10 rounded-bl-full transform translate-x-10 -translate-y-10 group-hover:scale-150 transition-transform duration-500">
        </div>

        <div class="flex items-center space-x-3 relative z-10">
            <a href="{{ route('profile') }}"
                class="w-14 h-14 rounded-full bg-gradient-to-br from-yellow-400 to-yellow-500 flex items-center justify-center text-blue-900 font-bold text-xl border-2 border-white shadow-lg transform group-hover:scale-110 transition-transform duration-200">
                {{ $initials }}
            </a>
            <div class="flex-1 min-w-0">
                <a href="{{ route('profile') }}"
                    class="font-bold text-white hover:text-yellow-400 transition-colors block truncate text-lg">
                    {{ $fullName }}
                </a>
                <div
                    class="text-sm bg-yellow-400 text-blue-900 px-2 py-0.5 rounded-full inline-block mt-1 font-semibold">
                    {{ ucfirst($userRole) }}
                </div>
            </div>
        </div>
    </div>

    <nav class="mt-6 flex-1 overflow-y-auto px-3 space-y-1">
        <!-- Dashboard Link -->
        <a href="{{ route('home') }}"
            class="flex items-center px-4 py-3 rounded-lg hover:bg-yellow-400 hover:text-blue-900 transition-all duration-200 transform hover:translate-x-1 group {{ $isDashboardRoute ? 'bg-yellow-400 text-blue-900 shadow-lg' : 'text-white hover:shadow-md' }}">
            <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                {!! $menuIcons['dashboard'] !!}
            </svg>
            <span class="font-medium">Dashboard</span>
            @if ($isDashboardRoute)
                <span class="ml-auto w-2 h-2 bg-blue-900 rounded-full animate-pulse"></span>
            @endif
        </a>

        <!-- Announcements Link -->
        <a href="{{ route('announcements') }}"
            class="flex items-center px-4 py-3 rounded-lg hover:bg-yellow-400 hover:text-blue-900 transition-all duration-200 transform hover:translate-x-1 group {{ request()->routeIs('announcements') ? 'bg-yellow-400 text-blue-900 shadow-lg' : 'text-white hover:shadow-md' }}">
            <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                {!! $menuIcons['announcements'] !!}
            </svg>
            <span class="font-medium">Announcements</span>
            @if (request()->routeIs('announcements'))
                <span class="ml-auto w-2 h-2 bg-blue-900 rounded-full animate-pulse"></span>
            @endif
        </a>

        {{-- Admin menu items --}}
        @if ($userRole === 'admin')
            <!-- Events Link -->
            <a href="{{ route('admin.events') }}"
                class="flex items-center px-4 py-3 rounded-lg hover:bg-yellow-400 hover:text-blue-900 transition-all duration-200 transform hover:translate-x-1 group {{ request()->routeIs('admin.events') ? 'bg-yellow-400 text-blue-900 shadow-lg' : 'text-white hover:shadow-md' }}">
                <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    {!! $menuIcons['events'] !!}
                </svg>
                <span class="font-medium">Events</span>
                @if (request()->routeIs('admin.events'))
                    <span class="ml-auto w-2 h-2 bg-blue-900 rounded-full animate-pulse"></span>
                @endif
            </a>

            <!-- Archived Events Link -->
            <a href="{{ route('admin.events.archived') }}"
                class="flex items-center px-4 py-3 rounded-lg hover:bg-yellow-400 hover:text-blue-900 transition-all duration-200 transform hover:translate-x-1 group {{ request()->routeIs('admin.events.archived') ? 'bg-yellow-400 text-blue-900 shadow-lg' : 'text-white hover:shadow-md' }}">
                <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    {!! $menuIcons['archived'] !!}
                </svg>
                <span class="font-medium">Archived Events</span>
                @if (request()->routeIs('admin.events.archived'))
                    <span class="ml-auto w-2 h-2 bg-blue-900 rounded-full animate-pulse"></span>
                @endif
            </a>

            <!-- Audit Logs Link -->
            <a href="{{ route('admin.audit-logs') }}"
                class="flex items-center px-4 py-3 rounded-lg hover:bg-yellow-400 hover:text-blue-900 transition-all duration-200 transform hover:translate-x-1 group {{ request()->routeIs('admin.audit-logs') ? 'bg-yellow-400 text-blue-900 shadow-lg' : 'text-white hover:shadow-md' }}">
                <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    {!! $menuIcons['audit'] !!}
                </svg>
                <span class="font-medium">Audit Logs</span>
                @if (request()->routeIs('admin.audit-logs'))
                    <span class="ml-auto w-2 h-2 bg-blue-900 rounded-full animate-pulse"></span>
                @endif
            </a>
        @endif

        {{-- Organizer menu items --}}
        @if ($userRole === 'organizer')
            <!-- Events Link -->
            <a href="{{ route('organizer.events') }}"
                class="flex items-center px-4 py-3 rounded-lg hover:bg-yellow-400 hover:text-blue-900 transition-all duration-200 transform hover:translate-x-1 group {{ request()->routeIs('organizer.events') ? 'bg-yellow-400 text-blue-900 shadow-lg' : 'text-white hover:shadow-md' }}">
                <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    {!! $menuIcons['events'] !!}
                </svg>
                <span class="font-medium">Events</span>
                @if (request()->routeIs('organizer.events'))
                    <span class="ml-auto w-2 h-2 bg-blue-900 rounded-full animate-pulse"></span>
                @endif
            </a>

            <!-- Archived Events Link -->
            <a href="{{ route('organizer.events.archived') }}"
                class="flex items-center px-4 py-3 rounded-lg hover:bg-yellow-400 hover:text-blue-900 transition-all duration-200 transform hover:translate-x-1 group {{ request()->routeIs('organizer.events.archived') ? 'bg-yellow-400 text-blue-900 shadow-lg' : 'text-white hover:shadow-md' }}">
                <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    {!! $menuIcons['archived'] !!}
                </svg>
                <span class="font-medium">Archived Events</span>
                @if (request()->routeIs('organizer.events.archived'))
                    <span class="ml-auto w-2 h-2 bg-blue-900 rounded-full animate-pulse"></span>
                @endif
            </a>

            <!-- Event Attendance Link -->
            <a href="{{ route('organizer.attendance') }}"
                class="flex items-center px-4 py-3 rounded-lg hover:bg-yellow-400 hover:text-blue-900 transition-all duration-200 transform hover:translate-x-1 group {{ request()->routeIs('organizer.attendance') ? 'bg-yellow-400 text-blue-900 shadow-lg' : 'text-white hover:shadow-md' }}">
                <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    {!! $menuIcons['attendance'] !!}
                </svg>
                <span class="font-medium">Event Attendance</span>
                @if (request()->routeIs('organizer.attendance'))
                    <span class="ml-auto w-2 h-2 bg-blue-900 rounded-full animate-pulse"></span>
                @endif
            </a>
        @endif

        {{-- Student menu items --}}
        @if ($userRole === 'student')
            <!-- Events Link -->
            <a href="{{ route('student.events') }}"
                class="flex items-center px-4 py-3 rounded-lg hover:bg-yellow-400 hover:text-blue-900 transition-all duration-200 transform hover:translate-x-1 group {{ request()->routeIs('student.events') ? 'bg-yellow-400 text-blue-900 shadow-lg' : 'text-white hover:shadow-md' }}">
                <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    {!! $menuIcons['events'] !!}
                </svg>
                <span class="font-medium">Events</span>
                @if (request()->routeIs('student.events'))
                    <span class="ml-auto w-2 h-2 bg-blue-900 rounded-full animate-pulse"></span>
                @endif
            </a>
        @endif
    </nav>

    <!-- Logout Section - Enhanced with yellow hover effect -->
    <div class="p-4 border-t-2 border-yellow-400 mt-auto">
        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button type="submit"
                class="flex items-center w-full px-4 py-3 text-sm text-red-200 hover:text-blue-900 hover:bg-yellow-400 rounded-lg transition-all duration-200 transform hover:scale-105 group">
                <svg class="w-5 h-5 mr-3 group-hover:rotate-12 transition-transform duration-200" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>
                <span class="font-medium">Log Out</span>
            </button>
        </form>
    </div>
</div>

<!-- Overlay for mobile sidebar - Enhanced with fade effect -->
<div id="sidebarOverlay"
    class="fixed inset-0 bg-gradient-to-r from-blue-900 to-transparent bg-opacity-50 backdrop-blur-sm z-30 lg:hidden hidden transition-opacity duration-300">
</div>

<style>
    /* Add custom animations */
    @keyframes slideIn {
        from {
            transform: translateX(-100%);
        }

        to {
            transform: translateX(0);
        }
    }

    .sidebar-open {
        overflow: hidden;
    }

    /* Pulse animation for active indicators */
    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
            transform: scale(1);
        }

        50% {
            opacity: 0.5;
            transform: scale(1.1);
        }
    }

    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    /* Smooth transitions */
    .hover\:translate-x-1:hover {
        transform: translateX(0.25rem);
    }

    .group:hover .group-hover\:scale-110 {
        transform: scale(1.1);
    }

    .group:hover .group-hover\:rotate-12 {
        transform: rotate(12deg);
    }
</style>

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

            // Add animation class
            if (isOpening) {
                sidebar.style.animation = 'slideIn 0.3s ease-out';
            }
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

        // Remove animation on window resize to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                body.classList.remove('sidebar-open');
                sidebar.style.animation = '';
            }
        });
    });
</script>