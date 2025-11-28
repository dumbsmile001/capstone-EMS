<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class OrganizerDashboard extends Component
{
    use WithFileUploads;
    
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

    // Add these properties for editing
    public $editingEvent = null;
    public $deletingEvent = null;

    public function viewAllRegistrations()
    {
        $this->dispatch('open-modal', modal: 'view-all-registrations');
    }

    public function openEditModal($eventId = null)
    {
        if ($eventId) {
            $this->editingEvent = Event::findOrFail($eventId);
            // Populate form fields with existing data
            $this->title = $this->editingEvent->title;
            $this->date = $this->editingEvent->date;
            $this->time = $this->editingEvent->time;
            $this->type = $this->editingEvent->type;
            $this->place_link = $this->editingEvent->place_link;
            $this->category = $this->editingEvent->category;
            $this->description = $this->editingEvent->description;
            $this->require_payment = $this->editingEvent->require_payment;
            $this->payment_amount = $this->editingEvent->payment_amount;
        }
        $this->showEditModal = true;
    }

    public function openDeleteModal($eventId = null)
    {
        if ($eventId) {
            $this->deletingEvent = Event::findOrFail($eventId);
        }
        $this->showDeleteModal = true;
    }

    public function deleteEvent()
    {
        if ($this->deletingEvent) {
            $this->deletingEvent->delete();
            session()->flash('success', 'Event deleted successfully!');
        }
        $this->showDeleteModal = false;
        $this->deletingEvent = null;
    }

    public function updateEvent()
    {
        if ($this->editingEvent) {
            $data = $this->validate([
                'title' => 'required|string|max:255',
                'date' => 'required|date',
                'time' => 'required',
                'type' => 'required|in:online,face-to-face',
                'place_link' => 'required|string|max:500',
                'category' => 'required|in:academic,sports,cultural',
                'description' => 'required|string|min:10',
                'banner' => 'nullable|image|max:2048',
                'require_payment' => 'boolean',
                'payment_amount' => 'nullable|required_if:require_payment,true|numeric|min:0',
            ]);

            // Handle banner upload if new banner is provided
            if ($this->banner) {
                $bannerPath = $this->banner->store('event-banners', 'public');
                $data['banner'] = $bannerPath;
            }

            $this->editingEvent->update($data);
            session()->flash('success', 'Event updated successfully!');
        }

        $this->showEditModal = false;
        $this->editingEvent = null;
        $this->resetForm();
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
        $this->resetForm();
        $this->showCreateModal = false;

        session()->flash('success', 'Event created successfully!');
    }

    public function openCreateModal()
    {
        $this->showCreateModal = true;
    }
    
    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->resetForm();
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->editingEvent = null;
        $this->resetForm();
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deletingEvent = null;
    }

    private function resetForm()
    {
        $this->reset([
            'title', 'date', 'time', 'type', 'place_link', 
            'category', 'description', 'banner', 'require_payment', 'payment_amount'
        ]);
        $this->resetErrorBag();
    }

    public function render()
    {
        $user = Auth::user();
        $userInitials = strtoupper(substr($user->first_name ?? 'O', 0, 1) . substr($user->last_name ?? 'U', 0, 1));
        
        // Fetch events from database - you can add filters/pagination as needed
        $events = Event::where('created_by', Auth::id())
                      ->orderBy('created_at', 'desc')
                      ->get();
        
        return view('livewire.organizer-dashboard', [
            'userInitials' => $userInitials,
            'events' => $events,
        ])->layout('layouts.app');
    }
}