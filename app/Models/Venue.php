<?php

namespace App\Models;

use App\Models\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Venue extends Model{
    use HasFactory;

    public function event(){
        return $this->belongsTo(Event::class);
    }
}
