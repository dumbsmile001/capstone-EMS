<?php

namespace App\Services;

use App\Models\Ticket;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class TicketPdfService
{
    public function generatePdf(Ticket $ticket)
    {
        // Load all relationships with the correct names
        $ticket->load([
            'registration.event.user',  // Now using 'user' relationship
            'registration.user'
        ]);
        
        $registration = $ticket->registration;
        $event = $registration->event;
        $user = $registration->user;
        $organizer = $event->user; // This will now work with the new relationship
        
        $data = [
            'ticket' => $ticket,
            'registration' => $registration,
            'event' => $event,
            'user' => $user,
            'organizer' => $organizer,
        ];
        
        // Generate PDF
        $pdf = Pdf::loadView('tickets.pdf', $data);
        
        // Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf;
    }
    
    public function downloadPdf(Ticket $ticket)
    {
        $pdf = $this->generatePdf($ticket);
        
        $filename = 'ticket-' . $ticket->ticket_number . '.pdf';
        
        return $pdf->download($filename);
    }
    
    public function streamPdf(Ticket $ticket)
    {
        $pdf = $this->generatePdf($ticket);
        
        return $pdf->stream();
    }
    
    public function savePdfToStorage(Ticket $ticket)
    {
        $pdf = $this->generatePdf($ticket);
        
        $filename = 'tickets/' . $ticket->ticket_number . '.pdf';
        
        // Save to storage
        Storage::disk('public')->put($filename, $pdf->output());
        
        return $filename;
    }
}