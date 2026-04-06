<?php

namespace App\Models;

use App\Models\Registration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Event extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'location',
        'category',
        'description',
        'banner',
        'require_payment',
        'payment_amount',
        'status',
        'created_by',
        'is_archived',
        'archived_at',
        'archived_by',
        'visibility_type',
        'visible_to_grade_level',
        'visible_to_shs_strand',
        'visible_to_year_level',
        'visible_to_college_program',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',  
        'require_payment' => 'boolean',
        'payment_amount' => 'decimal:2',
        'is_archived' => 'boolean',
        'archived_at' => 'datetime',
        'visible_to_grade_level' => 'array',
        'visible_to_shs_strand' => 'array',
        'visible_to_year_level' => 'array',
        'visible_to_college_program' => 'array',
    ];

    // Predefined locations
    public static $predefinedLocations = [
        'SPCC AVR',
        'SPCC School Grounds',
    ];

    // Helper method to get start datetime
    public function getStartDateTimeAttribute()
    {
        return \Carbon\Carbon::parse($this->start_date->format('Y-m-d') . ' ' . $this->start_time);
    }

    // Helper method to get end datetime
    public function getEndDateTimeAttribute()
    {
        return \Carbon\Carbon::parse($this->end_date->format('Y-m-d') . ' ' . $this->end_time);
    }

    /**
     * Check if this event conflicts with another event
     * Conflict occurs when:
     * 1. Same location
     * 2. Time periods overlap
     */
    public function conflictsWith(Event $otherEvent)
    {
        // Only check conflicts for active (non-archived) events
        if ($otherEvent->is_archived) {
            return false;
        }

        // Different locations don't conflict
        if ($this->location !== $otherEvent->location) {
            return false;
        }

        // Check if time periods overlap
        $thisStart = $this->startDateTime;
        $thisEnd = $this->endDateTime;
        $otherStart = $otherEvent->startDateTime;
        $otherEnd = $otherEvent->endDateTime;

        // Overlap condition: one event starts before the other ends AND ends after the other starts
        return $thisStart < $otherEnd && $thisEnd > $otherStart;
    }

    /**
     * Find conflicting events for a given event
     */
    public function findConflicts($excludeSelf = false)
    {
        $query = Event::where('location', $this->location)
            ->where('is_archived', false)
            ->where('status', 'published');

        if ($excludeSelf && $this->id) {
            $query->where('id', '!=', $this->id);
        } elseif ($excludeSelf && !$this->id) {
            // For new events, we don't need to exclude anything by ID
            // Just proceed with the query
        }

        $events = $query->get();
        
        $conflicts = [];
        foreach ($events as $event) {
            // Make sure we're not comparing the event with itself
            if ($excludeSelf && $this->id && $event->id === $this->id) {
                continue;
            }
            
            if ($this->conflictsWith($event)) {
                $conflicts[] = $event;
            }
        }
        
        return $conflicts;
    }

    /**
     * Check if an event would cause conflicts
     */
    public function wouldCauseConflict($excludeSelf = false)
    {
        return count($this->findConflicts($excludeSelf)) > 0;
    }

    /**
     * Get a human-readable conflict message
     */
    public function getConflictMessage()
    {
        $conflicts = $this->findConflicts();
        
        if (empty($conflicts)) {
            return null;
        }
        
        $conflict = $conflicts[0];
        $conflictCount = count($conflicts);
        
        if ($conflictCount === 1) {
            return sprintf(
                'This event conflicts with "%s" which runs from %s to %s at the same location (%s).',
                $conflict->title,
                $conflict->startDateTime->format('M d, Y g:i A'),
                $conflict->endDateTime->format('M d, Y g:i A'),
                $this->location
            );
        } else {
            return sprintf(
                'This event conflicts with %d other event(s) scheduled at %s during the same time period.',
                $conflictCount,
                $this->location
            );
        }
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
        return !$this->hasStarted() && !$this->is_archived && $this->status === 'published';
    }

    public function canCancelRegistration()
    {
        return !$this->hasStarted() && !$this->is_archived;
    }

    public function canBeArchived()
    {
        return $this->hasEnded() && !$this->is_archived && $this->status === 'published';
    }

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
        if ($this->is_archived || $this->status !== 'published') {
            return false;
        }

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

    public function archiver()
    {
        return $this->belongsTo(User::class, 'archived_by');
    }

    public function scopeActive($query)
    {
        return $query->where('is_archived', false);
    }

    public function scopeArchived($query)
    {
        return $query->where('is_archived', true);
    }

    public function archive($userId = null)
    {
        $this->update([
            'is_archived' => true,
            'archived_at' => now(),
            'archived_by' => $userId,
        ]);
    }

    public function unarchive()
    {
        $this->update([
            'is_archived' => false,
            'archived_at' => null,
            'archived_by' => null,
        ]);
    }

    public function isPast()
    {
        $eventDateTime = \Carbon\Carbon::parse($this->date->format('Y-m-d') . ' ' . $this->time);
        return $eventDateTime->isPast();
    }

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