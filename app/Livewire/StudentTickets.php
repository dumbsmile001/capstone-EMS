<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;

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

    public function downloadTicket($registrationId)
    {
        // Placeholder for PDF download
        // You can implement PDF generation using DomPDF or similar
        
        $registration = Registration::with(['event', 'ticket'])
            ->where('id', $registrationId)
            ->where('user_id', Auth::id())
            ->first();

        if ($registration && $registration->ticket) {
            // Here you would generate and download the PDF
            // For now, show a success message
            session()->flash('success', 'Ticket download started for ' . $registration->event->title);
            
            // You can trigger a browser download like this:
            // return response()->streamDownload(function () use ($registration) {
            //     echo $this->generateTicketPdf($registration);
            // }, 'ticket-' . $registration->ticket->ticket_number . '.pdf');
        } else {
            session()->flash('error', 'Ticket not found or you do not have permission to download it.');
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