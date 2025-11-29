<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'program',
        'email',
        'password',
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
}
