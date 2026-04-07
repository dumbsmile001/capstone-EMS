<?php
// app/Models/TermsVersion.php

namespace App\Models;

use App\Models\TermAgreement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TermsVersion extends Model
{
    protected $fillable = [
        'version',
        'content',
        'summary',
        'is_active',
        'effective_date',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'effective_date' => 'datetime',
    ];

    public function agreements(): HasMany
    {
        return $this->hasMany(TermAgreement::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function getActiveVersion(): ?self
    {
        return self::where('is_active', true)
            ->where('effective_date', '<=', now())
            ->orderBy('effective_date', 'desc')
            ->first();
    }
}