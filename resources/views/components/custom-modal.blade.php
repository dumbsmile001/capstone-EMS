@props([
    'model',
    'maxWidth' => 'lg'
])

@php
    $responsiveMaxWidth = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg md:max-w-xl lg:max-w-2xl',
        'xl' => 'sm:max-w-xl md:max-w-2xl lg:max-w-4xl',
        '2xl' => 'sm:max-w-2xl md:max-w-4xl lg:max-w-5xl',
    ][$maxWidth] ?? 'sm:max-w-lg md:max-w-xl lg:max-w-2xl';
@endphp

<x-modal
    wire:model="{{ $model }}"
    maxWidth="{{ $maxWidth }}"
>
    <div class="p-4 md:p-6 max-h-[90vh] overflow-y-auto">
        {{ $slot }}
    </div>
</x-modal>