<?php

namespace App\Services;

use App\Models\Ticket;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\PngWriter;

class TicketPdfService
{
    /**
     * Generate QR code for the ticket
     */
    protected function generateQrCode(Ticket $ticket): string
    {
        // For now, use a test URL - can be changed later to meaningful data
        $qrData = 'https://example.com/ticket/' . $ticket->ticket_number;
        
        // Create builder instance with constructor parameters
        $builder = new Builder(
            writer: new PngWriter(),
            data: $qrData,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 200,
            margin: 10
        );
        
        // Build the QR code
        $result = $builder->build();
        
        // Return as data URI for embedding in PDF
        return $result->getDataUri();
    }
    
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
        
        // Generate QR code
        $qrCodeDataUri = $this->generateQrCode($ticket);
        
        $data = [
            'ticket' => $ticket,
            'registration' => $registration,
            'event' => $event,
            'user' => $user,
            'organizer' => $organizer,
            'qrCodeDataUri' => $qrCodeDataUri,
        ];
        
        // Generate PDF with UTF-8 encoding
        $pdf = Pdf::loadView('tickets.pdf', $data)
            ->setPaper('A4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true)
            ->setOption('defaultFont', 'DejaVu Sans');
        
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
