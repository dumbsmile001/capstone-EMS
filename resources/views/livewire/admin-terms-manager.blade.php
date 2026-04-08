{{-- resources/views/livewire/admin-terms-manager.blade.php --}}
<div class="space-y-6">
    <!-- Page Header with Back Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('dashboard.admin') }}" 
               class="group flex items-center space-x-2 px-3 py-2 bg-white border border-gray-200 rounded-lg text-gray-600 hover:text-blue-900 hover:border-yellow-400 hover:shadow-md transition-all duration-200">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="text-sm font-medium">Back to Dashboard</span>
            </a>
            <div class="h-8 w-px bg-gray-200 hidden sm:block"></div>
            <div>
                <h2 class="text-2xl font-bold bg-gradient-to-r from-blue-900 to-blue-700 bg-clip-text text-transparent">Terms & Conditions</h2>
                <p class="text-sm text-gray-500 mt-0.5">Manage legal agreements and version history</p>
            </div>
        </div>
        <button wire:click="$toggle('showForm')" 
                class="group relative px-5 py-2.5 bg-gradient-to-r from-blue-900 to-blue-700 text-white rounded-xl hover:from-yellow-500 hover:to-yellow-400 hover:text-blue-900 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
            <div class="flex items-center space-x-2">
                <svg class="w-4 h-4 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span class="font-medium">{{ $showForm ? 'Cancel' : 'New Version' }}</span>
            </div>
        </button>
    </div>

    <!-- Success Message with Animation -->
    @if(session()->has('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition.duration.300
             class="relative p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-lg shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-green-700">{{ session('message') }}</span>
            </div>
        </div>
    @endif

    <!-- Create New Version Form - Modern Card Design -->
    @if($showForm)
        <div x-data="{ showForm: true }" x-show="showForm" x-transition.duration.300 
             class="relative bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <!-- Decorative header -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-yellow-400/10 to-transparent rounded-bl-full"></div>
            
            <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-gradient-to-br from-blue-900 to-blue-700 rounded-xl shadow-md">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Create New Terms Version</h3>
                        <p class="text-sm text-gray-500">Fill in the details below to create a new version</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Version <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                    </svg>
                                </div>
                                <input type="text" wire:model="version" placeholder="e.g., 2.0.0"
                                    class="pl-9 w-full rounded-xl border-gray-200 focus:border-yellow-400 focus:ring focus:ring-yellow-200 focus:ring-opacity-50 transition-all duration-200">
                            </div>
                            @error('version') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Effective Date <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <input type="date" wire:model="effective_date"
                                    class="pl-9 w-full rounded-xl border-gray-200 focus:border-yellow-400 focus:ring focus:ring-yellow-200 focus:ring-opacity-50 transition-all duration-200">
                            </div>
                            @error('effective_date') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Summary <span class="text-gray-400 text-xs font-normal">(Optional)</span>
                            </label>
                            <textarea wire:model="summary" rows="3" placeholder="Brief description of changes in this version..."
                                class="w-full rounded-xl border-gray-200 focus:border-yellow-400 focus:ring focus:ring-yellow-200 focus:ring-opacity-50 transition-all duration-200 resize-none"></textarea>
                            @error('summary') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Full Terms Content <span class="text-red-500">*</span>
                        </label>
                        <textarea wire:model="content" rows="12" placeholder="Enter the full terms and conditions content here..."
                            class="w-full rounded-xl border-gray-200 focus:border-yellow-400 focus:ring focus:ring-yellow-200 focus:ring-opacity-50 transition-all duration-200 font-mono text-sm resize-none"></textarea>
                        @error('content') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-100">
                    <button wire:click="$set('showForm', false)" 
                            class="px-5 py-2 text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium">
                        Cancel
                    </button>
                    <button wire:click="save" 
                            class="px-6 py-2 bg-gradient-to-r from-blue-900 to-blue-700 text-white rounded-xl hover:from-yellow-500 hover:to-yellow-400 hover:text-blue-900 transition-all duration-200 shadow-md hover:shadow-lg font-medium">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                            </svg>
                            <span>Create Version</span>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Terms Versions Table - Modern Card Design -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <!-- Table Header with Stats -->
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-gradient-to-br from-blue-900 to-blue-700 rounded-xl shadow-md">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Version History</h3>
                        <p class="text-sm text-gray-500">All terms and conditions versions</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2 text-sm">
                    <span class="px-2.5 py-1 bg-green-100 text-green-700 rounded-lg flex items-center space-x-1">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                        <span>{{ $termsVersions->where('is_active', true)->count() }} Active</span>
                    </span>
                    <span class="px-2.5 py-1 bg-gray-100 text-gray-600 rounded-lg">
                        {{ $termsVersions->total() }} Total Versions
                    </span>
                </div>
            </div>
        </div>

        <!-- Responsive Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Version</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Effective Date</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Created By</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Created At</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($termsVersions as $terms)
                        <tr class="hover:bg-yellow-50/30 transition-colors duration-150 group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center">
                                        <svg class="w-3.5 h-3.5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-bold text-gray-900 font-mono">{{ $terms->version }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-1.5">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-sm text-gray-600">{{ $terms->effective_date->format('M d, Y') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($terms->is_active)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-green-100 text-green-700">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5 animate-pulse"></span>
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-gray-100 text-gray-500">
                                        <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mr-1.5"></span>
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-1.5">
                                    <div class="w-6 h-6 rounded-full bg-gradient-to-br from-yellow-400 to-yellow-500 flex items-center justify-center text-blue-900 font-bold text-xs">
                                        {{ substr($terms->creator?->full_name ?? 'N/A', 0, 1) }}
                                    </div>
                                    <span class="text-sm text-gray-600">{{ $terms->creator?->full_name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $terms->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('terms.show', ['version' => $terms->id]) }}" target="_blank" 
                                       class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200 group-hover:scale-110">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    @if(!$terms->is_active)
                                        <button wire:click="activate({{ $terms->id }})" 
                                                class="p-2 text-green-600 hover:text-green-800 hover:bg-green-50 rounded-lg transition-all duration-200 group-hover:scale-110"
                                                onclick="return confirm('Are you sure you want to activate this version? This will deactivate the current active version.')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 font-medium">No terms versions found</p>
                                    <p class="text-sm text-gray-400 mt-1">Click "New Version" to create one</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($termsVersions->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $termsVersions->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Alpine.js for animations -->
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush