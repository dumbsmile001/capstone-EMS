<?php

namespace App\Models;

use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Registration extends Model{
    use HasFactory;
    protected $fillable = [
        'event_id',
        'user_id',
        'status',
        'registered_at'
    ];

    protected $casts = [
        'registered_at' => 'datetime',
    ];

    public function payment(){
        return $this->hasOne(Payment::class);
    }
    public function ticket(){
        return $this->hasOne(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}