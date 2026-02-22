<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id', 'action', 'model_type', 'model_id', 
        'description', 'old_values', 'new_values', 
        'ip_address', 'user_agent'
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getModelNameAttribute()
    {
        if (!$this->model_type) return null;
        
        // Convert 'App\Models\User' to 'User'
        return class_basename($this->model_type);
    }
}
