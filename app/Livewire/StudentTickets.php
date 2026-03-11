<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;

class StudentTickets extends Component
{
    use WithPagination;

    public $search = '';
    public $filterTicketStatus = '';
    public $perPage = 10;
    public $showTicketModal = false;
    public $selectedTicket = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterTicketStatus' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterTicketStatus()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterTicketStatus', 'perPage']);
        $this->resetPage();
    }

    public function viewTicket($registrationId)
    {
        $this->selectedTicket = Registration::with(['event', 'ticket', 'user'])
            ->where('id', $registrationId)
            ->where('user_id', Auth::id())
            ->first();

        if ($this->selectedTicket && $this->selectedTicket->ticket) {
            $this->showTicketModal = true;
        } else {
            session()->flash('error', 'Ticket not found or you do not have permission to view it.');
        }
    }

    public function closeTicketModal()
    {
        $this->showTicketModal = false;
        $this->selectedTicket = null;
    }

    public function render()
    {
        $tickets = Auth::user()->registrations()
            ->with(['event', 'ticket'])
            ->whereHas('ticket')
            ->when($this->search, function ($query) {
                $query->whereHas('event', function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterTicketStatus, function ($query) {
                $query->whereHas('ticket', function ($q) {
                    if ($this->filterTicketStatus === 'active') {
                        $q->where('status', 'active');
                    } elseif ($this->filterTicketStatus === 'pending_payment') {
                        $q->where('status', 'pending_payment');
                    } elseif ($this->filterTicketStatus === 'used') {
                        $q->where('status', 'used');
                    }
                });
            })
            ->orderBy('registered_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.student-tickets', [
            'tickets' => $tickets,
        ]);
    }
}