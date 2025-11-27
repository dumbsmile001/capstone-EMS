<x-dialog-modal wire:model="showModal">
    <x-slot name="title">
        {{ $mode === 'create' ? 'Create Event' : 'Edit Event' }}
    </x-slot>

    <x-slot name="content">
        <livewire:event-form />
    </x-slot>

    <x-slot name="footer">
        <x-secondary-button wire:click="close">Cancel</x-secondary-button>
    </x-slot>
</x-dialog-modal>