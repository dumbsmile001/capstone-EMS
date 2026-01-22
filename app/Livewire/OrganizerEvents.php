<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class OrganizerEvents extends Component
{
    use WithFileUploads, WithPagination;

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

    // Event management
    public $editingEvent = null;
    public $deletingEvent = null;

    // Search and filter
    public $search = '';
    public $filterType = '';
    public $filterCategory = '';
    public $filterPayment = '';
    public $eventsPerPage = 12;

    // Sort options
    public $sortBy = 'date';
    public $sortDirection = 'asc';

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
            ]);

            // Handle banner upload if new banner is provided
            if ($this->banner) {
                $bannerPath = $this->banner->store('event-banners', 'public');
                $data['banner'] = $bannerPath;
            }

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

    public function getEventsProperty()
    {
        $userId = Auth::id();
        
        return Event::where('created_by', $userId)
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
            'category', 'description', 'banner', 'require_payment', 'payment_amount'
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