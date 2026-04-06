<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'description',
        'user_id',
        'visibility_type',
        'visible_to_grade_level',
        'visible_to_shs_strand',
        'visible_to_year_level',
        'visible_to_college_program',
        'visible_to_roles',
    ];

    protected $casts = [
        'visible_to_grade_level' => 'array',
        'visible_to_shs_strand' => 'array',
        'visible_to_year_level' => 'array',
        'visible_to_college_program' => 'array',
        'visible_to_roles' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if an announcement is visible to a specific user
     */
    public function isVisibleToUser(User $user): bool
    {
        // Admins can see everything
        if ($user->isAdmin()) {
            return true;
        }

        // Organizers can see announcements they created plus any announcements visible to their role
        if ($user->isOrganizer()) {
            // Organizers can see their own announcements
            if ($this->user_id === $user->id) {
                return true;
            }
            // Also check role-based visibility
            if ($this->visibility_type === 'roles' && $this->visible_to_roles) {
                $userRoles = $user->roles->pluck('name')->toArray();
                if (array_intersect($userRoles, $this->visible_to_roles)) {
                    return true;
                }
            }
        }

        // For students and other roles, check visibility restrictions
        switch ($this->visibility_type) {
            case 'all':
                return true;
                
            case 'roles':
                if (!$this->visible_to_roles) {
                    return false;
                }
                $userRoles = $user->roles->pluck('name')->toArray();
                return !empty(array_intersect($userRoles, $this->visible_to_roles));
                
            case 'grade_level':
                if (!$user->grade_level || !$this->visible_to_grade_level) {
                    return false;
                }
                return in_array((string)$user->grade_level, $this->visible_to_grade_level);
                
            case 'shs_strand':
                if (!$user->shs_strand || !$this->visible_to_shs_strand) {
                    return false;
                }
                return in_array($user->shs_strand, $this->visible_to_shs_strand);
                
            case 'year_level':
                if (!$user->year_level || !$this->visible_to_year_level) {
                    return false;
                }
                return in_array((string)$user->year_level, $this->visible_to_year_level);
                
            case 'college_program':
                if (!$user->college_program || !$this->visible_to_college_program) {
                    return false;
                }
                return in_array($user->college_program, $this->visible_to_college_program);
                
            default:
                return true;
        }
    }

    /**
     * Scope to filter announcements visible to a user
     */
    public function scopeVisibleToUser($query, User $user)
    {
        if ($user->isAdmin()) {
            return $query;
        }

        return $query->where(function ($q) use ($user) {
            // Announcements visible to all
            $q->orWhere('visibility_type', 'all');
            
            // Role-based visibility
            if ($user->isOrganizer()) {
                $q->orWhere(function ($subQ) use ($user) {
                    $subQ->where('visibility_type', 'roles')
                         ->whereJsonContains('visible_to_roles', 'organizer');
                });
                // Organizers can see their own announcements regardless of visibility
                $q->orWhere('user_id', $user->id);
            }
            
            if ($user->isStudent()) {
                $q->orWhere(function ($subQ) use ($user) {
                    $subQ->where('visibility_type', 'roles')
                         ->whereJsonContains('visible_to_roles', 'student');
                });
            }
            
            // Grade level visibility
            if ($user->grade_level) {
                $q->orWhere(function ($subQ) use ($user) {
                    $subQ->where('visibility_type', 'grade_level')
                         ->whereJsonContains('visible_to_grade_level', (string)$user->grade_level);
                });
            }
            
            // SHS Strand visibility
            if ($user->shs_strand) {
                $q->orWhere(function ($subQ) use ($user) {
                    $subQ->where('visibility_type', 'shs_strand')
                         ->whereJsonContains('visible_to_shs_strand', $user->shs_strand);
                });
            }
            
            // Year level visibility
            if ($user->year_level) {
                $q->orWhere(function ($subQ) use ($user) {
                    $subQ->where('visibility_type', 'year_level')
                         ->whereJsonContains('visible_to_year_level', (string)$user->year_level);
                });
            }
            
            // College program visibility
            if ($user->college_program) {
                $q->orWhere(function ($subQ) use ($user) {
                    $subQ->where('visibility_type', 'college_program')
                         ->whereJsonContains('visible_to_college_program', $user->college_program);
                });
            }
        });
    }
}