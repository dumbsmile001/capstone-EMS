@props(['announcements' => []])

<div class="bg-white rounded-lg shadow-md p-6">
    <x-custom-modal model="showAnnouncementModal">
        <h1 class="text-xl text-center font-bold mb-6">Create Announcement</h1>
         @if (session()->has('success'))
                                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                                    {{ session('success') }}
                                </div>
                            @endif
        <form wire:submit.prevent="createAnnouncement" class="max-w-md mx-auto">
            <div class="mb-5">
                <label for="title" class="block mb-2.5 text-sm font-medium text-heading">Title</label>
                <input type="text" id="title" wire:model="title" class="w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Title..." required />
                @error('title') <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-5">
                <label for="category">Category</label>
                <select id="category" wire:model="category" class="block w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="general">General</option>
                    <option value="event">Event</option>
                    <option value="reminder">Reminder</option>
                </select>
                @error('category') <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-5">
                <label for="description" class="block mb-2.5 text-sm font-medium text-heading">Description</label>
                <input type="text" id="description" wire:model="description" class="w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Description..." required />
                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-4">
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded">Publish Announcement</button>
            </div>
        </form>
    </x-custom-modal>
    <div class="flex flex-row justify-between">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Announcements Feed</h3>
        @role(['admin', 'organizer'])
            <button wire:click="openAnnouncementModal" class="px-4 py-2 mb-6 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">Create Announcement</button>
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
                pl-4 pb-4">
                <h4 class="font-semibold text-gray-800 mb-1">{{ $announcement->title }}</h4>
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
                <p class="text-gray-600 mb-2">{{ $announcement->description }}</p>
                <p class="text-xs text-gray-500">
                    Posted by {{ $announcement->user->first_name ?? 'User' }} {{ $announcement->user->last_name ?? '' }} • 
                    {{ $announcement->created_at->diffForHumans() }}
                </p>
            </div>
        @empty
            <div class="text-sm text-gray-500">No announcements at this time.</div>
        @endforelse
        @if($announcements instanceof \Illuminate\Pagination\LengthAwarePaginator && $announcements->hasPages())
            <div class="mt-6">
                {{ $announcements->links() }}
            </div>
        @endif
    </div>
</div>