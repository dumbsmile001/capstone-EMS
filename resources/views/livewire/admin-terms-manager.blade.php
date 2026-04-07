{{-- resources/views/livewire/admin-terms-manager.blade.php --}}
<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Terms and Conditions Manager</h2>
        <button wire:click="$toggle('showForm')" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            {{ $showForm ? 'Cancel' : 'New Version' }}
        </button>
    </div>

    @if(session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    @if($showForm)
        <div class="mb-6 p-6 bg-white rounded-lg shadow border">
            <h3 class="text-lg font-semibold mb-4">Create New Terms Version</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Version</label>
                    <input type="text" wire:model="version" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @error('version') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Summary (Optional)</label>
                    <textarea wire:model="summary" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                    @error('summary') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Full Terms Content</label>
                    <textarea wire:model="content" rows="15" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm font-mono text-sm"></textarea>
                    @error('content') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Effective Date</label>
                    <input type="date" wire:model="effective_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @error('effective_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end">
                    <button wire:click="save" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Create Version
                    </button>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Version</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Effective Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created By</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created At</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($termsVersions as $terms)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $terms->version }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $terms->effective_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            @if($terms->is_active)
                                <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Active</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-800 rounded-full">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $terms->creator?->full_name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $terms->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-right text-sm">
                            <a href="{{ route('terms.show', ['version' => $terms->id]) }}" target="_blank" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                            @if(!$terms->is_active)
                                <button wire:click="activate({{ $terms->id }})" class="text-green-600 hover:text-green-900">Activate</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4">
            {{ $termsVersions->links() }}
        </div>
    </div>
</div>