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
        $user = Auth::user();
        
        // Check if user has permission to download this ticket
        // Allow if:
        // 1. User is the ticket owner (student who registered)
        // 2. User is the event organizer who created the event
        // 3. User is an admin (has access to everything)
        if ($ticket->registration->user_id !== $user->id && 
            $ticket->registration->event->created_by !== $user->id &&
            !$user->hasRole('admin')) {
            abort(403, 'Unauthorized access');
        }
        
        if (!$ticket->isActive()) {
            return back()->with('error', 'Ticket is not active');
        }
        
        return $this->pdfService->downloadPdf($ticket);
    }
    
    public function view(Ticket $ticket)
    {
        $user = Auth::user();
        
        // Check if user has permission to view this ticket
        // Allow if:
        // 1. User is the ticket owner (student who registered)
        // 2. User is the event organizer who created the event
        // 3. User is an admin (has access to everything)
        if ($ticket->registration->user_id !== $user->id && 
            $ticket->registration->event->created_by !== $user->id &&
            !$user->hasRole('admin')) {
            abort(403, 'Unauthorized access');
        }
        
        return $this->pdfService->streamPdf($ticket);
    }
}