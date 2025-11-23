@props([
    'model',
    'maxWidth' => 'lg'
])

<x-modal
    wire:model="{{ $model }}"
    maxWidth="{{ $maxWidth }}"
>
    <div class="p-6">
        {{ $slot }}
    </div>
</x-modal>