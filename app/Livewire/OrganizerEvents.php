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
    public $start_date;        // Changed
    public $start_time;        // Changed
    public $end_date;          // New
    public $end_time;          // New
    public string $location = '';
    public string $category = '';
    public string $description = '';
    public $banner;
    public bool $require_payment = false;
    public $payment_amount = 0;

    // Predefined locations
    public $predefinedLocations = [];
    public $customLocation = '';

    // Modal flags
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $showEventDetailsModal = false;
    public $showArchiveModal = false;
    public $showConflictModal = false;
    public $showAutoArchiveModal = false;
    public $autoArchiveDryRun = false;
    public $autoArchiveResults = null;

    // Event management
    public $editingEvent = null;
    public $deletingEvent = null;
    public $selectedEvent = null;
    public $archivingEvent = null;
    public $pendingEventData = null;
    public $conflictingEvents = [];

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
        // Load predefined locations
        $this->predefinedLocations = Event::$predefinedLocations;

        // Initialize with today's date for create form
        $this->start_date = now()->format('Y-m-d');
        $this->start_time = now()->format('H:i');
        $this->end_date = now()->addHours(2)->format('Y-m-d');  // Default end 2 hours later
        $this->end_time = now()->addHours(2)->format('H:i');

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
        $this->start_date = $this->editingEvent->start_date->format('Y-m-d');
        $this->start_time = $this->editingEvent->start_time;
        $this->end_date = $this->editingEvent->end_date->format('Y-m-d');
        $this->end_time = $this->editingEvent->end_time;

        // Handle location - check if it's a predefined location or custom
        if (in_array($this->editingEvent->location, Event::$predefinedLocations)) {
            $this->location = $this->editingEvent->location;
            $this->customLocation = '';
        } else {
            $this->location = 'custom';
            $this->customLocation = $this->editingEvent->location;
        }

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

     public function closeConflictModal()
    {
        $this->showConflictModal = false;
        $this->conflictingEvents = [];
        $this->pendingEventData = null;
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

    /**
     * Create event with conflict checking
     */
    public function createEvent()
    {
        // First validate the basic data
        $validatedData = $this->validateEventData();
        
        // Additional validation: if same date, end time must be after start time
        if ($this->start_date === $this->end_date && $this->end_time <= $this->start_time) {
            $this->addError('end_time', 'End time must be after start time on the same day.');
            return;
        }
        
        // Prepare event data
        $eventData = $this->prepareEventData();
        
        // Log the data for debugging
        \Log::info('Creating event with data:', $eventData);
        
        // Check for conflicts (no exclude ID for new events)
        if (!$this->checkConflicts($eventData, null)) {
            // Store pending data and show conflict modal
            $this->pendingEventData = $eventData;
            $this->showConflictModal = true;
            return;
        }
        
        // No conflicts, proceed with creation
        $this->saveEvent($eventData);
    }

    /**
     * Force create event despite conflicts (after user confirmation)
     */
    public function forceCreateEvent()
    {
        if ($this->pendingEventData) {
            $this->saveEvent($this->pendingEventData);
            $this->pendingEventData = null;
            $this->conflictingEvents = [];
            $this->showConflictModal = false;
        }
    }

    /**
     * Save event to database
     */
    private function saveEvent($eventData)
    {
        // Handle banner upload
        $bannerPath = $this->banner ? $this->banner->store('event-banners', 'public') : null;
        
        // Create the event
        $event = Event::create(array_merge($eventData, [
            'banner' => $bannerPath,
            'created_by' => Auth::id(),
            'status' => 'published',
        ]));
        
        $this->logActivity('CREATE', $event, 
            auth()->user()->first_name . ' ' . auth()->user()->last_name . ' created new event: ' . $event->title);
        
        $this->closeCreateModal();
        session()->flash('success', 'Event created successfully!');
    }

    /**
     * Update event with conflict checking
     */
    public function updateEvent()
    {
        if (!$this->editingEvent) {
            return;
        }
        
        $validatedData = $this->validateEventData();
        
        // Additional validation for time logic
        if ($this->start_date === $this->end_date && $this->end_time <= $this->start_time) {
            $this->addError('end_time', 'End time must be after start time on the same day.');
            return;
        }
        
        // Prepare event data
        $eventData = $this->prepareEventData();
        
        // Check for conflicts (excluding current event)
        if (!$this->checkConflicts($eventData, $this->editingEvent->id)) {
            // Store pending data and show conflict modal
            $this->pendingEventData = $eventData;
            $this->showConflictModal = true;
            return;
        }
        
        // No conflicts, proceed with update
        $this->saveUpdatedEvent($eventData);
    }

    /**
     * Force update event despite conflicts
     */
    public function forceUpdateEvent()
    {
        if ($this->pendingEventData && $this->editingEvent) {
            $this->saveUpdatedEvent($this->pendingEventData);
            $this->pendingEventData = null;
            $this->conflictingEvents = [];
            $this->showConflictModal = false;
        }
    }

    /**
     * Save updated event
     */
    private function saveUpdatedEvent($eventData)
    {
        // Handle banner upload if new banner is provided
        if ($this->banner) {
            $eventData['banner'] = $this->banner->store('event-banners', 'public');
        }
        
        $oldValues = $this->editingEvent->getOriginal();
        $this->editingEvent->update($eventData);
        
        $this->logActivity('UPDATE', $this->editingEvent, 
            auth()->user()->first_name . ' ' . auth()->user()->last_name . ' updated event: ' . $this->editingEvent->title,
            $oldValues, 
            $this->editingEvent->toArray()
        );
        
        $this->closeEditModal();
        session()->flash('success', 'Event updated successfully!');
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

    public function confirmAutoArchive()
    {
        $this->showAutoArchiveModal = true;
    }

    public function performAutoArchive()
    {
        $this->autoArchiveDryRun = false;
        
        // Get the count of events to archive first
        $cutoffDate = now()->subDays(1);
        $eventsToArchive = Event::where('is_archived', false)
            ->where('status', 'published')
            ->where(function ($query) use ($cutoffDate) {
                $query->where('end_date', '<', $cutoffDate->toDateString())
                    ->orWhere(function ($q) use ($cutoffDate) {
                        $q->where('end_date', $cutoffDate->toDateString())
                            ->where('end_time', '<', $cutoffDate->format('H:i:s'));
                    });
            })
            ->get();
        
        $archived = 0;
        $failed = 0;
        $results = [];
        
        foreach ($eventsToArchive as $event) {
            try {
                $event->archive(null);
                $archived++;
                $results[] = [
                    'title' => $event->title,
                    'status' => 'success'
                ];
            } catch (\Exception $e) {
                $failed++;
                $results[] = [
                    'title' => $event->title,
                    'status' => 'failed',
                    'error' => $e->getMessage()
                ];
            }
        }
        
        $this->autoArchiveResults = [
            'total' => $eventsToArchive->count(),
            'archived' => $archived,
            'failed' => $failed,
            'results' => $results
        ];
        
        $this->logActivity('AUTO_ARCHIVE', null, 
            auth()->user()->first_name . ' ' . auth()->user()->last_name . ' triggered manual auto-archive. ' .
            $archived . ' events archived, ' . $failed . ' failed.');
        
        if ($archived > 0) {
            session()->flash('success', "Auto-archived {$archived} event(s) successfully!");
        } else {
            session()->flash('info', 'No expired events found to archive.');
        }
        
        $this->showAutoArchiveModal = false;
    }

    public function previewAutoArchive()
    {
        $cutoffDate = now()->subDays(1);
        
        $eventsToArchive = Event::where('is_archived', false)
            ->where('status', 'published')
            ->where(function ($query) use ($cutoffDate) {
                $query->where('end_date', '<', $cutoffDate->toDateString())
                    ->orWhere(function ($q) use ($cutoffDate) {
                        $q->where('end_date', $cutoffDate->toDateString())
                            ->where('end_time', '<', $cutoffDate->format('H:i:s'));
                    });
            })
            ->with('creator')
            ->get();
        
        $this->autoArchiveResults = [
            'total' => $eventsToArchive->count(),
            'archived' => 0,
            'failed' => 0,
            'preview' => $eventsToArchive->map(fn($e) => [
                'title' => $e->title,
                'end_date' => $e->end_date->format('M d, Y'),
                'end_time' => \Carbon\Carbon::parse($e->end_time)->format('g:i A'),
                'creator' => ($e->creator->first_name ?? 'Unknown') . ' ' . ($e->creator->last_name ?? ''),
            ])->toArray()
        ];
        
        $this->autoArchiveDryRun = true;
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
            ->orderBy($this->sortBy === 'date' ? 'start_date' : $this->sortBy, $this->sortDirection)
            ->paginate($this->eventsPerPage);
    }

    /**
     * Check for conflicts before creating/updating
     */
    private function checkConflicts($eventData, $excludeEventId = null)
    {
        // Create a temporary event object to check conflicts
        $tempEvent = new Event($eventData);
        
        if ($excludeEventId) {
            $tempEvent->id = $excludeEventId;
        }
        
        // Get potential conflicting events
        $query = Event::where('location', $tempEvent->location)
            ->where('is_archived', false)
            ->where('status', 'published');
        
        // Exclude the current event if we're updating
        if ($excludeEventId) {
            $query->where('id', '!=', $excludeEventId);
        }
        
        $potentialConflicts = $query->get();
        
        $conflicts = [];
        foreach ($potentialConflicts as $event) {
            // Skip if it's the same event (for updates)
            if ($excludeEventId && $event->id == $excludeEventId) {
                continue;
            }
            
            // Check if time periods overlap
            $tempStart = $tempEvent->startDateTime;
            $tempEnd = $tempEvent->endDateTime;
            $eventStart = $event->startDateTime;
            $eventEnd = $event->endDateTime;
            
            // Overlap condition
            if ($tempStart < $eventEnd && $tempEnd > $eventStart) {
                $conflicts[] = $event;
            }
        }
        
        if (!empty($conflicts)) {
            $this->conflictingEvents = $conflicts;
            \Log::info('Conflicts found:', ['count' => count($conflicts), 'conflicts' => $conflicts]);
            return false;
        }
        
        return true;
    }

    /**
     * Prepare event data from form
     */
    private function prepareEventData()
    {
        // Determine final location
        $finalLocation = $this->location;
        if ($finalLocation === 'custom' && !empty($this->customLocation)) {
            $finalLocation = $this->customLocation;
        }
        
        return [
            'title' => $this->title,
            'start_date' => $this->start_date,
            'start_time' => $this->start_time,
            'end_date' => $this->end_date,
            'end_time' => $this->end_time,
            'location' => $finalLocation,
            'category' => $this->category,
            'description' => $this->description,
            'require_payment' => $this->require_payment,
            'payment_amount' => $this->require_payment ? $this->payment_amount : null,
            'visibility_type' => $this->visibility_type,
            'visible_to_grade_level' => $this->visibility_type === 'grade_level' ? $this->visible_to_grade_level : null,
            'visible_to_shs_strand' => $this->visibility_type === 'shs_strand' ? $this->visible_to_shs_strand : null,
            'visible_to_year_level' => $this->visibility_type === 'year_level' ? $this->visible_to_year_level : null,
            'visible_to_college_program' => $this->visibility_type === 'college_program' ? $this->visible_to_college_program : null,
        ];
    }

    /**
     * Validate event data
     */
    private function validateEventData()
    {
        return $this->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_date' => 'required|date|after_or_equal:start_date',
            'end_time' => 'required',
            'location' => 'required|string|max:500',
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
    }

    /**
     * Handle location change
     */
    public function updatedLocation($value)
    {
        if ($value !== 'custom') {
            $this->customLocation = '';
        }
    }

    public function getEventStatsProperty()
    {
        $userId = Auth::id();
        $now = now();
        
        return [
            'total' => Event::where('created_by', $userId)->count(),
            'ongoing' => Event::where('created_by', $userId)
                ->where('start_date', '<=', $now->format('Y-m-d'))
                ->where('end_date', '>=', $now->format('Y-m-d'))
                ->where('is_archived', false)
                ->count(),
            'upcoming' => Event::where('created_by', $userId)
                ->where('start_date', '>', $now->format('Y-m-d'))
                ->where('is_archived', false)
                ->count(),
            'paid' => Event::where('created_by', $userId)
                ->where('require_payment', true)
                ->count(),
        ];
    }

    private function resetForm()
    {
       $this->reset([
            'title', 'start_date', 'start_time', 'end_date', 'end_time', 'location', 
            'category', 'description', 'banner', 'require_payment', 'payment_amount',
            'visibility_type', 'visible_to_grade_level', 'visible_to_shs_strand',
            'visible_to_year_level', 'visible_to_college_program'
        ]);
        $this->resetErrorBag();
        $this->start_date = now()->format('Y-m-d');
        $this->start_time = now()->format('H:i');
        $this->end_date = now()->addHours(2)->format('Y-m-d');
        $this->end_time = now()->addHours(2)->format('H:i');
    }

    public function setDuration($hours)
    {
        $this->end_date = $this->start_date;
        $this->end_time = \Carbon\Carbon::parse($this->start_time)->addHours($hours)->format('H:i');
        
        // If adding hours crosses midnight, adjust date
        if (\Carbon\Carbon::parse($this->start_time)->addHours($hours)->format('Y-m-d') > $this->start_date) {
            $this->end_date = \Carbon\Carbon::parse($this->start_date)->addDay()->format('Y-m-d');
        }
    }

    public function updatedVisibilityType($value)
    {
        // Reset all visibility arrays when type changes
        $this->visible_to_grade_level = [];
        $this->visible_to_shs_strand = [];
        $this->visible_to_year_level = [];
        $this->visible_to_college_program = [];
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