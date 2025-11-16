<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class StudentDashboard extends Component
{
    public function showEventDetails($eventId)
    {
        $this->dispatch('open-modal', modal: 'event-details', eventId: $eventId);
    }

    public function registerForEvent($eventId)
    {
        $this->dispatch('open-modal', modal: 'register-event', eventId: $eventId);
    }

    public function cancelRegistration($eventId)
    {
        $this->dispatch('open-modal', modal: 'cancel-registration', eventId: $eventId);
    }

    public function downloadTicket($ticketId)
    {
        $this->dispatch('open-modal', modal: 'download-ticket', ticketId: $ticketId);
    }

    public function render()
    {
        $user = Auth::user();
        $userInitials = strtoupper(substr($user->first_name ?? 'S', 0, 1) . substr($user->last_name ?? 'U', 0, 1));
        
        return view('livewire.student-dashboard', [
            'userInitials' => $userInitials,
        ])->layout('layouts.app');
    }
}


