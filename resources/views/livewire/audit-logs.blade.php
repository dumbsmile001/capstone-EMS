<div class="flex min-h-screen bg-gray-50">
    <div class="fixed left-0 top-0 h-screen z-40">
        <x-dashboard-sidebar />
    </div>

    <!-- Main Content -->
    <div class="flex-1 lg:ml-64 overflow-y-auto overflow-x-hidden">
        <div class="fixed top-0 right-0 left-0 lg:left-64 z-30">
            <x-dashboard-header userRole="Admin" :userInitials="$userInitials" pageTitle="Audit Logs" />
        </div>

        <!-- Dashboard Content -->
        <div class="flex-1 p-6 mt-20 lg:mt-24 overflow-y-auto">
            <!-- Page Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Audit Logs</h1>
                <p class="text-sm text-gray-600 mt-1">Track all system activities and user actions</p>
            </div>

            <!-- Filters Card -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filter Logs
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <!-- Search Box -->
                    <div class="md:col-span-2">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" wire:model.live.debounce.300ms="search"
                                class="block w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Search by description, action, IP address...">
                        </div>
                    </div>

                    <!-- Action Filter -->
                    <div>
                        <select wire:model.live="filterAction"
                            class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Actions</option>
                            @foreach($availableActions as $action)
                                <option value="{{ $action }}">{{ $action }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- User Filter -->
                    <div>
                        <input type="text" wire:model.live.debounce.300ms="filterUser"
                            class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Filter by user...">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <!-- Model Type Filter -->
                    <div>
                        <select wire:model.live="filterModel"
                            class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Models</option>
                            @foreach($modelTypes as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date From -->
                    <div>
                        <input type="date" wire:model.live="dateFrom"
                            class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500"
                            placeholder="From date">
                    </div>

                    <!-- Date To -->
                    <div>
                        <input type="date" wire:model.live="dateTo"
                            class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500"
                            placeholder="To date">
                    </div>

                    <!-- Per Page -->
                    <div>
                        <select wire:model.live="perPage"
                            class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="15">15 per page</option>
                            <option value="25">25 per page</option>
                            <option value="50">50 per page</option>
                            <option value="100">100 per page</option>
                        </select>
                    </div>
                </div>

                <!-- Reset Filters Button -->
                <div class="flex justify-end">
                    <button wire:click="resetFilters"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        Reset All Filters
                    </button>
                </div>
            </div>

            <!-- Logs Table Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Model</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($logs as $log)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $log->created_at->format('M d, Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($log->user)
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <span class="text-sm font-medium text-blue-800">
                                                        {{ substr($log->user->first_name ?? 'U', 0, 1) }}{{ substr($log->user->last_name ?? 'N', 0, 1) }}
                                                    </span>
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-900">
                                                        {{ $log->user->first_name }} {{ $log->user->last_name }}
                                                    </p>
                                                    <p class="text-xs text-gray-500">{{ $log->user->email }}</p>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-500">System</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                       <x-action-badge :action="$log->action" />
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">
                                        {{ $log->description }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        @if($log->model_type)
                                            <span class="font-medium">{{ $log->model_name }}</span>
                                            @if($log->model_id)
                                                <span class="text-gray-400">#{{ $log->model_id }}</span>
                                            @endif
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $log->ip_address ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button wire:click="openLogDetailsModal({{ $log->id }})"
                                            class="text-blue-600 hover:text-blue-900 mr-3">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-16 h-16 mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <p class="text-lg font-medium text-gray-600">No audit logs found</p>
                                            <p class="text-sm text-gray-500 mt-1">
                                                @if($search || $filterAction || $filterUser || $filterModel || $dateFrom || $dateTo)
                                                    Try adjusting your filters
                                                @else
                                                    No activities have been logged yet
                                                @endif
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($logs && method_exists($logs, 'links'))
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        {{ $logs->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Log Details Modal -->
    <x-custom-modal model="showLogDetailsModal" maxWidth="lg" title="Log Details" headerBg="blue">
        @if($selectedLog)
            <div class="space-y-5">
                <!-- Basic Info Card -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-5 rounded-xl border border-blue-200">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs text-blue-600 font-medium">{{ $selectedLog->created_at->format('F j, Y g:i A') }}</span>
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                            ID: {{ $selectedLog->id }}
                        </span>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        @if($selectedLog->user)
                            <div class="flex-shrink-0 h-10 w-10 bg-blue-200 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-blue-800">
                                    {{ substr($selectedLog->user->first_name ?? 'U', 0, 1) }}{{ substr($selectedLog->user->last_name ?? 'N', 0, 1) }}
                                </span>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">{{ $selectedLog->user->first_name }} {{ $selectedLog->user->last_name }}</p>
                                <p class="text-sm text-gray-600">{{ $selectedLog->user->email }}</p>
                            </div>
                        @else
                            <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-gray-600">SY</span>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">System</p>
                                <p class="text-sm text-gray-600">Automated Action</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Action and Model Info -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white p-4 rounded-xl border border-gray-200">
                        <p class="text-xs text-gray-500 mb-2">Action</p>
                        <div class="flex items-center space-x-2">
                            <span class="w-2 h-2 rounded-full 
                                @if($selectedLog->action === 'CREATE') bg-green-500
                                @elseif($selectedLog->action === 'UPDATE') bg-yellow-500
                                @elseif($selectedLog->action === 'DELETE') bg-red-500
                                @else bg-blue-500
                                @endif">
                            </span>
                            <span class="font-semibold text-gray-800">{{ $selectedLog->action }}</span>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-xl border border-gray-200">
                        <p class="text-xs text-gray-500 mb-2">Description</p>
                        <p class="font-medium text-gray-800">{{ $selectedLog->description }}</p>
                    </div>
                </div>

                <!-- Model Details -->
                @if($selectedLog->model_type)
                    <div class="bg-white p-4 rounded-xl border border-gray-200">
                        <p class="text-xs text-gray-500 mb-2">Affected Model</p>
                        <div class="flex items-center space-x-2">
                            <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm font-medium">
                                {{ $selectedLog->model_name }}
                            </span>
                            @if($selectedLog->model_id)
                                <span class="text-gray-500">ID: <span class="font-mono">{{ $selectedLog->model_id }}</span></span>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Old Values -->
                @if(!empty($selectedLog->old_values))
                    <div class="bg-white p-4 rounded-xl border border-gray-200">
                        <p class="text-xs text-gray-500 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-1 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                            </svg>
                            Old Values
                        </p>
                        <div class="bg-gray-50 p-3 rounded-lg overflow-x-auto">
                            <pre class="text-xs text-gray-700">{{ json_encode($selectedLog->old_values, JSON_PRETTY_PRINT) }}</pre>
                        </div>
                    </div>
                @endif

                <!-- New Values -->
                @if(!empty($selectedLog->new_values))
                    <div class="bg-white p-4 rounded-xl border border-gray-200">
                        <p class="text-xs text-gray-500 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            New Values
                        </p>
                        <div class="bg-gray-50 p-3 rounded-lg overflow-x-auto">
                            <pre class="text-xs text-gray-700">{{ json_encode($selectedLog->new_values, JSON_PRETTY_PRINT) }}</pre>
                        </div>
                    </div>
                @endif

                <!-- Request Info -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white p-4 rounded-xl border border-gray-200">
                        <p class="text-xs text-gray-500 mb-2">IP Address</p>
                        <p class="font-mono text-sm">{{ $selectedLog->ip_address ?? 'N/A' }}</p>
                    </div>

                    <div class="bg-white p-4 rounded-xl border border-gray-200">
                        <p class="text-xs text-gray-500 mb-2">User Agent</p>
                        <p class="text-xs text-gray-600 break-words">{{ $selectedLog->user_agent ?? 'N/A' }}</p>
                    </div>
                </div>

                <!-- Close Button -->
                <div class="flex justify-end pt-4 border-t border-gray-200">
                    <button wire:click="closeLogDetailsModal"
                        class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span>Close</span>
                    </button>
                </div>
            </div>
        @endif
    </x-custom-modal>
</div>