<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class OrganizerDashboard extends Component
{
    public function viewAllRegistrations()
    {
        $this->dispatch('open-modal', modal: 'view-all-registrations');
    }

    public function render()
    {
        $user = Auth::user();
        $userInitials = strtoupper(substr($user->first_name ?? 'O', 0, 1) . substr($user->last_name ?? 'U', 0, 1));
        
        return view('livewire.organizer-dashboard', [
            'userInitials' => $userInitials,
        ])->layout('layouts.app');
    }
}


