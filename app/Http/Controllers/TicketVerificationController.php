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

        // Check if ticket is valid for verification
        if (!$ticket->isActive()) {
            return view('tickets.verification-invalid', [
                'ticket' => $ticket,
                'message' => 'This ticket is no longer valid for entry.'
            ]);
        }

        return view('tickets.verification', [
            'ticket' => $ticket,
            'registration' => $ticket->registration,
            'event' => $ticket->registration->event,
            'user' => $ticket->registration->user,
            'organizer' => $ticket->registration->event->user
        ]);
    }

    /**
     * Mark ticket as used (for event organizers)
     */
    // In TicketVerificationController.php, update the markAsUsed method:

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