<?php

namespace App\Livewire;

use App\Traits\LogsActivity;
use Livewire\Component;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;

class EventRegistration extends Component
{
    use LogsActivity;
    public $events;
     /** @var \Illuminate\Support\Collection */
    public $userRegistrations = [];
    
    public function mount()
    {
        $this->loadEvents();
        $this->loadUserRegistrations();
    }

    // In EventRegistration.php, update loadEvents() method
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
                // Events visible to all
                $query->where('visibility_type', 'all')
                    // OR events visible to user's grade level
                    ->orWhere(function($q) use ($user) {
                        $q->where('visibility_type', 'grade_level')
                        ->whereJsonContains('visible_to_grade_level', (string)$user->grade_level);
                    })
                    // OR events visible to user's SHS strand
                    ->orWhere(function($q) use ($user) {
                        $q->where('visibility_type', 'shs_strand')
                        ->whereJsonContains('visible_to_shs_strand', $user->shs_strand);
                    })
                    // OR events visible to user's year level
                    ->orWhere(function($q) use ($user) {
                        $q->where('visibility_type', 'year_level')
                        ->whereJsonContains('visible_to_year_level', (string)$user->year_level);
                    })
                    // OR events visible to user's college program
                    ->orWhere(function($q) use ($user) {
                        $q->where('visibility_type', 'college_program')
                        ->whereJsonContains('visible_to_college_program', $user->college_program);
                    });
            })
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->take(3)
            ->get();
    }

    public function loadUserRegistrations()
    {
        $this->userRegistrations = Auth::user()->registrations()
            ->with('event')
            ->get()
            ->keyBy('event_id');
    }

    public function registerForEvent($eventId)
{
        $event = Event::findOrFail($eventId);
        
        // Check if already actively registered
        if ($this->isRegistered($eventId)) {
            session()->flash('error', 'You are already registered for this event.');
            return;
        }

        try {
            // Update existing registration or create new one
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

            // Log the registration activity
            $this->logActivity(
                'REGISTER_EVENT',
                $event,
                null,
                [], // No old values for registration
                ['status' => 'registered', 'registered_at' => now()->toDateTimeString()]
            );

            // Reload data
            $this->loadUserRegistrations();
            
            session()->flash('success', 'Successfully registered for ' . $event->title);
            
        } catch (\Exception $e) {
            session()->flash('error', 'Registration failed: ' . $e->getMessage());
        }
    }

    public function cancelRegistration($eventId)
    {
        $event = Event::findOrFail($eventId);
        $registration = Registration::where('event_id', $eventId)
            ->where('user_id', Auth::id())
            ->first();

        if ($registration) {
             // Store old values before update
            $oldValues = [
                'status' => $registration->status,
                'cancelled_at' => $registration->cancelled_at
            ];

            $registration->update(['status' => 'cancelled']);

            // Log the cancellation activity
            $this->logActivity(
                'CANCEL_REGISTRATION',
                $event,
                null,
                $oldValues,
                ['status' => 'cancelled', 'cancelled_at' => now()->toDateTimeString()]
            );

            $this->loadUserRegistrations();
            session()->flash('success', 'Registration cancelled successfully.');
        }
    }

    public function getRegistrationStatus($eventId)
    {
        return $this->userRegistrations->get($eventId)?->status;
    }

    public function isRegistered($eventId)
    {
        if (!$this->userRegistrations->has($eventId)) {
            return false;
        }
        
        $registration = $this->userRegistrations->get($eventId);
        return in_array($registration->status, ['registered', 'attended']);
    }

    public function render()
    {
        return view('livewire.event-registration');
    }
}