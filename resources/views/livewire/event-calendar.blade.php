<div class="bg-white rounded-lg shadow-md p-4 lg:p-6">
    <!-- Calendar Header -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg lg:text-xl font-semibold text-gray-800">Event Calendar</h2>
        <div class="flex items-center space-x-2">
            <button wire:click="goToPreviousMonth" 
                class="p-2 hover:bg-gray-100 rounded-lg transition-colors"
                title="Previous Month">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            
            <span class="font-semibold text-gray-700 min-w-40 text-center">{{ $monthName }}</span>
            
            <button wire:click="goToNextMonth" 
                class="p-2 hover:bg-gray-100 rounded-lg transition-colors"
                title="Next Month">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            
            <button wire:click="goToCurrentMonth" 
                class="ml-2 px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors text-gray-700">
                Today
            </button>
        </div>
    </div>
    
    <!-- Week Days Header -->
    <div class="grid grid-cols-7 gap-1 mb-2">
        @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
            <div class="text-center text-sm font-semibold text-gray-500 py-2">
                {{ $day }}
            </div>
        @endforeach
    </div>
    
    <!-- Calendar Days Grid -->
    <div class="grid grid-cols-7 gap-1">
        @foreach($calendarDays as $dayData)
            @if(is_null($dayData))
                <!-- Empty cell -->
                <div class="aspect-square p-2 bg-gray-50 rounded-lg"></div>
            @else
                <!-- Day cell with events -->
                <button 
                    wire:click="showDateEvents('{{ $dayData['date'] }}')"
                    class="aspect-square p-2 bg-white hover:bg-blue-50 rounded-lg border border-gray-200 
                           hover:border-blue-300 transition-all relative group
                           {{ $dayData['hasEvents'] ? 'font-semibold' : '' }}"
                >
                    <span class="text-sm {{ $dayData['hasEvents'] ? 'text-blue-600' : 'text-gray-700' }}">
                        {{ $dayData['day'] }}
                    </span>
                    
                    <!-- Event Indicators -->
                    @if($dayData['hasEvents'])
                        <div class="absolute bottom-1 left-1/2 transform -translate-x-1/2 flex space-x-0.5">
                            @php
                                $eventCount = count($dayData['events']);
                                $indicatorCount = min($eventCount, 3); // Show max 3 dots
                            @endphp
                            
                            @for($i = 0; $i < $indicatorCount; $i++)
                                <span class="w-1 h-1 bg-blue-500 rounded-full"></span>
                            @endfor
                            
                            @if($eventCount > 3)
                                <span class="text-[8px] text-blue-600 font-bold">+{{ $eventCount - 3 }}</span>
                            @endif
                        </div>
                        
                        <!-- Tooltip on hover -->
                        <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 
                                    bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 
                                    transition-opacity pointer-events-none whitespace-nowrap z-10">
                            {{ $eventCount }} event{{ $eventCount > 1 ? 's' : '' }}
                        </div>
                    @endif
                </button>
            @endif
        @endforeach
    </div>
    
    <!-- Legend -->
    <div class="mt-4 flex items-center justify-end space-x-4 text-xs text-gray-500">
        <div class="flex items-center space-x-1">
            <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
            <span>Has events</span>
        </div>
    </div>
</div>