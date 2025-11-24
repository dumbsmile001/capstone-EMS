<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class OrganizerDashboard extends Component
{
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;

    public function viewAllRegistrations()
    {
        $this->dispatch('open-modal', modal: 'view-all-registrations');
    }

    public function openCreateModal(){
        $this->showCreateModal = true;
    }
    public function openEditModal(){
        $this->showEditModal = true;
    }
    public function openDeleteModal(){
        $this->showDeleteModal = true;
    }
    public function saveEvent(){
        $this->showCreateModal = false;
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


