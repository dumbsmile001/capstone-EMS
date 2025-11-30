<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;

class EventRegistration extends Component
{
    public $events;
     /** @var \Illuminate\Support\Collection */
    public $userRegistrations = [];
    
    public function mount()
    {
        $this->loadEvents();
        $this->loadUserRegistrations();
    }

    public function loadEvents()
    {
        $this->events = Event::where('status', 'published')
            ->where('date', '>=', now()->format('Y-m-d'))
            ->orderBy('date')
            ->orderBy('time')
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

            // Reload data
            $this->loadUserRegistrations();
            
            session()->flash('success', 'Successfully registered for ' . $event->title);
            
        } catch (\Exception $e) {
            session()->flash('error', 'Registration failed: ' . $e->getMessage());
        }
    }

    public function cancelRegistration($eventId)
    {
        $registration = Registration::where('event_id', $eventId)
            ->where('user_id', Auth::id())
            ->first();

        if ($registration) {
            $registration->update(['status' => 'cancelled']);
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