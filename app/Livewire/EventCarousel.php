<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventCarousel extends Component
{
    public $events;
    public $currentIndex = 0;
    protected $listeners = ['nextSlide' => 'nextSlide'];
    
    public function mount()
    {
        $this->loadEvents();
    }

    public function loadEvents()
    {
        $user = Auth::user();

        $this->events = Event::where('status', 'published')
            ->where('is_archived', false)
            ->where(function($query) {
                $query->where('start_date', '>', now()->toDateString())
                    ->orWhere(function($q) {
                        $q->where('start_date', now()->toDateString())
                        ->where('start_time', '>', now()->format('H:i:s'));
                    });
            })
            ->where(function($query) use ($user) {
                $query->where('visibility_type', 'all')
                    ->orWhere(function($q) use ($user) {
                        $q->where('visibility_type', 'grade_level')
                        ->whereJsonContains('visible_to_grade_level', (string)$user->grade_level);
                    })
                    ->orWhere(function($q) use ($user) {
                        $q->where('visibility_type', 'shs_strand')
                        ->whereJsonContains('visible_to_shs_strand', $user->shs_strand);
                    })
                    ->orWhere(function($q) use ($user) {
                        $q->where('visibility_type', 'year_level')
                        ->whereJsonContains('visible_to_year_level', (string)$user->year_level);
                    })
                    ->orWhere(function($q) use ($user) {
                        $q->where('visibility_type', 'college_program')
                        ->whereJsonContains('visible_to_college_program', $user->college_program);
                    });
            })
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->take(5) // Get a few more for smooth carousel
            ->get();
    }

     public function nextSlide()
    {
        if (count($this->events) > 0) {
            $this->currentIndex = ($this->currentIndex + 1) % count($this->events);
        }
    }

    public function prevSlide()
    {
        if (count($this->events) > 0) {
            $this->currentIndex = ($this->currentIndex - 1 + count($this->events)) % count($this->events);
        }
    }

    public function goToSlide($index)
    {
        if ($index >= 0 && $index < count($this->events)) {
            $this->currentIndex = $index;
        }
    }

    public function render()
    {
        return view('livewire.event-carousel');
    }
}