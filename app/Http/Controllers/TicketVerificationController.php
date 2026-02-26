<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketVerificationController extends Controller
{
    /**
     * Display ticket verification page (public access)
     */
    public function verify(Request $request, string $ticketNumber)
    {
        // Find ticket by ticket number (not ID)
        $ticket = Ticket::with([
            'registration.event.user',
            'registration.user'
        ])->where('ticket_number', $ticketNumber)->first();

        if (!$ticket) {
            abort(404, 'Ticket not found');
        }

        // Check if ticket was JUST marked as used (within the last 30 seconds)
        $justMarkedAsUsed = $ticket->isUsed() && $ticket->used_at && $ticket->used_at->diffInSeconds(now()) < 30;

        // If ticket is used and NOT just marked as used, show invalid view
        if ($ticket->isUsed() && !$justMarkedAsUsed) {
            return view('tickets.verification-invalid', [
                'ticket' => $ticket,
                'message' => 'This ticket has already been used for entry.'
            ]);
        }

        return view('tickets.verification', [
            'ticket' => $ticket,
            'registration' => $ticket->registration,
            'event' => $ticket->registration->event,
            'user' => $ticket->registration->user,
            'organizer' => $ticket->registration->event->user,
            'justMarkedAsUsed' => $justMarkedAsUsed
        ]);
    }

    /**
     * Mark ticket as used (for event organizers)
     */
    public function markAsUsed(Request $request, string $ticketNumber)
    {
        // Require authentication for this action
        if (!auth()->check()) {
            return response()->json(['error' => 'Authentication required'], 401);
        }
        
        // Check if user is authorized (admin or event organizer)
        $user = auth()->user();
        $ticket = Ticket::with('registration.event')->where('ticket_number', $ticketNumber)->first();
        
        if (!$ticket) {
            return response()->json(['error' => 'Ticket not found'], 404);
        }
        
        // Authorization check using Spatie roles
        $isAdmin = $user->hasRole('admin');
        $isOrganizer = $user->hasRole('organizer') && $ticket->registration->event->created_by == $user->id;
        
        if (!$isAdmin && !$isOrganizer) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        // Check if ticket is already used
        if ($ticket->isUsed()) {
            return response()->json(['message' => 'Ticket already used'], 200);
        }
        
        // Check if event has already ended - using the new date/time fields
        $event = $ticket->registration->event;
        $now = now();
        $today = $now->toDateString();
        $currentTime = $now->format('H:i:s');
        
        $eventHasEnded = $event->end_date < $today || 
                        ($event->end_date == $today && $event->end_time < $currentTime);
        
        if ($eventHasEnded) {
            return response()->json(['error' => 'Cannot mark ticket as used - event has already ended'], 400);
        }
        
        // Mark as used
        $ticket->status = 'used';
        $ticket->used_at = now();
        $ticket->save();
        
        // Return success response
        return response()->json([
            'message' => 'Ticket marked as used successfully',
            'ticket' => $ticket->fresh()->load('registration.user')
        ]);
    }
}