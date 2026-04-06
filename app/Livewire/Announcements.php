<?php

namespace App\Livewire;

use App\Models\Announcement;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class Announcements extends Component
{
    use WithPagination, WithFileUploads;

    // Form properties
    public $title = '';
    public $category = 'general';  // Change this line - add default 'general'
    public $description = '';
    public $editingId = null;
    
    // Visibility properties
    public $visibility_type = 'all';
    public $visible_to_grade_level = [];
    public $visible_to_shs_strand = [];
    public $visible_to_year_level = [];
    public $visible_to_college_program = [];
    public $visible_to_roles = [];
    
    // Available roles for selection
    public $availableRoles = [];
    
    // Modal flags
    public $showAnnouncementModal = false;
    public $showDeleteModal = false;
    
    // Filter properties
    public $search = '';
    public $categoryFilter = '';
    public $sortDirection = 'desc';
    
    // Delete management
    public $announcementToDelete = null;
    
    // Stats
    public $totalCount = 0;
    public $thisMonthCount = 0;
    public $generalCount = 0;
    public $eventCount = 0;
    public $reminderCount = 0;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'categoryFilter' => ['except' => ''],
        'sortDirection' => ['except' => 'desc'],
    ];
    
    public function mount()
    {
        $this->availableRoles = [
            'admin' => 'Admin',
            'organizer' => 'Organizer',
            'student' => 'Student',
        ];
        $this->loadStats();
    }
    
    public function loadStats()
    {
        $user = Auth::user();
        
        // Fix 2: Update loadStats to properly count announcements by category
        // Get all announcements visible to the user (without filters)
        $allAnnouncements = Announcement::visibleToUser($user)->get();
        
        $this->totalCount = $allAnnouncements->count();
        $this->thisMonthCount = $allAnnouncements->where('created_at', '>=', now()->startOfMonth())->count();
        $this->generalCount = $allAnnouncements->where('category', 'general')->count();
        $this->eventCount = $allAnnouncements->where('category', 'event')->count();
        $this->reminderCount = $allAnnouncements->where('category', 'reminder')->count();
    }
    
    public function getAnnouncementsProperty()
    {
        $user = Auth::user();
        
        return Announcement::visibleToUser($user)
            ->with('user')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->categoryFilter, function ($query) {
                $query->where('category', $this->categoryFilter);
            })
            ->orderBy('created_at', $this->sortDirection)
            ->paginate(10);
    }
    
    public function openAnnouncementModal()
    {
        $this->resetForm();
        $this->showAnnouncementModal = true;
    }
    
    public function closeAnnouncementModal()
    {
        $this->showAnnouncementModal = false;
        $this->resetForm();
    }
    
    public function editAnnouncement($id)
    {
        $announcement = Announcement::findOrFail($id);
        
        // Check if user can edit
        if (!auth()->user()->isAdmin() && $announcement->user_id !== auth()->id()) {
            session()->flash('error', 'You are not authorized to edit this announcement.');
            return;
        }
        
        $this->editingId = $id;
        $this->title = $announcement->title;
        $this->category = $announcement->category;
        $this->description = $announcement->description;
        $this->visibility_type = $announcement->visibility_type;
        $this->visible_to_grade_level = $announcement->visible_to_grade_level ?? [];
        $this->visible_to_shs_strand = $announcement->visible_to_shs_strand ?? [];
        $this->visible_to_year_level = $announcement->visible_to_year_level ?? [];
        $this->visible_to_college_program = $announcement->visible_to_college_program ?? [];
        $this->visible_to_roles = $announcement->visible_to_roles ?? [];
        
        $this->showAnnouncementModal = true;
    }
    
    public function saveAnnouncement()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'category' => 'required|in:general,event,reminder',
            'description' => 'required|string|min:10',
            'visibility_type' => 'required|in:all,roles,grade_level,shs_strand,year_level,college_program',
        ];
        
        // Add validation rules based on visibility type
        if ($this->visibility_type === 'roles') {
            $rules['visible_to_roles'] = 'required|array|min:1';
        } elseif ($this->visibility_type === 'grade_level') {
            $rules['visible_to_grade_level'] = 'required|array|min:1';
        } elseif ($this->visibility_type === 'shs_strand') {
            $rules['visible_to_shs_strand'] = 'required|array|min:1';
        } elseif ($this->visibility_type === 'year_level') {
            $rules['visible_to_year_level'] = 'required|array|min:1';
        } elseif ($this->visibility_type === 'college_program') {
            $rules['visible_to_college_program'] = 'required|array|min:1';
        }
        
        $this->validate($rules);
        
        $data = [
            'title' => $this->title,
            'category' => $this->category,
            'description' => $this->description,
            'user_id' => auth()->id(),
            'visibility_type' => $this->visibility_type,
            'visible_to_grade_level' => $this->visibility_type === 'grade_level' ? $this->visible_to_grade_level : null,
            'visible_to_shs_strand' => $this->visibility_type === 'shs_strand' ? $this->visible_to_shs_strand : null,
            'visible_to_year_level' => $this->visibility_type === 'year_level' ? $this->visible_to_year_level : null,
            'visible_to_college_program' => $this->visibility_type === 'college_program' ? $this->visible_to_college_program : null,
            'visible_to_roles' => $this->visibility_type === 'roles' ? $this->visible_to_roles : null,
        ];
        
        if ($this->editingId) {
            $announcement = Announcement::findOrFail($this->editingId);
            
            // Check authorization for update
            if (!auth()->user()->isAdmin() && $announcement->user_id !== auth()->id()) {
                session()->flash('error', 'You are not authorized to update this announcement.');
                return;
            }
            
            $announcement->update($data);
            session()->flash('success', 'Announcement updated successfully!');
        } else {
            Announcement::create($data);
            session()->flash('success', 'Announcement created successfully!');
        }
        
        $this->closeAnnouncementModal();
        $this->loadStats();
    }
    
    public function confirmDelete($id)
    {
        $announcement = Announcement::findOrFail($id);
        
        // Check authorization
        if (!auth()->user()->isAdmin() && $announcement->user_id !== auth()->id()) {
            session()->flash('error', 'You are not authorized to delete this announcement.');
            return;
        }
        
        $this->announcementToDelete = $announcement;
        $this->showDeleteModal = true;
    }
    
    public function deleteAnnouncement()
    {
        if ($this->announcementToDelete) {
            $this->announcementToDelete->delete();
            session()->flash('success', 'Announcement deleted successfully!');
        }
        $this->closeDeleteModal();
        $this->loadStats();
    }
    
    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->announcementToDelete = null;
    }
    
    public function clearFilters()
    {
        $this->search = '';
        $this->categoryFilter = '';
        $this->sortDirection = 'desc';
    }
    
    private function resetForm()
    {
        $this->reset([
            'title', 'category', 'description', 'editingId',
            'visibility_type', 'visible_to_grade_level', 'visible_to_shs_strand',
            'visible_to_year_level', 'visible_to_college_program', 'visible_to_roles'
        ]);
        $this->resetErrorBag();
        $this->visibility_type = 'all';
        $this->category = 'general';  // Reset category to 'general'
    }
    
    public function updatedVisibilityType($value)
    {
        // Reset visibility arrays when type changes
        $this->visible_to_grade_level = [];
        $this->visible_to_shs_strand = [];
        $this->visible_to_year_level = [];
        $this->visible_to_college_program = [];
        $this->visible_to_roles = [];
    }
    
    public function render()
    {
        $user = Auth::user();
        $userInitials = strtoupper(substr($user->first_name ?? 'A', 0, 1) . substr($user->last_name ?? 'U', 0, 1));
        
        return view('livewire.announcements', [
            'userInitials' => $userInitials,
            'announcements' => $this->announcements,
            'totalCount' => $this->totalCount,
            'thisMonthCount' => $this->thisMonthCount,
            'generalCount' => $this->generalCount,
            'eventCount' => $this->eventCount,
            'reminderCount' => $this->reminderCount,
        ])->layout('layouts.app');
    }
}