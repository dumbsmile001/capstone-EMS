@props(['id', 'maxWidth'])

@php
$id = $id ?? md5($attributes->wire('model'));

$maxWidth = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg md:max-w-xl lg:max-w-2xl',
    'xl' => 'sm:max-w-xl md:max-w-2xl lg:max-w-4xl',
    '2xl' => 'sm:max-w-2xl md:max-w-4xl lg:max-w-5xl',
][$maxWidth ?? 'lg'];
@endphp

<div
    x-data="{ show: @entangle($attributes->wire('model')) }"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-show="show"
    id="{{ $id }}"
    class="fixed inset-0 overflow-y-auto px-2 md:px-4 py-6 z-50"
    style="display: none;"
>
    <!-- Backdrop with blur effect -->
    <div x-show="show" 
         class="fixed inset-0 transition-all duration-300" 
         x-on:click="show = false"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-900/50 to-yellow-600/50 backdrop-blur-sm"></div>
    </div>

    <!-- Modal Container -->
    <div x-show="show" 
         class="min-h-full flex items-center justify-center p-4 transform transition-all duration-300"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
        <div class="w-full {{ $maxWidth }}">
            {{ $slot }}
        </div>
    </div>
</div>