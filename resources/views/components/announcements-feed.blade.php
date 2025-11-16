@props(['announcements' => []])

<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Announcements Feed</h3>
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

