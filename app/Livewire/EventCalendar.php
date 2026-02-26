<?php

namespace App\Livewire;

use App\Models\Event;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class EventCalendar extends Component
{
    public $currentMonth;
    public $currentYear;
    public $calendarDays = [];
    
    protected $listeners = [
        'refreshCalendar' => 'generateCalendar'
    ];
    
    public function mount()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->generateCalendar();
    }
    
    public function generateCalendar()
    {
        $firstDay = Carbon::create($this->currentYear, $this->currentMonth, 1);
        $lastDay = $firstDay->copy()->endOfMonth();
        
        // Get events for this month - UPDATED: using start_date instead of date
        $events = Event::where('created_by', Auth::id())
            ->whereMonth('start_date', $this->currentMonth)
            ->whereYear('start_date', $this->currentYear)
            ->where('status', 'published')
            ->where('is_archived', false)
            ->get()
            ->groupBy(function($event) {
                return Carbon::parse($event->start_date)->format('Y-m-d');
            });
        
        $this->calendarDays = [];
        
        // Add empty cells for days before month starts
        for ($i = 0; $i < $firstDay->dayOfWeek; $i++) {
            $this->calendarDays[] = null;
        }
        
        // Add days of the month
        for ($day = 1; $day <= $lastDay->day; $day++) {
            $date = Carbon::create($this->currentYear, $this->currentMonth, $day)->format('Y-m-d');
            $this->calendarDays[] = [
                'day' => $day,
                'date' => $date,
                'hasEvents' => isset($events[$date]),
                'events' => $events[$date] ?? [],
            ];
        }
    }
    
    public function goToPreviousMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->generateCalendar();
    }
    
    public function goToNextMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->generateCalendar();
    }
    
    public function goToCurrentMonth()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->generateCalendar();
    }
    
    public function showDateEvents($date)
    {
        // UPDATED: using start_date instead of date, and ordering by start_time
        $events = Event::where('created_by', Auth::id())
            ->whereDate('start_date', $date)
            ->where('status', 'published')
            ->where('is_archived', false)
            ->orderBy('start_time')
            ->get()
            ->map(function($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start_time' => $event->start_time,
                    'end_time' => $event->end_time,
                    'type' => $event->type,
                    'category' => $event->category,
                    'require_payment' => $event->require_payment,
                    'payment_amount' => $event->payment_amount,
                ];
            });
        
        // Dispatch event to show modal in the parent component
        $this->dispatch('showDateEventsModal', [
            'date' => $date,
            'events' => $events->toArray(),
            'eventCount' => $events->count()
        ]);
    }
    
    public function render()
    {
        $monthName = Carbon::create($this->currentYear, $this->currentMonth, 1)->format('F Y');
        
        return view('livewire.event-calendar', [
            'monthName' => $monthName,
        ]);
    }
}