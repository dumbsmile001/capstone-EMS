<?php

namespace App\Models;

use App\Models\Registration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'date',
        'time',
        'type',
        'place_link',
        'category',
        'description',
        'banner',
        'require_payment',
        'payment_amount',
        'status',
        'created_by',
        'is_archived', // Add this
        'archived_at', // Add this
        'archived_by', // Add this
    ];

    protected $casts = [
        'date' => 'date',
        'require_payment' => 'boolean',
        'payment_amount' => 'decimal:2',
        'is_archived' => 'boolean', // Add this
        'archived_at' => 'datetime', // Add this
    ];

    // Add these relationships
    public function archiver()
    {
        return $this->belongsTo(User::class, 'archived_by');
    }

    // Add this scope to get only active (non-archived) events
    public function scopeActive($query)
    {
        return $query->where('is_archived', false);
    }

    public function scopeArchived($query)
    {
        return $query->where('is_archived', true);
    }

    // Add this scope to get past events that should be auto-archived
    public function scopeShouldBeArchived($query)
    {
        return $query->where('date', '<', now()->toDateString())
            ->where('is_archived', false)
            ->where('status', 'published');
    }

    // Archive method
    public function archive($userId = null)
    {
        $this->update([
            'is_archived' => true,
            'archived_at' => now(),
            'archived_by' => $userId,
        ]);
    }

    // Unarchive method
    public function unarchive()
    {
        $this->update([
            'is_archived' => false,
            'archived_at' => null,
            'archived_by' => null,
        ]);
    }

    // Check if event is past
    public function isPast()
    {
        $eventDateTime = \Carbon\Carbon::parse($this->date->format('Y-m-d') . ' ' . $this->time);
        return $eventDateTime->isPast();
    }

    // Check if event can be archived
    public function canBeArchived()
    {
        return $this->isPast() && !$this->is_archived && $this->status === 'published';
    }

    /**
     * Get the user who created the event.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function user()
    {
        return $this->creator();
    }
    
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
    
    public function scopeCreatedBy($query, $userId)
    {
        return $query->where('created_by', $userId);
    }
    
    public function registeredUsers()
    {
        return $this->belongsToMany(User::class, 'registrations')
                    ->withPivot('status', 'registered_at')
                    ->withTimestamps();
    }
}