<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AdminDashboard extends Component
{
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;
    
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
        $userInitials = strtoupper(substr($user->first_name ?? 'A', 0, 1) . substr($user->last_name ?? 'U', 0, 1));
        
        return view('livewire.admin-dashboard', [
            'userInitials' => $userInitials,
        ])->layout('layouts.app');
    }
}