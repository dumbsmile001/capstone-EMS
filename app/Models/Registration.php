<?php

namespace App\Models;

use Log;
use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Registration extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'event_id',
        'user_id',
        'status',
        'registered_at',
        'payment_status',
        'payment_verified_at',
        'payment_verified_by'
    ];

    protected $casts = [
        'registered_at' => 'datetime',
        'payment_verified_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::created(function ($registration) {
            // Determine initial ticket status
            $initialStatus = $registration->event->require_payment ? 'pending_payment' : 'active';
            
            // Create ticket immediately (synchronous)
            try {
                Ticket::create([
                    'registration_id' => $registration->id,
                    'ticket_number' => self::generateTicketNumber(),
                    'status' => $initialStatus,
                    'generated_at' => now(),
                ]);
                
                Log::info('Ticket created successfully', [
                    'registration_id' => $registration->id,
                    'event_id' => $registration->event_id,
                    'status' => $initialStatus
                ]);
                
            } catch (\Exception $e) {
                Log::error('Failed to create ticket', [
                    'registration_id' => $registration->id,
                    'error' => $e->getMessage()
                ]);
            }
        });

        static::updated(function ($registration) {
            // If payment is verified and ticket is pending, activate it
            if ($registration->isPaymentVerified() && $registration->ticket && $registration->ticket->isPendingPayment()) {
                $registration->ticket->update(['status' => 'active']);
                
                \Log::info('Ticket activated after payment verification', [
                    'registration_id' => $registration->id,
                    'ticket_id' => $registration->ticket->id
                ]);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function paymentVerifier()
    {
        return $this->belongsTo(User::class, 'payment_verified_by');
    }

    public function ticket()
    {
        return $this->hasOne(Ticket::class);
    }

    // Helper methods
    public function isPaymentVerified()
    {
        return $this->payment_status === 'verified';
    }

    public function isPaymentPending()
    {
        return $this->payment_status === 'pending';
    }

    public function isPaymentRejected()
    {
        return $this->payment_status === 'rejected';
    }

    public function hasActiveTicket()
    {
        return $this->ticket && $this->ticket->isActive();
    }

    public function regenerateTicket()
    {
        if ($this->ticket) {
            $this->ticket->regenerateTicketNumber();
            return true;
        }
        return false;
    }

    // Static method for ticket number generation
    public static function generateTicketNumber()
    {
        do {
            $ticketNumber = 'TKT-' . strtoupper(Str::random(3)) . '-' . rand(1000, 9999) . '-' . Str::random(3);
        } while (Ticket::where('ticket_number', $ticketNumber)->exists());

        return $ticketNumber;
    }
}