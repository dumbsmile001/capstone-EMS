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

    public function event()
    {
        return $this->hasOneThrough(Event::class, Registration::class);
    }

    public function user()
    {
        return $this->hasOneThrough(User::class, Registration::class);
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

    public function markAsUsed()
    {
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