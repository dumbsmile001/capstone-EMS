<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class StudentEvents extends Component
{
    use WithPagination, WithFileUploads;

    // Search and filter
    public $search = '';
    public $filterType = '';
    public $filterCategory = '';
    public $filterPayment = '';
    public $eventsPerPage = 12;
    
    // Sort options
    public $sortBy = 'date';
    public $sortDirection = 'asc';

    // Modal controls
    public $showEventDetailsModal = false;
    public $selectedEvent = null;
    
    // User registrations
    public $userRegistrations = [];
    
    protected $queryString = [
        'search' => ['except' => ''],
        'filterType' => ['except' => ''],
        'filterCategory' => ['except' => ''],
        'filterPayment' => ['except' => ''],
        'eventsPerPage' => ['except' => 12],
    ];
    
    public function mount()
    {
        $this->loadUserRegistrations();
    }
    
    public function loadUserRegistrations()
    {
        $this->userRegistrations = Auth::user()->registrations()
            ->with('event')
            ->get()
            ->keyBy('event_id');
    }
    
    public function getEventsProperty()
    {
         $user = Auth::user();
    
        return Event::where('status', 'published')
            ->where('is_archived', false)
            ->where(function($query) {
                // Only show events that haven't ended yet
                $query->where('end_date', '>', now()->toDateString())
                    ->orWhere(function($q) {
                        $q->where('end_date', now()->toDateString())
                        ->where('end_time', '>', now()->format('H:i:s'));
                    });
            })
            ->where(function($query) use ($user) {
                // Visibility conditions...
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
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterType, function ($query) {
                $query->where('type', $this->filterType);
            })
            ->when($this->filterCategory, function ($query) {
                $query->where('category', $this->filterCategory);
            })
            ->when($this->filterPayment !== '', function ($query) {
                if ($this->filterPayment === 'paid') {
                    $query->where('require_payment', true);
                } elseif ($this->filterPayment === 'free') {
                    $query->where('require_payment', false);
                }
            })
            ->orderBy($this->sortBy === 'date' ? 'start_date' : $this->sortBy, $this->sortDirection)
            ->orderBy('start_time')
            ->paginate($this->eventsPerPage);
    }

     public function openEventDetailsModal($eventId)
    {
        $this->selectedEvent = Event::with('creator')->find($eventId);
        $this->showEventDetailsModal = true;
    }
    
    public function closeEventDetailsModal()
    {
        $this->showEventDetailsModal = false;
        $this->selectedEvent = null;
    }
    
    public function registerForEvent($eventId)
    {
         $event = Event::findOrFail($eventId);

        // Check if event can be registered for
        if (!$event->canRegister()) {
            session()->flash('error', 'Registration is closed for this event.');
            return;
        }
        
        // Check if already actively registered
        if ($this->isRegistered($eventId)) {
            session()->flash('error', 'You are already registered for this event.');
            return;
        }

        try {
            Registration::updateOrCreate(
                [
                    'event_id' => $eventId,
                    'user_id' => Auth::id(),
                ],
                [
                    'status' => 'registered',
                    'registered_at' => now(),
                ]
            );

            $this->loadUserRegistrations();
            session()->flash('success', 'Successfully registered for ' . $event->title);
            
        } catch (\Exception $e) {
            session()->flash('error', 'Registration failed: ' . $e->getMessage());
        }
    }

    public function cancelRegistration($eventId)
    {
         $event = Event::findOrFail($eventId);

        // Check if cancellation is allowed
        if (!$event->canCancelRegistration()) {
            session()->flash('error', 'Cannot cancel registration at this time.');
            return;
        }

        $registration = Registration::where('event_id', $eventId)
            ->where('user_id', Auth::id())
            ->first();

        if ($registration) {
            $registration->update(['status' => 'cancelled']);
            $this->loadUserRegistrations();
            session()->flash('success', 'Registration cancelled successfully.');
        }
    }
    
    public function isRegistered($eventId)
    {
        if (!$this->userRegistrations->has($eventId)) {
            return false;
        }
        
        $registration = $this->userRegistrations->get($eventId);
        return in_array($registration->status, ['registered', 'attended']);
    }

    public function isEventDatePassed($event)
    {
        $eventDate = \Carbon\Carbon::parse($event->date);
        $today = \Carbon\Carbon::today();
        return $eventDate->lt($today);
    }
    
    public function getRegistrationStatus($eventId)
    {
        return $this->userRegistrations->get($eventId)?->status;
    }
    
    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }
    
    public function resetFilters()
    {
        $this->reset(['search', 'filterType', 'filterCategory', 'filterPayment', 'eventsPerPage']);
        $this->resetPage();
    }
    
    public function getEventStatsProperty()
    {
        $user = Auth::user();
        
        $query = Event::where('status', 'published')
            ->where('is_archived', false)
            ->where('date', '>=', now()->format('Y-m-d'))
            ->where(function($q) use ($user) {
                $q->where('visibility_type', 'all')
                  ->orWhere(function($query) use ($user) {
                      $query->where('visibility_type', 'grade_level')
                          ->whereJsonContains('visible_to_grade_level', (string)$user->grade_level);
                  })
                  ->orWhere(function($query) use ($user) {
                      $query->where('visibility_type', 'shs_strand')
                          ->whereJsonContains('visible_to_shs_strand', $user->shs_strand);
                  })
                  ->orWhere(function($query) use ($user) {
                      $query->where('visibility_type', 'year_level')
                          ->whereJsonContains('visible_to_year_level', (string)$user->year_level);
                  })
                  ->orWhere(function($query) use ($user) {
                      $query->where('visibility_type', 'college_program')
                          ->whereJsonContains('visible_to_college_program', $user->college_program);
                  });
            });
        
        return [
            'total' => $query->count(),
            'paid' => $query->where('require_payment', true)->count(),
            'free' => $query->where('require_payment', false)->count(),
            'registered' => Auth::user()->registrations()
                ->whereHas('event', function($q) {
                    $q->where('date', '>=', now()->format('Y-m-d'));
                })
                ->whereIn('status', ['registered', 'attended'])
                ->count(),
        ];
    }
    
    public function render()
    {
        $user = Auth::user();
        $userInitials = strtoupper(substr($user->first_name ?? 'S', 0, 1) . substr($user->last_name ?? 'U', 0, 1));
        
        return view('livewire.student-events', [
            'userInitials' => $userInitials,
            'events' => $this->events,
            'stats' => $this->eventStats,
        ])->layout('layouts.app');
    }
}