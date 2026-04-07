<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\TermAgreement;
use App\Models\TermsVersion;
use App\Models\Announcement;
use App\Models\Registration;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'student_id',
        'grade_level',
        'year_level',
        'shs_strand',
        'college_program',  // Changed from 'program'
        'email',
        'password',
        'google_id',
    ];
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];
    protected $appends = [
        'profile_photo_url',
    ];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'shs_strand' => 'string',
            'college_program' => 'string',
        ];
    }
    public function announcements()
    {
        return $this->belongsToMany(Announcement::class)->withTimestamps();
    }
    //Event registration
    public function registrations(){
        return $this->hasMany(Registration::class);
    }
    public function events(){
        return $this->hasMany(Event::class, 'created_by');
    }
    // In User.php model, add:
    public function registeredEvents()
    {
        return $this->belongsToMany(Event::class, 'registrations')
                    ->withPivot('status', 'registered_at')
                    ->withTimestamps();
    }

    // Add these methods to your User.php model:

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isOrganizer()
    {
        return $this->hasRole('organizer');
    }

    public function isStudent()
    {
        return $this->hasRole('student');
    }

    public function getFullNameAttribute()
    {
        $name = $this->first_name;
        if ($this->middle_name) {
            $name .= ' ' . $this->middle_name;
        }
        $name .= ' ' . $this->last_name;
        return $name;
    }

    // Add this relationship:
    public function termAgreements()
    {
        return $this->hasMany(TermAgreement::class);
    }

    // Add these methods:
    public function hasAcceptedLatestTerms(): bool
    {
        $latestVersion = TermsVersion::getActiveVersion();
        if (!$latestVersion) {
            return true; // No terms defined yet
        }
        
        return $this->termAgreements()
            ->where('terms_version_id', $latestVersion->id)
            ->exists();
    }

    public function getLatestTermsAcceptance(): ?TermAgreement
    {
        return $this->termAgreements()
            ->with('termsVersion')
            ->latest()
            ->first();
    }
}
