<?php

namespace App\Livewire;

use App\Models\Announcement;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Traits\LogsActivity;
use Livewire\Attributes\Url;

class Announcements extends Component
{
    use WithPagination, LogsActivity;
    
    // Announcement properties
    public string $title = '';
    public string $category = 'general';
    public string $description = '';
    public ?int $editingId = null;
    // Add this property at the top with other properties
    public $perPage = 10;

    // Search and filter properties
    #[Url(history: true)]
    public string $search = '';
    public string $categoryFilter = '';
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';

    // Modal flags
    public $showAnnouncementModal = false;
    public $showDeleteModal = false;

    // For delete confirmation
    public $announcementToDelete = null;

    // Stats properties
    public $totalCount = 0;
    public $generalCount = 0;
    public $eventCount = 0;
    public $reminderCount = 0;
    public $thisMonthCount = 0;
    public $recentActivities = [];

    public function mount()
    {
        $this->loadStats();
    }

    protected function loadStats()
    {
        $this->totalCount = Announcement::count();
        $this->generalCount = Announcement::where('category', 'general')->count();
        $this->eventCount = Announcement::where('category', 'event')->count();
        $this->reminderCount = Announcement::where('category', 'reminder')->count();
        $this->thisMonthCount = Announcement::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Load recent activities (you can customize this based on your activity log implementation)
        $this->recentActivities = [
            [
                'message' => 'New announcement created',
                'time' => '5 minutes ago',
                'type' => 'create'
            ],
            // Add more activities as needed
        ];
    }

    // Add this method
    public function updatedPerPage()
    {
        $this->resetPage();
    }

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

        // Log the announcement creation
        $this->logActivity('CREATE', $announcement,
            auth()->user()->first_name . ' ' . auth()->user()->last_name . ' created announcement: ' . $announcement->title);

        $this->reset('title', 'category', 'description');
        $this->showAnnouncementModal = false;
        $this->editingId = null;

        // Reload stats
        $this->loadStats();

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
        $this->logActivity('UPDATE', $announcement,
            auth()->user()->first_name . ' ' . auth()->user()->last_name . ' updated announcement: ' . $announcement->title,
            $oldValues,
            $announcement->toArray()
        );

        $this->reset('title', 'category', 'description', 'editingId');
        $this->showAnnouncementModal = false;

        // Reload stats
        $this->loadStats();

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
        $this->logActivity('DELETE', $announcement,
            auth()->user()->first_name . ' ' . auth()->user()->last_name . ' deleted announcement: ' . $announcementTitle);

        $announcement->delete();
        $this->closeDeleteModal();

        // Reload stats
        $this->loadStats();

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

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedCategoryFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->categoryFilter = '';
        $this->sortField = 'created_at';
        $this->sortDirection = 'desc';
        $this->resetPage();
    }
    
    public function render()
    {
        $user = Auth::user();
        $userInitials = strtoupper(substr($user->first_name ?? 'U', 0, 1) . substr($user->last_name ?? 'S', 0, 1));
        $userRole = $user->getRoleNames()->first() ?? 'User';
        
        // Build query with filters
        $query = Announcement::with('user');

        // Apply search filter
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Apply category filter
        if (!empty($this->categoryFilter)) {
            $query->where('category', $this->categoryFilter);
        }

        // Apply sorting
        $query->orderBy($this->sortField, $this->sortDirection);
        
        // Get paginated results
        $announcements = $query->paginate(10);
        
        return view('livewire.announcements', [
            'userInitials' => $userInitials,
            'userRole' => ucfirst($userRole),
            'announcements' => $announcements,
            'editingId' => $this->editingId,
            'announcementToDelete' => $this->announcementToDelete,
            'totalCount' => $this->totalCount,
            'generalCount' => $this->generalCount,
            'eventCount' => $this->eventCount,
            'reminderCount' => $this->reminderCount,
            'thisMonthCount' => $this->thisMonthCount,
            'recentActivities' => $this->recentActivities,
            'search' => $this->search,
            'categoryFilter' => $this->categoryFilter,
            'sortField' => $this->sortField,
            'sortDirection' => $this->sortDirection,
        ])->layout('layouts.app');
    }
}