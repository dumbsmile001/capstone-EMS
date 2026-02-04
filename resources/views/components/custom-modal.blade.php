@props([
    'model',
    'maxWidth' => 'lg',
    'title' => null,
    'description' => null,
    'showCloseButton' => true,
    'padding' => 'p-4 md:p-6',
    'footer' => null,
    'noPadding' => false
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
@endphp

<x-modal
    wire:model="{{ $model }}"
    maxWidth="{{ $maxWidth }}"
>
    <div class="modal-content-wrapper">
        <!-- Modal Header -->
        @if($title || $description || $showCloseButton)
        <div class="modal-header">
            <div class="modal-header-content">
                @if($title)
                    <h2 class="modal-title">{{ $title }}</h2>
                @endif
                @if($description)
                    <p class="modal-description">{{ $description }}</p>
                @endif
            </div>
            
            @if($showCloseButton)
                <button type="button" class="modal-close-button" 
                        wire:click="$set('{{ $model }}', false)"
                        aria-label="Close modal">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            @endif
        </div>
        @endif

        <!-- Modal Body -->
        <div class="modal-body {{ $paddingClass }}">
            {{ $slot }}
        </div>

        <!-- Modal Footer (if provided) -->
        @if($footer)
            <div class="modal-footer">
                {{ $footer }}
            </div>
        @endif
    </div>
</x-modal>

@once
<style>
    .modal-content-wrapper {
        background: white;
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        max-height: calc(90vh - 2rem);
        display: flex;
        flex-direction: column;
    }

    .modal-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        padding: 1.5rem 1.5rem 0;
        background: linear-gradient(to right, #f8fafc, #ffffff);
        border-bottom: 1px solid #e5e7eb;
    }

    .modal-header-content {
        flex: 1;
        padding-right: 1rem;
    }

    .modal-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.25rem;
        line-height: 1.4;
    }

    .modal-description {
        font-size: 0.875rem;
        color: #6b7280;
        line-height: 1.5;
        margin-top: 0.25rem;
    }

    .modal-close-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2rem;
        height: 2rem;
        border-radius: 0.375rem;
        color: #9ca3af;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }

    .modal-close-button:hover {
        background-color: #f3f4f6;
        color: #374151;
        transform: rotate(90deg);
    }

    .modal-close-button:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .modal-body {
        flex: 1;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #d1d5db #f9fafb;
    }

    .modal-body::-webkit-scrollbar {
        width: 6px;
    }

    .modal-body::-webkit-scrollbar-track {
        background: #f9fafb;
        border-radius: 3px;
    }

    .modal-body::-webkit-scrollbar-thumb {
        background-color: #d1d5db;
        border-radius: 3px;
    }

    .modal-footer {
        padding: 1.25rem 1.5rem;
        background-color: #f9fafb;
        border-top: 1px solid #e5e7eb;
        display: flex;
        gap: 0.75rem;
        justify-content: flex-end;
    }

    /* Success/Failure Message Styling */
    .modal-body .bg-green-100 {
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        margin-bottom: 1.25rem;
        border-left: 4px solid #10b981;
        background-color: #ecfdf5;
        border-color: #10b981;
        color: #047857;
    }

    .modal-body .bg-red-100 {
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        margin-bottom: 1.25rem;
        border-left: 4px solid #ef4444;
        background-color: #fef2f2;
        border-color: #ef4444;
        color: #dc2626;
    }

    /* Form Styling within Modal */
    .modal-body form {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .modal-body .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .modal-body label {
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
        display: block;
        margin-bottom: 0.25rem;
    }

    .modal-body input[type="text"],
    .modal-body input[type="email"],
    .modal-body input[type="number"],
    .modal-body input[type="date"],
    .modal-body input[type="time"],
    .modal-body input[type="password"],
    .modal-body textarea,
    .modal-body select {
        width: 100%;
        padding: 0.625rem 0.875rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        color: #374151;
        background-color: white;
        transition: all 0.2s ease;
    }

    .modal-body input:focus,
    .modal-body textarea:focus,
    .modal-body select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        ring-width: 0;
    }

    .modal-body input::placeholder,
    .modal-body textarea::placeholder {
        color: #9ca3af;
    }

    .modal-body .text-red-500 {
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }

    /* File Upload Styling */
    .modal-body .file-upload-area {
        border: 2px dashed #d1d5db;
        border-radius: 0.5rem;
        padding: 2rem 1rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        background-color: #f9fafb;
    }

    .modal-body .file-upload-area:hover {
        border-color: #3b82f6;
        background-color: #eff6ff;
    }

    .modal-body .file-upload-area.dragover {
        border-color: #3b82f6;
        background-color: #dbeafe;
    }

    /* Checkbox and Radio Styling */
    .modal-body input[type="checkbox"],
    .modal-body input[type="radio"] {
        border-color: #d1d5db;
        border-radius: 0.25rem;
        color: #3b82f6;
    }

    .modal-body input[type="checkbox"]:checked,
    .modal-body input[type="radio"]:checked {
        background-color: #3b82f6;
        border-color: #3b82f6;
    }

    /* Button Styling within Modal */
    .modal-body .button-group {
        display: flex;
        gap: 0.75rem;
        margin-top: 1.5rem;
        padding-top: 1rem;
        border-top: 1px solid #e5e7eb;
    }

    .modal-body button {
        padding: 0.625rem 1.25rem;
        border-radius: 0.5rem;
        font-weight: 500;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .modal-body button[type="submit"] {
        background-color: #3b82f6;
        color: white;
        border: none;
    }

    .modal-body button[type="submit"]:hover {
        background-color: #2563eb;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
    }

    .modal-body button[type="button"] {
        background-color: #f3f4f6;
        color: #374151;
        border: 1px solid #d1d5db;
    }

    .modal-body button[type="button"]:hover {
        background-color: #e5e7eb;
    }

    /* Responsive adjustments */
    @media (max-width: 640px) {
        .modal-header {
            padding: 1rem 1rem 0;
        }
        
        .modal-body {
            padding: 1rem;
        }
        
        .modal-footer {
            padding: 1rem;
        }
        
        .modal-title {
            font-size: 1.125rem;
        }
    }
</style>
@endonce