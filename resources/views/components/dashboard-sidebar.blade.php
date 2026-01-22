@php
    $user = auth()->user();
    $userRole = $user?->getRoleNames()->first() ?? 'student';
    
    $dashboardRoutes = [
        'admin' => route('dashboard.admin'),
        'organizer' => route('dashboard.organizer'),
        'student' => route('dashboard.student'),
    ];
    
    $dashboardRoute = $dashboardRoutes[$userRole] ?? route('dashboard.student');
    
    // Check if current route is any dashboard route
    $isDashboardRoute = request()->routeIs('dashboard.*') || request()->routeIs('home');
@endphp

<div class="w-64 bg-blue-900 min-h-screen text-white">
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
    </nav>
</div>