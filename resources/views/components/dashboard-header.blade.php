@props(['userRole' => 'Student', 'userInitials' => 'SU'])

<div class="bg-gradient-to-r from-yellow-400 to-yellow-500 shadow-lg border-b-4 border-blue-900 px-4 sm:px-8 py-4 flex items-center justify-between relative">
    <h1 class="text-xl sm:text-2xl font-bold text-blue-900 drop-shadow-sm flex-1 text-left lg:text-left">
        <span class="px-3 sm:px-4 py-2 rounded-lg inline-block">
            Event Management System
        </span>
    </h1>
    
    <!-- Inspirational Message - Hidden on mobile, visible on desktop -->
    <div class="hidden lg:flex items-center space-x-2 text-blue-900 px-6 py-2">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
        </svg>
        <span class="font-medium text-sm">Manage and register to different events, all in one place!</span>
    </div>
</div>