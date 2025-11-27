<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class AdminDashboard extends Component
{
    use WithFileUploads;

    // User properties
    public $first_name;
    public $middle_name;
    public $last_name;
    public $student_id;
    public $email;
    public $role;
    
    // Events properties
    public string $title = '';
    public $date;
    public $time;
    public string $type = '';
    public $place_link = '';
    public string $category = '';
    public string $description = '';
    public $banner;
    public bool $require_payment = false;
    public $payment_amount = 0;

    // Modal flags
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
        // Validate the data
        $data = $this->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'type' => 'required|in:online,face-to-face',
            'place_link' => 'required|string|max:500',
            'category' => 'required|in:academic,sports,cultural',
            'description' => 'required|string|min:10',
            'banner' => 'nullable|image|max:2048', // 2MB max
            'require_payment' => 'boolean',
            'payment_amount' => 'nullable|required_if:require_payment,true|numeric|min:0',
        ]);

        // Handle banner upload
        $bannerPath = null;
        if ($this->banner) {
            $bannerPath = $this->banner->store('event-banners', 'public');
        }

        // Create the event
        Event::create([
            'title' => $this->title,
            'date' => $this->date,
            'time' => $this->time,
            'type' => $this->type,
            'place_link' => $this->place_link,
            'category' => $this->category,
            'description' => $this->description,
            'banner' => $bannerPath,
            'require_payment' => $this->require_payment,
            'payment_amount' => $this->require_payment ? $this->payment_amount : null,
            'created_by' => Auth::id(),
            'status' => 'published',
        ]);

        // Reset form fields
        $this->reset([
            'title', 'date', 'time', 'type', 'place_link', 
            'category', 'description', 'banner', 'require_payment', 'payment_amount'
        ]);

        // Close modal
        $this->showCreateModal = false;

        session()->flash('success', 'Event created successfully!');
    }

    public function openCreateModal(){
        $this->showCreateModal = true;
    }
    
    public function closeCreateModal(){
        $this->showCreateModal = false;
        $this->reset([
            'title', 'date', 'time', 'type', 'place_link', 
            'category', 'description', 'banner', 'require_payment', 'payment_amount'
        ]);
        $this->resetErrorBag();
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

    public function render()
    {
        $user = Auth::user();
        $userInitials = strtoupper(substr($user->first_name ?? 'A', 0, 1) . substr($user->last_name ?? 'U', 0, 1));
        
        return view('livewire.admin-dashboard', [
            'userInitials' => $userInitials,
        ])->layout('layouts.app');
    }
}