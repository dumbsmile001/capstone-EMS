<div class="min-h-screen bg-gray-50">
    <div class="fixed left-0 top-0 h-screen z-40">
        <x-dashboard-sidebar />
    </div>

    <!-- Main Content -->
    <div class="flex-1 lg:ml-64 overflow-y-auto overflow-x-hidden">
        <!-- Fixed Header -->
        <div class="fixed top-0 right-0 left-0 lg:left-64 z-30">
            <x-dashboard-header userRole="{{ ucfirst(auth()->user()->getRoleNames()->first()) }}" :userInitials="$userInitials ?? 'U'" />
        </div>

        <!-- Profile Content -->
        <div class="flex-1 p-6 mt-20 lg:mt-24">
            <!-- Page Header -->
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">User Profile</h1>
                    <p class="text-gray-600">Manage your account settings and preferences</p>
                </div>
                @if(auth()->user()->isAdmin())
                <button 
                    wire:click="$set('showUserManagement', true)"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    User Management
                </button>
                @endif
            </div>

            <!-- Success Messages -->
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

            <!-- Profile Tabs -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="border-b border-gray-200">
                    <nav class="flex space-x-4 px-6" aria-label="Tabs">
                        <button 
                            wire:click="$set('activeTab', 'profile')"
                            class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'profile' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                        >
                            Profile Information
                        </button>
                        <button 
                            wire:click="$set('activeTab', 'security')"
                            class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'security' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                        >
                            Security
                        </button>
                        @if(auth()->user()->isAdmin())
                        <button 
                            wire:click="$set('activeTab', 'admin')"
                            class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'admin' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                        >
                            Admin Settings
                        </button>
                        @endif
                    </nav>
                </div>

                <div class="p-6">
                    <!-- Profile Information Tab -->
                    @if($activeTab === 'profile')
                    <form wire:submit="updateProfile" class="space-y-6">
                        <!-- Profile Photo -->
                        <div class="flex items-center space-x-6">
                            <div class="relative">
                                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-3xl font-bold overflow-hidden">
                                    @if(auth()->user()->profile_photo_url)
                                        <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->full_name }}" class="w-full h-full object-cover">
                                    @else
                                        {{ substr(auth()->user()->first_name, 0, 1) }}{{ substr(auth()->user()->last_name, 0, 1) }}
                                    @endif
                                </div>
                                <label for="photo" class="absolute bottom-0 right-0 bg-blue-600 rounded-full p-2 cursor-pointer hover:bg-blue-700 transition-colors">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </label>
                                <input type="file" id="photo" wire:model="photo" class="hidden" accept="image/*">
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-medium text-gray-900">{{ auth()->user()->full_name }}</h3>
                                <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
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
                                @error('first_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <!-- Middle Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Middle Name</label>
                                <input type="text" wire:model="middle_name" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('middle_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <!-- Last Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                <input type="text" wire:model="last_name" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('last_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" wire:model="email" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <!-- Student-specific fields -->
                            @if(auth()->user()->isStudent())
                            <!-- Student ID -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Student ID</label>
                                <input type="text" wire:model="student_id" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('student_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <!-- Grade/Year Level -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Grade/Year Level</label>
                                <select wire:model="grade_level" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Level</option>
                                    <option value="11">Grade 11</option>
                                    <option value="12">Grade 12</option>
                                    <option value="1">1st Year</option>
                                    <option value="2">2nd Year</option>
                                    <option value="3">3rd Year</option>
                                    <option value="4">4th Year</option>
                                </select>
                            </div>

                            <!-- SHS Strand / College Program -->
                            @if(in_array($grade_level, ['11', '12']))
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">SHS Strand</label>
                                <select wire:model="shs_strand" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Strand</option>
                                    <option value="STEM">STEM</option>
                                    <option value="ABM">ABM</option>
                                    <option value="HUMSS">HUMSS</option>
                                    <option value="GAS">GAS</option>
                                    <option value="TVL">TVL</option>
                                </select>
                            </div>
                            @elseif(in_array($grade_level, ['1', '2', '3', '4']))
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">College Program</label>
                                <input type="text" wire:model="college_program" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            @endif
                            @endif
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
                    @if($activeTab === 'security')
                    <form wire:submit="updatePassword" class="max-w-lg space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                            <input type="password" wire:model="current_password" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('current_password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                            <input type="password" wire:model="new_password" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('new_password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
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

                    <!-- Admin Tab -->
                    @if($activeTab === 'admin' && auth()->user()->isAdmin())
                    <div class="space-y-6">
                        @if(session()->has('admin_message'))
                            <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                                {{ session('admin_message') }}
                            </div>
                        @endif

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">User Management</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Current Role</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($users as $user)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-bold">
                                                        {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <p class="font-medium text-gray-900">{{ $user->full_name }}</p>
                                                        @if($user->student_id)
                                                            <p class="text-xs text-gray-500">ID: {{ $user->student_id }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-600">{{ $user->email }}</td>
                                            <td class="px-4 py-3">
                                                <span class="px-2 py-1 text-xs rounded-full 
                                                    @if($user->isAdmin()) bg-red-100 text-red-800
                                                    @elseif($user->isOrganizer()) bg-green-100 text-green-800
                                                    @else bg-blue-100 text-blue-800
                                                    @endif">
                                                    {{ ucfirst($user->getRoleNames()->first() ?? 'student') }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <button 
                                                    wire:click="selectUser({{ $user->id }})"
                                                    class="text-sm text-blue-600 hover:text-blue-800 font-medium"
                                                >
                                                    Change Role
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Role Change Modal -->
                        @if($selectedUserId)
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
                            <div class="bg-white rounded-lg p-6 max-w-md w-full">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Change User Role</h3>
                                @php $targetUser = \App\Models\User::find($selectedUserId); @endphp
                                @if($targetUser)
                                <p class="text-sm text-gray-600 mb-4">
                                    Change role for <span class="font-semibold">{{ $targetUser->full_name }}</span>
                                </p>
                                <div class="space-y-3 mb-6">
                                    <label class="flex items-center space-x-3">
                                        <input type="radio" wire:model="selectedRole" value="admin" class="text-blue-600">
                                        <span class="text-sm text-gray-700">Admin</span>
                                    </label>
                                    <label class="flex items-center space-x-3">
                                        <input type="radio" wire:model="selectedRole" value="organizer" class="text-blue-600">
                                        <span class="text-sm text-gray-700">Organizer</span>
                                    </label>
                                    <label class="flex items-center space-x-3">
                                        <input type="radio" wire:model="selectedRole" value="student" class="text-blue-600">
                                        <span class="text-sm text-gray-700">Student</span>
                                    </label>
                                </div>
                                <div class="flex justify-end space-x-3">
                                    <button 
                                        wire:click="$set('selectedUserId', null)"
                                        class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors"
                                    >
                                        Cancel
                                    </button>
                                    <button 
                                        wire:click="updateUserRole({{ $selectedUserId }})"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                                    >
                                        Update Role
                                    </button>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>