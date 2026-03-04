@props(['announcements' => []])

<div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
    <!-- Enhanced Feed Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 pb-4 border-b border-gray-200">
        <div class="flex items-center gap-3">
            <div class="p-2.5 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg shadow-blue-500/20">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h8v4H7v-4z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">
                    Announcements Feed
                </h3>
                <p class="text-sm text-gray-500 mt-0.5">Stay updated with the latest news and events</p>
            </div>
        </div>
        
        <!-- Live Counter Badge -->
        @if($announcements->count() > 0)
            <div class="mt-3 sm:mt-0 flex items-center gap-2 px-4 py-2 bg-blue-50 rounded-xl border border-blue-100">
                <span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                </span>
                <span class="text-sm font-semibold text-blue-700">{{ $announcements->count() }} new announcements</span>
            </div>
        @endif
    </div>
    
    <!-- Announcements List -->
    <div class="space-y-5">
        @forelse($announcements as $announcement)
            @php
                $categoryColors = [
                    'event' => ['bg' => 'from-green-500 to-green-600', 'light' => 'from-green-50 to-green-100', 'border' => 'border-green-200', 'text' => 'text-green-700', 'badge' => 'bg-green-100 text-green-800', 'dot' => 'bg-green-500'],
                    'reminder' => ['bg' => 'from-yellow-500 to-yellow-600', 'light' => 'from-yellow-50 to-yellow-100', 'border' => 'border-yellow-200', 'text' => 'text-yellow-700', 'badge' => 'bg-yellow-100 text-yellow-800', 'dot' => 'bg-yellow-500'],
                    'general' => ['bg' => 'from-blue-500 to-blue-600', 'light' => 'from-blue-50 to-blue-100', 'border' => 'border-blue-200', 'text' => 'text-blue-700', 'badge' => 'bg-blue-100 text-blue-800', 'dot' => 'bg-blue-500'],
                ];
                $category = $announcement->category ?? 'general';
                $colors = $categoryColors[$category] ?? $categoryColors['general'];
            @endphp
            
            <div class="group relative bg-white rounded-xl overflow-hidden border {{ $colors['border'] }} hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <!-- Category Header Bar -->
                <div class="h-2 w-full bg-gradient-to-r {{ $colors['bg'] }}"></div>
                
                <!-- Main Content -->
                <div class="p-6">
                    <!-- Header with Category and Actions -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3 flex-wrap">
                            <!-- Enhanced Category Badge -->
                            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r {{ $colors['light'] }} {{ $colors['text'] }} border {{ $colors['border'] }} shadow-sm">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $colors['dot'] }} opacity-40"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 {{ $colors['dot'] }}"></span>
                                </span>
                                {{ ucfirst($announcement->category) }}
                            </span>
                            
                            <!-- Enhanced Date Badge -->
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-gray-50 text-gray-600 text-xs border border-gray-200">
                                <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $announcement->created_at->format('M d, Y') }}
                                <span class="text-gray-400">•</span>
                                {{ $announcement->created_at->format('h:i A') }}
                            </span>
                        </div>
                        
                        <!-- Action Buttons -->
                        @role(['admin', 'organizer'])
                            @php
                                $canModify = auth()->check() && 
                                    (auth()->user()->hasRole('admin') || 
                                    (auth()->user()->hasRole('organizer') && $announcement->user_id == auth()->id()));
                            @endphp
                            
                            @if($canModify)
                                <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300">
                                    <button 
                                        wire:click="editAnnouncement({{ $announcement->id }})" 
                                        class="p-2.5 bg-white hover:bg-gradient-to-br {{ $colors['light'] }} {{ $colors['text'] }} rounded-xl transition-all duration-200 shadow-sm hover:shadow-md border border-gray-200 hover:border-{{ explode('-', $colors['border'])[1] }}"
                                        title="Edit announcement">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button 
                                        wire:click="confirmDelete({{ $announcement->id }})" 
                                        class="p-2.5 bg-white hover:bg-red-50 text-red-600 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md border border-gray-200 hover:border-red-200"
                                        title="Delete announcement">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            @endif
                        @endrole
                    </div>

                    <!-- Title with Category-colored accent -->
                    <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:{{ $colors['text'] }} transition-colors relative inline-block">
                        {{ $announcement->title }}
                        <span class="absolute -bottom-1 left-0 w-12 h-1 bg-gradient-to-r {{ $colors['bg'] }} rounded-full opacity-0 group-hover:opacity-100 transition-all duration-300"></span>
                    </h3>

                    <!-- Description with better typography -->
                    <div class="relative mb-4">
                        <p class="text-gray-600 leading-relaxed">
                            {{ $announcement->description }}
                        </p>
                        @if(strlen($announcement->description) > 200)
                            <button class="text-sm {{ $colors['text'] }} font-medium hover:underline mt-2 focus:outline-none">
                                Read more →
                            </button>
                        @endif
                    </div>

                    <!-- Footer with Author and Stats -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <div class="flex items-center gap-3">
                            <!-- Enhanced User Avatar with Category-colored gradient -->
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $colors['bg'] }} flex items-center justify-center text-white text-sm font-bold shadow-lg shadow-{{ explode('-', $colors['bg'])[1] }}/20">
                                {{ strtoupper(substr($announcement->user->first_name ?? 'U', 0, 1)) }}{{ strtoupper(substr($announcement->user->last_name ?? 'S', 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $announcement->user->first_name ?? 'User' }} {{ $announcement->user->last_name ?? '' }}
                                </p>
                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $announcement->created_at->diffForHumans() }}
                                    </span>
                                    @if($announcement->created_at != $announcement->updated_at)
                                        <span class="flex items-center gap-1 text-gray-400">
                                            <span>•</span>
                                            <span>edited</span>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <!-- Enhanced Empty State -->
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl border-2 border-dashed border-gray-200 p-12 text-center">
                <div class="w-24 h-24 mx-auto bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mb-6 shadow-inner">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h8v4H7v-4z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No announcements yet</h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">Get started by creating your first announcement to keep everyone informed and engaged</p>
                @role(['admin', 'organizer'])
                    <button 
                        wire:click="openAnnouncementModal" 
                        class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Create Your First Announcement
                    </button>
                @endrole
            </div>
        @endforelse
        
        <!-- Enhanced Pagination -->
        @if($announcements instanceof \Illuminate\Pagination\LengthAwarePaginator && $announcements->hasPages())
            <div class="mt-10 pt-6 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-gray-500">
                        Showing <span class="font-semibold text-gray-900">{{ $announcements->firstItem() }}</span> 
                        to <span class="font-semibold text-gray-900">{{ $announcements->lastItem() }}</span> 
                        of <span class="font-semibold text-gray-900">{{ $announcements->total() }}</span> announcements
                    </div>
                    
                    <div class="flex items-center gap-2">
                        {{ $announcements->onEachSide(1)->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Add this to your main CSS file or inside a style tag -->
@push('styles')
<style>
    /* Custom scrollbar for announcement cards */
    .announcement-card {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e0 #f1f5f9;
    }
    
    .announcement-card::-webkit-scrollbar {
        width: 6px;
    }
    
    .announcement-card::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }
    
    .announcement-card::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 10px;
    }
    
    .announcement-card::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    
    /* Pulse animation for new announcements */
    @keyframes pulse-border {
        0% { border-color: rgba(59, 130, 246, 0.2); }
        50% { border-color: rgba(59, 130, 246, 0.5); }
        100% { border-color: rgba(59, 130, 246, 0.2); }
    }
    
    .announcement-new {
        animation: pulse-border 2s infinite;
    }
</style>
@endpush