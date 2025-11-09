<?php

namespace App\Models;

use App\Models\Receipt;
use App\Models\Registration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model{
    use HasFactory;
    public function receipt(){
        return $this->hasOne(Receipt::class);
    }
    public function registration(){
        return $this->belongsTo(Registration::class);
    }
}
