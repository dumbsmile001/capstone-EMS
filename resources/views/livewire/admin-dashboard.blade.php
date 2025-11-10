<div class="p-6 bg-gray-50 min-h-screen">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Admin Dashboard</h1>
        <p class="text-sm text-gray-600">Manage users, roles, events, and system settings.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow p-4">
            <p class="text-sm text-gray-500">Total Users</p>
            <p class="text-3xl font-semibold mt-1">1,248</p>
            <button class="mt-4 px-3 py-2 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">Manage Users</button>
        </div>
        <div class="bg-white rounded-xl shadow p-4">
            <p class="text-sm text-gray-500">Active Events</p>
            <p class="text-3xl font-semibold mt-1">12</p>
            <button class="mt-4 px-3 py-2 text-sm bg-indigo-600 text-white rounded hover:bg-indigo-700">View Events</button>
        </div>
        <div class="bg-white rounded-xl shadow p-4">
            <p class="text-sm text-gray-500">Pending Approvals</p>
            <p class="text-3xl font-semibold mt-1">5</p>
            <button class="mt-4 px-3 py-2 text-sm bg-amber-600 text-white rounded hover:bg-amber-700">Review Requests</button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div class="bg-white rounded-xl shadow">
            <div class="p-4 border-b">
                <h2 class="text-lg font-semibold">Recent Users</h2>
            </div>
            <div class="p-4 overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-gray-600">
                        <tr>
                            <th class="py-2 pr-4">Name</th>
                            <th class="py-2 pr-4">Email</th>
                            <th class="py-2 pr-4">Role</th>
                            <th class="py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr>
                            <td class="py-2 pr-4">Jane Doe</td>
                            <td class="py-2 pr-4">jane@example.com</td>
                            <td class="py-2 pr-4"><span class="px-2 py-1 rounded bg-green-100 text-green-800">Organizer</span></td>
                            <td class="py-2">
                                <button class="px-2 py-1 text-xs bg-gray-100 rounded hover:bg-gray-200">View</button>
                                <button class="px-2 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700">Edit</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 pr-4">John Smith</td>
                            <td class="py-2 pr-4">john@example.com</td>
                            <td class="py-2 pr-4"><span class="px-2 py-1 rounded bg-blue-100 text-blue-800">Admin</span></td>
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
                <h2 class="text-lg font-semibold">System Activity</h2>
            </div>
            <div class="p-4 space-y-3">
                <div class="text-sm text-gray-700">• New organizer registered</div>
                <div class="text-sm text-gray-700">• Event "Tech Summit" approved</div>
                <div class="text-sm text-gray-700">• 3 students purchased tickets</div>
            </div>
        </div>
    </div>
</div>


