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

    public function payment(){
        return $this->hasOne(Payment::class);
    }
    public function ticket(){
        return $this->hasOne(Ticket::class);
    }
    public function events(){
        return $this->belongsToMany(Event::class);
    }
    public function users(){
        return $this->belongsToMany(User::class);
    }
}
