<?php

namespace App\Models;

use App\Models\Venue;
use App\Models\Registration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model{
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
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'require_payment' => 'boolean',
        'payment_amount' => 'decimal:2',
    ];

    /**
     * Get the user who created the event.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function attachments(){
        return $this->morphMany(Attachment::class, 'attachable');
    }
    public function registrations(){
        return $this->hasMany(Registration::class);
    }
    public function venue(){
        return $this->hasOne(Venue::class);
    }
}
