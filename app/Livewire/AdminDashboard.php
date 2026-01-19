<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class AdminDashboard extends Component
{
    use WithFileUploads, WithPagination;

    // User properties
    public $first_name;
    public $middle_name;
    public $last_name;
    public $student_id;
    public $email;
    public $role;
    public $grade_level;
    public $year_level;
    public $program;

    // Search and filter properties
    public $search = '';
    public $filterGradeLevel = '';
    public $filterYearLevel = '';
    public $filterProgram = '';
    public $filterRole = '';
    
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

    // Edit or delete
    public $editingEvent = null;
    public $deletingEvent = null;
    public $editingUser = null;
    public $deletingUser = null;

    //Event details
    public $showEventDetailsModal = false;
    public $selectedEvent = null;

     // Available programs and roles for filters
    public $availablePrograms = [];
    public $availableRoles = [];
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;

    public function mount()
    {
        $this->loadFilterOptions();
    }

    public function loadFilterOptions()
    {
        // Load distinct programs from users
        $this->availablePrograms = User::whereNotNull('program')
            ->distinct()
            ->pluck('program')
            ->filter()
            ->toArray();
        
        // Load available roles
        $this->availableRoles = Role::pluck('name')->toArray();
    }

    // Computed property for users with search and filters
    public function getUsersProperty()
    {
        return User::with('roles')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                      ->orWhere('last_name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('student_id', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterGradeLevel, function ($query) {
                $query->where('grade_level', $this->filterGradeLevel);
            })
            ->when($this->filterYearLevel, function ($query) {
                $query->where('year_level', $this->filterYearLevel);
            })
            ->when($this->filterProgram, function ($query) {
                $query->where('program', $this->filterProgram);
            })
            ->when($this->filterRole, function ($query) {
                $query->whereHas('roles', function ($q) {
                    $q->where('name', $this->filterRole);
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
    }

    // Reset filters
    public function resetFilters()
    {
        $this->reset(['search', 'filterGradeLevel', 'filterYearLevel', 'filterProgram', 'filterRole']);
        $this->gotoPage(1); // Use gotoPage instead of resetPage
    }

    // Apply filters
    public function applyFilters()
    {
        $this->resetPage();
    }

    public function openEditUserModal($userId = null)
    {
        if ($userId) {
            $this->editingUser = User::with('roles')->findOrFail($userId);
            
            // Populate form fields with existing user data
            $this->first_name = $this->editingUser->first_name;
            $this->middle_name = $this->editingUser->middle_name;
            $this->last_name = $this->editingUser->last_name;
            $this->student_id = $this->editingUser->student_id;
            $this->email = $this->editingUser->email;
            $this->grade_level = $this->editingUser->grade_level;
            $this->year_level = $this->editingUser->year_level;
            $this->program = $this->editingUser->program;
            
            // Get the first role name (assuming users have one primary role)
            $this->role = $this->editingUser->roles->first()->name ?? 'student';
        }
        
        $this->showEditUserModal = true;
    }

    public function closeEditUserModal()
    {
        $this->showEditUserModal = false;
        $this->editingUser = null;
        $this->resetUserForm();
    }

    public function openDeleteUserModal($userId = null)
    {
        if ($userId) {
            $this->deletingUser = User::findOrFail($userId);
        }
        $this->showDeleteUserModal = true;
    }

    public function closeDeleteUserModal()
    {
        $this->showDeleteUserModal = false;
        $this->deletingUser = null;
    }

    public function saveUser()
    {
        $this->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'student_id' => 'required|integer|unique:users,student_id,' . ($this->editingUser ? $this->editingUser->id : ''),
            'email' => 'required|email|unique:users,email,' . ($this->editingUser ? $this->editingUser->id : ''),
            'grade_level' => 'nullable|integer|min:11|max:12',
            'year_level' => 'nullable|integer|min:1|max:5',
            'program' => 'nullable|string|max:255',
            'role' => 'required|in:admin,organizer,student',
        ]);

        if ($this->editingUser) {
            // Update existing user
            $this->editingUser->update([
                'first_name' => $this->first_name,
                'middle_name' => $this->middle_name,
                'last_name' => $this->last_name,
                'student_id' => $this->student_id,
                'email' => $this->email,
                'grade_level' => $this->grade_level,
                'year_level' => $this->year_level,
                'program' => $this->program,
            ]);

            // Update role
            $this->editingUser->syncRoles([$this->role]);

            session()->flash('success', 'User updated successfully!');
        }

        $this->closeEditUserModal();
        $this->loadUsers(); // Refresh the users list
    }

    public function deleteUser()
    {
        if ($this->deletingUser) {
            // Prevent admin from deleting themselves
            if ($this->deletingUser->id === Auth::id()) {
                session()->flash('error', 'You cannot delete your own account!');
                $this->closeDeleteUserModal();
                return;
            }

            $this->deletingUser->delete();
            session()->flash('success', 'User deleted successfully!');
        }

        $this->closeDeleteUserModal();
        $this->loadUsers(); // Refresh the users list
    }

    private function resetUserForm()
    {
        $this->reset([
            'first_name', 'middle_name', 'last_name', 'student_id', 
            'email', 'role', 'grade_level', 'year_level', 'program'
        ]);
        $this->resetErrorBag();
    }

    // Existing event methods remain the same...
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

        // Close modal
        $this->showCreateModal = false;

        session()->flash('success', 'Event created successfully!');
    }

    public function getUpcomingEvents()
    {
        return Event::where('date', '>=', Carbon::today())
            ->where('status', 'published') // Only published events
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->limit(3)
            ->get();
    }

    public function openEventDetailsModal($eventId)
    {
        $this->selectedEvent = Event::findOrFail($eventId);
        $this->showEventDetailsModal = true;
    }

     public function closeEventDetailsModal()
    {
        $this->showEventDetailsModal = false;
        $this->selectedEvent = null;
    }

    public function openCreateModal(){
        $this->showCreateModal = true;
    }
    
    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->resetForm();
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

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->editingEvent = null;
        $this->resetForm();
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
    
    public function openGenerateReportModal(){
        $this->showGenerateReportModal = true;
    }
    
    public function openArchiveModal(){
        $this->showArchiveModal = true;
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
        $userInitials = strtoupper(substr($user->first_name ?? 'A', 0, 1) . substr($user->last_name ?? 'U', 0, 1));

        // Fetch events from database
        $events = Event::where('created_by', Auth::id())
                      ->orderBy('created_at', 'desc')
                      ->get();

        // Get upcoming events
        $upcomingEventsData = $this->getUpcomingEvents();

        // Get counts for overview cards
        $usersCount = User::count();
        $eventsCount = Event::count();
        $archivedEvents = Event::where('status', 'archived')->count();
        $upcomingEvents = Event::where('date', '>=', now()->format('Y-m-d'))->count();
        
        return view('livewire.admin-dashboard', [
            'userInitials' => $userInitials,
            'events' => $events,
            'usersCount' => $usersCount,
            'eventsCount' => $eventsCount,
            'archivedEvents' => $archivedEvents,
            'upcomingEvents' => $upcomingEvents,
            'upcomingEventsData' => $upcomingEventsData, // Pass upcoming events to view
            'users' => $this->users, // Use the computed property
        ])->layout('layouts.app');
    }
}