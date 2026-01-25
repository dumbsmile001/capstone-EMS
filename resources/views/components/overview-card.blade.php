@props(['title', 'value', 'icon' => null, 'iconColor' => 'blue'])

@php
    $borderColors = [
        'blue' => 'border-blue-500',
        'green' => 'border-green-500',
        'yellow' => 'border-yellow-500',
        'orange' => 'border-orange-500',
        'purple' => 'border-purple-500',
    ];
    $iconColors = [
        'blue' => 'text-blue-500',
        'green' => 'text-green-500',
        'yellow' => 'text-yellow-500',
        'orange' => 'text-orange-500',
        'purple' => 'text-purple-500',
    ];
    $borderColor = $borderColors[$iconColor] ?? 'border-blue-500';
    $iconColorClass = $iconColors[$iconColor] ?? 'text-blue-500';
@endphp

<div class="bg-white rounded-lg shadow-md p-3 md:p-4 lg:p-6 border-l-4 {{ $borderColor }}">
    <div class="flex items-center justify-between">
        <div class="flex-1 min-w-0">
            <p class="text-xs md:text-sm text-gray-600 mb-1 truncate">{{ $title }}</p>
            <p class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-800 truncate">{{ $value }}</p>
        </div>
        @if($icon)
            <div class="{{ $iconColorClass }} flex-shrink-0 ml-2">
                {!! $icon !!}
            </div>
        @endif
    </div>
</div>