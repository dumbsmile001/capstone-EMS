<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminEvents extends Component
{
    use WithPagination, WithFileUploads;

    // Event properties
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
    public $showEventDetailsModal = false;
    
    // Event management
    public $editingEvent = null;
    public $deletingEvent = null;
    public $selectedEvent = null;
    
    // Search and filter
    public $search = '';
    public $filterType = '';
    public $filterCategory = '';
    public $filterPayment = '';
    public $filterCreator = '';
    public $filterStatus = '';
    public $eventsPerPage = 12;
    
    // Sort options
    public $sortBy = 'date';
    public $sortDirection = 'asc';
    
    // Visibility properties
    public $visibility_type = 'all';
    public $visible_to_grade_level = [];
    public $visible_to_shs_strand = [];
    public $visible_to_year_level = [];
    public $visible_to_college_program = [];
    
    // For creator filter
    public $creators = [];
    
    protected $queryString = [
        'search' => ['except' => ''],
        'filterType' => ['except' => ''],
        'filterCategory' => ['except' => ''],
        'filterPayment' => ['except' => ''],
        'filterCreator' => ['except' => ''],
        'filterStatus' => ['except' => ''],
        'eventsPerPage' => ['except' => 12],
    ];
    
    public function mount()
    {
        // Load all creators (organizers and admins)
        $this->creators = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['admin', 'organizer']);
        })
        ->select('id', 'first_name', 'last_name')
        ->get()
        ->mapWithKeys(function ($user) {
            return [$user->id => $user->first_name . ' ' . $user->last_name];
        })->toArray();
        
        // Initialize with today's date for create form
        $this->date = now()->format('Y-m-d');
        $this->time = now()->format('H:i');
    }
    
    public function getEventsProperty()
    {
        return Event::where('is_archived', false) // Only non-archived events
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterType, function ($query) {
                $query->where('type', $this->filterType);
            })
            ->when($this->filterCategory, function ($query) {
                $query->where('category', $this->filterCategory);
            })
            ->when($this->filterPayment !== '', function ($query) {
                if ($this->filterPayment === 'paid') {
                    $query->where('require_payment', true);
                } elseif ($this->filterPayment === 'free') {
                    $query->where('require_payment', false);
                }
            })
            ->when($this->filterCreator, function ($query) {
                $query->where('created_by', $this->filterCreator);
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->with('creator')
            ->paginate($this->eventsPerPage);
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
    
    public function openEditModal($eventId)
    {
        $this->editingEvent = Event::findOrFail($eventId);
        
        // Populate form fields
        $this->title = $this->editingEvent->title;
        $this->date = $this->editingEvent->date->format('Y-m-d');
        $this->time = $this->editingEvent->time;
        $this->type = $this->editingEvent->type;
        $this->place_link = $this->editingEvent->place_link;
        $this->category = $this->editingEvent->category;
        $this->description = $this->editingEvent->description;
        $this->require_payment = $this->editingEvent->require_payment;
        $this->payment_amount = $this->editingEvent->payment_amount;
        $this->visibility_type = $this->editingEvent->visibility_type;
        $this->visible_to_grade_level = $this->editingEvent->visible_to_grade_level ?? [];
        $this->visible_to_shs_strand = $this->editingEvent->visible_to_shs_strand ?? [];
        $this->visible_to_year_level = $this->editingEvent->visible_to_year_level ?? [];
        $this->visible_to_college_program = $this->editingEvent->visible_to_college_program ?? [];
        
        $this->showEditModal = true;
    }
    
    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->editingEvent = null;
        $this->resetForm();
    }
    
    public function openDeleteModal($eventId)
    {
        $this->deletingEvent = Event::findOrFail($eventId);
        $this->showDeleteModal = true;
    }
    
    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deletingEvent = null;
    }
    
    public function openEventDetailsModal($eventId)
    {
        $this->selectedEvent = Event::with('creator')->findOrFail($eventId);
        $this->showEventDetailsModal = true;
    }
    
    public function closeEventDetailsModal()
    {
        $this->showEventDetailsModal = false;
        $this->selectedEvent = null;
    }
    
    public function createEvent()
    {
        $data = $this->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'type' => 'required|in:online,face-to-face',
            'place_link' => 'required|string|max:500',
            'category' => 'required|in:academic,sports,cultural',
            'description' => 'required|string|min:10',
            'banner' => 'nullable|image|max:2048',
            'require_payment' => 'boolean',
            'payment_amount' => 'nullable|required_if:require_payment,true|numeric|min:0',
            'visibility_type' => 'required|in:all,grade_level,shs_strand,year_level,college_program',
            'visible_to_grade_level' => 'nullable|array',
            'visible_to_shs_strand' => 'nullable|array',
            'visible_to_year_level' => 'nullable|array',
            'visible_to_college_program' => 'nullable|array',
        ]);
        
        // Handle banner upload
        $bannerPath = $this->banner ? $this->banner->store('event-banners', 'public') : null;
        
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
            'visibility_type' => $this->visibility_type,
            'visible_to_grade_level' => $this->visibility_type === 'grade_level' ? $this->visible_to_grade_level : null,
            'visible_to_shs_strand' => $this->visibility_type === 'shs_strand' ? $this->visible_to_shs_strand : null,
            'visible_to_year_level' => $this->visibility_type === 'year_level' ? $this->visible_to_year_level : null,
            'visible_to_college_program' => $this->visibility_type === 'college_program' ? $this->visible_to_college_program : null,
        ]);
        
        $this->closeCreateModal();
        session()->flash('success', 'Event created successfully!');
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
                'visibility_type' => 'required|in:all,grade_level,shs_strand,year_level,college_program',
                'visible_to_grade_level' => 'nullable|array',
                'visible_to_shs_strand' => 'nullable|array',
                'visible_to_year_level' => 'nullable|array',
                'visible_to_college_program' => 'nullable|array',
            ]);
            
            // Handle banner upload if new banner is provided
            if ($this->banner) {
                $data['banner'] = $this->banner->store('event-banners', 'public');
            } else {
                // Keep the existing banner if no new banner is uploaded
                unset($data['banner']);
            }
            
            // Add visibility fields
            $data['visibility_type'] = $this->visibility_type;
            $data['visible_to_grade_level'] = $this->visibility_type === 'grade_level' ? $this->visible_to_grade_level : null;
            $data['visible_to_shs_strand'] = $this->visibility_type === 'shs_strand' ? $this->visible_to_shs_strand : null;
            $data['visible_to_year_level'] = $this->visibility_type === 'year_level' ? $this->visible_to_year_level : null;
            $data['visible_to_college_program'] = $this->visibility_type === 'college_program' ? $this->visible_to_college_program : null;
            
            $this->editingEvent->update($data);
            
            $this->closeEditModal();
            session()->flash('success', 'Event updated successfully!');
        }
    }
    
    public function deleteEvent()
    {
        if ($this->deletingEvent) {
            $this->deletingEvent->delete();
            session()->flash('success', 'Event deleted successfully!');
        }
        $this->closeDeleteModal();
    }
    
    public function archiveEvent($eventId)
    {
        $event = Event::findOrFail($eventId);
        
        if ($event->archive(Auth::id())) {
            session()->flash('success', 'Event archived successfully!');
        } else {
            session()->flash('error', 'Failed to archive event.');
        }
    }
    
    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }
    
    public function resetFilters()
    {
        $this->reset(['search', 'filterType', 'filterCategory', 'filterPayment', 
                     'filterCreator', 'filterStatus', 'eventsPerPage']);
        $this->resetPage();
    }
    
    public function getEventStatsProperty()
    {
        return [
            'total' => Event::where('is_archived', false)->count(),
            'ongoing' => Event::where('is_archived', false)
                ->where('date', now()->format('Y-m-d'))
                ->where('status', 'published')
                ->count(),
            'upcoming' => Event::where('is_archived', false)
                ->where('date', '>', now()->format('Y-m-d'))
                ->where('status', 'published')
                ->count(),
            'paid' => Event::where('is_archived', false)
                ->where('require_payment', true)
                ->count(),
        ];
    }
    
    private function resetForm()
    {
        $this->reset([
            'title', 'date', 'time', 'type', 'place_link', 
            'category', 'description', 'banner', 'require_payment', 'payment_amount',
            'visibility_type', 'visible_to_grade_level', 'visible_to_shs_strand',
            'visible_to_year_level', 'visible_to_college_program'
        ]);
        $this->resetErrorBag();
        $this->date = now()->format('Y-m-d');
        $this->time = now()->format('H:i');
    }
    
    public function render()
    {
        $user = Auth::user();
        $userInitials = strtoupper(substr($user->first_name ?? 'A', 0, 1) . substr($user->last_name ?? 'U', 0, 1));
        
        return view('livewire.admin-events', [
            'userInitials' => $userInitials,
            'events' => $this->events,
            'stats' => $this->eventStats,
            'creators' => $this->creators,
        ])->layout('layouts.app');
    }
}