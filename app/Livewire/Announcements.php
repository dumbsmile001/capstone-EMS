<?php

namespace App\Livewire;

use App\Models\Announcement;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Traits\LogsActivity; // Add this

class Announcements extends Component
{
    use WithPagination, LogsActivity;
    
    // Announcement properties
    public string $title = '';
    public string $category = 'general';
    public string $description = '';
    public ?int $editingId = null;

    // Modal flags
    public $showAnnouncementModal = false;
    public $showDeleteModal = false;

    // For delete confirmation
    public $announcementToDelete = null;

    public function createAnnouncement()
    {
        $data = $this->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:general,event,reminder',
            'description' => 'required|string|min:10'
        ]);

        $announcement = Announcement::create([
            'title' => $this->title,
            'category' => $this->category,
            'description' => $this->description,
            'user_id' => Auth::id(),
        ]);

        // Log the announcement creation with specific action
        $this->logActivity('ANNOUNCEMENT_CREATE', $announcement,
            auth()->user()->first_name . ' ' . auth()->user()->last_name . ' created announcement: ' . $announcement->title);

        $this->reset('title', 'category', 'description');
        $this->showAnnouncementModal = false;
        $this->editingId = null;

        session()->flash('success', 'Announcement created successfully!');
    }

    public function editAnnouncement($id)
    {
        $announcement = Announcement::findOrFail($id);
        
        // Check authorization - only creator or admin can edit
        if (!$this->canModifyAnnouncement($announcement)) {
            session()->flash('error', 'You are not authorized to edit this announcement.');
            return;
        }

        $this->editingId = $id;
        $this->title = $announcement->title;
        $this->category = $announcement->category;
        $this->description = $announcement->description;
        
        $this->showAnnouncementModal = true;
    }

    public function updateAnnouncement()
    {
        if (!$this->editingId) return;

        $data = $this->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:general,event,reminder',
            'description' => 'required|string|min:10'
        ]);

        $announcement = Announcement::findOrFail($this->editingId);
        
        // Check authorization
        if (!$this->canModifyAnnouncement($announcement)) {
            session()->flash('error', 'You are not authorized to update this announcement.');
            return;
        }

        $oldValues = $announcement->getOriginal();
        $announcement->update([
            'title' => $this->title,
            'category' => $this->category,
            'description' => $this->description,
        ]);

        // Log the announcement update
        $this->logActivity('ANNOUNCEMENT_UPDATE', $announcement,
            auth()->user()->first_name . ' ' . auth()->user()->last_name . ' updated announcement: ' . $announcement->title,
            $oldValues,
            $announcement->toArray()
        );

        $this->reset('title', 'category', 'description', 'editingId');
        $this->showAnnouncementModal = false;

        session()->flash('success', 'Announcement updated successfully!');
    }

    public function confirmDelete($id)
    {
        $announcement = Announcement::findOrFail($id);
        
        // Check authorization
        if (!$this->canModifyAnnouncement($announcement)) {
            session()->flash('error', 'You are not authorized to delete this announcement.');
            return;
        }

        $this->announcementToDelete = $announcement;
        $this->showDeleteModal = true;
    }

    public function deleteAnnouncement()
    {
        if (!$this->announcementToDelete) return;

        // Final authorization check
        if (!$this->canModifyAnnouncement($this->announcementToDelete)) {
            session()->flash('error', 'You are not authorized to delete this announcement.');
            $this->closeDeleteModal();
            return;
        }

        $announcement = $this->announcementToDelete;
        $announcementTitle = $announcement->title;

        // Log before deletion
        $this->logActivity('ANNOUNCEMENT_DELETE', $announcement,
            auth()->user()->first_name . ' ' . auth()->user()->last_name . ' deleted announcement: ' . $announcementTitle);

        $this->announcementToDelete->delete();
        $this->closeDeleteModal();

        session()->flash('success', 'Announcement deleted successfully!');
    }

    public function saveAnnouncement()
    {
        if ($this->editingId) {
            $this->updateAnnouncement();
        } else {
            $this->createAnnouncement();
        }
    }

    public function canModifyAnnouncement($announcement)
    {
        $user = Auth::user();
        
        // Admins can modify any announcement
        if ($user->hasRole('admin')) {
            return true;
        }
        
        // Organizers can only modify their own announcements
        if ($user->hasRole('organizer')) {
            return $announcement->user_id == $user->id;
        }
        
        return false;
    }
    
    public function openAnnouncementModal(){
        $this->reset('editingId', 'title', 'category', 'description');
        $this->category = 'general';
        $this->showAnnouncementModal = true;
    }
    
    public function closeAnnouncementModal(){
        $this->showAnnouncementModal = false;
        $this->reset(['title', 'category', 'description', 'editingId']);
        $this->category = 'general'; 
        $this->resetErrorBag();
    }
    
    public function closeDeleteModal(){
        $this->showDeleteModal = false;
        $this->announcementToDelete = null;
    }
    
    public function render()
    {
        $user = Auth::user();
        $userInitials = strtoupper(substr($user->first_name ?? 'U', 0, 1) . substr($user->last_name ?? 'S', 0, 1));
        $userRole = $user->getRoleNames()->first() ?? 'User';
        
        // Get announcements from database, ordered by latest first
        $announcements = Announcement::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('livewire.announcements', [
            'userInitials' => $userInitials,
            'userRole' => ucfirst($userRole),
            'announcements' => $announcements,
            'editingId' => $this->editingId, // Add this line
            'announcementToDelete' => $this->announcementToDelete, // Also add this
        ])->layout('layouts.app');
    }
}