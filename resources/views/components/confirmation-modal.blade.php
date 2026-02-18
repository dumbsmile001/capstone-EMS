@props([
    'model',
    'title',
    'message',
    'confirmButtonText' => 'Confirm',
    'confirmButtonColor' => 'blue',
    'icon' => null,
    'maxWidth' => 'md'
])

@php
    $colorConfig = [
        'green' => [
            'header' => 'bg-green-600',
            'icon' => 'bg-green-500',
            'iconSvg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />',
            'button' => 'bg-green-600 hover:bg-green-700 focus:ring-green-300',
            'hover' => 'hover:bg-green-700'
        ],
        'red' => [
            'header' => 'bg-red-600',
            'icon' => 'bg-red-500',
            'iconSvg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />',
            'button' => 'bg-red-600 hover:bg-red-700 focus:ring-red-300',
            'hover' => 'hover:bg-red-700'
        ],
        'blue' => [
            'header' => 'bg-blue-600',
            'icon' => 'bg-blue-500',
            'iconSvg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />',
            'button' => 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-300',
            'hover' => 'hover:bg-blue-700'
        ],
    ];
    
    $config = $colorConfig[$confirmButtonColor] ?? $colorConfig['blue'];
@endphp

<x-modal wire:model="{{ $model }}" maxWidth="{{ $maxWidth }}">
    <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all">
        <!-- Header -->
        <div class="{{ $config['header'] }} px-6 py-4 flex items-center space-x-3">
            <div class="p-2 {{ $config['icon'] }} rounded-full">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    {!! $config['iconSvg'] !!}
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-white">{{ $title }}</h3>
        </div>

        <!-- Body -->
        <div class="px-6 py-4">
            <p class="text-gray-600">{{ $message }}</p>
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
            <button 
                type="button" 
                wire:click="$set('{{ $model }}', false)"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-400">
                Cancel
            </button>
            <button 
                type="button" 
                wire:click="confirmAction"
                class="px-4 py-2 {{ $config['button'] }} text-white rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2">
                {{ $confirmButtonText }}
            </button>
        </div>
    </div>
</x-modal>