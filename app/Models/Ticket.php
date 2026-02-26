<?php

namespace App\Models;

use App\Models\Registration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'ticket_number',
        'status',
        'generated_at',
        'used_at',
        'qr_data',
    ];

    protected $casts = [
        'generated_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    // Correct the event relationship - use through() with correct parameters
    public function event()
    {
        return $this->through('registration')->has('event');
    }

   // Correct the user relationship - use through() with correct parameters
    public function user()
    {
        return $this->through('registration')->has('user');
    }

    // Helper methods
    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isPendingPayment()
    {
        return $this->status === 'pending_payment';
    }

    public function isUsed()
    {
        return $this->status === 'used';
    }

    /**
     * Check if ticket is valid for entry based on event timing
     */
    public function isValidForEntry()
    {
        if (!$this->isActive()) {
            return false;
        }

        $now = now();
        $today = $now->toDateString();
        $currentTime = $now->format('H:i:s');
        
        $event = $this->registration->event;
        
        // Check if event has started (or is starting now)
        $eventHasStarted = $event->start_date < $today || 
                          ($event->start_date == $today && $event->start_time <= $currentTime);
        
        // Check if event has ended
        $eventHasEnded = $event->end_date < $today || 
                        ($event->end_date == $today && $event->end_time < $currentTime);
        
        // Ticket is valid if event has started but not ended yet
        return $eventHasStarted && !$eventHasEnded;
    }

    /**
     * Check if ticket can be used (for organizers to mark as used)
     */
    public function canBeUsed()
    {
        if (!$this->isActive()) {
            return false;
        }

        $now = now();
        $today = $now->toDateString();
        $currentTime = $now->format('H:i:s');
        
        $event = $this->registration->event;
        
        // Check if event has ended
        $eventHasEnded = $event->end_date < $today || 
                        ($event->end_date == $today && $event->end_time < $currentTime);
        
        // Cannot use ticket if event has already ended
        return !$eventHasEnded;
    }

    public function markAsUsed()
    {
        if (!$this->canBeUsed()) {
            throw new \Exception('Cannot mark ticket as used - event has already ended');
        }

        $this->update([
            'status' => 'used',
            'used_at' => now(),
        ]);
    }

    public function regenerateTicketNumber()
    {
        if (!$this->canRegenerate()) {
            throw new \Exception('Cannot regenerate a used ticket');
        }
        
        $this->update([
            'ticket_number' => $this->generateNewTicketNumber(),
        ]);
    }

    protected function generateNewTicketNumber()
    {
        do {
            $ticketNumber = 'TKT-' . strtoupper(Str::random(3)) . '-' . rand(1000, 9999) . '-' . Str::random(3);
        } while (self::where('ticket_number', $ticketNumber)->exists());

        return $ticketNumber;
    }

    // Add this method to your Ticket.php model
    public function canRegenerate()
    {
        // You can add logic here to restrict regeneration
        // For example, don't allow regeneration for used tickets
        return $this->status !== 'used';
    }
}