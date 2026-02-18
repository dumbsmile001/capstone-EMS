@props([
    'model',
    'maxWidth' => 'lg',
    'title' => null,
    'description' => null,
    'showCloseButton' => true,
    'padding' => 'p-4 md:p-6',
    'footer' => null,
    'noPadding' => false,
    'headerBg' => 'blue' // blue, yellow, green, etc.
])

@php
    $responsiveMaxWidth = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg md:max-w-xl lg:max-w-2xl',
        'xl' => 'sm:max-w-xl md:max-w-2xl lg:max-w-4xl',
        '2xl' => 'sm:max-w-2xl md:max-w-4xl lg:max-w-5xl',
    ][$maxWidth] ?? 'sm:max-w-lg md:max-w-xl lg:max-w-2xl';
    
    $paddingClass = $noPadding ? '' : $padding;
    
    $headerSolidColors = [
        'blue' => 'bg-blue-600',
        'yellow' => 'bg-yellow-500',
        'green' => 'bg-green-600',
        'red' => 'bg-red-600',
        'purple' => 'bg-purple-600',
    ];
    
    $headerBgClass = $headerSolidColors[$headerBg] ?? $headerSolidColors['blue'];
    
    $iconBgColors = [
        'blue' => 'bg-blue-500',
        'yellow' => 'bg-yellow-400',
        'green' => 'bg-green-500',
        'red' => 'bg-red-500',
        'purple' => 'bg-purple-500',
    ];
    
    $iconBgClass = $iconBgColors[$headerBg] ?? $iconBgColors['blue'];
    
    $closeButtonColors = [
        'blue' => 'hover:bg-blue-700 focus:ring-blue-300',
        'yellow' => 'hover:bg-yellow-600 focus:ring-yellow-300',
        'green' => 'hover:bg-green-700 focus:ring-green-300',
        'red' => 'hover:bg-red-700 focus:ring-red-300',
        'purple' => 'hover:bg-purple-700 focus:ring-purple-300',
    ];
    
    $closeButtonClass = $closeButtonColors[$headerBg] ?? $closeButtonColors['blue'];
@endphp

<x-modal
    wire:model="{{ $model }}"
    maxWidth="{{ $maxWidth }}"
>
    <div class="modal-content-wrapper">
        <!-- Modal Header with Solid Color Background -->
        <div class="modal-header {{ $headerBgClass }}">
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center space-x-3">
                    <!-- Icon Circle with darker shade for contrast -->
                    <div class="p-2.5 rounded-xl {{ $iconBgClass }} text-white shadow-lg">
                        @if($headerBg === 'blue')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        @elseif($headerBg === 'yellow')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        @elseif($headerBg === 'green')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        @endif
                    </div>
                    
                    <!-- Title and Description - White text for contrast -->
                    <div>
                        @if($title)
                            <h2 class="text-xl font-bold text-white">{{ $title }}</h2>
                        @endif
                        @if($description)
                            <p class="text-sm text-white/90 mt-0.5">{{ $description }}</p>
                        @endif
                    </div>
                </div>
                
                @if($showCloseButton)
                    <button type="button" class="modal-close-button text-white hover:bg-white/20 transition-all duration-200 rounded-lg p-2 focus:outline-none focus:ring-2 {{ $closeButtonClass }}" 
                            wire:click="$set('{{ $model }}', false)"
                            aria-label="Close modal">
                        <svg class="w-5 h-5 transition-transform duration-300 group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                @endif
            </div>
        </div>

        <!-- Modal Body with Improved Spacing -->
        <div class="modal-body {{ $paddingClass }}">
            {{ $slot }}
        </div>

        <!-- Modal Footer -->
        @if($footer)
            <div class="modal-footer">
                {{ $footer }}
            </div>
        @endif
    </div>
</x-modal>

@once
<style>
    /* School Colors - Replace these with your actual school colors */
    :root {
        --school-blue: #2563eb;
        --school-blue-light: #3b82f6;
        --school-yellow: #eab308;
        --school-yellow-light: #facc15;
        --school-green: #16a34a;
        --school-green-light: #22c55e;
    }

    .modal-content-wrapper {
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        max-height: calc(90vh - 2rem);
        display: flex;
        flex-direction: column;
        animation: modalSlideIn 0.3s ease-out;
    }

    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-20px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .modal-header {
        padding: 1.25rem 1.5rem;
    }

    .modal-close-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }

    .modal-close-button:hover {
        transform: scale(1.1);
    }

    .modal-body {
        flex: 1;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e0 #f1f5f9;
    }

    .modal-body::-webkit-scrollbar {
        width: 8px;
    }

    .modal-body::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }

    .modal-body::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 4px;
    }

    .modal-body::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Form Elements Styling */
    .modal-body input[type="text"],
    .modal-body input[type="email"],
    .modal-body input[type="number"],
    .modal-body input[type="date"],
    .modal-body input[type="time"],
    .modal-body textarea,
    .modal-body select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 0.75rem;
        font-size: 0.95rem;
        color: #1f2937;
        background-color: white;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
    }

    .modal-body input:hover,
    .modal-body textarea:hover,
    .modal-body select:hover {
        border-color: var(--school-blue-light);
        box-shadow: 0 4px 8px rgba(37, 99, 235, 0.1);
        transform: translateY(-1px);
    }

    .modal-body input:focus,
    .modal-body textarea:focus,
    .modal-body select:focus {
        outline: none;
        border-color: var(--school-yellow);
        box-shadow: 0 0 0 4px rgba(234, 179, 8, 0.15);
        transform: translateY(-1px);
    }

    /* Modal Footer */
    .modal-footer {
        padding: 1rem 1.5rem;
        background: #f9fafb;
        border-top: 1px solid #e5e7eb;
        display: flex;
        gap: 0.75rem;
        justify-content: flex-end;
    }

    /* Responsive adjustments */
    @media (max-width: 640px) {
        .modal-header {
            padding: 1rem 1.25rem;
        }
        
        .modal-body {
            padding: 1rem;
        }
        
        .modal-footer {
            padding: 0.875rem 1.25rem;
        }
    }
</style>
@endonce