<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conference extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'pin',
        'moderator_pin',
        'max_members',
        'record',
        'video_enabled',
        'profile',
        'status',
        'settings',
    ];

    protected $casts = [
        'record' => 'boolean',
        'video_enabled' => 'boolean',
        'settings' => 'array',
    ];

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function requiresPin(): bool
    {
        return !empty($this->pin);
    }
}
