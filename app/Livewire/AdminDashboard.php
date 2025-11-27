<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AdminDashboard extends Component
{
    //User properties
    //Events properties
    public $title;
    public $date;
    public $time;
    public $type;
    public $category;
    public $description;
    public $require_payment = false;

    //Modal flags
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $showEditUserModal = false;
    public $showDeleteUserModal = false;
    public $showGenerateReportModal = false;
    public $showArchiveModal = false;
    
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
        //$this->dispatch('open-modal', modal: 'create-event');

        $data = $this->validate([
            'title' => 'required',
            'date' => 'required',
            'time' => 'required',
            'type' => 'required',
            'category' => 'required',
            'description' => 'required',
        ]);
        Event::create([
            'title' => $this->title,
            'date' => $this->date,
            'time' => $this->time,
            'type' => $this->type,
            'category' => $this->category,
            'description' => $this->description,
            'require_payment' => $this->require_payment
        ]);
        $this->reset(['title', 'date', 'time', 'type', 'category', 'description', 'require_payment']);

        session()->flash('success', 'Event created successfully');
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
    public function openEditUserModal(){
        $this->showEditUserModal = true;
    }
    public function openDeleteUserModal(){
        $this->showDeleteUserModal = true;
    }
    public function openGenerateReportModal(){
        $this->showGenerateReportModal = true;
    }
    public function openArchiveModal(){
        $this->showArchiveModal = true;
    }
    public function saveUser(){
        $this->showEditUserModal = false;
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