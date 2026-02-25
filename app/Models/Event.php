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
        'start_date',        // Changed from 'date'
        'start_time',        // Changed from 'time'
        'end_date',          // New field
        'end_time',          // New field
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
        // Add these for visibility
        'visibility_type', // 'all', 'grade_level', 'shs_strand', 'year_level', 'college_program'
        'visible_to_grade_level', // JSON array: [11, 12] or null
        'visible_to_shs_strand', // JSON array: ['ABM', 'HUMSS'] or null
        'visible_to_year_level', // JSON array: [1, 2, 3] or null
        'visible_to_college_program', // JSON array: ['BSIT', 'BSBA'] or null
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',  
        'require_payment' => 'boolean',
        'payment_amount' => 'decimal:2',
        'is_archived' => 'boolean', // Add this
        'archived_at' => 'datetime', // Add this
        'visible_to_grade_level' => 'array',
        'visible_to_shs_strand' => 'array',
        'visible_to_year_level' => 'array',
        'visible_to_college_program' => 'array',
    ];

    // Add helper methods for date/time logic
    public function getStartDateTimeAttribute()
    {
        return \Carbon\Carbon::parse($this->start_date->format('Y-m-d') . ' ' . $this->start_time);
    }

    public function getEndDateTimeAttribute()
    {
        return \Carbon\Carbon::parse($this->end_date->format('Y-m-d') . ' ' . $this->end_time);
    }

    public function isCurrentlyOngoing()
    {
        $now = now();
        return $now->between($this->startDateTime, $this->endDateTime);
    }

    public function hasStarted()
    {
        return now()->gte($this->startDateTime);
    }

    public function hasEnded()
    {
        return now()->gt($this->endDateTime);
    }

    public function canRegister()
    {
        // Registration closes when event starts
        return !$this->hasStarted() && !$this->is_archived && $this->status === 'published';
    }

    public function canCancelRegistration()
    {
        // Can cancel until event starts
        return !$this->hasStarted() && !$this->is_archived;
    }

    public function canBeArchived()
    {
        // Can archive after event ends
        return $this->hasEnded() && !$this->is_archived && $this->status === 'published';
    }

    // Update the scope for events that should be auto-archived
    public function scopeShouldBeArchived($query)
    {
        return $query->where('end_date', '<', now()->toDateString())
            ->orWhere(function($q) {
                $q->where('end_date', now()->toDateString())
                ->where('end_time', '<', now()->format('H:i:s'));
            })
            ->where('is_archived', false)
            ->where('status', 'published');
    }

    // Update the scope for upcoming events
    public function scopeUpcoming($query)
    {
        return $query->where(function($q) {
            $q->where('start_date', '>', now()->toDateString())
            ->orWhere(function($q2) {
                $q2->where('start_date', now()->toDateString())
                    ->where('start_time', '>', now()->format('H:i:s'));
            });
        });
    }

    // New scope for ongoing events
    public function scopeOngoing($query)
    {
        return $query->where('start_date', '<=', now()->toDateString())
            ->where('end_date', '>=', now()->toDateString())
            ->where(function($q) {
                $q->where('end_date', '>', now()->toDateString())
                ->orWhere(function($q2) {
                    $q2->where('end_date', now()->toDateString())
                        ->where('end_time', '>', now()->format('H:i:s'));
                });
            });
    }

    public function isVisibleToUser(User $user)
    {
        // If event is archived or not published, it's not visible
        if ($this->is_archived || $this->status !== 'published') {
            return false;
        }

        // Check visibility rules
        switch ($this->visibility_type) {
            case 'all':
                return true;
                
            case 'grade_level':
                if (!$user->grade_level || !$this->visible_to_grade_level) {
                    return false;
                }
                return in_array($user->grade_level, $this->visible_to_grade_level);
                
            case 'shs_strand':
                if (!$user->shs_strand || !$this->visible_to_shs_strand) {
                    return false;
                }
                return in_array($user->shs_strand, $this->visible_to_shs_strand);
                
            case 'year_level':
                if (!$user->year_level || !$this->visible_to_year_level) {
                    return false;
                }
                return in_array($user->year_level, $this->visible_to_year_level);
                
            case 'college_program':
                if (!$user->college_program || !$this->visible_to_college_program) {
                    return false;
                }
                return in_array($user->college_program, $this->visible_to_college_program);
                
            default:
                return true;
        }
    }

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