<?php

namespace App\Livewire;

use App\Models\Announcement;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Announcements extends Component
{
    use WithPagination;
    
    //Announcement properties
    public string $title = '';
    public string $category = 'general';
    public string $description = '';

    //Modal flags
    public $showAnnouncementModal = false;

    public function createAnnouncement()
    {
        $data = $this->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:general,event,reminder',
            'description' => 'required|string|min:10'
        ]);

        $category = $this->category ?: 'general';

        Announcement::create([
            'title' => $this->title,
            'category' => $category,
            'description' => $this->description,
            'user_id' => Auth::id(),
        ]);

        $this->reset('title', 'category', 'description');
        $this->showAnnouncementModal = false;

        session()->flash('success', 'Announcement created successfully!');
    }   
    
    public function openAnnouncementModal(){
        $this->showAnnouncementModal = true;
    }
    
    public function closeAnnouncementModal(){
        $this->showAnnouncementModal = false;
        $this->reset([
            'title', 'category', 'description'
        ]);
        $this->category = 'general'; 
        $this->resetErrorBag();
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
        ])->layout('layouts.app');
    }
}