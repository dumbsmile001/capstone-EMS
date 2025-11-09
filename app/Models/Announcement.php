<?php

namespace App\Models;

use App\Models\User;
use App\Models\Attachment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model{
    use HasFactory;
    public function attachments(){
        return $this->morphMany(Attachment::class, 'attachable');
    }
    public function users(){
        return $this->belongsToMany(User::class);
    }
}
