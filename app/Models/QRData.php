<?php

namespace App\Models;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QRData extends Model{
    use HasFactory;

    public function ticket(){
        return $this->belongsTo(Ticket::class);
    }
}
