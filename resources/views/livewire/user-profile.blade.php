<div class="min-h-screen bg-gray-50">
    <div class="fixed left-0 top-0 h-screen z-40">
        <x-dashboard-sidebar />
    </div>

    <!-- Main Content -->
    <div class="flex-1 lg:ml-64 overflow-y-auto overflow-x-hidden">
        <!-- Fixed Header -->
        <div class="fixed top-0 right-0 left-0 lg:left-64 z-30">
            <x-dashboard-header userRole="{{ ucfirst(auth()->user()->getRoleNames()->first()) }}" :userInitials="$userInitials" />
        </div>

        <!-- Profile Content -->
        <div class="flex-1 p-6 mt-20 lg:mt-24">
            <!-- Page Header -->
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">User Profile</h1>
                    <p class="text-gray-600">Manage your account settings and preferences</p>
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if (session()->has('message'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('message') }}
                </div>
            @endif

            @if (session()->has('password_message'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('password_message') }}
                </div>
            @endif

            @if (session()->has('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Profile Tabs -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="border-b border-gray-200">
                    <nav class="flex space-x-4 px-6" aria-label="Tabs">
                        <button wire:click="$set('activeTab', 'profile')"
                            class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'profile' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Profile Information
                        </button>
                        <button wire:click="$set('activeTab', 'security')"
                            class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'security' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Security
                        </button>
                        @if (auth()->user()->isAdmin())
                            <button wire:click="$set('activeTab', 'admin')"
                                class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'admin' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                User Management
                            </button>
                        @endif
                    </nav>
                </div>

                <div class="p-6">
                    <!-- Profile Information Tab -->
                    @if ($activeTab === 'profile')
                        <form wire:submit="updateProfile" class="space-y-6">
                            <!-- Profile Initials Display -->
                            <div class="flex items-center space-x-6">
                                <div
                                    class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-3xl font-bold">
                                    {{ $userInitials }}
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-lg font-medium text-gray-900">
                                        {{ $user->full_name ?? $first_name . ' ' . $last_name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $email }}</p>
                                    <p class="text-xs mt-1">
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full">
                                            {{ ucfirst(auth()->user()->getRoleNames()->first()) }}
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- First Name -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                    <input type="text" wire:model="first_name"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('first_name')
                                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Middle Name -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Middle Name</label>
                                    <input type="text" wire:model="middle_name"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('middle_name')
                                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Last Name -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                    <input type="text" wire:model="last_name"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('last_name')
                                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                    <input type="email" wire:model="email"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('email')
                                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit"
                                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    @endif

                    <!-- Security Tab -->
                    @if ($activeTab === 'security')
                        <form wire:submit="updatePassword" class="max-w-lg space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                                <input type="password" wire:model="current_password"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('current_password')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                                <input type="password" wire:model="new_password"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('new_password')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                                <input type="password" wire:model="new_password_confirmation"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="flex justify-end">
                                <button type="submit"
                                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                    Update Password
                                </button>
                            </div>
                        </form>
                    @endif

                    <!-- Admin Tab - User Management -->
                    <!-- Admin Tab - User Management -->
                    @if ($activeTab === 'admin' && auth()->user()->isAdmin())
                        <div class="space-y-6">
                            <!-- Header with Search, Per Page, and Export Button -->
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                <h3 class="text-lg font-semibold text-gray-800">System Users</h3>

                                <div class="flex items-center gap-3 w-full sm:w-auto">
                                    <div class="relative flex-1 sm:flex-initial">
                                        <input type="text" wire:model.live.debounce.300ms="search"
                                            placeholder="Search by name, email, or student ID..."
                                            class="w-full sm:w-80 px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>

                                    <select wire:model.live="perPage"
                                        class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="10">10 per page</option>
                                        <option value="25">25 per page</option>
                                        <option value="50">50 per page</option>
                                        <option value="100">100 per page</option>
                                    </select>

                                    <!-- Export Button -->
                                    <button wire:click="$set('showExportModal', true)"
                                        class="px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition-all duration-200 font-medium flex items-center gap-2 shadow-md shadow-green-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <span>Export</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Users Table - Horizontally Scrollable -->
                            <div class="overflow-x-auto bg-white rounded-lg border border-gray-200 shadow-sm">
                                <div class="min-w-[1200px]">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">
                                                    User</th>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Student ID</th>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Grade Level</th>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Year Level</th>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    SHS Strand</th>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    College Program</th>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Current Role</th>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Actions</th>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Joined</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @forelse($users as $userItem)
                                                <tr class="hover:bg-gray-50 transition-colors">
                                                    <!-- User Info - Sticky Column -->
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap sticky left-0 bg-white hover:bg-gray-50 z-10">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 h-10 w-10">
                                                                <div
                                                                    class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-medium">
                                                                    {{ strtoupper(substr($userItem->first_name, 0, 1) . substr($userItem->last_name, 0, 1)) }}
                                                                </div>
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-gray-900">
                                                                    {{ $userItem->full_name }}
                                                                </div>
                                                                <div class="text-sm text-gray-500">
                                                                    {{ $userItem->email }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <!-- Student ID -->
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        @if ($userItem->student_id)
                                                            <span
                                                                class="font-mono text-xs">{{ $userItem->student_id }}</span>
                                                        @else
                                                            <span class="text-gray-400">—</span>
                                                        @endif
                                                    </td>

                                                    <!-- Grade Level -->
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                        @if ($userItem->grade_level)
                                                            <span
                                                                class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                                                                Grade {{ $userItem->grade_level }}
                                                            </span>
                                                        @else
                                                            <span class="text-gray-400">—</span>
                                                        @endif
                                                    </td>

                                                    <!-- Year Level -->
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                        @if ($userItem->year_level)
                                                            <span
                                                                class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-medium">
                                                                {{ $userItem->year_level }}{{ $userItem->year_level == 1 ? 'st' : ($userItem->year_level == 2 ? 'nd' : ($userItem->year_level == 3 ? 'rd' : 'th')) }}
                                                                Year
                                                            </span>
                                                        @else
                                                            <span class="text-gray-400">—</span>
                                                        @endif
                                                    </td>

                                                    <!-- SHS Strand -->
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                        @if ($userItem->shs_strand)
                                                            <span
                                                                class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                                                {{ $userItem->shs_strand }}
                                                            </span>
                                                        @else
                                                            <span class="text-gray-400">—</span>
                                                        @endif
                                                    </td>

                                                    <!-- College Program -->
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                        @if ($userItem->college_program)
                                                            <span
                                                                class="px-2 py-1 bg-orange-100 text-orange-800 rounded-full text-xs font-medium">
                                                                {{ $userItem->college_program }}
                                                            </span>
                                                        @else
                                                            <span class="text-gray-400">—</span>
                                                        @endif
                                                    </td>

                                                    <!-- Current Role Badge -->
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        @php
                                                            $roleName = $userItem->getRoleNames()->first() ?? 'No Role';
                                                            $roleColors = [
                                                                'admin' => 'bg-purple-100 text-purple-800',
                                                                'organizer' => 'bg-yellow-100 text-yellow-800',
                                                                'student' => 'bg-green-100 text-green-800',
                                                            ];
                                                            $roleColor =
                                                                $roleColors[$roleName] ?? 'bg-gray-100 text-gray-800';
                                                        @endphp
                                                        <span
                                                            class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $roleColor }}">
                                                            {{ ucfirst($roleName) }}
                                                        </span>
                                                    </td>

                                                    <!-- Actions Column -->
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        @if ($selectedUserId === $userItem->id)
                                                            <div class="flex items-center space-x-2">
                                                                <select wire:model="selectedRole"
                                                                    class="px-3 py-1 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                                    @foreach ($availableRoles as $role)
                                                                        <option value="{{ $role }}">
                                                                            {{ ucfirst($role) }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <button
                                                                    wire:click="updateUserRole({{ $userItem->id }})"
                                                                    class="px-3 py-1 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">
                                                                    Save
                                                                </button>
                                                                <button wire:click="$set('selectedUserId', null)"
                                                                    class="px-3 py-1 bg-gray-300 text-gray-700 text-sm rounded-lg hover:bg-gray-400 transition-colors">
                                                                    Cancel
                                                                </button>
                                                            </div>
                                                        @else
                                                            @if ($userItem->id === auth()->id())
                                                                <span class="text-xs text-gray-400 italic">Cannot edit
                                                                    own role</span>
                                                            @else
                                                                <button
                                                                    wire:click="selectUserForRole({{ $userItem->id }})"
                                                                    class="text-blue-600 hover:text-blue-900 font-medium text-sm flex items-center space-x-1">
                                                                    <svg class="w-4 h-4" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                                    </svg>
                                                                    <span>Edit Role</span>
                                                                </button>
                                                            @endif
                                                        @endif
                                                    </td>

                                                    <!-- Joined Date -->
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        <span
                                                            class="text-xs">{{ $userItem->created_at->format('M d, Y') }}</span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="px-6 py-12 text-center text-gray-500">
                                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                                        </svg>
                                                        <p class="mt-2">No users found</p>
                                                        <p class="text-sm">Try adjusting your search or filters</p>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Pagination -->
                            <div class="mt-4">
                                {{ $users->links() }}
                            </div>

                            <!-- Help Text -->
                            <div class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                                <div class="flex items-start space-x-3">
                                    <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div class="text-sm text-blue-800">
                                        <p class="font-medium mb-1">Role Management Guide:</p>
                                        <ul class="list-disc list-inside space-y-1">
                                            <li><strong>Admin</strong> - Full system access, can manage all users and
                                                events</li>
                                            <li><strong>Organizer</strong> - Can create and manage events</li>
                                            <li><strong>Student</strong> - Can view events and register for them</li>
                                            <li class="text-blue-600">Note: You cannot change your own role for
                                                security reasons</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Export Users Modal -->
    @if ($showExportModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                    wire:click="$set('showExportModal', false)"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Export Users
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Export the current user list to Excel or CSV format.
                                        @if ($search)
                                            <span class="block mt-1 text-blue-600">Currently filtering by:
                                                "{{ $search }}"</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Choose Export Format</label>
                            <div class="grid grid-cols-2 gap-4">
                                <!-- Excel Option -->
                                <label class="relative cursor-pointer">
                                    <input type="radio" wire:model="exportFormat" value="xlsx"
                                        class="sr-only peer">
                                    <div
                                        class="p-4 bg-white border-2 border-gray-200 rounded-lg peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-green-300 transition-all duration-200">
                                        <div class="flex flex-col items-center text-center">
                                            <div class="p-3 bg-green-100 rounded-full mb-2">
                                                <svg class="w-8 h-8 text-green-600" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z" />
                                                    <path d="M14 2v6h6M8 13h8M8 17h4" stroke="white"
                                                        stroke-width="2" />
                                                </svg>
                                            </div>
                                            <span class="font-semibold text-gray-800">Excel</span>
                                            <span class="text-xs text-gray-500 mt-1">.xlsx format</span>
                                        </div>
                                    </div>
                                </label>

                                <!-- CSV Option -->
                                <label class="relative cursor-pointer">
                                    <input type="radio" wire:model="exportFormat" value="csv"
                                        class="sr-only peer">
                                    <div
                                        class="p-4 bg-white border-2 border-gray-200 rounded-lg peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-green-300 transition-all duration-200">
                                        <div class="flex flex-col items-center text-center">
                                            <div class="p-3 bg-green-100 rounded-full mb-2">
                                                <svg class="w-8 h-8 text-green-600" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z" />
                                                    <text x="8" y="18" fill="white" font-size="10"
                                                        font-weight="bold">CSV</text>
                                                </svg>
                                            </div>
                                            <span class="font-semibold text-gray-800">CSV</span>
                                            <span class="text-xs text-gray-500 mt-1">Comma separated</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Records to export:</span>
                                <span class="font-semibold text-gray-900">{{ $users->total() ?? 0 }} users</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" wire:click="exportUsers"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Export {{ strtoupper($exportFormat) }}
                        </button>
                        <button type="button" wire:click="$set('showExportModal', false)"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>