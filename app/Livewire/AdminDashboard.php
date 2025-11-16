<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AdminDashboard extends Component
{
    public function viewUser($userId)
    {
        $this->dispatch('open-modal', modal: 'view-user', userId: $userId);
    }

    public function editUser($userId)
    {
        $this->dispatch('open-modal', modal: 'edit-user', userId: $userId);
    }

    public function createEvent()
    {
        $this->dispatch('open-modal', modal: 'create-event');
    }

    public function render()
    {
        $user = Auth::user();
        $userInitials = strtoupper(substr($user->first_name ?? 'A', 0, 1) . substr($user->last_name ?? 'U', 0, 1));
        
        return view('livewire.admin-dashboard', [
            'userInitials' => $userInitials,
        ])->layout('layouts.app');
    }
}


