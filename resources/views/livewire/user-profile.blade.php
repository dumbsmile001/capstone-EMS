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
                        <button wire:click="$set('activeTab', 'profile')"
                            class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'profile' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Profile Information
                        </button>
                        <button wire:click="$set('activeTab', 'security')"
                            class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'security' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Security
                        </button>
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
                </div>
            </div>
        </div>
    </div>
</div>