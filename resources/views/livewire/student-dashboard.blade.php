<div class="p-6 bg-gray-50 min-h-screen">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Student Dashboard</h1>
        <p class="text-sm text-gray-600">Discover events, manage your tickets, and view receipts.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow p-4">
            <p class="text-sm text-gray-500">Upcoming Events</p>
            <p class="text-3xl font-semibold mt-1">7</p>
            <button class="mt-4 px-3 py-2 text-sm bg-indigo-600 text-white rounded hover:bg-indigo-700">Browse Events</button>
        </div>
        <div class="bg-white rounded-xl shadow p-4">
            <p class="text-sm text-gray-500">My Registrations</p>
            <p class="text-3xl font-semibold mt-1">3</p>
            <button class="mt-4 px-3 py-2 text-sm bg-emerald-600 text-white rounded hover:bg-emerald-700">View Tickets</button>
        </div>
        <div class="bg-white rounded-xl shadow p-4">
            <p class="text-sm text-gray-500">Unread Announcements</p>
            <p class="text-3xl font-semibold mt-1">1</p>
            <button class="mt-4 px-3 py-2 text-sm bg-amber-600 text-white rounded hover:bg-amber-700">Read Now</button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div class="bg-white rounded-xl shadow">
            <div class="p-4 border-b">
                <h2 class="text-lg font-semibold">Recommended Events</h2>
            </div>
            <div class="p-4 overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-gray-600">
                        <tr>
                            <th class="py-2 pr-4">Event</th>
                            <th class="py-2 pr-4">Date</th>
                            <th class="py-2 pr-4">Venue</th>
                            <th class="py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr>
                            <td class="py-2 pr-4">Tech Summit</td>
                            <td class="py-2 pr-4">Dec 12, 2025</td>
                            <td class="py-2 pr-4">Main Hall</td>
                            <td class="py-2">
                                <button class="px-2 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700">Details</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 pr-4">Career Fair</td>
                            <td class="py-2 pr-4">Jan 8, 2026</td>
                            <td class="py-2 pr-4">Auditorium</td>
                            <td class="py-2">
                                <button class="px-2 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700">Details</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow">
            <div class="p-4 border-b">
                <h2 class="text-lg font-semibold">My Tickets</h2>
            </div>
            <div class="p-4 overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-gray-600">
                        <tr>
                            <th class="py-2 pr-4">Event</th>
                            <th class="py-2 pr-4">Ticket</th>
                            <th class="py-2 pr-4">Status</th>
                            <th class="py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr>
                            <td class="py-2 pr-4">Tech Summit</td>
                            <td class="py-2 pr-4">General</td>
                            <td class="py-2 pr-4"><span class="px-2 py-1 rounded bg-emerald-100 text-emerald-800">Paid</span></td>
                            <td class="py-2">
                                <button class="px-2 py-1 text-xs bg-gray-100 rounded hover:bg-gray-200">Download</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 pr-4">Career Fair</td>
                            <td class="py-2 pr-4">Free</td>
                            <td class="py-2 pr-4"><span class="px-2 py-1 rounded bg-yellow-100 text-yellow-800">Pending</span></td>
                            <td class="py-2">
                                <button class="px-2 py-1 text-xs bg-gray-100 rounded hover:bg-gray-200">View</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


