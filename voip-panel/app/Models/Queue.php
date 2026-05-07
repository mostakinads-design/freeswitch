<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Queue extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'strategy',
        'moh_sound',
        'timeout',
        'max_wait_time',
        'max_wait_time_with_no_agent',
        'tier_rules_apply',
        'tier_rule_wait_second',
        'record_calls',
        'status',
        'settings',
    ];

    protected $casts = [
        'record_calls' => 'boolean',
        'settings' => 'array',
    ];

    public function members()
    {
        return $this->belongsToMany(User::class, 'queue_members')
            ->withPivot('level', 'position', 'status')
            ->withTimestamps();
    }

    public function dialers()
    {
        return $this->hasMany(Dialer::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
