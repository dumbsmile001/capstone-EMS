<div>
    @if($registrations->count() > 0)
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event Name</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event Category</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event Date</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registration Date</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($registrations as $registration)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $registration->event->title }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600 capitalize">{{ $registration->event->category }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            {{ $registration->event->date->format('F j, Y') }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600 font-medium">
                            {{ $registration->registered_at->format('F j, Y') }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            @if($registration->status === 'registered')
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-medium">Registered</span>
                            @elseif($registration->status === 'attended')
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium">Attended</span>
                            @elseif($registration->status === 'cancelled')
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-medium">Cancelled</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-center py-8">
            <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <p class="mt-4 text-gray-500">No registration history found.</p>
        </div>
    @endif
</div>