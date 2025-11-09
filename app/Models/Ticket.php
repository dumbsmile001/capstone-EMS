<?php

namespace App\Models;

use App\Models\QRData;
use App\Models\Registration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model{
    use HasFactory;

    public function qrdata(){
        return $this->hasOne(QRData::class);
    }
    public function registration(){
        return $this->belongsTo(Registration::class);
    }
}
