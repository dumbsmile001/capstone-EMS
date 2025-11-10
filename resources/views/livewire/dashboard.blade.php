<div class="p-6 bg-gray-50 min-h-screen">
    <h1 class="text-2xl font-bold mb-6">
        Welcome, {{ ucfirst($role) }}!
    </h1>
    {{-- ADMIN --}}
    @if($role === 'admin')
        <div class="bg-white shadow rounded-xl p-4">
            <h2 class="text-lg font-semibold">Admin Overview</h2>
            <p>Here you can manage users, events and permissions.</p>
            <ul class="mt-3 list-disc list-inside">
                <li><a href="#" class="text-blue-600 hover-underline">Action 1</a></li>
                <li><a href="#" class="text-blue-600 hover-underline">Action 2</a></li>
                <li><a href="#" class="text-blue-600 hover-underline">Action 3</a></li>
            </ul>
			<div class="mt-4">
				<a href="{{ route('dashboard.admin') }}" class="inline-block px-3 py-2 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">Go to Admin Dashboard</a>
			</div>
        </div>
    @elseif($role === 'organizer')
        <div class="bg-white shadow rounded-xl p-4">
            <h2 class="text-lg font-semibold">Organizer Overview</h2>
            <p>Manage your assigned events and announcements.</p>
            <ul class="mt-3 list-disc list-inside">
                <li><a href="#" class="text-blue-600 hover-underline">Action 1</a></li>
                <li><a href="#" class="text-blue-600 hover-underline">Action 2</a></li>
                <li><a href="#" class="text-blue-600 hover-underline">Action 3</a></li>
            </ul>
			<div class="mt-4">
				<a href="{{ route('dashboard.organizer') }}" class="inline-block px-3 py-2 text-sm bg-indigo-600 text-white rounded hover:bg-indigo-700">Go to Organizer Dashboard</a>
			</div>
        </div>
    @elseif($role === 'student')
        <div class="bg-white shadow rounded-xl p-4">
            <h2 class="text-lg font-semibold">Student Overview</h2>
            <p>View events, announcemnts and track your registrations.</p>
            <ul class="mt-3 list-disc list-inside">
                <li><a href="#" class="text-blue-600 hover-underline">Action 1</a></li>
                <li><a href="#" class="text-blue-600 hover-underline">Action 2</a></li>
                <li><a href="#" class="text-blue-600 hover-underline">Action 3</a></li>
            </ul>
			<div class="mt-4">
				<a href="{{ route('dashboard.student') }}" class="inline-block px-3 py-2 text-sm bg-emerald-600 text-white rounded hover:bg-emerald-700">Go to Student Dashboard</a>
			</div>
        </div>
    @else
        <p>You are not registered to any role yet.</p>
    @endif
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
</div>
