<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Registration;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination; // Add this
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrganizerDashboard extends Component
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

    // Add these properties for editing
    public $editingEvent = null;
    public $deletingEvent = null;

    // Add computed properties for dynamic card data
    public $eventRegistrationsCount;
    public $ongoingEventsCount;
    public $upcomingEventsCount;
    public $pendingPaymentsCount;

    // Add these properties to the OrganizerDashboard class
    public $paymentSearch = '';
    public $filterPaymentEvent = '';
    public $filterPaymentStatus = '';
    public $paymentsPerPage = 10;
    
    // Add this property to control payments tab
    public $activeTab = 'registrations';

    // Initialize or update the card data
    public function mount()
    {
        $this->updateCardData();
    }

    // Method to update all card data
    public function updateCardData()
    {
        $userId = Auth::id();
        $today = now()->format('Y-m-d');
        
        // 1. Total Event Registrations (all registrations for organizer's events)
        $this->eventRegistrationsCount = Registration::whereHas('event', function($query) use ($userId) {
            $query->where('created_by', $userId);
        })->count();

        // 2. Ongoing Events (events happening today)
        $this->ongoingEventsCount = Event::where('created_by', $userId)
            ->where('date', $today)
            ->where('status', 'published')
            ->count();

        // 3. Upcoming Events (events with future dates)
        $this->upcomingEventsCount = Event::where('created_by', $userId)
            ->where('date', '>', $today)
            ->where('status', 'published')
            ->count();

        // 4. Pending Payments - ONLY for paid events
        // Option 1: Using Registration model with event join
        $this->pendingPaymentsCount = Registration::whereHas('event', function($query) use ($userId) {
                $query->where('created_by', $userId)
                    ->where('require_payment', true); // Only count registrations for paid events
            })
            ->where('payment_status', 'pending') // Only count pending payments
            ->count();
    }
     // Update the loadPayments method to be a computed property
    public function getPaymentsProperty()
    {
        $userId = Auth::id();
        
        $paymentsQuery = Registration::with(['user', 'event', 'ticket'])
            ->whereHas('event', function($query) use ($userId) {
                $query->where('created_by', $userId)
                    ->where('require_payment', true);
            })
            ->whereNotNull('payment_status')
            ->where('payment_status', '!=', '');
        
        // Apply search filter
        if ($this->paymentSearch) {
            $paymentsQuery->where(function ($query) {
                $query->whereHas('user', function ($userQuery) {
                    $userQuery->where('first_name', 'like', '%' . $this->paymentSearch . '%')
                            ->orWhere('last_name', 'like', '%' . $this->paymentSearch . '%')
                            ->orWhere('email', 'like', '%' . $this->paymentSearch . '%')
                            ->orWhere('student_id', 'like', '%' . $this->paymentSearch . '%');
                });
            });
        }
        
        // Apply event filter
        if ($this->filterPaymentEvent) {
            $paymentsQuery->where('event_id', $this->filterPaymentEvent);
        }
        
        // Apply status filter
        if ($this->filterPaymentStatus) {
            $paymentsQuery->where('payment_status', $this->filterPaymentStatus);
        }
        
        return $paymentsQuery
            ->orderBy('registered_at', 'desc')
            ->paginate($this->paymentsPerPage);
    }

   // Add reset filters method for payments
    public function resetPaymentFilters()
    {
        $this->reset(['paymentSearch', 'filterPaymentEvent', 'filterPaymentStatus', 'paymentsPerPage']);
        $this->resetPage();
    }

    // Refresh card data after creating/updating/deleting events
    public function updated($propertyName)
    {
        // If any event-related operation happened, refresh card data
        if (in_array($propertyName, ['showCreateModal', 'showEditModal', 'showDeleteModal'])) {
            $this->updateCardData();
            $this->loadPayments();
        }
    }

    // Add a refresh method that can be called from the frontend
    public function refreshCards()
    {
        $this->updateCardData();
        $this->dispatch('cards-refreshed');
    }
    // Add a refresh method for payments
    public function refreshPayments()
    {
        $this->loadPayments();
        $this->dispatch('payments-refreshed');
    }

    public function viewAllRegistrations()
    {
        $this->dispatch('open-modal', modal: 'view-all-registrations');
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
            $this->updateCardData(); // Refresh card data
        }
        $this->showDeleteModal = false;
        $this->deletingEvent = null;
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
            session()->flash('success', 'Event updated successfully!');
            $this->updateCardData(); // Refresh card data
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
        $this->showCreateModal = false;
        $this->updateCardData(); // Refresh card data

        session()->flash('success', 'Event created successfully!');
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

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->editingEvent = null;
        $this->resetForm();
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deletingEvent = null;
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
        $userInitials = strtoupper(substr($user->first_name ?? 'O', 0, 1) . substr($user->last_name ?? 'U', 0, 1));
        
        // Fetch events from database
        $events = Event::where('created_by', Auth::id())
                      ->orderBy('created_at', 'desc')
                      ->get();
        
        // Get events for payment filter dropdown (only paid events)
        $paidEvents = Event::where('created_by', Auth::id())
            ->where('require_payment', true)
            ->orderBy('title')
            ->get();
        
        return view('livewire.organizer-dashboard', [
            'userInitials' => $userInitials,
            'events' => $events,
            'paidEvents' => $paidEvents, // Add this for payment filter
            'eventRegistrationsCount' => $this->eventRegistrationsCount,
            'ongoingEventsCount' => $this->ongoingEventsCount,
            'upcomingEventsCount' => $this->upcomingEventsCount,
            'pendingPaymentsCount' => $this->pendingPaymentsCount,
            'payments' => $this->payments, // This will use the computed property
        ])->layout('layouts.app');
    }
}