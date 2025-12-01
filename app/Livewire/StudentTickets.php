<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class StudentTickets extends Component
{
    public $tickets;

    public function mount()
    {
        $this->loadTickets();
    }

    public function loadTickets()
    {
        $this->tickets = Auth::user()->registrations()
            ->with(['event', 'ticket'])
            ->whereHas('ticket') // Only show registrations with tickets
            ->orderBy('registered_at', 'desc')
            ->get();
    }

    public function downloadTicket($ticketId)
    {
        // Placeholder for PDF download
        session()->flash('info', 'PDF download functionality coming soon!');
    }

    public function viewTicket($ticketId)
    {
        // Placeholder for ticket view
        session()->flash('info', 'Ticket view functionality coming soon!');
    }

    public function render()
    {
        return view('livewire.student-tickets');
    }
}