<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ArchivedEvents extends Component
{
    use WithPagination;

    public $search = '';
    public $filterCategory = '';
    public $filterType = '';
    public $filterPayment = '';
    public $eventsPerPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterCategory' => ['except' => ''],
        'filterType' => ['except' => ''],
        'filterPayment' => ['except' => ''],
        'eventsPerPage' => ['except' => 10],
    ];

    public function mount()
    {
        if (!auth()->user()->hasRole('organizer')) {
            abort(403, 'Unauthorized access.');
        }
    }

    public function unarchiveEvent($eventId)
    {
        $event = Event::findOrFail($eventId);
        
        if ($event->created_by !== Auth::id()) {
            session()->flash('error', 'You are not authorized to unarchive this event.');
            return;
        }

        $event->unarchive();
        session()->flash('success', 'Event unarchived successfully!');
    }

    public function deleteArchivedEvent($eventId)
    {
        $event = Event::findOrFail($eventId);
        
        if ($event->created_by !== Auth::id()) {
            session()->flash('error', 'You are not authorized to delete this event.');
            return;
        }

        $event->delete();
        session()->flash('success', 'Event deleted permanently!');
    }

    public function getEventsProperty()
    {
        $userId = Auth::id();
        
        return Event::where('created_by', $userId)
            ->where('is_archived', true)
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
            ->withCount('registrations')
            ->with('creator')
            ->orderBy('archived_at', 'desc')
            ->paginate($this->eventsPerPage);
    }

    public function render()
    {
        $user = Auth::user();
        $userInitials = strtoupper(substr($user->first_name ?? 'O', 0, 1) . substr($user->last_name ?? 'U', 0, 1));
        
        return view('livewire.archived-events', [
            'userInitials' => $userInitials,
            'events' => $this->events,
        ])->layout('layouts.app');
    }
}