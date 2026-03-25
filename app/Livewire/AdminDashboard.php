<?php

namespace App\Livewire;

use App\Models\AuditLog;
use App\Models\Event;
use App\Models\User;
use App\Traits\LogsActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class AdminDashboard extends Component
{
    use WithFileUploads, WithPagination, LogsActivity;
    
    // Events properties - UPDATED
    public string $title = '';
    public $start_date;        // Changed from 'date'
    public $start_time;        // Changed from 'time'
    public $end_date;          // New
    public $end_time;          // New
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
    public $showGenerateReportModal = false;
    public $showArchiveModal = false;

    // Add export format selection
    public $exportFormat = 'xlsx';

    // Edit or delete
    public $editingEvent = null;
    public $deletingEvent = null;

    //Event details
    public $showEventDetailsModal = false;
    public $selectedEvent = null;

     // Available programs and roles for filters
    public $availableSHSStrands = [];
    public $availableCollegePrograms = [];
    public $availableRoles = [];
    public $recentActivities = [];
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;

    // Add these properties to the AdminDashboard class:
    public $visibility_type = 'all';
    public $visible_to_grade_level = [];
    public $visible_to_shs_strand = [];
    public $visible_to_year_level = [];
    public $visible_to_college_program = [];

    public function mount()
    {
        $this->loadRecentActivities();
        // Initialize dates - ADD THIS
        $this->start_date = now()->format('Y-m-d');
        $this->start_time = now()->format('H:i');
        $this->end_date = now()->addHours(2)->format('Y-m-d');
        $this->end_time = now()->addHours(2)->format('H:i');
    }

    // Add this method
    public function loadRecentActivities()
    {
        $this->recentActivities = AuditLog::with('user')
            ->latest()
            ->limit(4)
            ->get();
    }
    public function openLogDetailsModal($logId)
    {
        return redirect()->route('admin.audit-logs');
    }

    // UPDATED: Event methods with new fields
    public function updateEvent()
    {
        if ($this->editingEvent) {
            $data = $this->validate([
                'title' => 'required|string|max:255',
                'start_date' => 'required|date',
                'start_time' => 'required',
                'end_date' => 'required|date|after_or_equal:start_date',
                'end_time' => 'required',
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

            // Additional validation for time logic
            if ($this->start_date === $this->end_date && $this->end_time <= $this->start_time) {
                $this->addError('end_time', 'End time must be after start time on the same day.');
                return;
            }

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

            $oldValues = $this->editingEvent->getOriginal();
            $this->editingEvent->update($data);

            $this->logActivity('UPDATE', $this->editingEvent, null, $oldValues, $this->editingEvent->toArray());
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
            'start_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_date' => 'required|date|after_or_equal:start_date',
            'end_time' => 'required',
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

        // Additional validation: if same date, end time must be after start time
        if ($this->start_date === $this->end_date && $this->end_time <= $this->start_time) {
            $this->addError('end_time', 'End time must be after start time on the same day.');
            return;
        }

        $bannerPath = $this->banner ? $this->banner->store('event-banners', 'public') : null;

        // Create the event
        $event = Event::create([
            'title' => $this->title,
            'start_date' => $this->start_date,
            'start_time' => $this->start_time,
            'end_date' => $this->end_date,
            'end_time' => $this->end_time,
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

        // Reset form fields
        $this->resetForm();

        // Close modal
        $this->showCreateModal = false;

         // Log the activity
        $this->logActivity('CREATE', $event);

        session()->flash('success', 'Event created successfully!');
    }

    // UPDATED: Get upcoming events with new date fields
    public function getUpcomingEvents()
    {
        return Event::where('start_date', '>=', Carbon::today())
            ->where('status', 'published')
            ->where('is_archived', false)
            ->orderBy('start_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->limit(3)
            ->get();
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

    public function openCreateModal(){
        $this->resetForm(); // Reset to default values
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
            // Populate form fields with existing data - UPDATED
            $this->title = $this->editingEvent->title;
            $this->start_date = $this->editingEvent->start_date->format('Y-m-d');
            $this->start_time = $this->editingEvent->start_time;
            $this->end_date = $this->editingEvent->end_date->format('Y-m-d');
            $this->end_time = $this->editingEvent->end_time;
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
            $event = $this->deletingEvent;
            $this->deletingEvent->delete();

            // Log the deletion
            $this->logActivity('DELETE', $event);
            session()->flash('success', 'Event deleted successfully!');
        }
        $this->showDeleteModal = false;
        $this->deletingEvent = null;
    }
    
    // Open generate report modal
    public function openGenerateReportModal()
    {
        $this->exportFormat = 'xlsx'; // Reset to default
        $this->showGenerateReportModal = true;
    }

    // Close generate report modal
    public function closeGenerateReportModal()
    {
        $this->showGenerateReportModal = false;
    }
    
    public function openArchiveModal(){
        $this->showArchiveModal = true;
    }

    private function resetForm()
    {
        $this->reset([
            'title', 'start_date', 'start_time', 'end_date', 'end_time', 'type', 'place_link', 
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

    // Add helper method for duration presets
    public function setDuration($hours)
    {
        $this->end_date = $this->start_date;
        $this->end_time = \Carbon\Carbon::parse($this->start_time)->addHours($hours)->format('H:i');
        
        // If adding hours crosses midnight, adjust date
        if (\Carbon\Carbon::parse($this->start_time)->addHours($hours)->format('Y-m-d') > $this->start_date) {
            $this->end_date = \Carbon\Carbon::parse($this->start_date)->addDay()->format('Y-m-d');
        }
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
        
        // Count all archived events (using is_archived field)
        $archivedEvents = Event::where('is_archived', true)->count();
        
        // UPDATED: Count upcoming events (published and not archived)
        $upcomingEvents = Event::where('start_date', '>=', now()->format('Y-m-d'))
                            ->where('is_archived', false)
                            ->where('status', 'published')
                            ->count();
        
        return view('livewire.admin-dashboard', [
            'userInitials' => $userInitials,
            'events' => $events,
            'usersCount' => $usersCount,
            'eventsCount' => $eventsCount,
            'archivedEvents' => $archivedEvents,
            'upcomingEvents' => $upcomingEvents,
            'upcomingEventsData' => $upcomingEventsData,
        ])->layout('layouts.app');
    }
}