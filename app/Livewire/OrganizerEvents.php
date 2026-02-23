<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Traits\LogsActivity;

class OrganizerEvents extends Component
{
    use WithFileUploads, WithPagination, LogsActivity;

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
    public $showArchiveModal = false;

    // Event management
    public $editingEvent = null;
    public $deletingEvent = null;
    public $selectedEvent = null;
    public $archivingEvent = null;

    // Search and filter
    public $search = '';
    public $filterType = '';
    public $filterCategory = '';
    public $filterPayment = '';
    public $eventsPerPage = 12;

    // Sort options
    public $sortBy = 'date';
    public $sortDirection = 'asc';

    // Add these properties to the OrganizerEvents class (around line 40-50):
    public $visibility_type = 'all';
    public $visible_to_grade_level = [];
    public $visible_to_shs_strand = [];
    public $visible_to_year_level = [];
    public $visible_to_college_program = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'filterType' => ['except' => ''],
        'filterCategory' => ['except' => ''],
        'filterPayment' => ['except' => ''],
        'eventsPerPage' => ['except' => 12],
    ];

    public function mount()
    {
        // Initialize with today's date for create form
        $this->date = now()->format('Y-m-d');
        $this->time = now()->format('H:i');

        // Check if user is organizer
        if (!auth()->user()->hasRole('organizer')) {
            abort(403, 'Unauthorized access.');
        }
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
        // Add these lines:
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

    public function confirmDelete()
    {
        if ($this->deletingEvent) {
            // Store event info before deletion
            $event = $this->deletingEvent;
            $this->deletingEvent->delete();
            // Log the activity after successful deletion
            $this->logActivity('DELETE', $event);
            session()->flash('success', 'Event deleted successfully!');
        }
        $this->closeDeleteModal();
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
        $event = Event::create([
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

         // Log the activity
        $this->logActivity('CREATE', $event);

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

            // Get old values for logging
            $oldValues = $this->editingEvent->toArray();

            // Handle banner upload if new banner is provided
            if ($this->banner) {
                $data['banner'] = $this->banner->store('event-banners', 'public');
            }
            else {
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

            // Log the activity with changes
            $newValues = $this->editingEvent->fresh()->toArray();
            $this->logActivity('UPDATE', $this->editingEvent, null, $oldValues, $newValues);
            
            $this->closeEditModal();
            session()->flash('success', 'Event updated successfully!');
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
        $this->reset(['search', 'filterType', 'filterCategory', 'filterPayment', 'eventsPerPage']);
        $this->resetPage();
    }

    public function openArchiveModal($eventId)
    {
        $this->archivingEvent = Event::findOrFail($eventId);
        $this->showArchiveModal = true;
    }

    public function closeArchiveModal()
    {
        $this->showArchiveModal = false;
        $this->archivingEvent = null;
    }

    public function confirmArchive()
    {
        if (!$this->archivingEvent) {
            return;
        }
        
        try {
            // Log the archive action BEFORE archiving
            $this->logActivity('ARCHIVE', $this->archivingEvent,
                auth()->user()->first_name . ' ' . auth()->user()->last_name . ' archived event: ' . $this->archivingEvent->title);
            
            // Then archive the event
            $archived = $this->archivingEvent->archive(Auth::id());
            
            if ($archived) {
                session()->flash('success', 'Event archived successfully!');
            } else {
                session()->flash('error', 'Failed to archive event. The archive operation returned false.');
            }
        } catch (\Exception $e) {
            \Log::error('Archive failed: ' . $e->getMessage(), [
                'event_id' => $this->archivingEvent->id,
                'user_id' => Auth::id()
            ]);
            
            session()->flash('error', 'Failed to archive event: ' . $e->getMessage());
        }
        
        $this->closeArchiveModal();
    }

    public function getEventsProperty()
    {
        $userId = Auth::id();
        
        return Event::where('created_by', $userId)
            ->where('is_archived', false) // Add this
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
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
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->eventsPerPage);
    }

    public function getEventStatsProperty()
    {
        $userId = Auth::id();
        $today = now()->format('Y-m-d');
        
        return [
            'total' => Event::where('created_by', $userId)->count(),
            'ongoing' => Event::where('created_by', $userId)
                ->where('date', $today)
                ->where('status', 'published')
                ->count(),
            'upcoming' => Event::where('created_by', $userId)
                ->where('date', '>', $today)
                ->where('status', 'published')
                ->count(),
            'paid' => Event::where('created_by', $userId)
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
        $userInitials = strtoupper(substr($user->first_name ?? 'O', 0, 1) . substr($user->last_name ?? 'U', 0, 1));
        
        return view('livewire.organizer-events', [
            'userInitials' => $userInitials,
            'events' => $this->events,
            'stats' => $this->eventStats,
        ])->layout('layouts.app');
    }
}