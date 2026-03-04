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
            <!-- Page Header with School Colors -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <div class="h-10 w-2 bg-gradient-to-b from-green-600 to-green-500 rounded-full"></div>
                            <h1 class="text-3xl font-bold text-gray-800">Audit Logs</h1>
                        </div>
                        <p class="text-sm text-gray-600 ml-5">Track all system activities and user actions</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('dashboard.admin') }}"
                            class="px-4 py-2.5 bg-white border-2 border-green-600 text-green-600 rounded-xl hover:bg-green-50 transition-all duration-200 font-medium flex items-center gap-2 shadow-sm hover:shadow">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Dashboard
                        </a>
                        <button wire:click="openExportModal"
                            class="px-4 py-2.5 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-200 font-medium flex items-center gap-2 shadow-lg shadow-green-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Export to Excel/CSV
                        </button>
                    </div>
                </div>
            </div>

            <!-- Filters Card - Modern Design -->
            <div class="bg-white rounded-2xl shadow-xl p-6 mb-8 border-t-4 border-t-blue-600">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <span class="bg-blue-100 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                        </span>
                        Filter Logs
                    </h3>
                    <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                        {{ $logs->total() }} records found
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <!-- Search Box - Full Width on Mobile -->
                    <div class="md:col-span-2 lg:col-span-2">
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" wire:model.live.debounce.300ms="search"
                                class="block w-full pl-10 pr-4 py-3 text-sm border-2 border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                placeholder="Search by description, action, IP address...">
                        </div>
                    </div>

                    <!-- Action Filter -->
                    <div>
                        <select wire:model.live="filterAction"
                            class="block w-full px-4 py-3 text-sm border-2 border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all appearance-none cursor-pointer">
                            <option value="">All Actions</option>
                            @foreach ($availableActions as $action)
                                <option value="{{ $action }}">{{ $action }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- User Filter -->
                    <div>
                        <input type="text" wire:model.live.debounce.300ms="filterUser"
                            class="block w-full px-4 py-3 text-sm border-2 border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                            placeholder="Filter by user...">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Model Type Filter -->
                    <div>
                        <select wire:model.live="filterModel"
                            class="block w-full px-4 py-3 text-sm border-2 border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all appearance-none cursor-pointer">
                            <option value="">All Models</option>
                            @foreach ($modelTypes as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date From -->
                    <div>
                        <input type="date" wire:model.live="dateFrom"
                            class="block w-full px-4 py-3 text-sm border-2 border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    </div>

                    <!-- Date To -->
                    <div>
                        <input type="date" wire:model.live="dateTo"
                            class="block w-full px-4 py-3 text-sm border-2 border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    </div>

                    <!-- Per Page -->
                    <div>
                        <select wire:model.live="perPage"
                            class="block w-full px-4 py-3 text-sm border-2 border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all appearance-none cursor-pointer">
                            <option value="15">15 per page</option>
                            <option value="25">25 per page</option>
                            <option value="50">50 per page</option>
                            <option value="100">100 per page</option>
                        </select>
                    </div>
                </div>

                <!-- Reset Filters Button -->
                <div class="flex justify-end mt-4">
                    <button wire:click="resetFilters"
                        class="px-6 py-2.5 text-sm font-medium text-yellow-700 bg-yellow-50 border-2 border-yellow-300 rounded-xl hover:bg-yellow-100 focus:ring-2 focus:ring-yellow-500 transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset All Filters
                    </button>
                </div>
            </div>

            <!-- Logs Table Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gradient-to-r from-blue-600 to-blue-700">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Time
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    User
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Action
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Description
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Model
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    IP Address
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($logs as $index => $log)
                                <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-blue-50/30' }} hover:bg-yellow-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <div class="flex items-center">
                                            <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                                            {{ $log->created_at->format('M d, Y H:i') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($log->user)
                                            <div class="flex items-center">
                                                <div
                                                    class="flex-shrink-0 h-8 w-8 bg-gradient-to-br from-blue-100 to-yellow-100 rounded-full flex items-center justify-center ring-2 ring-white">
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
                                            <span class="px-3 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full">System</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-action-badge :action="$log->action" />
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">
                                        {{ $log->description }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if ($log->model_type)
                                            <span class="font-medium text-blue-600">{{ $log->model_name }}</span>
                                            @if ($log->model_id)
                                                <span class="text-gray-400 text-xs ml-1">#{{ $log->model_id }}</span>
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
                                            class="text-blue-600 hover:text-yellow-600 transition-colors p-2 hover:bg-blue-50 rounded-lg">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-16 h-16 mb-4 text-gray-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <p class="text-lg font-medium text-gray-600">No audit logs found</p>
                                            <p class="text-sm text-gray-500 mt-1">
                                                @if ($search || $filterAction || $filterUser || $filterModel || $dateFrom || $dateTo)
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

                <!-- Modern Pagination -->
                @if ($logs && method_exists($logs, 'links'))
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                            <div class="text-sm text-gray-600">
                                Showing <span class="font-semibold text-blue-600">{{ $logs->firstItem() }}</span> 
                                to <span class="font-semibold text-blue-600">{{ $logs->lastItem() }}</span> 
                                of <span class="font-semibold text-blue-600">{{ $logs->total() }}</span> results
                            </div>
                            
                            <div class="flex items-center gap-2">
                                @if ($logs->onFirstPage())
                                    <span class="px-3 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-200 rounded-lg cursor-not-allowed">
                                        Previous
                                    </span>
                                @else
                                    <button wire:click="previousPage" wire:loading.attr="disabled"
                                        class="px-3 py-2 text-sm font-medium text-blue-600 bg-white border border-blue-200 rounded-lg hover:bg-blue-50 transition-colors">
                                        Previous
                                    </button>
                                @endif

                                <div class="flex items-center gap-1">
                                    @php
                                        $currentPage = $logs->currentPage();
                                        $lastPage = $logs->lastPage();
                                        $start = max($currentPage - 2, 1);
                                        $end = min($currentPage + 2, $lastPage);
                                    @endphp

                                    @if ($start > 1)
                                        <button wire:click="gotoPage(1)" 
                                            class="w-10 h-10 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-blue-50 transition-colors">
                                            1
                                        </button>
                                        @if ($start > 2)
                                            <span class="px-2 text-gray-400">...</span>
                                        @endif
                                    @endif

                                    @for ($page = $start; $page <= $end; $page++)
                                        @if ($page == $currentPage)
                                            <span class="w-10 h-10 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-yellow-600 border border-transparent rounded-lg flex items-center justify-center">
                                                {{ $page }}
                                            </span>
                                        @else
                                            <button wire:click="gotoPage({{ $page }})"
                                                class="w-10 h-10 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-blue-50 transition-colors">
                                                {{ $page }}
                                            </button>
                                        @endif
                                    @endfor

                                    @if ($end < $lastPage)
                                        @if ($end < $lastPage - 1)
                                            <span class="px-2 text-gray-400">...</span>
                                        @endif
                                        <button wire:click="gotoPage({{ $lastPage }})"
                                            class="w-10 h-10 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-blue-50 transition-colors">
                                            {{ $lastPage }}
                                        </button>
                                    @endif
                                </div>

                                @if ($logs->hasMorePages())
                                    <button wire:click="nextPage" wire:loading.attr="disabled"
                                        class="px-3 py-2 text-sm font-medium text-blue-600 bg-white border border-blue-200 rounded-lg hover:bg-blue-50 transition-colors">
                                        Next
                                    </button>
                                @else
                                    <span class="px-3 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-200 rounded-lg cursor-not-allowed">
                                        Next
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Log Details Modal with School Colors -->
    <x-custom-modal model="showLogDetailsModal" maxWidth="lg" title="Log Details" headerBg="blue">
        @if ($selectedLog)
            <div class="space-y-5">
                <!-- Basic Info Card with Gradient -->
                <div class="bg-gradient-to-r from-blue-600 to-yellow-600 p-5 rounded-xl">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs text-white/90 font-medium">{{ $selectedLog->created_at->format('F j, Y g:i A') }}</span>
                        <span class="px-3 py-1 bg-white/20 text-white rounded-full text-xs font-semibold backdrop-blur-sm">
                            ID: {{ $selectedLog->id }}
                        </span>
                    </div>

                    <div class="flex items-center space-x-3">
                        @if ($selectedLog->user)
                            <div class="flex-shrink-0 h-12 w-12 bg-white/30 rounded-full flex items-center justify-center backdrop-blur-sm">
                                <span class="text-lg font-bold text-white">
                                    {{ substr($selectedLog->user->first_name ?? 'U', 0, 1) }}{{ substr($selectedLog->user->last_name ?? 'N', 0, 1) }}
                                </span>
                            </div>
                            <div class="text-white">
                                <p class="font-semibold text-lg">{{ $selectedLog->user->first_name }} {{ $selectedLog->user->last_name }}</p>
                                <p class="text-sm text-white/80">{{ $selectedLog->user->email }}</p>
                            </div>
                        @else
                            <div class="flex-shrink-0 h-12 w-12 bg-white/30 rounded-full flex items-center justify-center backdrop-blur-sm">
                                <span class="text-lg font-bold text-white">SY</span>
                            </div>
                            <div class="text-white">
                                <p class="font-semibold text-lg">System</p>
                                <p class="text-sm text-white/80">Automated Action</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Rest of the modal content remains the same but with updated colors -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white p-4 rounded-xl border border-gray-200">
                        <p class="text-xs text-gray-500 mb-2">Action</p>
                        <div class="flex items-center space-x-2">
                            <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                            <span class="font-semibold text-gray-800">{{ $selectedLog->action }}</span>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-xl border border-gray-200">
                        <p class="text-xs text-gray-500 mb-2">Description</p>
                        <p class="font-medium text-gray-800">{{ $selectedLog->description }}</p>
                    </div>
                </div>

                <!-- Model Details -->
                @if ($selectedLog->model_type)
                    <div class="bg-white p-4 rounded-xl border border-gray-200">
                        <p class="text-xs text-gray-500 mb-2">Affected Model</p>
                        <div class="flex items-center space-x-2">
                            <span class="px-3 py-1 bg-gradient-to-r from-blue-100 to-yellow-100 text-blue-700 rounded-full text-sm font-medium">
                                {{ $selectedLog->model_name }}
                            </span>
                            @if ($selectedLog->model_id)
                                <span class="text-gray-500">ID: <span class="font-mono">{{ $selectedLog->model_id }}</span></span>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Old Values -->
                @if (!empty($selectedLog->old_values))
                    <div class="bg-white p-4 rounded-xl border border-gray-200">
                        <p class="text-xs text-gray-500 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-1 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                @if (!empty($selectedLog->new_values))
                    <div class="bg-white p-4 rounded-xl border border-gray-200">
                        <p class="text-xs text-gray-500 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-yellow-600 text-white rounded-xl hover:from-blue-700 hover:to-yellow-700 transition-all duration-200 font-medium flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span>Close</span>
                    </button>
                </div>
            </div>
        @endif
    </x-custom-modal>

    <!-- Export Modal with School Colors -->
    <x-custom-modal model="showExportModal" maxWidth="lg" title="Export Audit Logs"
        description="Export audit logs data with current filters" headerBg="green">
        <div class="space-y-6">
            <!-- Current Filters Summary Card -->
            <div class="bg-gradient-to-br from-green-50 to-green-50 p-5 rounded-xl border border-green-200">
                <div class="flex items-center space-x-2 mb-3">
                    <div class="p-1.5 bg-green-200 rounded-lg">
                        <svg class="w-4 h-4 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-green-800">Active Filters</h3>
                </div>

                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div class="space-y-2">
                        <p class="text-green-700">
                            <span class="font-medium">Search:</span>
                            <span class="text-green-600">{{ $search ?: 'None' }}</span>
                        </p>
                        <p class="text-green-700">
                            <span class="font-medium">Action:</span>
                            <span class="text-green-600">{{ $filterAction ?: 'All' }}</span>
                        </p>
                        <p class="text-green-700">
                            <span class="font-medium">User:</span>
                            <span class="text-green-600">{{ $filterUser ?: 'All' }}</span>
                        </p>
                    </div>
                    <div class="space-y-2">
                        <p class="text-green-700">
                            <span class="font-medium">Model:</span>
                            <span class="text-green-600">{{ $filterModel ?: 'All' }}</span>
                        </p>
                        <p class="text-green-700">
                            <span class="font-medium">Date Range:</span>
                            <span class="text-green-600">
                                @if ($dateFrom || $dateTo)
                                    {{ $dateFrom ?: 'Any' }} to {{ $dateTo ?: 'Any' }}
                                @else
                                    All Dates
                                @endif
                            </span>
                        </p>
                        <p class="text-green-700">
                            <span class="font-medium">Per Page:</span>
                            <span class="text-green-600">{{ $perPage }}</span>
                        </p>
                    </div>
                </div>

                <!-- Total Records Badge -->
                <div class="mt-3 pt-3 border-t border-green-200">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-green-700">Logs to export:</span>
                        <span class="px-3 py-1 bg-gradient-to-r from-green-200 to-green-200 text-green-800 rounded-full text-sm font-semibold">
                            {{ $logs->total() }} logs
                        </span>
                    </div>
                </div>
            </div>

            <!-- Export Format Selection -->
            <div class="space-y-3">
                <label class="flex items-center space-x-2 text-sm font-semibold text-green-800">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Choose Export Format</span>
                </label>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Excel Option -->
                    <label class="relative cursor-pointer">
                        <input type="radio" wire:model="exportFormat" value="xlsx" class="sr-only peer">
                        <div
                            class="p-4 bg-white border-2 border-gray-200 rounded-xl peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-green-400 transition-all duration-200">
                            <div class="flex flex-col items-center text-center">
                                <div class="p-3 bg-gradient-to-br from-green-100 to-green-100 rounded-full mb-2">
                                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z" />
                                        <path d="M14 2v6h6M8 13h8M8 17h4" stroke="white" stroke-width="2" />
                                    </svg>
                                </div>
                                <span class="font-semibold text-gray-800">Excel</span>
                                <span class="text-xs text-gray-500 mt-1">.xlsx format</span>
                            </div>
                        </div>
                    </label>

                    <!-- CSV Option -->
                    <label class="relative cursor-pointer">
                        <input type="radio" wire:model="exportFormat" value="csv" class="sr-only peer">
                        <div
                            class="p-4 bg-white border-2 border-gray-200 rounded-xl peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-green-400 transition-all duration-200">
                            <div class="flex flex-col items-center text-center">
                                <div class="p-3 bg-gradient-to-br from-green-100 to-green-100 rounded-full mb-2">
                                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z" />
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

            <!-- Action Buttons -->
            <div class="flex space-x-3 pt-4 border-t-2 border-gray-100">
                <button type="button" wire:click="closeExportModal"
                    class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group">
                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Cancel</span>
                </button>
                <button type="button" wire:click="exportAuditLogs"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-green-600 text-white rounded-xl hover:from-green-700 hover:to-green-700 transition-all duration-200 font-medium flex items-center justify-center space-x-2 group shadow-lg shadow-green-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span>Export to Excel/CSV</span>
                </button>
            </div>
        </div>
    </x-custom-modal>
</div>