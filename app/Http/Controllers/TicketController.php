<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Services\TicketPdfService;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    protected $pdfService;
    
    public function __construct(TicketPdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }
    
    public function download(Ticket $ticket)
    {
        // Check if user has permission to download this ticket
        if ($ticket->registration->user_id !== Auth::id() && 
            $ticket->registration->event->created_by !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }
        
        if (!$ticket->isActive()) {
            return back()->with('error', 'Ticket is not active');
        }
        
        return $this->pdfService->downloadPdf($ticket);
    }
    
    public function view(Ticket $ticket)
    {
        // Check if user has permission to view this ticket
        if ($ticket->registration->user_id !== Auth::id() && 
            $ticket->registration->event->created_by !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }
        
        return $this->pdfService->streamPdf($ticket);
    }
}