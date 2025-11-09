<?php

namespace App\Models;

use App\Models\Venue;
use App\Models\Registration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model{
    use HasFactory;
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
