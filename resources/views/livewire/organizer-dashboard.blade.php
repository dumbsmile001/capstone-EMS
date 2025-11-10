<div class="p-6 bg-gray-50 min-h-screen">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Organizer Dashboard</h1>
        <p class="text-sm text-gray-600">Plan events, manage registrations, and publish announcements.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow p-4">
            <p class="text-sm text-gray-500">My Active Events</p>
            <p class="text-3xl font-semibold mt-1">4</p>
            <button class="mt-4 px-3 py-2 text-sm bg-indigo-600 text-white rounded hover:bg-indigo-700">Create Event</button>
        </div>
        <div class="bg-white rounded-xl shadow p-4">
            <p class="text-sm text-gray-500">Pending Registrations</p>
            <p class="text-3xl font-semibold mt-1">23</p>
            <button class="mt-4 px-3 py-2 text-sm bg-amber-600 text-white rounded hover:bg-amber-700">Review</button>
        </div>
        <div class="bg-white rounded-xl shadow p-4">
            <p class="text-sm text-gray-500">Announcements</p>
            <p class="text-3xl font-semibold mt-1">2</p>
            <button class="mt-4 px-3 py-2 text-sm bg-emerald-600 text-white rounded hover:bg-emerald-700">New Announcement</button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div class="bg-white rounded-xl shadow">
            <div class="p-4 border-b">
                <h2 class="text-lg font-semibold">Upcoming Events</h2>
            </div>
            <div class="p-4 overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-gray-600">
                        <tr>
                            <th class="py-2 pr-4">Event</th>
                            <th class="py-2 pr-4">Venue</th>
                            <th class="py-2 pr-4">Date</th>
                            <th class="py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr>
                            <td class="py-2 pr-4">Tech Summit</td>
                            <td class="py-2 pr-4">Main Hall</td>
                            <td class="py-2 pr-4">Dec 12, 2025</td>
                            <td class="py-2">
                                <button class="px-2 py-1 text-xs bg-gray-100 rounded hover:bg-gray-200">View</button>
                                <button class="px-2 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700">Edit</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 pr-4">Career Fair</td>
                            <td class="py-2 pr-4">Auditorium</td>
                            <td class="py-2 pr-4">Jan 8, 2026</td>
                            <td class="py-2">
                                <button class="px-2 py-1 text-xs bg-gray-100 rounded hover:bg-gray-200">View</button>
                                <button class="px-2 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700">Edit</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow">
            <div class="p-4 border-b">
                <h2 class="text-lg font-semibold">Recent Registrations</h2>
            </div>
            <div class="p-4 overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-gray-600">
                        <tr>
                            <th class="py-2 pr-4">Student</th>
                            <th class="py-2 pr-4">Event</th>
                            <th class="py-2 pr-4">Ticket</th>
                            <th class="py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr>
                            <td class="py-2 pr-4">Alex Rivera</td>
                            <td class="py-2 pr-4">Tech Summit</td>
                            <td class="py-2 pr-4">General</td>
                            <td class="py-2"><span class="px-2 py-1 rounded bg-emerald-100 text-emerald-800">Paid</span></td>
                        </tr>
                        <tr>
                            <td class="py-2 pr-4">Mia Santos</td>
                            <td class="py-2 pr-4">Career Fair</td>
                            <td class="py-2 pr-4">Free</td>
                            <td class="py-2"><span class="px-2 py-1 rounded bg-yellow-100 text-yellow-800">Pending</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


