@props(['announcements' => [], 'editingId' => null, 'announcementToDelete' => null])
<div class="bg-white rounded-lg shadow-md p-6">
    <!-- Create/Edit Modal -->
    <x-custom-modal 
        model="showAnnouncementModal" 
        maxWidth="lg"
        :title="$editingId ? 'Edit Announcement' : 'Create New Announcement'"
        description="{{ $editingId ? 'Update your announcement details below' : 'Fill in the details below to create a new announcement' }}"
        headerBg="{{ $editingId ? 'yellow' : 'blue' }}"
    >
        <form wire:submit.prevent="saveAnnouncement" class="space-y-6">
            @if (session()->has('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif
            
            @if (session()->has('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                    {{ session('error') }}
                </div>
            @endif
            
            <!-- Title Field -->
            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                    Announcement Title
                    <span class="text-xs font-normal text-gray-500 ml-2">e.g., Important Update, Event Reminder</span>
                </label>
                <input 
                    type="text" 
                    id="title" 
                    wire:model="title" 
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                    placeholder="Enter announcement title..."
                    required 
                />
                @error('title') 
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category Field -->
            <div>
                <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">
                    Category
                </label>
                <select 
                    id="category" 
                    wire:model="category" 
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                >
                    <option value="general">General Announcement</option>
                    <option value="event">Event Announcement</option>
                    <option value="reminder">Reminder</option>
                </select>
                @error('category') 
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description Field -->
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                    Description
                </label>
                <textarea 
                    id="description" 
                    wire:model="description" 
                    rows="5" 
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 resize-none"
                    placeholder="Write your announcement content here..."
                    required
                ></textarea>
                @error('description') 
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <!-- Form Actions -->
<div class="flex gap-3 pt-4">
    <button 
        type="submit" 
        class="flex-1 px-6 py-3 font-medium rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all duration-200 transform hover:scale-[1.02] 
            @if($editingId)
                bg-yellow-600 text-white hover:bg-yellow-700 focus:ring-yellow-500
            @else
                bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500
            @endif"
    >
        {{ $editingId ? 'Update Announcement' : 'Publish Announcement' }}
    </button>
    <button 
        type="button" 
        wire:click="closeAnnouncementModal" 
        class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition-all duration-200"
    >
        Cancel
    </button>
</div>
        </form>
    </x-custom-modal>

    <!-- Delete Confirmation Modal -->
    <x-custom-modal 
        model="showDeleteModal" 
        maxWidth="md"
        title="Delete Announcement"
        description="This action cannot be undone"
        headerBg="red"
        :showCloseButton="true"
    >
        <div class="text-center py-2">
            <!-- Warning Icon -->
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.928-.833-2.698 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
            
            <!-- Confirmation Message -->
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Are you absolutely sure?</h3>
            <p class="text-sm text-gray-500 mb-4">
                This will permanently delete this announcement and remove all associated data.
            </p>
            
            <!-- Announcement Details -->
            @if($announcementToDelete)
                <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left">
                    <p class="text-xs text-gray-500 mb-1">Announcement:</p>
                    <p class="font-medium text-gray-900">"{{ $announcementToDelete->title }}"</p>
                    @if($announcementToDelete->category)
                        <span class="inline-block mt-2 px-2 py-1 text-xs font-semibold rounded 
                            @switch($announcementToDelete->category)
                                @case('event') bg-green-100 text-green-800 @break
                                @case('reminder') bg-yellow-100 text-yellow-800 @break
                                @default bg-blue-100 text-blue-800
                            @endswitch">
                            {{ ucfirst($announcementToDelete->category) }}
                        </span>
                    @endif
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex gap-3">
                <button 
                    wire:click="deleteAnnouncement" 
                    class="flex-1 px-4 py-3 bg-red-600 text-white font-medium rounded-xl hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200"
                >
                    Confirm Delete
                </button>
                <button 
                    wire:click="closeDeleteModal" 
                    class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition-all duration-200"
                >
                    Cancel
                </button>
            </div>
        </div>
    </x-custom-modal>

    <div class="flex flex-row justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Announcements Feed</h3>
        @role(['admin', 'organizer'])
            <button wire:click="openAnnouncementModal" class="px-4 py-2 mb-6 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                Create Announcement
            </button>
        @endrole
    </div>
    
    <div class="space-y-4">
        @forelse($announcements as $announcement)
            <div class="border-l-4 
                @switch($announcement->category)
                    @case('event') border-green-500 @break
                    @case('reminder') border-yellow-500 @break
                    @default border-blue-500
                @endswitch
                pl-4 pb-4 relative group hover:bg-gray-50 p-2 rounded transition-colors">
                
                <!-- Action Buttons (visible on hover for authorized users) -->
                @role(['admin', 'organizer'])
                    @php
                        $canModify = auth()->check() && 
                            (auth()->user()->hasRole('admin') || 
                            (auth()->user()->hasRole('organizer') && $announcement->user_id == auth()->id()));
                    @endphp
                    
                    @if($canModify)
                        <div class="absolute top-2 right-2 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button 
                                wire:click="editAnnouncement({{ $announcement->id }})" 
                                class="p-1.5 text-blue-600 hover:text-blue-800 hover:bg-blue-100 rounded transition-colors"
                                title="Edit announcement">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <button 
                                wire:click="confirmDelete({{ $announcement->id }})" 
                                class="p-1.5 text-red-600 hover:text-red-800 hover:bg-red-100 rounded transition-colors"
                                title="Delete announcement">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    @endif
                @endrole
                
                <h4 class="font-semibold text-gray-800 mb-1 pr-16">{{ $announcement->title }}</h4>
                <p class="text-sm text-gray-600 mb-2">
                    <span class="inline-block px-2 py-1 text-xs font-semibold rounded 
                        @switch($announcement->category)
                            @case('event') bg-green-100 text-green-800 @break
                            @case('reminder') bg-yellow-100 text-yellow-800 @break
                            @default bg-blue-100 text-blue-800
                        @endswitch">
                        {{ ucfirst($announcement->category) }}
                    </span>
                </p>
                <p class="text-gray-600 mb-2 whitespace-pre-line">{{ $announcement->description }}</p>
                <p class="text-xs text-gray-500">
                    Posted by {{ $announcement->user->first_name ?? 'User' }} {{ $announcement->user->last_name ?? '' }} • 
                    {{ $announcement->created_at->diffForHumans() }}
                    
                    @if($announcement->created_at != $announcement->updated_at)
                        • <span class="text-gray-400" title="Last updated {{ $announcement->updated_at->diffForHumans() }}">
                            (edited)
                        </span>
                    @endif
                </p>
            </div>
        @empty
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="mt-2 text-gray-500">No announcements at this time.</p>
                @role(['admin', 'organizer'])
                    <button wire:click="openAnnouncementModal" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Create your first announcement
                    </button>
                @endrole
            </div>
        @endforelse
        
        @if($announcements instanceof \Illuminate\Pagination\LengthAwarePaginator && $announcements->hasPages())
            <div class="mt-6">
                {{ $announcements->links() }}
            </div>
        @endif
    </div>
</div>