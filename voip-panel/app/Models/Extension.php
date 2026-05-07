<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Extension extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'extension',
        'user_id',
        'password',
        'name',
        'voicemail_password',
        'voicemail_enabled',
        'caller_id_name',
        'caller_id_number',
        'status',
        'settings',
    ];

    protected $casts = [
        'voicemail_enabled' => 'boolean',
        'settings' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function getFullCallerIdAttribute(): string
    {
        return "\"{$this->caller_id_name}\" <{$this->caller_id_number}>";
    }
}
