@props(['announcements' => []])

<div class="bg-white rounded-lg shadow-md p-6">
    <x-custom-modal model="showAnnouncementModal">
        <h1 class="text-xl text-center font-bold mb-6">Create Announcement</h1>
        <form class="max-w-md mx-auto">
            <div class="mb-5">
                <label for="title" class="block mb-2.5 text-sm font-medium text-heading">Title</label>
                <input type="text" id="title" class="w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Title..." required />
            </div>
            <div class="mb-5">
                <label for="category">Category</label>
                <select id="category" wire:model="event_category" class="block w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="general">General</option>
                    <option value="event">Event</option>
                    <option value="reminder">Reminder</option>
                </select>
            </div>
            <div class="mb-5">
                <label for="description" class="block mb-2.5 text-sm font-medium text-heading">Description</label>
                <input type="text" id="description" class="w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Description..." required />
            </div>
            <div class="mt-4">
                <button type="submit" wire:click="saveAnnouncement" class="w-full px-4 py-2 bg-blue-600 text-white rounded">Publish Announcement</button>
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
            <div class="border-l-4 border-blue-500 pl-4 pb-4">
                <h4 class="font-semibold text-gray-800 mb-1">{{ $announcement['title'] ?? 'Announcement' }}</h4>
                <p class="text-sm text-gray-600 mb-2">{{ $announcement['content'] ?? '' }}</p>
                <p class="text-xs text-gray-500">{{ $announcement['posted'] ?? 'Posted recently' }}</p>
            </div>
        @empty
            <div class="text-sm text-gray-500">No announcements at this time.</div>
        @endforelse
    </div>
</div>

