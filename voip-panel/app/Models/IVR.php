<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IVR extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ivrs';

    protected $fillable = [
        'name',
        'description',
        'greeting_file',
        'greeting_text',
        'use_tts',
        'timeout',
        'max_timeouts',
        'max_failures',
        'timeout_action',
        'failure_action',
        'menu_options',
        'status',
    ];

    protected $casts = [
        'use_tts' => 'boolean',
        'menu_options' => 'array',
    ];

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
