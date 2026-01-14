<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;
use App\Services\TicketPdfService;

class StudentTickets extends Component
{
    public $tickets;
    public $showTicketModal = false;
    public $selectedTicket = null;

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

    public function viewTicket($registrationId)
    {
        $this->selectedTicket = Registration::with(['event', 'ticket'])
            ->where('id', $registrationId)
            ->where('user_id', Auth::id())
            ->first();

        if ($this->selectedTicket && $this->selectedTicket->ticket) {
            $this->showTicketModal = true;
        } else {
            session()->flash('error', 'Ticket not found or you do not have permission to view it.');
        }
    }

    // In StudentTickets.php component, update the downloadTicket method:

    public function downloadTicket($registrationId)
    {
        $registration = Registration::with(['event', 'ticket'])
            ->where('id', $registrationId)
            ->where('user_id', Auth::id())
            ->first();

        if ($registration && $registration->ticket && $registration->ticket->isActive()) {
            // Redirect to the download route
            return $this->redirect(route('ticket.download', $registration->ticket->id), navigate: false);
        } else {
            session()->flash('error', 'Ticket not found, inactive, or you do not have permission to download it.');
            return null;
        }
    }

    public function closeTicketModal()
    {
        $this->showTicketModal = false;
        $this->selectedTicket = null;
    }

    // Helper method to generate PDF (placeholder)
    private function generateTicketPdf($registration)
    {
        // This is where you would generate the PDF content
        // Example using a blade view:
        // return view('tickets.pdf', ['registration' => $registration])->render();
        return "PDF content for ticket: " . $registration->ticket->ticket_number;
    }

    public function render()
    {
        return view('livewire.student-tickets');
    }
}